<?php
/**
 *
 * @version        $Id: file_manage_main.php 1 8:48 2010��7��13��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_baseconfg.class.php");


/*һ\��ʾ:
����ʾ���ݿ����Ѿ������
Ȼ���������ݿ�δ�����



*/

//����ʵ���ļ����ܵı�ע��Ϣ
if(empty($dopost)) $dopost = '';




//��������ʵ���ļ�����Ϣ ���ļ���
if($dopost=='batupdate')
{
        $cachefile = DEDEDATA.'/sys_function_data.php';
        $fp = fopen($cachefile,'w');
        fwrite($fp,'<'."?php\r\n\$GLOBALS['baseConfigFunArray']= array();\r\n");
        fwrite($fp,"//�����ʽ   �ļ������ƣ��ļ����ƣ��ļ�����˵�����⣬�Ƿ���ת���Ƿ��в�������\r\n");

        fwrite($fp,"//���÷���		require_once(DEDEDATA.\"/sys_function_data.php\");\r\n");
        fwrite($fp,"////              global \$baseConfigFunArray;\r\n");
		 if(empty($isdepdate)) $isdepdate = '';
		 if(empty($isjeep)) $isjeep = '';
			  
		foreach($dir as $key => $dirname)
		{
			$row_isjeep=0;//�Ƿ���ת Ĭ��Ϊ0
			if(is_array($isjeep))
			{
				if(in_array($key,$isjeep))$row_isjeep=1;
			}
			$row_isdepdate=0;//�Ƿ������������ Ĭ��Ϊ0
			if(is_array($isdepdate))
			{
				if(in_array($key,$isdepdate))$row_isdepdate=1;
			}
			
			
			
		   //�����ʽ   �ļ������ƣ��ļ����ƣ��ļ�����˵�����⣬�Ƿ���ת���Ƿ��в�������
            fwrite($fp,"\$GLOBALS['baseConfigFunArray'][\"{$dirname}\"][]=\"{$dirname},{$childfilename[$key]},{$title[$key]},{$row_isjeep},{$row_isdepdate}\";\r\n");
		   //$sys_function[\"$dirname\"][]=$dirname.",".$childfilename[$key].",".$title[$key].",".$row_isjeep.",".$row_isdepdate;
		}






        fwrite($fp,'?'.'>');
        fclose($fp);
	
	
    ShowMsg('�ɹ���������!', 'sys_function_set2file.php');
    exit();
	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>ϵͳ�����ļ��趨��Ϣ���浽�ļ�</title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<style>
.linerow {
	border-bottom: 1px solid #CBD8AC;
	height: 24px
}
</style>
<script type="text/javascript">
function checkSubmit()
{

//�����δ��д�����ƣ�����ʾ�û���ȫ
	var title = document.getElementsByName('title[]');
	var isTitleNull=false;
	for(i=0; i < title.length; i++)
	{
		 if(title[i].value=="")isTitleNull=true;continue;

	}
   if(isTitleNull){
          alert("�뽫��д�����ļ���Ӧ�Ĺ���˵�����⣡");
          return false;
     }
     return true;
}
</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong>ϵͳ�����ļ��趨��Ϣ���浽�ļ�</strong></td>
  </tr>
</table>
<form name='form1' action='' method='post'  onSubmit="return checkSubmit();">
  <table width='98%' border='0' cellspacing='1' cellpadding='0' align='center' style="background:#cfcfcf;">
    <?php 
	
	
$fun = new sys_baseconfg();
$fun->listDir();




?>
    <tr bgcolor="#cfcfcf" height="28" align="center">
      <td colspan="12" background="../images/tbg.gif" ><input  type="hidden"  name="filenumbi" value='<?echo $fun->noDateId?>' class='abt' />
        <input  type="hidden"  name="dopost" value='batupdate' class='abt' />
        <input name="imageField" type="submit" value="ȫ������" class='np coolbg' /></td>
    </tr>
  </table>
</form>
</body>
</html>



