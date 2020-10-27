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
$group = new sys_group();

if(empty($dopost)) $dopost = "";



$sql="SELECT * FROM `#@__sys_admin` WHERE id=".$id."";
$row = $dsql->GetOne($sql);

$usertypes = explode(',', $row['usertype']);    //用户有属于多个权限组的话,则分别存入数组中

$depRoleArrary=array();
$webRoleArrary=array();
foreach($usertypes as $usertype)
{
	  //直接从数据 库获取 权限内容
	  $sql="SELECT web_role,department_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$usertype."'";
	  $groupSet = $dsql->GetOne($sql);
	  if(is_array($groupSet))
	  {
		  $groupWebRanks = explode('|', $groupSet['web_role']);
		  $groupDepRanks = explode('|', $groupSet['department_role']);
		  //将用户的多个权限组的值 合并成一个  存入数组 供权限检查使用
		  foreach($groupWebRanks as $web_role)
		  {
			  array_push($webRoleArrary,$web_role);
		  }
		  foreach($groupDepRanks as $dep_role)
		  {
			  array_push($depRoleArrary,$dep_role);
		  }
	  }

	  
	  
}

//  140922此处不能删除重复数据 删除的话 容易引起部门中有用的数据删除

//dump($webRoleArrary);
//dump($depRoleArrary);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<center>
  <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
    <tr>
      <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><div style="color:#333333"><img src='../images/ico/help.gif' /> 标注:★ 为具有权限的功能</div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
    <tr>
      <td height="23" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b><?php echo $sysFunTitle?></b></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF" align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10%" class="bline" align="right">用户登录名：</td>
            <td  class="bline"><?php echo $row['userName']?></td>
          </tr>
          <?php
if(file_exists('../emp'))
{//如果有员工管理功能,才输出下面的
	
	?>
          <tr>
            <td  class="bline" align='right'>用户组：</td>
            <td  class="bline"><?php
				echo GetUserTypeNames($row['usertype']);
			  
			  	?></td>
          </tr>
          <tr>
            <td   height=35  align='right'>员工姓名：</td>
            <td ><?php 
						  
						  echo GetEmpNameById($row['empid']);
						  
				
			  	?></td>
          </tr>
          <?php }?>
        </table></td>
    </tr>
  </table>
   <table width="98%"  border="0" cellspacing="1" cellpadding="1" style="margin-top:10px" bgcolor="#D6D6D6">
       <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b>权限信息</b></td>
      </tr>
  <?php
if(in_array("admin_AllowAll",$depRoleArrary)&&in_array("admin_AllowAll",$webRoleArrary))
{

?>
   <tr>
      <td height='35'  bgcolor='#F9FAF3'  align='center'><strong>用户组具有管理员的权限 可以进行任意操作 </strong></td>
    </tr>
  </table>
  <?php }else{?>
              <tr>
              <td height='25'  bgcolor='#FFFFFF' align="left">
    
          <?php 
                  $group->getRoleTable($webRoleArrary,$depRoleArrary,true);   //直接输出
             ?>
             
             </td>
      </tr>
   
  <?php }?>
    </table>

  	<?php 
$t2 = ExecTime();
//echo $t2-$t1;

?>

</body>
</html>