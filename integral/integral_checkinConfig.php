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
	

/*--------------------------------
function __save(){  }
-------------------------------*/
 if($dopost=='save')
{
	$yjcd=trim($yjcd);
	$ejcd=trim($ejcd);
	$sjcd=trim($sjcd);
	$yjzt=trim($yjzt);
	$ejzt=trim($ejzt);
	$sjzt=trim($sjzt);
	$kgbt=trim($kgbt);
	$kgyt=(double)trim($kgyt);

//$kgbt=0;
//$kgyt=0;
//$djorxj=trim($djorxj);

    //����
    $inQuery = "UPDATE `#@__integral_checkinConfig` SET yjcd=$yjcd,ejcd=$ejcd,sjcd=$sjcd,yjzt=$yjzt,ejzt=$ejzt,sjzt=$sjzt,kgbt=$kgbt,kgyt=$kgyt   WHERE (`id`='$id')";
    
	
//echo	$inQuery;
	if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("��������ʱ��������ԭ��", "-1");
        exit();
    }

     ShowMsg("�޸���Ϣ�ɹ���","integral_checkinConfig.php");
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
<body background='../images/allbg.gif' leftmargin='10' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"  colspan="10"><b>���ֿ��ڵ����Զ��۷ֹ���</b>(ÿ���޸ĺ� �����β��"ȷ��",һ�θ���һ��)</td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td>��������</td>
    <td> һ���ٵ���</td>
    <td >�����ٵ���</td>
    <td >�����ٵ���</td>
    <td>һ�����˿�</td>
    <td>�������˿�</td>
    <td>�������˿�</td>
    <td> ���������</td>
    <td> ����һ���</td>
    <td >����</td>
  </tr>
  <?php



for($i=65;$i<74;$i++)
{ 
/*   echo "<option value=".strtolower(chr($i))."";
   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
   echo ">".strtoupper(chr($i))."����</option>";
*/





    //��ȡ�鵵��Ϣ
    $arcQuery = "SELECT *  from #@__integral_checkinConfig  WHERE id='".($i-64)."' ";   //��ȡA�ֿ��� �۷ֹ���
 //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }

?>
  <form name="form1" action="integral_checkinConfig.php" method="post"   >
    <input type="hidden" name="dopost" value="save" />
    <input type="hidden" name="id" value="<?php echo ($i-64); ?>" />
    <tr   bgcolor='#FFffff' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFffff';">
      <td   style="line-height:30px" align="center"><?php echo strtoupper(chr($i))."����"?></td>
      <td   align="center"><input name="yjcd" type="text" value="<?php echo $arcRow['yjcd'];?>" size="5" /></td>
      <td   align="center"><input name="ejcd" type="text" value="<?php echo $arcRow['ejcd'];?>" size="5" /></td>
      <td   align="center"><input name="sjcd" type="text" value="<?php echo $arcRow['sjcd'];?>" size="5" /></td>
      <td   align="center"><input name="yjzt" type="text" value="<?php echo $arcRow['yjzt'];?>" size="5" /></td>
      <td   align="center"><input name="ejzt" type="text" value="<?php echo $arcRow['ejzt'];?>" size="5" /></td>
      <td   align="center"><input name="sjzt" type="text" value="<?php echo $arcRow['sjzt'];?>" size="5" /></td>
      <td   align="center"><input name="kgbt" type="text" value="<?php echo $arcRow['kgbt'];?>" size="5" /></td>
      <td   align="center"><input name="kgyt" type="text" value="<?php echo $arcRow['kgyt'];?>" size="5" /></td>
      <td  align="center" ><input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" border="0" class="np" /></td>
    </tr>
  </form>
   
  <?php }?>
</table>
</body>
</html>
