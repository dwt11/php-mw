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
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="../images/allbg.gif" leftmargin='8' topmargin='8' >
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong><?php echo $sysFunTitle?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr  >
    <td  height="28"  width="70" background='../images/tbg.gif' >
     <?php
      if(Test_webRole("emp/emp_add.php"))echo " <div class=\"toolbox\"> <a href=\"emp_add.php\" >����</a> </div> ";
       ?>
    
    
    
    </td>
    <td  height="28"  background='../images/tbg.gif' ><form name="form2" method="get" action="emp.php">
         <label><span>Ա�����/Ա������</span>
          <input name="keyword" type="text" id="keyword"  style="width:100px" value="<?php echo $keyword?>"  class='inputTips'/>
        </label>
        <?php
          $depOptions = GetDepOptionList($emp_dep);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>��ѡ����...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
       <input name="imageField" type="submit" value="����" class='np coolbg' />
      </form></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
  <tr bgcolor="#E7E7E7" >
    <td height="28" colspan="14"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
  <tr bgcolor="#FBFCE2"  height="25">
    <td  align="center" style="white-space:nowrap;">Ա�����</td>
    <td align="center">����</td>
    <td align="center">��¼��</td>
    <td align="center">����</td>
    <td  align="center">����</td>
    <td align="center">����</td>
    <td  align="center">�Ա�</td>
    <td  align="center">�绰</td>
    <td  align="center">סַ</td>
    <td  align="center">��ְ����</td>
    <td  align="center">��������</td>
    <td  align="center">��ǰ״̬</td>
    <td  align="center">���ڰ��</td>
    <!--<td  align="center">����A</td>
    <td  align="center">����B</td>
    <td align="center">����C</td>-->
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
?>
    <tr align='center' bgcolor="#FFFFFF" height="26"  onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td align="center" style='white-space:nowrap; '><?php echo GetIntAddZero($fields['emp_code']);?></td>
      <td align="center" style='white-space:nowrap; ' > <?php echo $fields['emp_realname']; ?> </td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo GetUserName($fields['emp_id']);?></td>
      <td align="center" style='white-space:nowrap; ' ><?php if($fields['emp_bx']=='��')echo "<b>".$fields['emp_bx']."</b>";else echo  $fields['emp_bx'];?></td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo GetEmpDepAllNameByEmpId($fields['emp_id']);?></td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo GetGz($fields['emp_worktype']);?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_sex']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_phone']; ?></td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo $fields['emp_add']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo date("Y��m��d��",strtotime($fields['emp_rzdate']));?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo date("Y��m��d��",strtotime($fields['emp_csdate']));?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_ste']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_bb']; ?></td>
      
      <!-- <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_integralA']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_integralB']; ?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo $fields['emp_integralC']; ?></td>
    -->
      <td  align="center"  style='white-space:nowrap; '>
      <a onclick="AlertMsg(event,'Ա����ϸ��Ϣ','emp.inc.do.php?dopost=empview&id=<?php echo $fields['emp_id']; ?>',400);" href="javascript:;">��ϸ��Ϣ</a>
     <?php
      if(Test_webRole("emp/emp_edit.php"))echo " <a href=\"emp_edit.php?aid=".$fields['emp_id']."\">�༭</a> ";
      if(Test_webRole("emp/emp_del.php"))echo " <a href='javascript:isdel(\"emp_del.php?aid=\",".$fields['emp_id'].");'>ɾ��</a>"; 
       ?>
       <br>
        <a href="?dopost=bb&aid=<?php echo $fields['emp_id']; ?>&bb=���װ�">��</a> <a href="?dopost=bb&aid=<?php echo $fields['emp_id']; ?>&bb=����">��</a> <br>
        <a href="?dopost=bx&aid=<?php echo $fields['emp_id']; ?>&bx=��">����</a> <a href="?dopost=bx&aid=<?php echo $fields['emp_id']; ?>&bx=��">����</a></td>
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