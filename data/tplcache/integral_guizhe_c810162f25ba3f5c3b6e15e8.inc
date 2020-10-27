<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8' >
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="26" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong><?php echo $sysFunTitle?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr  bgcolor="#EDF9D5" background='../images/tbg.gif'>
    <td  width="60"><?php

if(Test_webRole("integral/integral_guizhe_add.php")) echo "<div class=\"toolbox\"><a href=\"integral_guizhe_add.php\" >添加</a></div>";
     
 ?></td>
    <td  ><form name="form2" method="get" action="integral_guizhe.php">
        <label><span>名称</span>
          <input name="keyword" type="text" id="keyword"  style="width:100px" value="<?php echo $keyword?>"  class='inputTips'/>
        </label>
                <select name="integral_class">
       <option value="">请选择积分类型</option>
          
          
              <?php
               for($i=65;$i<74;$i++)
			   { 
				   echo "<option value=".strtolower(chr($i))."";
				   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
				   echo ">".strtoupper(chr($i))."积分</option>";
			   
			   }?>      
        </select>

        <input name="imageField" type="submit" value="搜索" class='np coolbg' />
      </form></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-top:5px" >
  <tr>
    <td height="28" colspan="14"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
  <tr bgcolor="#FBFCE2">
    <td  align="center" style="white-space:nowrap;">编号</td>
    <td align="center">名称</td>
    <td  align="center">内容</td>
    <td align="center">分类</td>
    <td  align="center">增/减</td>
    <td  align="center">分值</td>
    <td  align="center">操作</td>
  </tr>
  <form name="form1">
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
 
   
   
    $bgcolor="#FFffff";
    ?>
    <tr   bgcolor='#FFffff' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFffff';">
      <td align="center" style='white-space:nowrap; ' > <?php echo $fields['gz_id']; ?> </td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['gz_name']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['gz_ms']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php 
      if($fields['gz_class']=="a")echo "A分";
      if($fields['gz_class']=="b")echo "B分";
      if($fields['gz_class']=="c")echo "C分";
       for($i=65;$i<74;$i++)
			   { 
				    
				   if($fields['gz_class']== strtolower(chr($i)) )echo strtoupper(chr($i))."积分";
				   
			   }
      ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php 
      if($fields['gz_aors']=="add")echo "加分";
      if($fields['gz_aors']=="sub")echo "减分";
      
      ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo (double)($fields['gz_fz']);?></td>
      <td  align="center"  style='white-space:nowrap; '><?php
  //37规则 是其他规则 用于B分的手动输入  不可编辑和删除  
  if($fields['gz_id']!="37"&&$fields['gz_id']!="40"){
  
 
   if(Test_webRole("integral/integral_guizhe_edit.php")) echo " <a href=\"integral_guizhe_edit.php?aid=".$fields['gz_id']."\">编辑</a> ";
   if(Test_webRole("integral/integral_guizhe_del.php")) echo " <a href='javascript:isdel(\"integral_guizhe_del.php?aid=\",".$fields['gz_id'].");'>删除</a>";
   
 
  }?></td>
    </tr>
    <?php
}
}?>
  </form>
  <tr>
    <td height="28" colspan="14" bgcolor="#F9FCEF" align="center"  background='../images/tbg.gif'> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>