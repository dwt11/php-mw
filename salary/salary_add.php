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
//
//require_once(DEDEINC."/customfields.func.php");
//require_once(DEDEPATH."/inc/inc_archives_functions.php");
getconfig();
if(empty($dopost)) {
	
		require_once(DEDEPATH."/emp/emp.inc.options.php");	

	
	
		$salary_kq="";
		$salary_kqsm="";

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
			 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
//dump($ejcd);
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=1 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					  ////dump($row);
					   $salary_kq = $row['dd']*$yjcd;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0) $salary_kqsm="һ���ٵ�".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=2 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$ejcd;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="�����ٵ�".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=3 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$sjcd;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="�����ٵ�".$row['dd']."�� ";
	
	
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=11 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$yjzt;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0)   $salary_kqsm="һ������".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=12 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$ejzt;  //һ���ٵ�ÿ��10Ԫ
					  if($row['dd']>0)   $salary_kqsm.="��������".$row['dd']."�� ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=13 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$sjzt;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="��������".$row['dd']."�� ";
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=21 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$kgbt;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="��������".$row['dd']."�� ";
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=22 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$kgyt;  //һ���ٵ�ÿ��10Ԫ
					   if($row['dd']>0)  $salary_kqsm.="����һ��".$row['dd']."�� ";
	
	
	
						if($salary_kqsm=="")  $salary_kqsm="δ��ѯ��Υ�濼�ڼ�¼ ";
				
				}
			
			
			}
	$dopost = '';
}




/*------------------------
function getCatMap() {  }
-------------------------
���ڵ�ѡ��Ա-���radio ������ʹ��*/
else if($dopost=='getEmpMap_radio')
{
		require_once('../emp/emp.inc.class.radio.php');
		AjaxHead();
		//���AJAX���ƶ�����
		$divname = 'getEmpMap_radio';
		$tus = new empMapRadio();
	?>
<form name='quicksel' action='javascript:;' method='get'>
  <div class='quicksel'>
    <?php $tus->empAllRadio(); ?>
  </div>
  <div align='center' class='quickselfoot'><img src="../images/button_ok.gif" onClick="getSelCat('<?php echo $targetid; ?>','<?php echo $targetid_display; ?>');" width="60" height="22" class="np" border="0" style="cursor:pointer" />&nbsp;&nbsp;<img src="../images/button_back.gif" onclick='CloseMsg();' width="60" height="22" border="0"  style="cursor:pointer" /></div>
</form>
<?php
	//AJAX�������
	exit();
}

/*------------------------
function getEmpMap_checbox() {  }
-------------------------
���ڶ�ѡ��Ա ������ʹ�� ���checbox*/
else if($dopost=='getEmpMap_checkbox')
{
		require_once('../emp/emp.inc.class.checkbox.php');
		AjaxHead();
		//���AJAX���ƶ�����
		$divname = 'getEmpMap_checkbox';
		$tus = new empMapCheckbox();
	?>
<form name='quicksel' action='javascript:;' method='get'>
  <div class='quicksel'>
    <?php $tus->empAllCheckbox(); ?>
  </div>
  <div align='center' class='quickselfoot'><img src="../images/button_ok.gif" onClick="getSelCat('<?php echo $targetid; ?>','<?php echo $targetid_display; ?>');" width="60" height="22" class="np" border="0" style="cursor:pointer" />&nbsp;&nbsp;<img src="../images/button_back.gif" onclick='CloseMsg();' width="60" height="22" border="0"  style="cursor:pointer" /></div>
</form>
<?php
	//AJAX�������
	exit();
}



/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
    
	
	
	
	$salary_empid=trim($salary_empid); 
	$salary_empids=trim($salary_empids); 


/*�˶��Ѿ�û������,��Ϊ�ɶ�ѡԱ��150111
    //����ǿ���ѡ����ѡ���Ա��
	if($salary_empids!="")
      {
	$salary_empid=$salary_empids; 

	  }
	$salary_yf=trim($salary_yf); 
*/	
	
