<?php
/**
 * �������
 *
 * @version        $Id: sys_cache_up.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost)) $dopost = '';
if(empty($step)) $step = 1;

if($dopost=="ok")
{
    if(empty($uparc)) $uparc = 0;
    if($step == -1)
    {
        if($uparc == 0) sleep(1);
        ShowMsg("�ɹ��������л��棡","javascript:;");
        exit();
    }

    //��ջ���Ŀ¼ tplcache
    else if($step == 1)
    {
       if( ClearCache())ShowMsg("�ɹ����tplcacheĿ¼","sys_cache_up.php?dopost=ok&step=-1");else ShowMsg("tplcacheĿ¼���ļ�","sys_cache_up.php?dopost=ok&step=-1");
        exit();
    }

}
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

<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" align="center">
  <form name="form1" action="sys_cache_up.php" method="get" target='stafrm'>
  <input type="hidden" name="dopost" value="ok">
   
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF" style="line-height:20px;">
      	��������Ĭ�ϻ�ִ������Ĳ�����
      	<br />
      	1�����'data/tplcache/'
      </td>
    </tr>
    <tr> 
      <td height="20" bgcolor="#ffffff" align="center">
      	<input name="b112" type="button" class="coolbg np" value="��ʼִ��" onClick="document.form1.submit();" style="width:100px" /> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#F9FCEF"> 
    <td height="20"> <table width="100%">
        <tr> 
          <td width="74%">����״̬�� </td>
          <td width="26%" align="right"> <script language='javascript'>
            	function ResizeDiv(obj,ty)
            	{
            		if(ty=="+") document.all[obj].style.pixelHeight += 50;
            		else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
            	}
            	</script>
            [<a href='#' onClick="ResizeDiv('mdv','+');">����</a>] [<a href='#' onClick="ResizeDiv('mdv','-');">��С</a>] 
          </td>
        </tr>
      </table></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td id="mtd">
    	<div id='mdv' style='width:100%;height:350px;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
     </td>
  </tr>
</table>
</body>
</html>
