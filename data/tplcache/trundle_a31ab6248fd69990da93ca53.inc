<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'  >



<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-top:5px" >
  <tr>
    <td height="28" colspan="6"  background='../images/tbg.gif' align="center"><strong><?php echo $title?></strong></td>
  </tr>
  <tr bgcolor="#FBFCE2" height="28">
    <td  align="center" style="white-space:nowrap;"><strong>Ա�����</strong></td>
    <td align="center"><strong>����</strong></td>
    <td align="center"><strong>����</strong></td>
    <td  align="center"><strong>�׶ε÷�</strong></td>
    <td  align="center"><strong>�׶�����</strong></td>
    <td  align="center"><strong>��ʷ���ܷ�ֵ</strong></td>
  </tr>
  <?php $i=0;
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{

	$i++;
	if($i%2==0)
	{
		$bgcolor = "#F9FCEF";
	}
	else
	{
		$bgcolor = "#ffffff";
	}
?>
    <tr   bgcolor='<?php echo $bgcolor?>'  height="30">
      <td align="center" ><?php echo GetEmpCodeByEmpId($fields['emp_id']);?></td>
      <td align="center"  ><?php echo GetEmpNameById($fields['emp_id']);?></td>
      <td align="left"  ><?php echo GetEmpDepAllNameByEmpId($fields['emp_id']);?></td>
       <td  align="center"  ><strong><?php echo (double)($fields['totalfz']);?></strong></td>
<td  align="center" style='white-space:nowrap; ' >
      
      
     ��<strong><?php echo $fields['rowno']; ?></strong>��
      
      
      </td>
      <td  align="center" style='white-space:nowrap; ' >
      
      
      <strong><?php echo getOldEmpFz($fields['emp_id'],$class);?></strong>
      
      
      
      </td>
     
    </tr>
    
    
    
    
    <?php
}
}?>
  
  <tr>
    <td height="28" colspan="6" bgcolor="#F9FCEF" align="center"  background='../images/tbg.gif'>  <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>