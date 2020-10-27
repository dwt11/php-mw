<?php
/**
 * @version        $Id: sys_data_revert.php 1 22:28 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

$bkdir = DEDEDATA."/".$cfg_backup_dir;
$filelists = Array();
$dh = dir($bkdir);
$structfile = "没找到数据结构文件";
while(($filename=$dh->read()) !== false)
{
    if(!preg_match("#txt$#", $filename))
    {
        continue;
    }
    if(preg_match("#tables_struct#", $filename))
    {
        $structfile = $filename;
    }
    else if( filesize("$bkdir/$filename") >0 )
    {
        $filelists[] = $filename;
    }
}
$dh->close();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/dedeajax2.js"></script>
<script language="javascript" src="../js/main.js"></script>
<script language="javascript" src="../js/dialog.js"></script>



<script language="javascript">

function checkSubmit()
{
	var myform = document.form1;
	myform.bakfiles.value = getCheckboxItem();
	return true;
}
//不能删除 获得选中文件的数据表
function getCheckboxItem(){
	 var myform = document.form1;
	 var allSel="";
	 if(myform.bakfile.value) return myform.bakfile.value;
	 for(i=0;i<myform.bakfile.length;i++)
	 {
		 if(myform.bakfile[i].checked){
			 if(allSel=="")
				 allSel=myform.bakfile[i].value;
			 else
				 allSel=allSel+","+myform.bakfile[i].value;
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
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" align="center">
  <form name="form1" onSubmit="checkSubmit()" action="sys_data.done.php" method="post" target="stafrm">
    <input type='hidden' name='dopost' value='redat' />
    <input type='hidden' name='bakfiles' value='' />
    <tr bgcolor="#F7F8ED"> 
      <td height="24" colspan="4" valign="top">
      	<strong>发现的备份文件：</strong>
        <?php if(count($filelists)==0) echo " 没找到任何备份文件... "; ?>
      </td>
    </tr>
    <?php
    for($i=0;$i<count($filelists);$i++)
    {
    	echo "<tr  bgcolor='#FFFFFF' align='center' height='24'>\r\n";
      $mtd = "<td width='10%'>
             <input name='bakfile' id='bakfile' type='checkbox' class='np' value='".$filelists[$i]."' checked='1' /> 
             </td>
             <td width='40%'>{$filelists[$i]}</td>\r\n";
      echo $mtd;
      if(isset($filelists[$i+1]))
      {
      	$i++;
      	$mtd = "<td width='10%'>
              <input name='bakfile' id='bakfile' type='checkbox' class='np' value='".$filelists[$i]."' checked='1' /> 
              </td>
              <td width='40%'>{$filelists[$i]}</td>\r\n";
        echo $mtd;
      }else{
      	echo "<td></td><td></td>\r\n";
      }
      echo "</tr>\r\n";
    }
    ?>
    <tr align="center" bgcolor="#FDFDEA"> 
      <td height="24" colspan="4">
      	       <a href="javascript:selAll('bakfile')" id="selAllBut" class="coolbg">全否</a>

     </td>
    </tr>
	  <tr bgcolor="#F7F8ED"> 
      <td height="24" colspan="4" valign="top">
      	<strong>附加参数：</strong>
      </td>
    </tr>
    <tr  bgcolor="#FFFFFF"> 
      <td height="24" colspan="4"> 
        <input name="structfile" type="checkbox" class="np" id="structfile" value="<?php echo $structfile?>" checked='1' />
        还原表结构信息(<?php echo $structfile?>) 
        <input name="delfile" type="checkbox" class="np" id="delfile" value="1" />
        还原后删除备份文件 </td>
    </tr>
    <tr bgcolor="#E3F4BB"> 
      <td height="33" colspan="4">
      	 &nbsp; 
      	 <input type="submit" name="Submit" value="开始还原数据" class="coolbg np" />
      </td>
    </tr>
  </form>
  <tr bgcolor="#F7F8ED"> 
    <td height="24" colspan="4"><strong>进行状态： </strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="180" colspan="4">
    	<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe> 
    </td>
  </tr>
</table>
</body>
</html>