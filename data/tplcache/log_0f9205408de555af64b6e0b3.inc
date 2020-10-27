<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>


<script language="javascript">


function DelSel(){
	 var nid = getCheckboxItem('logs');
	 if(nid==""){
		  alert("请选择项目!\r\n");
		  return ;
	 }
	 location.href = "log_del.php?dopost=del&ids="+nid;
}

function ClearLog(){
	 location.href = "log_del.php?dopost=clear";
}

</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
     <form name='formsearch'>
  <tr >
     <td height="28" background="../images/tbg.gif" >
        <label><span>用户登录名</span>
      <input name="userName" type="text" id="userName" size="15" style="width:100px" value="<?php echo $userName?>"  class='inputTips'/>
        </label>
		   <label><span>文件名称</span>
      <input name="logfilename" type="text" id="logfilename" size="15" style="width:100px" value="<?php echo $logfilename?>"  class='inputTips' />
		 </label>
		  <label><span>IP地址</span>
      <input name="cip" type="text" id="cip" size="15" style="width:100px"  value="<?php echo $cip?>" class='inputTips' />
      </label>
       
      <select name="dtime" id="dtime">
              <option value="0"<?php if($dtime==0) echo " selected"?> selected>选择时间段</option>
              <option value="7"<?php if($dtime==7) echo " selected"?>>一周内</option>
              <option value="15"<?php if($dtime==15) echo " selected"?>>15天内</option>
              <option value="30"<?php if($dtime==30) echo " selected"?>>30天以内</option>
              <option value="60"<?php if($dtime==60) echo " selected"?>>60天以内</option>
        </select> 
			   &nbsp;
        <input type="submit" name="Submit" value="搜索" />
    
     </td>

     </tr>
 		</form>
    </table>



  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
    <tr >
      <td height="28" colspan="8"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
    </tr>
    <tr align="center" bgcolor="#FBFCE2" height="25">
    <td width="8%">选择</td>
    <td width="11%">用户名</td>
    <td width="15%">功能名称</td>
    <td width="15%">访问功能</td>
    <td width="8%">方式</td>
    <td width="14%">访问IP</td>
    <td width="16%">时间</td>
    <td width="28%">Query参数</td>
  </tr>
  <form name="form1">
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align='center' bgcolor="#FFFFFF" height="28"  onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td>
      	<input name='logs' type='checkbox' class='np' id="logs" value='<?php echo $fields['lid']; ?>' />
      </td>
      <td> 
        <?php echo $fields['userName']; ?>
      </td>
      <td>
      	<?php echo getFileTitle($fields['filename']);?>
      </td>
      <td>
      	<?php echo $fields['filename']; ?>
      </td>
      <td> 
        <?php echo $fields['method']; ?>
      </td>
      <td> 
        <?php echo $fields['cip']; ?>
      </td>
      <td> 
        <?php echo MyDate('y-m-d H:i:s',$fields['dtime']); ?>
      </td>
      <td>
      	<input class="np" type="text" value="<?php echo $fields['query']; ?>" name="t1" style="width:280px" />
      </td>
    </tr>
<?php
}
}?>
  </form>
  
    <?php

if(Test_webRole("sys/log_del.php")) {
 ?>  
  <tr> 
    <td height="30" colspan="8" bgcolor="#FCFDF7">
    	&nbsp;
		 <a href="javascript:selAll('logs')" id="selAllBut" class="coolbg np">全选</a> 
      &nbsp; 
	  <a href="javascript:DelSel();" id="DelSel" class="coolbg np">删除所选</a>
      &nbsp; 
	  <a href="javascript:ClearLog();" id="ClearLog" class="coolbg np">清空所有日志</a>
    </td>
  </tr>
<?php }?>  
  
    <tr >
      <td height="28" colspan="8"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
    </tr>
</table>
</body>
</html>