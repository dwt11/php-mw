<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$inputdate=$inputdate;  //input ��������Ҫ������·� 
$integral_class=$integral_class;  //��������


////dump ($inputdate);

if(empty($dopost)) $dopost = '';
$totalhj=0;
getconfig($integral_class);  //��ȡ�۷ֹ���
if($dopost=='input')
{
	$truenumb=0;  //�ɹ����������
	$falsenumb=0;  //����ʧ�ܵ�����
    
	
	$get_no_input_data="Select *,count(*) as dd  From `dede_checkin` WHERE
	                     date_format(kq_hw_emptime, '%Y-%m') = '$inputdate' and kq_zt>0 and kq_zt<100
                         GROUP BY kq_zt,kq_hw_empcode,kq_hw_emptime";
    $dsql->Execute('c', $get_no_input_data);
    while($row = $dsql->GetArray('c'))
    {
				$integral_empid=getempid($row['kq_hw_empcode']);
				$integral_date=$row['kq_hw_emptime'];
				$integral_gzid=$row['kq_hw_empcode'];
				//$integral_class="b";
				$integral_gzid=0;
				$integral_aors="sub";
				$integral_fz="-".(double)(GetSub($row['kq_zt'],$row['dd']));
				$integral_bz="����Υ��".strtoupper($integral_class)."�ֿ۷���".$row['kq_hw_emptime'].GetSm($row['kq_zt']);
				$integral_markdate=date("Y-m-d", time());
				$questr="SELECT * FROM `dede_integral` where integral_class='$integral_class' and  integral_date ='".$integral_date."' and integral_empid=".$integral_empid;
				$rowarc = $dsql->GetOne($questr);
				if(is_array($rowarc))
				{
					//��ʱ��ļ�¼�Ѿ�������Թ�
									  $falsenumb++;
				  } else
						{	$query = "
							 INSERT INTO `dede_integral` (`integral_empid`, `integral_date`, `integral_gzid`, `integral_class`, `integral_aors`, `integral_fz`, `integral_bz`, `integral_markdate`, `integral_czy`)
							  VALUES ('".$integral_empid."', '".$integral_date."', '".$integral_gzid."', '".$integral_class."', '".$integral_aors."', '".$integral_fz."', '".$integral_bz."', '".$integral_markdate."',".$cuserLogin->getUserID().")";
							
					  
							if(!$dsql->ExecuteNoneQuery($query))
							  {
								  $falsenumb++;
							  }else{
								  $truenumb++;
								  }
								  
						}
						 
					  
				}
    
  ShowMsg("����Υ��".strtoupper($integral_class)."�ֿ۷���,�����·�: ".$inputdate .",�ɹ�  ".$truenumb." ��,������ظ���¼ʧ�� ".$falsenumb." ����","integral_input.php");
   exit();
}














$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$sql = "Select *,count(*) as dd  From `dede_checkin` WHERE
	date_format(kq_hw_emptime, '%Y-%m') = '$inputdate' and kq_zt>0 and kq_zt<100
    GROUP BY kq_zt,kq_hw_empcode,kq_hw_emptime";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;


$dlist->SetParameter("inputdate",$inputdate);  //Ա��״̬����


$tplfile = "integral_input_1.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ




//��ȡԱ����� 
function getempid($empcode)
{

			global $dsql;
	
		$questr1="SELECT emp_id FROM `#@__emp` where emp_code='".$empcode."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="�޼�¼";
		}
		else
		{
		
			$str=$rowarc1['emp_id'];
		
		
		}
	
		
	

return $str;


}
//��ʾ�����Ĳ������� 




//��ȡ�����ֵ
//$kqzt ״̬ 
//
//$numb����
function GetSub($kq_zt,$numb)
{
			 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;


					    if($kq_zt==1)$integral_kq = $numb*$yjcd;  //һ���ٵ�ÿ��10Ԫ
	
	
					   if($kq_zt==2)$integral_kq = $numb*$ejcd;  //һ���ٵ�ÿ��10Ԫ
					   if($kq_zt==3)$integral_kq = $numb*$sjcd;  //һ���ٵ�ÿ��10Ԫ

					  if($kq_zt==11) $integral_kq = $numb*$yjzt;  //һ���ٵ�ÿ��10Ԫ

					  if($kq_zt==12) $integral_kq = $numb*$ejzt;  //һ���ٵ�ÿ��10Ԫ


					  if($kq_zt==13) $integral_kq = $numb*$sjzt;  //һ���ٵ�ÿ��10Ԫ

					  if($kq_zt==21) $integral_kq = $numb*$kgbt;  //һ���ٵ�ÿ��10Ԫ

					  if($kq_zt==22) $integral_kq = $numb*$kgyt;  //һ���ٵ�ÿ��10Ԫ


return $integral_kq;


}



function GetSm($kq_zt)
{


          if($kq_zt==1)$kqzt_temp="һ���ٵ�";
          if($kq_zt==2)$kqzt_temp="�����ٵ�";
          if($kq_zt==3)$kqzt_temp="�����ٵ�";
          if($kq_zt==11)$kqzt_temp="һ������";
          if($kq_zt==12)$kqzt_temp="��������";
          if($kq_zt==13)$kqzt_temp="��������";
	      if($kq_zt==21)$kqzt_temp="��������";
          if($kq_zt==22)$kqzt_temp="����һ��";

//dump($kqzt_temp);
//dump($kqzt_zt);
return $kqzt_temp;




}



//��ȡ���ڿۿ����  ȫ��
function getconfig($integral_class)
 {  
 
	  global $dsql;
	  
	  global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
	  $yjcd=0;//һ���ٵ�</td>
	  $ejcd=0;//�����ٵ�</td>
	  $sjcd=0;//�����ٵ�</td>
	  
	  $yjzt=0;//һ������</td>
	  $ejzt=0;//��������</td>
	  $sjzt=0;//��������</td>
	  
	  $id=0;
	  for($i=65;$i<74;$i++)
	 { 
		 if(strtolower(chr($i))==$integral_class)$id=$i-64;
	 }
               

	if($id!=0)
	{
	
		  $arcQuery = "SELECT *  from #@__integral_checkinConfig  WHERE id='$id' ";
		  // //dump($arcQuery);
			$arcRow = $dsql->GetOne($arcQuery);
			if(!is_array($arcRow))
			{
				ShowMsg("��ȡ���ڿ۷�������Ϣ����!","-1");
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
				
			}
	}
}



//��ʾ�����Ĳ������� 
function GetDep($empcode)
{
			global $dsql;
	
		$questr1="SELECT dep_name FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_code='".$empcode."')";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="�޲��ż�¼";
		}
		else
		{
		
			$str=$rowarc1['dep_name'];
		
		
		}
	

return $str;

}





?>