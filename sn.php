<?php
/**
 * ��ʾϵͳע���
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
		alert('����Ϊ�գ�');
		document.form1.yesorno.focus();
		return false;
	}
}
function checkSubmit1()
{
	if(document.form1.diskcode.value=='')
	{
		alert('�����벻��Ϊ�գ�');
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
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" align="center"><strong>ע���</strong></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
	
	
	
	<?php
if($dopost=='create')
{//3����ע����

	//echo $_SESSION['$pwd'];
	if($_SESSION['$pwd']=='52c984258dfe9c9ffbd1')
	{
		$obj = new COM("PHPdll.dwt11");//����VBд��DLL��PHPdll�ǹ�������test������
		$output=$diskcode; // Call the "sum()" ����
		echo "<strong>disk code:</strong>  ".$output; // ��ʾ���
		
		
		
		$output1=$obj->getRegCode($output); // Call the "sum()" ����
		
		echo "<br><strong>reg code:</strong>  ".$output1; // ��ʾ���
	}else{
		echo "�������,����������";
		
	}



}elseif($dopost=='display')
{//2���������
	
	$yesorno = substr(md5($yesorno), 5, 20);

	if($yesorno=='52c984258dfe9c9ffbd1')
	{
		
		$_SESSION['$pwd']=$yesorno;
		$obj = new COM("PHPdll.dwt11");//����VBд��DLL��PHPdll�ǹ�������test������
		$output=$obj->getCode(); // Call the "sum()" ����
		echo "<strong>disk code:</strong>  ".$output; // ��ʾ���
		
		
		
		$output1=$obj->getRegCode($output); // Call the "sum()" ����
		
		echo "<br><strong>reg code:</strong>  ".$output1; // ��ʾ���
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
		echo "�������ƽ�,���κ��ɾ����������";
		
	}
	
	
	
?>	
	
	
	
	
<?php
}else{
	//1����
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
