<?php
/**
 * 数据库备份/还原 
 *
 * @version        $Id: sys_data.php 1 17:19 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost)) $dopost = '';

if($dopost=="viewinfo") //查看表结构
{
    //echo "[<a href='#' onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]\r\n<xmp>";
    echo "<xmp>";
    if(empty($tablename))
    {
        echo "没有指定表名！";
    }
    else
    { //dump("SHOW CREATE TABLE ".$dsql->dbName.".".$tablename);
        $dsql->SetQuery("SHOW CREATE TABLE ".$dsql->dbName.".".$tablename);
        $dsql->Execute('me');
        $row2 = $dsql->GetArray('me',MYSQL_BOTH);
        $ctinfo = $row2[1];
        echo trim($ctinfo);
    }
   echo '</xmp>';
    exit();
}
else if($dopost=="opimize") //优化表
{
   // echo "[<a href='#' onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]\r\n<xmp>";
    if(empty($tablename))
    {
        echo "没有指定表名！";
    }
    else
    {
        $rs = $dsql->ExecuteNoneQuery("OPTIMIZE TABLE `$tablename` ");
        if($rs)
        {
            echo "执行优化表： $tablename  完成！";
        }
        else
        {
            echo "执行优化表： $tablename  失败，原因是：".$dsql->GetError();
        }
    }
    //echo '</xmp>';
    exit();
}
else if($dopost=="repair") //修复表
{
    //echo "[<a href='#' onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]\r\n<xmp>";
    if(empty($tablename))
    {
        echo "没有指定表名！";
    }
    else
    {
        $rs = $dsql->ExecuteNoneQuery("REPAIR TABLE `$tablename` ");
        if($rs)
        {
            echo "修复表： $tablename  OK！";
        }
        else
        {
            echo "修复表： $tablename  失败，原因是：".$dsql->GetError();
        }
    }
    //echo '</xmp>';
    exit();
}

//获取系统存在的表信息
//$otherTables = Array();//其他数据表
$dedeSysTables = Array();


$dsql->SetQuery("SHOW TABLES");
$dsql->Execute('t');
while($row = $dsql->GetArray('t',MYSQL_BOTH))
{
    //if(preg_match("#^{$cfg_dbprefix}#", $row[0])||in_array($row[0],$channelTables))
   // {
        $dedeSysTables[] = $row[0];
    //}
   // else
   // {
       // $otherTables[] = $row[0];
  //  }
}
$mysql_version = $dsql->GetVersion();


function TjCount($tbname,&$dsql)
{
    $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM $tbname");
    return $row['dd'];
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
<script src="../js/dedeajax2.js"></script>
<script language="javascript" src="../js/main.js"></script>
<script language="javascript" src="../js/dialog.js"></script>
<script language="javascript">
function checkSubmit()
{
	var myform = document.form1;
	myform.tablearr.value = getCheckboxItem();
	return true;
}



//不能删除 获得选中文件的数据表
function getCheckboxItem(){
	 var myform = document.form1;
	 var allSel="";
	 if(myform.tables.value) return myform.tables.value;
	 for(i=0;i<myform.tables.length;i++)
	 {
		 if(myform.tables[i].checked){
			 if(allSel=="")
				 allSel=myform.tables[i].value;
			 else
				 allSel=allSel+","+myform.tables[i].value;
		 }
	 }
	 return allSel;	
}

</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>

<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>

<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6"  align="center">
 
  <form name="form1" onSubmit="checkSubmit()" action="sys_data.done.php?dopost=bak" method="post" target="stafrm">
    <input type='hidden' name='tablearr' value='' />
    <tr bgcolor="#F7F8ED">
      <td height="24" colspan="8"><strong>默认系统表：</strong></td>
    </tr>
    <tr bgcolor="#FBFCE2" align="center">
      <td height="24" width="5%">选择</td>
      <td width="20%">表名</td>
      <td width="8%">记录数</td>
      <td width="17%">操作</td>
      <td width="5%">选择</td>
      <td width="20%">表名</td>
      <td width="8%">记录数</td>
      <td width="17%">操作</td>
    </tr>
    <?php  
  for($i=0; isset($dedeSysTables[$i]); $i++)
  { 
    $t = $dedeSysTables[$i];
    echo "<tr align='center'  bgcolor='#FFFFFF' height='24'>\r\n";
  ?> 
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked /> 
    </td>
    <td> 
      <?php echo $t; ?>
    </td>
    <td> 
      <?php echo TjCount($t,$dsql); ?>
    </td>
    <td>
        
    <a onclick="AlertMsg(event,'优化数据表','sys_data.php?dopost=opimize&tablename=<?php echo $t; ?>',200,150);" href="javascript:;">优化</a> |
    <a onclick="AlertMsg(event,'修复数据表','sys_data.php?dopost=repair&tablename=<?php echo $t; ?>',200,150);" href="javascript:;">修复</a> |
    <a onclick="AlertMsg(event,'数据表结构','sys_data.php?dopost=viewinfo&tablename=<?php echo $t; ?>');" href="javascript:;">结构</a> 
    </td>
  <?php
   $i++;
   if(isset($dedeSysTables[$i])) {
   	$t = $dedeSysTables[$i];
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked /> 
    </td>
    <td> 
      <?php echo $t; ?>
    </td>
    <td> 
      <?php echo TjCount($t,$dsql); ?>
    </td>
    <td>
    <a onclick="AlertMsg(event,'优化数据表','sys_data.php?dopost=opimize&tablename=<?php echo $t; ?>',200,150);" href="javascript:;">优化</a> |
    <a onclick="AlertMsg(event,'修复数据表','sys_data.php?dopost=repair&tablename=<?php echo $t; ?>',200,150);" href="javascript:;">修复</a> |
    <a onclick="AlertMsg(event,'数据表结构','sys_data.php?dopost=viewinfo&tablename=<?php echo $t; ?>');" href="javascript:;">结构</a> 
  </td>
  <?php
   }
   else
   {
   	  echo "<td></td><td></td><td></td><td></td>\r\n";
   }
   echo "</tr>\r\n";
  }
  ?>

    <tr bgcolor="#ffffff"> 
      <td height="24" colspan="8">
      	&nbsp; 
       <a href="javascript:selAll('tables')" id="selAllBut" class="coolbg">全否</a>
      </td>
  </tr>
  <tr bgcolor="#F9FCEF"> 
    <td height="24" colspan="8"><strong>数据备份选项：</strong></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="50" colspan="8">
    	  <table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="30">当前数据库版本： <?php echo $mysql_version?></td>
          </tr>
          <tr> 
            <td height="30">
            	指定备份数据格式： 
              <input name="datatype" type="radio" class="np" value="4.0"<?php if($mysql_version<4.1) echo " checked='1'";?> />
              MySQL3.x/4.0.x 版本 
              <input type="radio" name="datatype" value="4.1" class="np"<?php if($mysql_version>=4.1) echo " checked='1'";?> />
              MySQL4.1.x/5.x 版本
              </td>
          </tr>
          <tr> 
            <td height="30">
            	分卷大小： 
              <input name="fsize" type="text" id="fsize" value="2048" size="6" />
              K&nbsp;， 
              <input name="isstruct" type="checkbox" class="np" id="isstruct" value="1" checked='1' />
              备份表结构信息
              <?php  if(@function_exists('gzcompress') && false) {  ?>
              <input name="iszip" type="checkbox" class="np" id="iszip" value="1" checked='1' />
              完成后压缩成ZIP
              <?php } ?>
              <input type="submit" name="Submit" value="提交" class="coolbg np" />
             </td>
          </tr>
        </table>
      </td>
   </tr>
   </form>
  <tr bgcolor="#F9FCEF">
    <td height="24" colspan="8"><strong>进行状态：</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="180" colspan="8">
	<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
	</td>
  </tr>
</table>
</body>
</html>