/*�˶��Ѿ�û������,��Ϊ���� ���  ������Ӷ���150111
	$questr="SELECT salary_empid FROM `dede_salary` where salary_hy='".$salary_yf."' and salary_empid =".$salary_empid;
			////dump($questr);
			$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
    {
		ShowMsg("��ѡ�·��Ѿ����ڴ�Ա���Ĺ��ʣ�","-1");
		exit(); 
	}
*/		
    
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
	$salary_markdate= date("Y-m-d", time());; 
	$salary_yfmoney=$salary_jb+$salary_jj-$salary_hs-$salary_kq-$salary_qtsub+$salary_qtadd;


    setcookie("SALARY_YF_COOK",$salary_yf,time()+3600*12,"/");   //150122�ͻ�ÿ����ӹ���ʱ,���ǵ��������,�������ｫ���ڱ���,Ȼ���´����ʱ��ȡCOOKIE(����12��Сʱ)

    //����Ƕ�ѡ��Ա��
	if($salary_empids!="")
      {
		$empids = explode(',', $salary_empids);
        if(is_array($empids))
        {
            foreach($empids as $v)
            {
                if($v=='') continue;
				
				  $query = "
				   INSERT INTO `dede_salary` (salary_empid,salary_yf,salary_jb,salary_jbsm,salary_jj,salary_jjsm,salary_hs,salary_hssm,salary_kq,salary_kqsm,salary_qtsub,salary_qtsubsm,salary_qtadd,salary_qtaddsm,salary_czy,salary_markdate,salary_lqdate,salary_lqname,salary_yfmoney,salary_sf)
									VALUES (".$v.", '".$salary_yf."', '".$salary_jb."', '".$salary_jbsm."', '".$salary_jj."', '".$salary_jjsm."', '".$salary_hs."', '".$salary_hssm."','".$salary_kq."', '".$salary_kqsm."', '".$salary_qtsub."', '".$salary_qtsubsm."', '".$salary_qtadd."', '".$salary_qtaddsm."', ".$cuserLogin->getUserID().", '".$salary_markdate."', null,null, '".$salary_yfmoney."',null);
				  ";
			   
			   
				 if(!$dsql->ExecuteNoneQuery($query))
				{
					ShowMsg("�������ʱ��������ԭ��", "-1");
					exit();
				}
   
            }
        }
	  }else
	  
	  {

			$query = "
			 INSERT INTO `dede_salary` (salary_empid,salary_yf,salary_jb,salary_jbsm,salary_jj,salary_jjsm,salary_hs,salary_hssm,salary_kq,salary_kqsm,salary_qtsub,salary_qtsubsm,salary_qtadd,salary_qtaddsm,salary_czy,salary_markdate,salary_lqdate,salary_lqname,salary_yfmoney,salary_sf)
							  VALUES (".$salary_empid.", '".$salary_yf."', '".$salary_jb."', '".$salary_jbsm."', '".$salary_jj."', '".$salary_jjsm."', '".$salary_hs."', '".$salary_hssm."','".$salary_kq."', '".$salary_kqsm."', '".$salary_qtsub."', '".$salary_qtsubsm."', '".$salary_qtadd."', '".$salary_qtaddsm."', ".$cuserLogin->getUserID().", '".$salary_markdate."', null,null, '".$salary_yfmoney."',null);
			";
			 if(!$dsql->ExecuteNoneQuery($query))
			{
				ShowMsg("�������ʱ��������ԭ��", "-1");
				exit();
			}
	  }
	
	
	
	
	
   
    ShowMsg("�ɹ����Ա�����ʣ�",$ENV_GOBACK_URL);
    exit();
}

