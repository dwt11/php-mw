<?php
/**
 * ר��༭
 *
 * @version        $Id: spec_edit.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
if(empty($dopost)) $dopost = '';
if($dopost=='')
{
		require_once(DEDEPATH."/emp/emp.inc.options.php");	

    



if($selectempid>0){
			// ���ѡ����Ա�� ���ѯ���Ŀ��� 
				global $dsql;
				
				$questr1="SELECT emp_code FROM `#@__emp` where emp_id='".$selectempid."'";
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
						$salary_kq=0;
						$salary_kqsm="δ��ѯ�����ڼ�¼";
				}
				else
				{
				
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=1 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					  ////dump($row);
					   $salary_kq = $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0) $salary_kqsm="һ���ٵ�".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=2 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="�����ٵ�".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=3 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="�����ٵ�".$row['dd']."�� ";
	
	
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=11 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0)   $salary_kqsm="һ������".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=12 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0)   $salary_kqsm.="��������".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=13 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*10;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="��������".$row['dd']."�� ";
	
	
	
						if($salary_kqsm=="")  $salary_kqsm="δ��ѯ��Υ�濼�ڼ�¼ ";
				
				}
			
			
			}




//��ȡ�鵵��Ϣ
    $arcQuery = "SELECT *  from #@__salary  WHERE salary_id='$aid' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }


}
/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
	$salary_empid=trim($salary_empid); 
	$salary_yf=trim($salary_yf); 


	$salary_jb=(double)trim($salary_jb); 
	$salary_jbsm=trim($salary_jbsm); 
	$salary_jj=(double)trim($salary_jj); 
	$salary_jjsm=trim($salary_jjsm); 
	$salary_hs=(double)trim($salary_hs); 
	$salary_hssm=trim($salary_hssm); 
	$salary_kq=(double)trim($salary_kq); 
	$salary_kqsm=trim($salary_kqsm); 
	$salary_qtsub=(double)trim($salary_qtsub); 
	$salary_qtsubsm=trim($salary_qtsubsm); 
	$salary_qtadd=(double)trim($salary_qtadd); 
	$salary_qtaddsm=trim($salary_qtaddsm); 
	$salary_markdate= date("Y-m-d", time()); 
$salary_yfmoney=$salary_jb+$salary_jj-$salary_hs-$salary_kq-$salary_qtsub+$salary_qtadd;

	    $inQuery = "UPDATE `#@__salary` SET 
salary_empid='$salary_empid',
	salary_yf='$salary_yf',
	salary_jb='$salary_jb',
	salary_jbsm='$salary_jbsm',
	salary_qtsub='$salary_qtsub',
	salary_qtsubsm='$salary_qtsubsm',
	salary_qtadd='$salary_qtadd',
	salary_qtaddsm='$salary_qtaddsm',
	salary_yfmoney='$salary_yfmoney' 
  WHERE (`salary_id`='$aid')
	";
	
	
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("��������ʱ��������ԭ��", "-1");
        exit();
    }

    ShowMsg("�޸Ĺ�����Ϣ�ɹ���",$ENV_GOBACK_URL);
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
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script language='javascript' src="../js/main.js"></script>
<script language="javascript">
function checkSubmit()
{
  
	 
	 //�Ĺ�δѡ��Ա��
//	if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100)&&document.form1.salary_empids.value=="")
	if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100))
	{
		alert('��ѡ��Ա����');
		return false;
	}
	 
     return true;
}


function ChangePage2(sobj)
{
    var nv = document.form1.salary_empid.value;
	var date=document.form1.salary_yf.value;
    //var empids = document.form1.integral_empids.value;
    if(nv!=-100)
    {
        
//location.href='salary_add.php?selectempid='+nv+'&salary_empids='+empids+'&date='+date;

location.href='salary_edit.php?aid=<?php echo $aid; ?>&selectempid='+nv+'&date='+date;
    }
    else
    {
		alert('��ѡ��Ա��,�㵱ǰѡ����ǲ��ţ�');
    }
}


</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
      
      
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="salary_edit.php" method="post"  enctype="multipart/form-data"  onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
  <input type="hidden" name="aid" value="<?php echo $aid; ?>" />

          <tr>
            <td width="10%" class="bline" align="right">&nbsp;<b>Ա��</b>��</td>
            <td  class="bline">
              
              <span id='typeidct'>
       <?php
          $EmpOptions = GetEmpOptionList($arcRow['salary_empid']);
          echo "<select name='salary_empid' id='salary_empid'  onChange='ChangePage2()'   >\r\n";
         // echo "<select name='salary_empid' id='salary_empid' >\r\n";
          echo "<option value='0'>��ѡ��Ա��...</option>\r\n";
          echo $EmpOptions;
          echo "</select>";
			?></span>  ������޸�
<!--              <input type='text' name='salary_empids' id='integral_empids' value='<?php echo $salary_empids;?>' style='width:200px;'  readonly="readonly" >
                      <img src='../images/ico/search.gif' style='cursor:pointer;' onClick="ShowEmpMap(event, this,  'salary_empids')" alt='ѡ����Ա' title='ѡ����Ա' />
-->            </td>
          </tr>
          
          <tr>
            <td    class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
            
            
            <?php
            $date= $arcRow['salary_yf'];
                  if($date==""){
                  
                    $nowtime =date("Y-m-d", time());
                    }
                    else
                    
                    {
                    $nowtime =$date;
                    }
                    
                    
                          ?>
              <input type="text" name="salary_yf" readonly="readonly" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"  onChange='ChangePage2(this)'  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/>
              
              
              ������޸�</td>
   


  <!--    <input type="text" name="salary_yf" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"    onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/>
      --> 
      
      </td>          
          </tr>
    
    
              <tr>
            <td    class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_jb" size="10"   value="<?php echo $arcRow['salary_jb'];?>" />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_jbsm" size="30"   value="<?php echo $arcRow['salary_jbsm'];?>" />

              </td>
          </tr>



            <!--  <tr>
            <td    class="bline" align="right">&nbsp;<b>�ʽ�</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_jj" size="10"   />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_jjsm" size="30"   />

              </td>
          </tr>



              <tr>
            <td   class="bline" align="right">&nbsp;<b>��ʳ��</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_hsf" size="10"   />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_hsfsm" size="30"   />

              </td>
          </tr>

-->

              <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_kq" size="10"  value="<?php echo $salary_kq?>"  />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_kqsm" size="30"  value="<?php echo $salary_kqsm?>"   />

              </td>
          </tr>



              <tr>
            <td    class="bline" align="right">&nbsp;<b>�������</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_qtadd" size="10"   value="<?php echo $arcRow['salary_qtadd'];?>" />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_qtaddsm" size="30"  value="<?php echo $arcRow['salary_qtaddsm'];?>"  />

              </td>
          </tr>



              <tr>
            <td   class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline">
              <input type="text" name="salary_qtsub" size="10"  value="<?php echo $arcRow['salary_qtsub'];?>"  />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
                            <input type="text" name="salary_qtsubsm" size="30" value="<?php echo $arcRow['salary_qtsubsm'];?>" />

              </td>
          </tr>






     
            <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td >
	    <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" border="0" class="np" />
                  </td>
                          </tr>
        </form>
      </table>
      
   
   </td>
  </tr>
</table>
</body>
</html>
