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
<script src="../js/dialog.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script >
function isclear(){
		if(confirm('您确定要清空内容吗？')){
			location.href='?dopost=clear';
		}
}
	
function isClearDate(){
     clearDate=document.form3.clearDate.value;
	if(clearDate==""){
	     alert("请选择要清空的月份！");
	     document.form3.clearDate.focus();
	     return false;
     }
		if(confirm('您确定要清空'+clearDate+'的考勤记录吗？')){
			location.href='?dopost=clearDate&clearDate='+clearDate;
		}
}
	
function updateAll(kq_zt){
	var qstr=getCheckboxItem("kqid");
	if(qstr=='')
	{
		alert('必须选择一个或多个！');
		return;
	}
	location="c_list.php?dopost=updates&qstr="+qstr+"&kq_zt="+kq_zt;
}

</script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'  >
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
    <td  width="140" ><div class="toolbox"> <a href="c_input.php" >导入</a> </div></td>
    <td  ><form name="form2" method="get" action="">
         <label><span>员工姓名</span>
          <input name="keyword" type="text" id="keyword"  style="width:100px" value="<?php echo $keyword?>"  class='inputTips'/>
        </label>
        <input type="text" name="date" size="14" value="<?php echo $date;?>" readonly="readonly" class="Wdate"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/>
        <span id='typeidct'>
        <?php
          $depOptions = GetDepOptionList($emp_dep);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>请选择部门...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
        </span>
        <input name="imageField" type="submit" value="搜索" class='np coolbg' />
      </form></td>
    <td ><form name="form3" method="get" action="">
        <div class="toolbox"> <a href="#"  onclick="isclear()">全部清空</a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;只清空<input type="text" name="clearDate" size="12" value="" readonly="readonly" class="Wdate"   onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})"/>
          的数据 <a href="#"  onclick="isClearDate()">确定</a> </div>
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
  <tr>
    <td height="28" colspan="14"  background='../images/tbg.gif' align="left"><a href="javascript:selAll('kqid')" id="selAllBut" class="coolbg">全选</a> &nbsp;&nbsp;&nbsp;&nbsp;
      批量审核：<a href="javascript:updateAll(100)" class="coolbg">正常</a>&nbsp; 
      <!--   <a href="javascript:update(1)" class="coolbg">一级迟到</a>--></td>
  </tr>
  <tr bgcolor="#FBFCE2">
    <td  align="center" style="white-space:nowrap;"></td>
    <td  align="center" style="white-space:nowrap;">考勤机中员工编号</td>
    <td  align="center" style="white-space:nowrap;">员工姓名</td>
    <td align="center">部门</td>
    <td  align="center">设备名称</td>
    <td align="center">设备IP</td>
    <!--    <td align="center">导入日期</td>
    <td align="center">是否工资考核</td>
    <td align="center">是否工资考核</td>
-->
    <td align="center">状态</td>
    <td align="center">考勤时间</td>
    <td align="center">选项</td>
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
      <td  align="center"  style='white-space:nowrap; ' ><input name="kqid" type="checkbox" id="kqid" value="<?php echo $fields['kq_id']; ?>" class="np" /></td>
      <td align="center" style='white-space:nowrap; '><?php echo GetIntAddZero($fields['kq_hw_empcode']);?>  </td>
      <td align="center" style='white-space:nowrap; ' > <?php echo $fields['kq_hw_empname']; ?>（
        <?php 
        
        
       echo getbb($fields['kq_hw_empcode']);
      ?>
        ） </td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo GetEmpDepAllNameByEmpCode($fields['kq_hw_empcode']);?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_devname']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_devip']; ?></td>
      <!--      <td  align="center" style='white-space:nowrap; ' ><?php echo date("Y年m月d日",strtotime($fields['kq_markdate']));?></td>
     <td  align="center" style='white-space:nowrap; ' >
      
      <?php if($fields['kq_integralid']==null||$fields['kq_integralid']=='0'){
      echo "否";
      }
      else
      {
      echo "<strong>是</strong>";
      }
      
      
      ?>
      
      </td>
      <td  align="center" style='white-space:nowrap; ' >
      
        <?php if($fields['kq_salaryid']==null||$fields['kq_salaryid']=='0'){
      echo "否";
      }
      else
      {
      echo "<strong>是</strong>";
      }
      
      
      ?>
      
      
     </td>
-->
      <td  align="center" style='white-space:nowrap; ' ><?php echo getste($fields['kq_zt']);
      
      ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['kq_hw_emptime']; ?></td>
      <td  align="left" style='white-space:nowrap; ' ><a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=100">正常</a> <br>
        <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=1">一迟</a> <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=2">二迟</a> <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=3">三迟</a> <br>
        <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=11">一早</a> <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=12">二早</a> <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=13">三早</a> <br>
        <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=21">旷半</a> <a href="?dopost=update&aid=<?php echo $fields['kq_id']; ?>&kq_zt=22">旷一</a></td>
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