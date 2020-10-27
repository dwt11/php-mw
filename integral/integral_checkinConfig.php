<?php
/**
 * 专题编辑
 *
 * @version        $Id: spec_edit.php 1 16:22 2010年7月20日Z tianya $
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

    //更新
    $inQuery = "UPDATE `#@__integral_checkinConfig` SET yjcd=$yjcd,ejcd=$ejcd,sjcd=$sjcd,yjzt=$yjzt,ejzt=$ejzt,sjzt=$sjzt,kgbt=$kgbt,kgyt=$kgyt   WHERE (`id`='$id')";
    
	
//echo	$inQuery;
	if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("更新数据时出错，请检查原因！", "-1");
        exit();
    }

     ShowMsg("修改信息成功！","integral_checkinConfig.php");
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
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"  colspan="10"><b>积分考勤导入自动扣分规则</b>(每行修改后 点击行尾的"确定",一次更新一行)</td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td>积分名称</td>
    <td> 一级迟到扣</td>
    <td >二级迟到扣</td>
    <td >三级迟到扣</td>
    <td>一级早退扣</td>
    <td>二级早退扣</td>
    <td>三级早退扣</td>
    <td> 旷工半天扣</td>
    <td> 旷工一天扣</td>
    <td >操作</td>
  </tr>
  <?php



for($i=65;$i<74;$i++)
{ 
/*   echo "<option value=".strtolower(chr($i))."";
   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
   echo ">".strtoupper(chr($i))."积分</option>";
*/





    //读取归档信息
    $arcQuery = "SELECT *  from #@__integral_checkinConfig  WHERE id='".($i-64)."' ";   //读取A分考勤 扣分规则
 //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("读取信息出错!","-1");
        exit();
    }

?>
  <form name="form1" action="integral_checkinConfig.php" method="post"   >
    <input type="hidden" name="dopost" value="save" />
    <input type="hidden" name="id" value="<?php echo ($i-64); ?>" />
    <tr   bgcolor='#FFffff' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFffff';">
      <td   style="line-height:30px" align="center"><?php echo strtoupper(chr($i))."积分"?></td>
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
