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
    $arcQuery = "SELECT *  from #@__checkin_config  WHERE id='1' ";
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
$yjcd=trim($yjcd);
$ejcd=trim($ejcd);
$sjcd=trim($sjcd);
$yjzt=trim($yjzt);
$ejzt=trim($ejzt);
$sjzt=trim($sjzt);
//$kgbt=trim($kgbt);
//$kgyt=trim($kgyt);

$kgbt=0;
$kgyt=0;
$djorxj=trim($djorxj);

    //����
    $inQuery = "UPDATE `#@__checkin_config` SET  
yjcd=$yjcd,ejcd=$ejcd,sjcd=$sjcd,yjzt=$yjzt,ejzt=$ejzt,sjzt=$sjzt,kgbt=$kgbt,kgyt=$kgyt,djorxj='$djorxj'   WHERE (`id`='1')";
//echo $inQuery;
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("��������ʱ��������ԭ��", "-1");
        exit();
    }

    ShowMsg("�޸���Ϣ�ɹ���","c_config.php");
    exit();
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
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
      
      
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="c_config.php" method="post"   >
          <input type="hidden" name="dopost" value="save" />
  <input type="hidden" name="aid" value="<?php echo $aid; ?>" />

          <tr>
            <td    width="10%" class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
              <input name="yjcd" type="text" value="<?php echo $arcRow['yjcd'];?>" size="5" /> ���Ӽ�Ϊһ���ٵ�</td>
          </tr>
          
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
              <input name="ejcd" type="text" value="<?php echo $arcRow['ejcd'];?>" size="5" /> ���Ӽ�Ϊ�����ٵ�</td>
          </tr>
          
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
              <input name="sjcd" type="text" value="<?php echo $arcRow['sjcd'];?>" size="5" /> ���Ӽ�Ϊ�����ٵ�</td>
          </tr>
          
       
               <tr>
            <td  class="bline" align="right">&nbsp;<b>��ǰ</b>��</td>
            <td  class="bline">
              <input name="yjzt" type="text" value="<?php echo $arcRow['yjzt'];?>" size="5" /> ���Ӽ�Ϊһ������</td>
          </tr>
          
     
               <tr>
            <td    class="bline" align="right">&nbsp;<b>��ǰ</b>��</td>
            <td  class="bline">
              <input name="ejzt" type="text" value="<?php echo $arcRow['ejzt'];?>" size="5" /> ���Ӽ�Ϊ��������</td>
          </tr>
          
     
               <tr>
            <td    class="bline" align="right">&nbsp;<b>��ǰ</b>��</td>
            <td  class="bline">
              <input name="sjzt" type="text" value="<?php echo $arcRow['sjzt'];?>" size="5" /> ���Ӽ�Ϊ��������</td>
          </tr>
          
          
          
          
          
            <tr>
            <td    class="bline" align="right">&nbsp;<b>�ϰ�ʱ��</b>��</td>
            <td  class="bline"><label>
                <input name="djorxj" type="radio" id="RadioGroup1_0" value="�ļ�"  <?php if($arcRow['djorxj']=='�ļ�')echo  "checked='checked'";?>/>
                �ļ�</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label>
                <input name="djorxj" type="radio" id="RadioGroup1_1" value="���＾"  <?php if($arcRow['djorxj']=='���＾')echo  "checked='checked'";?>/>
                ���＾</label>     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         
<label>
                <input name="djorxj" type="radio" id="RadioGroup1_1" value="����"  <?php if($arcRow['djorxj']=='����')echo  "checked='checked'";?>/>
                ����</label>
               </td>
          </tr>
    
          
          
       <!--   
          
                         <tr>
            <td   class="bline" align="right">&nbsp;<b>�ϰ೬��</b>��</td>
            <td  class="bline">
              <input name="kgbt" type="text" value="<?php echo $arcRow['kgbt'];?>" size="5" /> ����δ���ڼ�Ϊ ��������</td>
          </tr>
          
     
          <tr>
            <td    class="bline" align="right">&nbsp;<b>�ϰ೬��</b>��</td>
            <td  class="bline">
              <input name="kgyt" type="text" value="<?php echo $arcRow['kgyt'];?>" size="5" /> ���Ӽ�Ϊ ����һ��</td>
          </tr>
          -->
     

          
          
     
        
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