//��ȡ���ڿۿ����  ȫ��
function getconfig()
 {  
 
 			global $dsql;

 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
	  $yjcd=0;//һ���ٵ�</td>
          $ejcd=0;//�����ٵ�</td>
		  $sjcd=0;//�����ٵ�</td>
          
		  $yjzt=0;//һ������</td>
		 $ejzt=0;//��������</td>
         $sjzt=0;//��������</td>

  $arcQuery = "SELECT *  from #@__salary_config  WHERE id='1' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }else{
		  
		  
		  $yjcd=$arcRow['yjcd'];//һ���ٵ�</td>
          $ejcd=$arcRow['ejcd'];//�����ٵ�</td>
		  $sjcd=$arcRow['sjcd'];//�����ٵ�</td>
          
		  $yjzt=$arcRow['yjzt'];//һ������</td>
		 $ejzt=$arcRow['ejzt'];//��������</td>
         $sjzt=$arcRow['sjzt'];//��������</td>

         $kgbt=$arcRow['kgbt'];//��������</td>
         $kgyt=$arcRow['kgyt'];//��������</td>
	//dump($ejcd);	
		}
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
<script src="../js/main.js"></script>
<script language="javascript">
function checkSubmit()
{
	 //�Ĺ�δѡ��Ա��
	if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100)&&document.form1.salary_empids.value=="")
	
	//��ѡ150111ע����Ϊ��ѡ
	//if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100))
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
    var nv_display = document.form1.salary_empids_display.value;
   // var empids = document.form1.integral_empids.value;
    if(nv_display=="")
    {
		if(nv!=-100)
		{
			//location.href='salary_add.php?selectempid='+nv+'&salary_empids='+empids+'&date='+date;
			//location.href='salary_add.php?selectempid='+nv+'&date='+date;
			location.href='salary_add.php?selectempid='+nv+'&date='+date;
		}
		else
		{
			alert('��ѡ��Ա��,�㵱ǰѡ����ǲ��ţ�');
		}
	}
}
/*�˶�����
function ChangePage2_d(sobj)
{
    var nvs = document.form1.salary_empids.value;
    var nvs_display = document.form1.salary_empids_display.value;
	if(nvs!=null)nv=nvs;
	var date=document.form1.salary_yf.value;
   // var empids = document.form1.integral_empids.value;
    if(nv!=-100)
    {
        //location.href='salary_add.php?selectempid='+nv+'&salary_empids='+empids+'&date='+date;
		location.href='salary_add.php?selectempid='+nv+'&selectempid_display='+nv_display+'&date='+date;
    }
}
*/






/*/��ѡ150111ע����Ϊ��ѡ�����ڵ�����ѡ��Ա��ֵ����input
//targetId���浽���ݿ�
//targetId_displayҳ���Ѻ���ʾ
function getSelCat(targetId,targetId_display)
{
	var selBox = document.quicksel.selempid;
	var targetObj = $DE(targetId);
	var selvalue = '';
	var seldisplay = '';

	for(var i=0; i< selBox.length; i++)
	{
			if(selBox[i].checked) {
				seldisplay =  selBox[i].nextSibling.nodeValue;
				selvalue =  selBox[i].value;
				 break;
			}
	}
	if(selvalue=='')
	{
		alert('��û��ѡ���κ���Ŀ��');
		return ;
	}else	if(targetObj)
	{
	   	var date=document.form1.salary_yf.value;
		// var empids = document.form1.integral_empids.value;
		location.href='salary_add.php?selectempid='+selvalue+'&selectempid_display='+seldisplay+'&date='+date;
	 }
}
*/




//���ڶ�ѡ��Ա1450111���*/

//targetId���浽���ݿ�
//targetId_displayҳ���Ѻ���ʾ
function getSelCat(targetId,targetId_display)
{
	var selBox = document.quicksel.selempid;
	var targetObj = $DE(targetId);
	var targetdisplayObj = $DE(targetId_display);
	var selvalue = '';
	var seldisplay = '';

	var j = 0;
	for(var i=0; i< selBox.length; i++)
	{
			if(selBox[i].checked) {
				j++;
				//if(j==10) break;//���ѡ��ʮ��
				selvalue += (selvalue=='' ? selBox[i].value : ','+selBox[i].value);
				seldisplay += (seldisplay=='' ? selBox[i].nextSibling.nodeValue : ','+selBox[i].nextSibling.nodeValue);
			}
	}



	if(selvalue=='')
	{
		alert('��û��ѡ���κ���Ŀ��');
		return ;
	}else if(targetObj) 
	{
		targetObj.value = selvalue;
		targetdisplayObj.value = seldisplay;
	
	}

	
	CloseMsg();

	
}

