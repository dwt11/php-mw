<?php
/**
 * �༭ϵͳ����Ա
 *
 * @version        $Id: sys_user_edit.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('config.php');

if(empty($dopost)) $dopost = '';
$id = preg_replace("#[^0-9]#", '', $cuserLogin->getUserId());





if($dopost=='saveedit')
{
    $pwd = trim($pwd);
    if($pwd!='' && preg_match("#[^0-9a-zA-Z_@!\.-]#", $pwd))
    {
        ShowMsg('���벻�Ϸ�����ʹ��[0-9a-zA-Z_@!.-]�ڵ��ַ���', '-1', 0, 3000);
        exit();
    }
    $pwdm = '';
    if($pwd != '')
    {
        $pwdm = " pwd='".md5($pwd)."'";
        $pwd = " pwd='".substr(md5($pwd), 5, 20)."'";
    }

    
    $query = "UPDATE `#@__sys_admin` SET $pwd WHERE id='$id'";
   // dump($query);
	$dsql->ExecuteNoneQuery($query);
    ShowMsg("�ɹ��޸����룡","index_body.php");
    exit();
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>�����޸�</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
<script language='javascript'>
	function checkSubmit()
  {
     if(document.form1.pwd.value==""){
	     alert("�����벻��Ϊ�գ�");
	     document.form1.pwd.focus();
	     return false;
     }
     if(document.form1.pwd1.value==""){
	     alert("ȷ�����벻��Ϊ�գ�");
	     document.form1.pwd1.focus();
	     return false;
     }
	 if (document.form1.pwd.value.length<5||document.form1.pwd.value.length>20) 
	 { 
		 alert("��������Ҫ����5λС��20λ��");
	     document.form1.pwd.focus();
	     return false;	
	 }
 
 
 
	  if(document.form1.pwd1.value!=document.form1.pwd.value)
	   {
		 alert("�������벻һ�£�");
	     document.form1.pwd.focus();
	     return false;	
	   }
     return true;
 }
</script>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="19" background="images/tbg.gif" bgcolor="#E7E7E7"> 
      <table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td  style="padding-left:10px;"><b>�����޸�</b> </td>
        </tr>
      </table></td>
   </tr>
  <tr>
  <td height="215" align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1" action="" method="post" onSubmit="return checkSubmit();">
	<input type="hidden" name="dopost" value="saveedit" />
        <table width="98%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td width="16%" height="30" align="right">�û���¼����</td>
            <td width="84%" style="text-align:left;"><?php echo $cuserLogin->getUserName()?></td>
          </tr>
        
          <tr> 
            <td height="30" align="right">�����룺</td>
            <td style="text-align:left;">
            	<input name="pwd" type="password" id="pwd" size="16" style="width:200px" /> 
            </td>
          </tr>
          <tr> 
            <td height="30" align="right">ȷ�������룺</td>
            <td style="text-align:left;">
            	<input name="pwd1" type="password" id="pwd1" size="16" style="width:200px" /> 
         </td>
          </tr>
     
          <tr> 
            <td height="60">&nbsp;</td>
            <td>
            	<input type="submit" name="Submit" value=" ���� " class="coolbg np" />
            </td>
          </tr>
        </table>
      </form>
	  </td>
</tr>
</table>
</body>
</html>