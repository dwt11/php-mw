<?php
/**
 * �������
 *
 * @version        $Id: dep_add.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_function.class.php");

if(empty($dopost)) $dopost = '';

$topid = isset($topid) ? intval($topid) : 0;




/*---------------------
function action_save(){ }
---------------------*/
if($dopost=="save")
{

	if($urladd=="0")
	{
        ShowMsg("��ѡ���ܲ�����,��ѡ��ǻ�ɫ����ѡ�","-1");
        exit();
	}
	//dump("SELECT title,disorder FROM `dede_sys_function` where topid={$topid} and title='$title' ORDER BY disorder desc");
	
	$row = $dsql->GetOne("SELECT title,disorder FROM `dede_sys_function` where topid={$topid}  ORDER BY disorder desc");
//	dump($title==$row["title"]);
	//dump($title);
//	dump($row["title"]);
	if(is_array($row))
	{
		if( $title==$row["title"])
		{
			ShowMsg("�Ѿ�������ͬ���ƵĹ���,���޸ģ�","-1");
			exit();
		}
		$disorder=$row["disorder"]+1;
	}else
	{
		$disorder=1;
	}
	
	//�����ӵĹ���Ϊ��ʱ���� �����ַ���� ������ĿID_�������
	if($urladd=="#")
	{
		$urladd=$topid."_".mt_rand(10000,99999);
	}
	
	$in_query = "INSERT INTO `dede_sys_function` (`topid`,`urladd`,  `groups` ,`title`, `disorder`, `remark`) 
	VALUES ('{$topid}','{$urladd}','',  '{$title}', '{$disorder}', '{$remark}')";
    //dump($in_query);
    if(!$dsql->ExecuteNoneQuery($in_query))
    {
        ShowMsg("��������ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
        exit();
    }
    ShowMsg("�ɹ���ӹ��ܣ�","sys_function.php");
    exit();

}//End dopost==save

$fun = new sys_function();

$optionarr = $fun->getDirFileOption();  //����Ŀѡ��

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script language="javascript">


function checkSubmit()
{
    if(document.form1.title.value==""){
          alert("��ʾ���Ʋ���Ϊ�գ�");
          document.form1.title.focus();
          return false;
     }
	 
     return true;
}


</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><?php echo $sysFunTitle?></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
 
  <form name="form1" action="sys_function_add.php" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="save" />
  <input type='hidden' name='topid' id='topid' value='<?php echo $topid; ?>' />
 
 
        
       
       
<?php
if($topid>0)
{
?>
          <tr>
            <td  width="10%" class="bline" align="right">�ϼ����ܣ�</td>
            <td class='bline'><?php echo $parentTitle;?></td>
          </tr>
          <?php }?>
          <tr>
            <td  width="10%" class="bline" align="right">��ʾ���ƣ�</td>
            <td class='bline'><input name="title" type="text" id="title" size="30"   /></td>
          </tr>
          <?php
if($topid>0)
{
?>
          <tr>
            <td class='bline'  align="right"> ѡ���ܣ� </td>
            <td class='bline'><?php
            echo "<select name='urladd' >\r\n";
            echo "<option value='#' style=''  selected>���޹���...</option>\r\n";
            echo $optionarr;
            echo "</select>";
			     ?>
                 
                 <br><img src='../images/ico/help.gif' /> <strong>���޹���</strong>������ʱ���ܣ���������б�ҳ��༭ʵ�ʶ�Ӧ�Ĺ��ܵ�ַ��
                 <br><img src='../images/ico/help.gif' /> <strong>��ɫ����</strong>�����ܸ����࣬����ѡ��
                 <br><img src='../images/ico/help.gif' /> <strong>��ɫ����</strong>�������ӷ��࣬����ѡ��
                 <br><img src='../images/ico/help.gif' /> <strong>��ɫ����</strong>�����ܸ�����������������Ŀ���࣬��ѡ��ѡ���Ĭ���ڲ˵����Զ�������Ŀ�������¼�����Ŀ��
              </td>
          </tr>
          <?php }else
{
	
	echo "<input name=\"urladd\"  type=\"hidden\"   />";
	}


?>
          <tr>
            <td class='bline'  align="right"> ��ע�� </td>
             <td class='bline'>          <textarea name="remark" cols="70" style="height:50px" rows="4" id="dep_info" class="alltxt"></textarea>
                  </td>
          </tr>
                <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" ��  �� " class="coolbg np" /></td>
          </tr>  
          
          
                </form> 
	</table>
	</td>
     
  </tr>
</table>
</body>
</html>