</script>

<!--//select����ѡ��� �Զ�����������-->
<script type="text/javascript" src="../js/jquery/jquery.selectseach.min.js"></script>
<script>
function getmydata(){
	alert($('#sssss').val());
}
$(document).ready(function(){
   $('select').selectseach(); 
}); 

</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="salary_add.php" method="post"    onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
          <tr>
            <td    width="10%" class="bline" align="right">&nbsp;<b>Ա����ѡ</b>��</td>
            <td  class="bline"><table>
                <tr>
                  <td width="200px"><span id='typeidct'>
                    <?php
          $EmpOptions = GetEmpOptionList($selectempid);
          echo "<div style='width:300px'><span style='color:#999; float:right'>֧�ֱ��\����\ƴ������ĸ����</span><select name='salary_empid' id='salary_empid'  onChange='ChangePage2()'  m='search'>\r\n";
          echo "<option value='0'>��ѡ��Ա��...</option>\r\n";
          echo $EmpOptions;
          echo "</select></div>";
			?>
                    </span></td>
                  <td><input type='hidden' name='salary_empids' id='salary_empids' value='<?php echo $selectempid;?>'  >
                    
                    <!-- ��ѡԱ��

             <input type='text' name='salary_empids_display' id='salary_empids' value='<?php echo $selectempid_display;?>'    style='width:100px;'  onClick="AlertMsg(event,'ѡ��Ա��','?dopost=getEmpMap_radio&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500)"   readonly="readonly" >
                     <a onClick="AlertMsg(event,'ѡ��Ա��','?dopost=getEmpMap_radio&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500);" href="javascript:;">
--> 
                    &nbsp;&nbsp;<b>Ա����ѡ</b>��
                    <input type='text' name='salary_empids_display' id='salary_empids_display' value='<?php echo $selectempid_display;?>'    style='width:200px;'  onClick="AlertMsg(event,'ѡ��Ա��','?dopost=getEmpMap_checkbox&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500)"   readonly="readonly" >
                    <a onClick="AlertMsg(event,'ѡ��Ա��','?dopost=getEmpMap_checkbox&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500);" href="javascript:;"> <img src='../images/ico/search.gif' style='cursor:pointer;'  alt='ѡ����Ա' title='ѡ����Ա' /></a> <span style="color:#999">�����ѡԱ��,���Զ����ڿۿ��ʧЧ</span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline"><?php
				  if($date==""){
                  
				       //���cook��������һ����ӵ�����  ��ʹ����һ�ε�
					   //����ʹ�÷������ĵ�ǰ����
                       if($SALARY_YF_COOK=="")
					   {
						     $nowtime =date("Y-m-d", time());
					   }else
					   {
						     $nowtime =$SALARY_YF_COOK;
					   }
                    }
                    else
                    
                    {
                    $nowtime =$date;
                    }
                    
                   
                          ?>
              <input type="text" name="salary_yf" size="14" value="<?php echo $nowtime;?>" readonly class="Wdate"  onChange='ChangePage2(this)'  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-{%d-5}'})"/></td>
            
            <!--  <input type="text" name="salary_yf" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"    onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/>
   --> 
            
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline"><input type="text" name="salary_jb" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
              <input type="text" name="salary_jbsm" size="30"   /></td>
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
            <td  class="bline"><input type="text" name="salary_kq" size="10"  value="<?php echo $salary_kq?>"  />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
              <input type="text" name="salary_kqsm" size="30"  value="<?php echo $salary_kqsm?>"   /></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>�������</b>��</td>
            <td  class="bline"><input type="text" name="salary_qtadd" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
              <input type="text" name="salary_qtaddsm" size="30"   /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline"><input type="text" name="salary_qtsub" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>˵��</b>��
              <input type="text" name="salary_qtsubsm" size="30"   /></td>
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
