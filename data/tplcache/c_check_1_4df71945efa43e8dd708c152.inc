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
<script >
function checkSubmit(no_check_numb){
		
		if(no_check_numb==0){
		
				alert('没有可以审核的记录！');
		return false;

		}
		else{
					if(confirm('您确定要保存这 '+no_check_numb+' 条考勤记录的审核信息吗？')){
					  return true;
					}else{          return false;
			}
}
	}
	


</script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'   onLoad="checkShowHidelist('kqtrue');">
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="26" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong> <?php echo $checkdate.$sysFunTitle?> </strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr  bgcolor="#EDF9D5" background='../images/tbg.gif'>
    <td ><form name="form2" method="get" action="?dopost=check"  onSubmit="return checkSubmit('<?php echo Get_all_check($checkdate);?>');">
        共在考勤记录中找到<strong> <?php echo Get_all_check($checkdate);?> </strong>条未审核数据 
        
        <!-- ,其中正常记录有<strong> <?php echo Get_yes_check($checkdate);?> </strong>条,
        不正常记录有<strong> <?php echo Get_no_check($checkdate);?> </strong>条-->
        <input name="checkdate" type="hidden" id="checkdate" class="input" value="<?php echo $checkdate;?>">
        <input name="dopost"  type="hidden" id="dopost" class="input" value="check">
        <input name="imageField" type="submit" value="审核" class='np coolbg' />
      </form></td>
    <td   ><b>
      <input  name="hidchild" type="checkbox" id="hidchild" onClick="javascript:showHidelist('kqtrue');" class="np" />
      显示正常记录</b></td>
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
    <td  align="center" style="white-space:nowrap;">员工姓名</td>
    <td align="center">考勤时间</td>
    <td  align="center">设备名称</td>
    <td align="center">设备IP</td>
    <td align="center">导入日期</td>
    <td align="center">状态</td>
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
    <tr   bgcolor='<?php echo $bgcolor?>' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='<?php echo $bgcolor?>';"
    
   <?php  if(	returncheck($fields['kq_hw_emptime'],$fields['kq_hw_empcode'])=="<font color='#009900'>正常</font>")echo " class='hid' ";
?>  
    
    >
      <td align="center" style='white-space:nowrap; '> <?php echo $fields['kq_hw_empcode']; ?> </td>
      <td align="center" style='white-space:nowrap; ' > <?php echo $fields['kq_hw_empname']; ?>（
        <?php 
        
        
       echo getbb($fields['kq_hw_empcode']);
      ?>
        ） </td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_emptime']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_devname']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_devip']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo date("Y年m月d日",strtotime($fields['kq_markdate']));?></td>
      <td  align="center" style='white-space:nowrap; ' ><strong>
        <?php 
        
        
       echo returncheck($fields['kq_hw_emptime'],$fields['kq_hw_empcode']);
      ?>
        </strong>
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