<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="left"><div style="color:red"><img src='../images/ico/help.gif' /> 修改系统用户信息后,相应的用户需要"注销"后重新登录,新的信息才会启用！</div></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
  <tr >
    <td height="28" width="70"  background='../images/tbg.gif'><?php

if(Test_webRole("sys/sys_user_add.php")) echo "<div class=\"toolbox\"><a href=\"sys_user_add.php\" >添加</a></div>";
     
 ?></td>
    <td  height="28"  background='../images/tbg.gif' ><form name="form2" method="get" action="sys_user.php">
        <input name="keyword" type="text" id="keyword" class="input" value="<?php echo $keyword;?>">
        <select name='orderby' >
          <option value='id'>排序...</option>
          <option value='logintime' <?php if($orderby=="logintime") echo "selected=\"selected\"";?>>登录日期</option>
          <option value='loginnumb' <?php if($orderby=="loginnumb") echo "selected=\"selected\"";?>>登录次数</option>
        </select>
        <input name="imageField" type="submit" value="搜索" class='np coolbg' />
        注:登录名
      </form></td>
  </tr>
</table>

    <?php 
     $colspan=6;
     if(file_exists(DEDEPATH.'/emp'))$colspan=7;
     ?>

  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
    <tr >
      <td height="28" colspan="<?php echo $colspan;?>"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
    </tr>
    <tr align="center" bgcolor="#FBFCE2" height="25">
    <td  height="24">登录名</td>
    <?php 
     if(file_exists(DEDEPATH.'/emp'))
     {
     
     echo "<td >所属用户组</td>";
     echo "<td >员工姓名</td>";
     
     }
     ?>
    <td >登录次数</td>
    <td>最后登录IP</td>
    <td>最后登录日期</td>
    <td>操作</td>
  </tr>
  <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align='center' bgcolor="#FFFFFF" height="28"  onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
    <td ><?php echo $fields['userName']; ?></td>
    <?php 
     if(file_exists(DEDEPATH.'/emp'))
      {//如果系统有EMP的功能,则输出
       
     ?>
    <td align="left"><?php echo GetUserTypeNames($fields['usertype']); ?></td>
    <td><?php echo GetEmpNameById($fields['empid']); ?></td>
    <?php }?>
    <td><?php echo $fields['loginnumb']; ?></td>
    <td><?php echo $fields['loginip']; ?></td>
    <td><?php echo GetDateTimeMk($fields['logintime']); ?>　</td>
    <td ><?php
    if(Test_webRole("sys/sys_user_role_view.php"))echo " <a href='sys_user_role_view.php?id=".$fields['id']."'>查看权限</a>  ";
    if(Test_webRole("sys/sys_user_edit.php"))echo " <a href='sys_user_edit.php?id=".$fields['id']."'>更改</a>";
    if($fields['id']>1&&Test_webRole("sys/sys_user_del.php"))echo " <a href='sys_user_del.php?id=".$fields['id']."&userName=".$fields['userName']."'>删除</a>";

     
 ?></td>
  </tr>
  <?php
}
}?>
    <tr >
    <td height="28" colspan="<?php echo $colspan;?>" bgcolor="#F9FCEF" align="center"  background='../images/tbg.gif'> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>