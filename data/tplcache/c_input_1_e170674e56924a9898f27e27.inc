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
function checkSubmit(no_input_numb){
		
		if(no_input_numb==0){
		
				alert('没有可以导入的记录！');
		return false;

		}
		else{
					if(confirm('您确定要导入这 '+no_input_numb+' 条考勤记录吗？')){
					  return true;
					}else{          return false;
			}
}
	}
	


</script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="26" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong> <?php echo $inputdate." ". $sysFunTitle?> </strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr  bgcolor="#EDF9D5" background='../images/tbg.gif'>
    <td >
    <form name="form2" method="get" action="?"  onSubmit="return checkSubmit('<?php echo $no_input_numb;?>');">
        共在考勤机找到<strong> <?php echo $allResult;?> </strong>条数据,
        其中有<strong> <?php echo $yes_input_numb;?> </strong>已经导入,
        还有<strong> <?php echo $no_input_numb;?> </strong>条未导入
        <input name="inputdate" type="hidden" id="inputdate" class="input" value="<?php echo $inputdate;?>">
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
    <td  align="center" style="white-space:nowrap;">员工姓名</td>
    <td align="center">考勤时间</td>
    <td  align="center">设备名称</td>
    <td align="center">设备IP</td>
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
      <td align="center" style='white-space:nowrap; '> <?php echo $fields['employeecode']; ?> </td>
      <td align="center" style='white-space:nowrap; ' > <?php echo $fields['employeename']; ?> </td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['cardtime']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['devname']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['ipaddress']; ?></td>
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