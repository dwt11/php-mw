<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	

if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("delete from  `#@__salary`  where salary_id='$aid';");
	ShowMsg("ɾ���ɹ���",$ENV_GOBACK_URL);
	exit();
}



$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$title="���ʹ���"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And salary_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //���ϱ��
      
	 
}


if($emp_dep!=0)
{
  $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //���ϱ��
 
	  //$wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //���ϱ��
      
	 
}


//����Ȩ������
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //���ϱ��





//4����    
$startdate = isset($startdate) ? $startdate : "";  
$enddate = isset($enddate) ? $enddate : "";   
if ($startdate!="" && $enddate!="")
{
 // $title.="����:��".$startdate."��".$enddate;
 // $startdate1=GetMkTime($startdate);      //(ʱ���)���ѡ����ʼ���ڵĿ�ʼʱ�� ��ʽ  2014-11-04 00:00:00
 // $enddate1=GetMkTime($enddate)+86399;    //(ʱ���)���ѡ���������ڵĽ���ʱ���ʽ2014-11-04 23:59:59   86399����23Сʱ59��59��
  //dump(GetDateTimeMk($startdate1).GetDateTimeMk($enddate1));
  $wheresql  .= " And (salary_yf>= '$startdate' and salary_yf<= '$enddate')"; //qq
}

$date = isset($date) ? $date : "";   
/*if($date!="")
{
  
	  $wheresql  .= " and  salary_yf = '$date' ";    //���ϱ��
      
	 
}
*/


$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//Ĭ��DESC����110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by salary_yf desc ";
	$neworderway = "";
}


 

$sql = "Select *  From `#@__salary`  $wheresql $neworderby $neworderway ";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;
/*$dlist->SetParameter("mid",$mid);
	$dlist->SetParameter("search_type",$search_type);
	$dlist->SetParameter("startdate",$startdate);
	$dlist->SetParameter("enddate",$enddate);



if(isset($sta))
{
	$dlist->SetParameter("sta",$sta);
}*/

$dlist->SetParameter("emp_dep",$emp_dep);  //Ա��״̬����

$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("startdate",$startdate);      //�ؼ���
$dlist->SetParameter("enddate",$enddate);      //�ؼ���
$dlist->SetParameter("orderby",$orderby);      //�����ֶ�
$dlist->SetParameter("orderway",$orderway);      //�����½�


$tplfile = "salary.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ







	







?>