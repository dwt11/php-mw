<?php
/**
 * ר��༭
 *
 * @version        $Id: spec_edit.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
if(empty($dopost)) $dopost = '';
if($dopost=='')
{

    //��ȡ�鵵��Ϣ
    $arcQuery = "SELECT *  from #@__integral_guizhe  WHERE gz_id='$aid' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }
}
/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
$gz_name=trim($gz_name);
$gz_ms=trim($gz_ms);
$gz_class=trim($gz_class);
$gz_aors=trim($gz_aors);
$gz_fz=trim($gz_fz);


    //����
    $inQuery = "UPDATE `dede_integral_guizhe` SET `gz_name`='".$gz_name."', `gz_ms`='".$gz_ms."', `gz_class`='".$gz_class."', `gz_aors`='".$gz_aors."', `gz_fz`='".$gz_fz."' WHERE (`gz_id`='".$aid."')	";
	
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("��������ʱ��������ԭ��", "-1");
        exit();
    }

    ShowMsg("�޸Ļ�����Ŀ�ɹ���",$ENV_GOBACK_URL);
    exit();
}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script language='javascript' src="../js/main.js"></script>
<script language="javascript">
function checkSubmit()
{
   if(document.form1.gz_name.value==""){
          alert("����д���ƣ�");
          document.form1.gz_name.focus();
          return false;
     }
	 
   if(document.form1.gz_ms.value==""){
          alert("����д���� ��");
          document.form1.gz_ms.focus();
          return false;
     }
   if(document.form1.gz_fz.value==""){
          alert("����д��ֵ ��");
          document.form1.gz_fz.focus();
          return false;
     }
     return true;
}
</script>






</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
      
      
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="integral_guizhe_edit.php" method="post"   onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
  <input type="hidden" name="aid" value="<?php echo $aid; ?>" />

                <tr>
            <td width="10%" class="bline" align="right">&nbsp;<b>�������� </b>��</td>
            <td  class="bline">
              <input type="text" name="gz_name" size="30" value="<?php echo $arcRow['gz_name'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
          
      <?php for($i=65;$i<74;$i++)
			   { 
				   echo "<input name=\"gz_class\" type=\"radio\" id=\"RadioGroup1_0\" value='".strtolower(chr($i))."'";
				   if($arcRow['gz_class']== strtolower(chr($i)) )echo "   checked='checked'";
				   echo ">".strtoupper(chr($i))."���� &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
			       if(($i-1)%3==0) echo "<br>";
			   }?>        
         
             
          
          
			</span></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>�������� </b>��</td>
            <td  class="bline">
             
             
             
             
            <textarea name="gz_ms" cols="50" rows="10"> <?php echo $arcRow['gz_ms'];?></textarea></td>
          </tr>
          <tr>
            <td class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline"><label>
                <input name="gz_aors" type="radio" id="RadioGroup1_0" value="add"   <?php if($arcRow['gz_aors']=='add')echo  "checked='checked'";?> />
                ��</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="gz_aors" type="radio" id="RadioGroup1_1" value="sub"  <?php if($arcRow['gz_aors']=='sub')echo  "checked='checked'";?>/>
                ��</label>
               </td>
          </tr>
    
    
              <tr>
            <td    class="bline" align="right">&nbsp;<b>��ֵ</b>��</td>
            <td  class="bline">
              <input type="text" name="gz_fz" size="14"  value="<?php echo $arcRow['gz_fz'];?>"   /></td>
          </tr>

              
        
 
            <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td >
	    <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" border="0" class="np" />
                  </td>
                          </tr>
        </form>
      </table>
      
   
   </td>
  </tr>
</table>
</body>
</html>
