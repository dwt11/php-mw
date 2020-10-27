<?php
/**
 * 系统权限组编辑
 *
 * @version        $Id: sys_group_edit.php 1 22:28 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

 
require_once("../config.php");
require_once("sys_group.class.php");
$t1 = ExecTime();
$group = new sys_group();
if(empty($adminRole))$adminRole="";

if(empty($dopost)) $dopost = "";
if($dopost=='save')
{
 
 
   
    if($rank==10)
    {
        ShowMsg('超级管理员的权限不允许更改!', 'sys_group.php');
        exit();
    }


	//dump($adminWebRole);exit;
        $All_webRole = $All_depRole =  "";      //页面权限
	
	
	
	if($adminRole!=""){
		$All_webRole = $All_depRole =  "admin_AllowAll";      //页面权限
	}else
	{



			$checkBoxArrary=array();
	
			//引入功能类
			require_once("sys_function.class.php");
			$fun = new sys_function();
			$fucArray=$fun->getSysFunArray();
			//有部门数据的CHECKBOX
			//1将页面选中的checkbox组合为一个数组
			//按部门的行为数组,循环获取选中的checkbox
			foreach ($fucArray as $key=>$menu)
			{
				  for($i2=0; $i2<=$allDepNumb-1; $i2++)
				  {
					  $checkBoxName="dep".$i2.$key;   //通过页面input hidden传递过来的部门个数,来定义CHECKBOx的名字,然后用PHP来获取选中的CHECKBOX的值
					  if(empty($$checkBoxName))$$checkBoxName="";
					//dump($$checkBoxName);
					  if(is_array($$checkBoxName))
					  {
						  
						  foreach($$checkBoxName as $checkBoxValues)
						  {
							  $value = explode(',',$checkBoxValues);
							  if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$value[1],"depRole"=>$value[0]));   //获取到值后 存入新的数组
						  }
					  }
				  }
			}
			
			//无部门数据的 文件名称压入数组
			foreach ($fucArray as $key=>$menu)
			{
					$checkBoxName="dep".$key;   //通过页面input hidden传递过来的部门个数,来定义CHECKBOx的名字,然后用PHP来获取选中的CHECKBOX的值
					if(empty($$checkBoxName))$$checkBoxName="";
				  //dump($$checkBoxName);
					if(is_array($$checkBoxName))
					{
						
						foreach($$checkBoxName as $checkBoxValues)
						{
							$value = explode(',',$checkBoxValues);
							if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$checkBoxValues,"depRole"=>"0"));   //获取到值后 存入新的数组
						}
					}
				
			}


//dump($checkBoxArrary);
			$group->getSaveValue($checkBoxArrary);   //获取字符串
			$All_webRole=$group->save_webRole;
			$All_depRole=$group->save_depRole;
	}






	
	
//dump($onlyfile);
//dump($All_webRole);
//dump($All_depRole);
    $dsql->ExecuteNoneQuery("UPDATE `#@__sys_admintype` SET typename='$groupname',web_role='$All_webRole',department_role='$All_depRole',Remark='$Remark' WHERE CONCAT(`rank`)='$rank'");
    ShowMsg('成功更改用户组的权限!', 'sys_group.php');
    exit();
}



$groupWebRanks = Array();
$groupSet = $dsql->GetOne("SELECT * FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='{$rank}' ");
$groupWebRanks = explode('|', $groupSet['web_role']);
$groupDepRanks = explode('|', $groupSet['department_role']);
//dump($groupWebRanks);
//dump($groupDepRanks);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script src="../js/sys_group.js"></script>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
</head>

<body background='../images/allbg.gif' leftmargin='8' topmargin='8' onload="ShowHide('roleTable');">
<center>
  <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
    <tr>
      <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><div style="color:red"><img src='../images/ico/help.gif' /> 修改此页内容有风险，请小心操作！</div>
              <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>第一行</strong> 为用户可以访问的页面权限，每项的<strong>管理</strong>选中后，其后的<strong>添加、删除、编辑</strong>等扩展功能，才可以根据设定显示</div>
              
              
 <?php
 if(file_exists(DEDEPATH.'/emp'))
{
	?>
 <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>第一列</strong> 为用户可以访问的部门权限</div>
 <?php }?>
 
              
              </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <form name='form1' action='sys_group_edit.php' method='post' >
    <input type='hidden' name='dopost' value='save'>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b><?php echo $sysFunTitle?></b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td  width="10%" class="bline" align="right">组名称：</td>
              <td ><input name="groupname" type="text" id="groupname" value="<?php echo $groupSet['typename']?>"></td>
            </tr>
            <tr>
            <td  class="bline" align="right">级别值：</td>
              <td  class="bline"><input name="rank" type="hidden" id="rank" value="<?php echo $groupSet['rank']?>">
                <?php echo $groupSet['rank']?></td>
            </tr>
            <tr>
            <td    align="right">备注：</td>
              <td  ><textarea name="Remark" rows="5" id="Remark" style="width:15%;height:50px"><?php echo $groupSet['Remark']?></textarea></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center" style="margin-top:10px">
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b>权限选择</b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="center">
        
        <table width="98%"  border="0" cellspacing="1" cellpadding="1" style="margin-top:10px" bgcolor="#D6D6D6">
            <tr>
              <td height='25'  bgcolor='#FBFCE2' align="left">
               &nbsp;<strong>特别权限(仅超级管理员使用)</strong>
               <br> 
          <input name='adminRole' type='checkbox' class='np'  value='admin_AllowAll'   <?php echo $group->CRank("admin_AllowAll","admin_AllowAll",$groupWebRanks,$groupDepRanks)?>  onclick="ShowHide('roleTable')">
          可以进行任意操作(选择此项后,用户组将具有管理员的权限) </td>
      </tr>
    </table>
         
          <?php 
                  $group->getRoleTable($groupWebRanks,$groupDepRanks);   //直接输出
             ?>
             
             </td>
      </tr>
      <tr  bgcolor="#F9FCEF">
        <td height="45" align="left" style="padding-left:50px">
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
          <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" class="np" border="0" style="cursor:pointer">
          <img src="../images/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:pointer"></td>
      </tr>
    </table>
  </form>
  	<?php 
$t2 = ExecTime();
//echo $t2-$t1;

?>

  
</center>
</body>
</html>