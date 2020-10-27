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
if($dopost=='')
{
	
    //读取归档信息
    $arcQuery = "SELECT *  from #@__checkin_config  WHERE id='1' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("读取信息出错!","-1");
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

    //更新
    $inQuery = "UPDATE `#@__checkin_config` SET  
yjcd=$yjcd,ejcd=$ejcd,sjcd=$sjcd,yjzt=$yjzt,ejzt=$ejzt,sjzt=$sjzt,kgbt=$kgbt,kgyt=$kgyt,djorxj='$djorxj'   WHERE (`id`='1')";
//echo $inQuery;
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("更新数据时出错，请检查原因！", "-1");
        exit();
    }

    ShowMsg("修改信息成功！","c_config.php");
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
            <td    width="10%" class="bline" align="right">&nbsp;<b>超过</b>：</td>
            <td  class="bline">
              <input name="yjcd" type="text" value="<?php echo $arcRow['yjcd'];?>" size="5" /> 分钟记为一级迟到</td>
          </tr>
          
          <tr>
            <td   class="bline" align="right">&nbsp;<b>超过</b>：</td>
            <td  class="bline">
              <input name="ejcd" type="text" value="<?php echo $arcRow['ejcd'];?>" size="5" /> 分钟记为二级迟到</td>
          </tr>
          
          <tr>
            <td   class="bline" align="right">&nbsp;<b>超过</b>：</td>
            <td  class="bline">
              <input name="sjcd" type="text" value="<?php echo $arcRow['sjcd'];?>" size="5" /> 分钟记为三级迟到</td>
          </tr>
          
       
               <tr>
            <td  class="bline" align="right">&nbsp;<b>提前</b>：</td>
            <td  class="bline">
              <input name="yjzt" type="text" value="<?php echo $arcRow['yjzt'];?>" size="5" /> 分钟记为一级早退</td>
          </tr>
          
     
               <tr>
            <td    class="bline" align="right">&nbsp;<b>提前</b>：</td>
            <td  class="bline">
              <input name="ejzt" type="text" value="<?php echo $arcRow['ejzt'];?>" size="5" /> 分钟记为二级早退</td>
          </tr>
          
     
               <tr>
            <td    class="bline" align="right">&nbsp;<b>提前</b>：</td>
            <td  class="bline">
              <input name="sjzt" type="text" value="<?php echo $arcRow['sjzt'];?>" size="5" /> 分钟记为三级早退</td>
          </tr>
          
          
          
          
          
            <tr>
            <td    class="bline" align="right">&nbsp;<b>上班时间</b>：</td>
            <td  class="bline"><label>
                <input name="djorxj" type="radio" id="RadioGroup1_0" value="夏季"  <?php if($arcRow['djorxj']=='夏季')echo  "checked='checked'";?>/>
                夏季</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label>
                <input name="djorxj" type="radio" id="RadioGroup1_1" value="春秋季"  <?php if($arcRow['djorxj']=='春秋季')echo  "checked='checked'";?>/>
                春秋季</label>     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         
<label>
                <input name="djorxj" type="radio" id="RadioGroup1_1" value="冬季"  <?php if($arcRow['djorxj']=='冬季')echo  "checked='checked'";?>/>
                冬季</label>
               </td>
          </tr>
    
          
          
       <!--   
          
                         <tr>
            <td   class="bline" align="right">&nbsp;<b>上班超过</b>：</td>
            <td  class="bline">
              <input name="kgbt" type="text" value="<?php echo $arcRow['kgbt'];?>" size="5" /> 分钟未考勤记为 旷工半天</td>
          </tr>
          
     
          <tr>
            <td    class="bline" align="right">&nbsp;<b>上班超过</b>：</td>
            <td  class="bline">
              <input name="kgyt" type="text" value="<?php echo $arcRow['kgyt'];?>" size="5" /> 分钟记为 旷工一天</td>
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


