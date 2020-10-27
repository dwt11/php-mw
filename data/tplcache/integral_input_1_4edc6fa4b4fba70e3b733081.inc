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
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'  >
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="26" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong> <?php echo $inputdate;
          
          echo $sysFunTitle;?> </strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr  bgcolor="#EDF9D5" background='../images/tbg.gif'>
    <td ><form name="form2" method="get" action="?dopost=input" >
       
        
        <input name="inputdate" type="hidden" id="inputdate" class="input" value="<?php echo $inputdate;?>">
        <input name="integral_class"  type="hidden" id="integral_class" class="input" value="<?php echo $integral_class;?>">
        <input name="dopost"  type="hidden" id="dopost" class="input" value="input">
        <input name="imageField" type="submit" value="导入" class='np coolbg' />
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
    <td  align="center" style="white-space:nowrap;">员工编号</td>
    <td align="center">姓名</td>
    <td align="center">部门</td>
    <td  align="center">积分日期</td>
    <td  align="center">积分类型</td>
    <td  align="center">积分分值</td>
    <td  align="center">说明</td>
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
    <tr   bgcolor='<?php echo $bgcolor?>' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='<?php echo $bgcolor?>';">
      <td align="center" ><?php echo $fields['kq_hw_empcode'];?></td>
      <td align="center"  ><?php echo $fields['kq_hw_empname'];?></td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo GetDep($fields['kq_hw_empcode']);?></td>
       <td  align="center"  ><?php echo date("Y年m月d日",strtotime($fields['kq_hw_emptime']));?></td>
<td  align="center" style='white-space:nowrap; ' >
      
      
      <?php 
     echo strtoupper($integral_class)."分";
      
      ?>
      
      
      
      </td>
      <td  align="center" style='white-space:nowrap; ' >
      
      
      <?php 
      echo "-".(double)(GetSub($fields['kq_zt'],$fields['dd']));
      
      ?>
      
      
      
      </td>
      
      
     <td  align="left"  > 考勤违规<?php echo strtoupper($integral_class);?>分扣分项：<?php echo $fields['kq_hw_emptime']; 
      echo GetSm($fields['kq_zt']);
      
      ?></td>
   
    </tr>
    
    
    
    <?php $totalhj+=(double)(GetSub($fields['kq_zt'],$fields['dd']));
}
}?>
  </form>
  
  <tr>
    <td height="28" colspan="5" align="right"  background='../images/tbg.gif'  bgcolor="#F9FCEF"><strong>合计:</strong></td>
    <td height="28"  bgcolor="#F9FCEF" align="center"  background='../images/tbg.gif'><span style="white-space:nowrap; ">
      -<?php 
      
      echo (double)($totalhj);
      
      ?>
    </span></td>
    <td height="28" colspan="4" align="center"  background='../images/tbg.gif'  bgcolor="#F9FCEF">&nbsp;</td>
  </tr>

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