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

if(Test_webRole("integral/integral_guizhe_add.php")) echo "<div class=\"toolbox\"><a href=\"integral_guizhe_add.php\" >����</a></div>";
     
 ?></td>
    <td  ><form name="form2" method="get" action="integral_guizhe.php">
        <label><span>����</span>
          <input name="keyword" type="text" id="keyword"  style="width:100px" value="<?php echo $keyword?>"  class='inputTips'/>
        </label>
                <select name="integral_class">
       <option value="">��ѡ���������</option>
          
          
              <?php
               for($i=65;$i<74;$i++)
			   { 
				   echo "<option value=".strtolower(chr($i))."";
				   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
				   echo ">".strtoupper(chr($i))."����</option>";
			   
			   }?>      
        </select>

        <input name="imageField" type="submit" value="����" class='np coolbg' />
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
    <td  align="center" style="white-space:nowrap;">���</td>
    <td align="center">����</td>
    <td  align="center">����</td>
    <td align="center">����</td>
    <td  align="center">��/��</td>
    <td  align="center">��ֵ</td>
    <td  align="center">����</td>
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
      if($fields['gz_class']=="a")echo "A��";
      if($fields['gz_class']=="b")echo "B��";
      if($fields['gz_class']=="c")echo "C��";
       for($i=65;$i<74;$i++)
			   { 
				    
				   if($fields['gz_class']== strtolower(chr($i)) )echo strtoupper(chr($i))."����";
				   
			   }
      ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php 
      if($fields['gz_aors']=="add")echo "�ӷ�";
      if($fields['gz_aors']=="sub")echo "����";
      
      ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo (double)($fields['gz_fz']);?></td>
      <td  align="center"  style='white-space:nowrap; '><?php
  //37���� ���������� ����B�ֵ��ֶ�����  ���ɱ༭��ɾ��  
  if($fields['gz_id']!="37"&&$fields['gz_id']!="40"){
  
 
   if(Test_webRole("integral/integral_guizhe_edit.php")) echo " <a href=\"integral_guizhe_edit.php?aid=".$fields['gz_id']."\">�༭</a> ";
   if(Test_webRole("integral/integral_guizhe_del.php")) echo " <a href='javascript:isdel(\"integral_guizhe_del.php?aid=\",".$fields['gz_id'].");'>ɾ��</a>";
   
 
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