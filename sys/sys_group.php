<?php
/**
 * ϵͳȨ����
 *
 * @version        $Id: sys_group.php 1 22:28 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost)) $dopost = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<link href="../css/base.css" rel="stylesheet" type="text/css">
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle;?></strong></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="left"><div style="color:red"><img src='../images/ico/help.gif' /> �޸��û�����Ϣ��,�û��������ϵͳ�û���ʹ�õ�Ȩ�޻�������Ч��</div></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
  <tr>
    <td height="28" width="70"  background="../images/tbg.gif" ><?php

if(Test_webRole("sys/sys_group_add.php")) echo "<div class=\"toolbox\"><a href=\"sys_group_add.php\" >���</a></div>";
     
 ?></td>
  </tr>
</table>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
    <tr align="center" bgcolor="#FBFCE2" height="25">
      <td  height="24">Ȩ��ֵ</td>
      <td >������</td>
      <td>��ע</td>
      <td >����</td>
    </tr>
    <?php
	$dsql->SetQuery("Select rank,typename,remark From #@__sys_admintype order by rank");
	$dsql->Execute();
	while($row = $dsql->GetObject())
	{
	?>
    <tr align='center' bgcolor="#FFFFFF" height="28"  onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td><?php echo $row->rank?></td>
      <td align="left"><?php echo $row->typename?></td>
      <td align="left"><?php echo $row->remark?></td>
      <td><?php
	  
		  $usernumb=0;
		  $userinfo = $dsql->getone("select count(*) as dd from #@__sys_admin where find_in_set(".$row->rank.",usertype)");
		  if($userinfo!="")
		  {
		     $usernumb=$userinfo['dd'];
		  }
	  
	  
	   if($row->rank!=10){ 
	  
		if(Test_webRole("sys/sys_group_view.php"))  echo " <a href='sys_group_view.php?rank=".$row->rank."'>��ϸ��Ϣ(����:".$usernumb.")</a>";
		if(Test_webRole("sys/sys_group_edit.php"))  echo "  <a href='sys_group_edit.php?rank=".$row->rank."'>Ȩ���趨</a>";
        if(Test_webRole("sys/sys_group_del.php")) echo " <a href='javascript:isdel(\"sys_group_del.php?rank=\",".$row->rank.");'>ɾ��</a>";
	  
	  }else
	  {
		  echo "��������ԱȨ�޲������޸�";
		  
		  } 
		  ?></td>
    </tr>
    <?php
	}
	?>
    <tr >
      <td height="28" colspan="4"  background='../images/tbg.gif' align="center"> ��<?php echo $dsql->GetTotalRow();?>����¼ </td>
    </tr>
</table>
</body>
</html>
