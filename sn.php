<?php
/**
 * 显示系统注册号
 */
		session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script src="../js/dialog.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<script language="javascript">
<!--
function checkSubmit()
{
	if(document.form1.yesorno.value=='')
	{
		alert('不能为空！');
		document.form1.yesorno.focus();
		return false;
	}
}
function checkSubmit1()
{
	if(document.form1.diskcode.value=='')
	{
		alert('机器码不能为空！');
		document.form1.diskcode.focus();
		return false;
	}
}
-->
</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" align="center"><strong>注册号</strong></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
	
	
	
	<?php
if($dopost=='create')
{//3生成注册码

	//echo $_SESSION['$pwd'];
	if($_SESSION['$pwd']=='52c984258dfe9c9ffbd1')
	{
		$obj = new COM("PHPdll.dwt11");//调用VB写的DLL，PHPdll是工程名，test是类名
		$output=$diskcode; // Call the "sum()" 方法
		echo "<strong>disk code:</strong>  ".$output; // 显示结果
		
		
		
		$output1=$obj->getRegCode($output); // Call the "sum()" 方法
		
		echo "<br><strong>reg code:</strong>  ".$output1; // 显示结果
	}else{
		echo "密码过期,请重新输入";
		
	}



}elseif($dopost=='display')
{//2输入机器码
	
	$yesorno = substr(md5($yesorno), 5, 20);

	if($yesorno=='52c984258dfe9c9ffbd1')
	{
		
		$_SESSION['$pwd']=$yesorno;
		$obj = new COM("PHPdll.dwt11");//调用VB写的DLL，PHPdll是工程名，test是类名
		$output=$obj->getCode(); // Call the "sum()" 方法
		echo "<strong>disk code:</strong>  ".$output; // 显示结果
		
		
		
		$output1=$obj->getRegCode($output); // Call the "sum()" 方法
		
		echo "<br><strong>reg code:</strong>  ".$output1; // 显示结果
		?>
        
      <form name="form1" action="sn.php"  method="post" onSubmit="return checkSubmit1();">
        <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;" align="center">
          <input type="hidden" name="dopost" value="create" />
          <tr>
            <td class="bline" ><input name="diskcode" type="text" id="diskcode" value="" style="width:188px">
            <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" class="np" border="0" style="cursor:pointer">
            </td>
          </tr>
        </table>
      </form>
        
        
        <?php
		
		
		
		
		
	}else{
		echo "请勿尝试破解,三次后会删除所有数据";
		
	}
	
	
	
?>	
	
	
	
	
<?php
}else{
	//1密码
?>
      <form name="form1" action="sn.php"  method="post" onSubmit="return checkSubmit();">
        <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;" align="center">
          <input type="hidden" name="dopost" value="display" />
          <tr>
            <td class="bline" ><input name="yesorno" type="password" id="yesorno" value="" style="width:88px">
            <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" class="np" border="0" style="cursor:pointer">
            </td>
          </tr>
        </table>
      </form>
      <?php }?></td>
  </tr>
</table>
</body>
</html>
