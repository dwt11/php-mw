<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	



$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$title="����ͳ��"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //���ϱ��
      
	 
}

$startdate = isset($startdate) ? $startdate : "";  
$enddate = isset($enddate) ? $enddate : "";   

//4����
if($startdate=="")$startdate=date("Y-m",time())."-01";
if($enddate=="")
{
		$nowmonthmaxday=date('t', strtotime($startdate));//�����µ��������
		$enddate=date("Y-m",time())."-".$nowmonthmaxday;
	
}
       

    
if ($startdate!="" && $enddate!="")
{
 // $title.="����:��".$startdate."��".$enddate;
 // $startdate1=GetMkTime($startdate);      //(ʱ���)���ѡ����ʼ���ڵĿ�ʼʱ�� ��ʽ  2014-11-04 00:00:00
 // $enddate1=GetMkTime($enddate)+86399;    //(ʱ���)���ѡ���������ڵĽ���ʱ���ʽ2014-11-04 23:59:59   86399����23Сʱ59��59��
  //dump(GetDateTimeMk($startdate1).GetDateTimeMk($enddate1));
  $wheresql  .= " And (date_format(integral_date, '%Y-%m-%d')>= '$startdate' and date_format(integral_date, '%Y-%m-%d')<= '$enddate')"; //qq
}

$date = isset($date) ? $date : "";   

$emp_dep  = isset($emp_dep ) ? $emp_dep  : 0;   
if($emp_dep!=0)
{
  
	   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //���ϱ��
//  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //���ϱ��
      
	 
}



$integral_class  = isset($integral_class ) ? $integral_class  : "a";   

 if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //���ϱ��
      
	 
}


//����Ȩ������
//$emp_depidRoles= getDepRole($funAllName,"");
//if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //���ϱ��


//$sql = "SELECT *,SUM(integral_fz) as totalfz from dede_integral   $wheresql and integral_class='b'   GROUP BY integral_empid";
$sql = "SELECT *,SUM(integral_fz) as totalfz from dede_integral   $wheresql    GROUP BY integral_empid order by totalfz desc";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 300;


$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("date",$date);      //�ؼ���
$dlist->SetParameter("integral_class",$integral_class);      //�����ֶ�
$dlist->SetParameter("emp_dep",$emp_dep);      //�����ֶ�


$tplfile = "integral_query.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ





//��ȡ
function Getoldempfz($empid)
{

			global $dsql;
	
		$questr1="SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where integral_class='b' and integral_empid='".$empid."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="0";
		}
		else
		{
		
			$str=$rowarc1['totalfz'];
		
		
		}
	

return (double)($str);


}


	







?>