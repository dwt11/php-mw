<?php
/**
 * ���
 *
 * @version        $Id: spec_add.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");




if(empty($dopost)) {
	    //��ȡ�鵵��Ϣ
    $arcQuery = "SELECT *  from dede_integral  WHERE integral_id='$aid' ";
	$row = $dsql->GetOne($arcQuery);
    if(!is_array($row))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }
	
		if(empty($integral_class))$integral_class=$row['integral_class'];;
		if(empty($integral_gzid))$integral_gzid=$row['integral_gzid'];;
		$gzOptions="";
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
		if($integral_class!=""){
		  // ���ѡ����
			  global $dsql;
				   $gzOptions.="<option value='-1'";
				   
				   if($integral_gzid==-1)$gzOptions.=" selected='selected'";
				   $gzOptions.=">".strtoupper($integral_class)."��������ֵ</option>";
			  $query1="SELECT * FROM `#@__integral_guizhe` where gz_class='".$integral_class."' order by gz_id desc";
			  //dump($query);
			  $dsql->Execute('c', $query1);
			  while($row1 = $dsql->GetArray('c'))
			  {
				$isaors="&nbsp;&nbsp;";
				if($row1['gz_aors']=="add")$isaors="��";
				if($row1['gz_aors']=="sub")$isaors="��";
				
			 
				   $gzOptions.="<option value='".$row1['gz_id']."'";
				   if($integral_gzid==$row1['gz_id'])$gzOptions.=" selected='selected'";
				   $gzOptions.=">".$isaors." ".$row1['gz_fz']."  ".$row1['gz_name']."</option>";
			  }
			}
			
				   $gzOptions.="<option value='0'";
				   if($integral_gzid==0)$gzOptions.=" selected='selected'";
				   $gzOptions.="> ��������</option>";
			
	$dopost = '';
	
	
	
	

}






/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
	$integral_empid=trim($integral_empid);
	$integral_date=trim($integral_date);
	$integral_gzid=trim($integral_gzid);
	$integral_class=trim($integral_class);
	
	$questr="SELECT * FROM `dede_integral_guizhe` where gz_id =".$integral_gzid;
					//dump($questr);
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
    {
		$integral_fz=$rowarc['gz_fz'];
		$integral_aors=$rowarc['gz_aors'];
		if($rowarc['gz_aors']=="sub")$integral_fz="-".$rowarc['gz_fz'];

	}
	
	
	//������ֵ
	if($integral_gzid==-1)$integral_fz=$integral_qtfz;  //���ѡ��������  �򱣴��ֶ�����ֵ�����ڳ�ʼ����
	$integral_bz=trim($integral_bz);
	$integral_markdate=date("Y-m-d", time());
		
   
	$query = "UPDATE `dede_integral` SET  
	`integral_empid`='$integral_empid', 
	`integral_date`='$integral_date', 
	`integral_gzid`='$integral_gzid', 
	`integral_class`='$integral_class', 
	`integral_aors`='$integral_aors', 
	`integral_fz`='$integral_fz', 
	`integral_bz`='$integral_bz', 
	`integral_markdate`='$integral_markdate', 
	`integral_czy`='1'
	 WHERE (`integral_id`='$aid');";

	
 //dump($query);
   
   
	 if(!$dsql->ExecuteNoneQuery($query))
	{
		ShowMsg("��������ʱ��������ԭ��", "-1");
		exit();
	}
   
	 
   
   ShowMsg("�ɹ��༭���ּ�¼��",$ENV_GOBACK_URL);
   exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script language='javascript' src="../js/dialog.js"></script>
<script language="javascript">
function checkSubmit()
{
  
	 
	 //�Ĺ�δѡ��Ա��
	if(document.form1.integral_empid.value==0)
	{
		alert('��ѡ��Ա����');
		return false;
	}
	 
	if(document.form1.integral_class.value=="")
	{
		alert('��ѡ��������ͣ�');
		return false;
	}
	 
     return true;
}


function ChangePage2()
{
    var nv = document.form1.integral_class.value;
    var empid = document.form1.integral_empid.value;
    var aid = document.form1.aid.value;
	var date=document.form1.integral_date.value;
  
        location.href='integral_edit.php?integral_class='+nv+'&integral_empid='+empid+'&aid='+aid+'&integral_date='+date;
    
}




</script>

</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="integral_edit.php" method="post"    onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
          <input type="hidden" name="aid" value="<?php echo $aid?>" />
          <tr>
            <td    width="10%" class="bline" align="right">&nbsp;<b>Ա��</b>��</td>
            <td  class="bline"><table>
                <tr>
                  <td width="200px"><?php
          $integral_empid=$row['integral_empid'];
		  
		  $EmpOptions = GetEmpOptionList($integral_empid);
          echo "<select disabled=\"disabled\">\r\n";
          echo "<option value='0'>��ѡ��Ա��...</option>\r\n";
          echo $EmpOptions;
          echo "</select>";
			?>
            <input name="integral_empid" type="hidden" value="<?php echo $integral_empid?>" />
            </td>
                  <td></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline"><?php
                  
          if(empty($integral_date))$integral_date=$row['integral_date'];
				  
				  if($integral_date==""){
                  
                    $nowtime =date("Y-m-d", time());
                    }
                    else
                    
                    {
                    $nowtime =$integral_date;
                    }
                    
                    
                          ?>
              <input type="text" name="integral_date" size="23" value="<?php echo $nowtime;?>" readonly class="Wdate"    onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline">
 
            <select name="integral_class" onChange='ChangePage2()'>
                <option value="">��ѡ��</option>
                
               <?php for($i=65;$i<74;$i++)
			   { 
				   echo "<option value=".strtolower(chr($i))."";
				   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
				   echo ">".strtoupper(chr($i))."����</option>";
			   
			   }?>
                
                </select></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>������Ŀ</b>��</td>
            <td  class="bline"><?php
          echo "<select name='integral_gzid' id='integral_gzid'   >\r\n";
          echo "<option value='0'>��ѡ�����...</option>\r\n";
          echo $gzOptions;
          echo "</select>";
			?></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>������ֵ</b>��</td>
            <td  class="bline"><input type="text" name="integral_qtfz" size="30"  value='<?php echo $row['integral_fz']?>' />
              �༭������ĿΪ��������ֵ���͡��������롱�����ݲ������� </td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>��ע</b>��</td>
            <td  class="bline"><input type="text" name="integral_bz" size="30"   value='<?php echo $row['integral_bz']?>'   /></td>
          </tr>
          <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" ��  �� " class="coolbg np" /></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
