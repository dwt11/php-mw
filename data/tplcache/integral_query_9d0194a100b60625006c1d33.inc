<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
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
    <td  ><form name="form2" method="get" action="integral_query.php">
       
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
       <?php
          $depOptions = GetDepOptionList_norole($emp_dep);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>��ѡ����...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
           <select name="integral_class">
          <option value="">��ѡ���������</option>
          <?php for($i=65;$i<74;$i++)
			   { 
				   echo "<option value=".strtolower(chr($i))."";
				   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
				   echo ">".strtoupper(chr($i))."����</option>";
			   
			   }?></select>
     <input name="imageField" type="submit" value="ͳ��" class='np coolbg' />
        ע:�·�ͳ��
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
  <tr bgcolor="#FBFCE2">
    <td  align="center" style="white-space:nowrap;">Ա�����</td>
    <td align="center">����</td>
    <td  align="center">�׶ε÷�</td>
    <td  align="center">����</td>
    <td  align="center">��ʷ���ܷ�ֵ</td>
  </tr>
 <?php $i=0;?>
  <form name="form1">
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
 
   
   $i++;
    $bgcolor="#FFffff";
    ?>
    <tr   bgcolor='<?php echo $bgcolor?>' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='<?php echo $bgcolor?>';">
      <td align="center" ><?php echo GetEmpCodeByEmpId($fields['integral_empid']);?></td>
      <td align="center"  ><?php echo GetEmpNameById($fields['integral_empid']);?></td>
       <td  align="center"  ><?php echo (double)($fields['totalfz']);?></td>
<td  align="center" style='white-space:nowrap; ' >
      
      
     <?php echo "��".$i."��";?>
      
      
      </td>
      <td  align="center" style='white-space:nowrap; ' >
      
      
      <?php echo Getoldempfz($fields['integral_empid']);?>
      
      
      
      </td>
     
    </tr>
    
    
    
    
    <?php
}
}?>
  </form>
  
</table>
</body>
</html>