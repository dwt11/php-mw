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
<body background="../images/allbg.gif" leftmargin='8' topmargin='8'>
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
    <td width="60" ><?php

if(Test_webRole("salary/salary_add.php")) echo "<div class=\"toolbox\"><a href=\"salary_add.php\" >����</a></div>";
     
 ?></td>
    <td  ><form name="form2" method="get" action="salary.php">
   
   <label><span>Ա�����\Ա������ </span>
          <input name='keyword' type='text' id='keyword'   value="<?php echo $keyword;?>"  class='inputTips'/>
        </label>  
   
         
        ��
        <input type='text' value="<?php echo $startdate;?>" name='startdate'  id='startdate' size='14'  readonly='readonly' class='Wdate'  onfocus="var enddate=$dp.$('enddate');WdatePicker({onpicked:function(){pickedFunc();enddate.focus();},dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\')}'})"/>
        ��
        <input type='text' value="<?php echo $enddate;?>" name='enddate' id='enddate' size='14'  readonly='readonly' class='Wdate'  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\')}',onpicked:pickedFunc})"/>
        <script language="JavaScript">
    // �����������ڵļ������  
     //   document.all.dateChangDu.value = iDays;
	function pickedFunc(){
		  Date.prototype.dateDiff = function(interval,objDate){    
		//����������� objDate �������������ش� undefined    
		if(arguments.length<2||objDate.constructor!=Date) return undefined;    
		  }
	
	}

</script>  

        <span id='typeidct'>
        <?php
          $depOptions = GetDepOptionList($emp_dep);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>��ѡ����...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
        </span>
        <input name="imageField" type="submit" value="����" class='np coolbg' />
       
        
        
        &nbsp;&nbsp;&nbsp;&nbsp; 
        
               <span class="toolbox"> 
        
        <?php $nowdate="";
        if($startdate==""){
        $nowdate=date("Y-m-d",time());
        }else{
        $nowdate=$startdate;
        }
        ?>
        <a href='<?php echo getMonthUrl($nowdate,-1)?>'>��һ��</a> 
        <a href='<?php echo getMonthUrl($nowdate,1)?>'>��һ��</a> 
        
        </span>
        

      </form></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-top:5px" >
  <tr>
    <td height="28" colspan="15"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
  <tr bgcolor="#FBFCE2">
    <td  align="center" style="white-space:nowrap;">Ա�����</td>
    <td align="center">����</td>
    <td align="center">����</td>
    <td  align="center">��������</td>
    <td  align="center">��������<br>
      ˵��</td>
    <!--    <td  align="center">�ʽ�<br>˵��</td>
    <td  align="center">��ʳ<br>˵��</td>
 -->
    <td  align="center">����<br>
      ˵��</td>
    <td  align="center">��������<br>
      ˵��</td>
    <td  align="center">��������<br>
      ˵��</td>
    <td  align="center">��������</td>
    <td  align="center">Ӧ�����</td>
    <!--    <td  align="center">ʵ�����</td>
    <td  align="center">��ȡ����</td>
    <td  align="center">��ȡ��</td>
-->
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
    <tr   bgcolor='<?php echo $bgcolor?>' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='<?php echo $bgcolor?>';">
      <td align="center" ><?php echo GetEmpCodeByEmpId($fields['salary_empid']);?></td>
      <td align="center"  ><?php echo GetEmpNameById($fields['salary_empid']);?></td>
      <td  align="left" style='white-space:nowrap; ' ><?php echo GetEmpDepNameByEmpId($fields['salary_empid']);?></td>
      <td  align="left"  > <?php echo $fields['salary_yf']; ?> </td>
      <td  align="left"  ><?php echo (double)($fields['salary_jb']);?> <br />
        <?php echo $fields['salary_jbsm']; ?>&nbsp; </td>
      <!--      <td  align="left"  ><?php echo (double)($fields['salary_jj']);?> <br />
        <?php echo $fields['salary_jjsm']; ?>&nbsp; </td>
      <td  align="left"  >-<?php echo (double)($fields['salary_hs']);?> <br />
        <?php echo $fields['salary_hssm']; ?>&nbsp; </td>
 -->
      <td  align="left"  >-<?php echo (double)($fields['salary_kq']);?> <br />
        <?php echo $fields['salary_kqsm']; ?>&nbsp; </td>
      <td  align="left"  ><?php echo (double)($fields['salary_qtadd']);?> <br />
        <?php echo $fields['salary_qtaddsm']; ?>&nbsp; </td>
      <td  align="left"  >-<?php echo (double)($fields['salary_qtsub']);?> <br />
        <?php echo $fields['salary_qtsubsm']; ?>&nbsp; </td>
      <td  align="center"  ><?php echo date("Y��m��d��",strtotime($fields['salary_markdate']));?></td>
      <td  align="left"  ><?php echo (double)($fields['salary_yfmoney']);?></td>
      <!--      <td  align="left"  > <?php echo (double)($fields['salary_sf']);?></td>
      <td  align="center"  ><?php
      if ($fields['salary_lqdate']!=null || $fields['salary_lqdate']!="") echo date("Y��m��d��",strtotime($fields['salary_lqdate']));
       
       ?></td>
      <td  align="center"  ><?php echo $fields['salary_lqname']; ?></td>
-->
      
      <td  align="center"  >
    <?php

if(Test_webRole("salary/salary_edit.php")) echo " <a href=\"salary_edit.php?aid=".$fields['salary_id']."\">�༭</a>";

if(Test_webRole("salary/salary_del.php")) echo " <a href='javascript:isdel(\"salary_del.php?aid=\",".$fields['salary_id'].");'>ɾ��</a>";
     
 ?>  
       
       
       
       </td>
    </tr>
    <?php 
    
        $salary_jb_total+=(double)($fields['salary_jb']);
        
        $salary_jj_total+=(double)($fields['salary_jj']);
    
    $salary_hs_total+=(double)($fields['salary_hs']);
    

$salary_kq_total+=(double)($fields['salary_kq']);
$salary_qtadd_total+=(double)($fields['salary_qtadd']);
$salary_qtsub_total+=(double)($fields['salary_qtsub']);
$salary_yfmoney_total+=(double)($fields['salary_yfmoney']);


    
    
    
    
}
}?>
  </form>
  <tr>
    <td height="28" colspan="4" align="right"  background='../images/tbg.gif' bgcolor="#F9FCEF"><strong>�ϼ�:</strong></td>
    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'><strong> <?php echo (double)($salary_jb_total);?> </strong></td>
    <!--    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'>
<strong>        <?php echo (double)($salary_jj_total);?>
</strong>
    </td>
    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'>
<strong>        -<?php echo (double)($salary_hs_total);?>
</strong>
    </td>
 -->
    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'><strong> -<?php echo (double)($salary_kq_total);?> </strong></td>
    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'><strong> <?php echo (double)($salary_qtadd_total);?></strong></td>
    <td height="28" bgcolor="#F9FCEF" align="left"  background='../images/tbg.gif'><strong> <?php echo (double)($salary_qtsub_total);?> </strong></td>
    <td height="28" align="left"  background='../images/tbg.gif' bgcolor="#F9FCEF">&nbsp;</td>
    <td height="28" align="left"  background='../images/tbg.gif' bgcolor="#F9FCEF"><strong><?php echo (double)($salary_yfmoney_total);?></strong></td>
    <td height="28" align="left"  background='../images/tbg.gif' bgcolor="#F9FCEF">&nbsp;</td>
  </tr>
  <tr>
    <td height="28" colspan="15" bgcolor="#F9FCEF" align="center"  background='../images/tbg.gif'> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>