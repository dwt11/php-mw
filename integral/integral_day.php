<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');

	require_once(DEDEPATH."/emp/dep.inc.options.php");	




$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$date = isset($date) ? $date : date("Y-m", time());   
$title=$date."����ÿ�ձ���"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //���ϱ��
      
	 
}

/*if($date!="")
{
  
	  $wheresql  .= " and  integral_date = '$date' ";    //���ϱ��
      
	 
}
*/


if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //���ϱ��
 
	//  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //���ϱ��
      
	 
}


//����Ȩ������
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //���ϱ��


if($date!="")
{
  
	  $wheresql  .= " and    date_format(integral_date, '%Y-%m') = '$date' ";    //���ϱ��
      
	 
}





$integral_class  = isset($integral_class ) ? $integral_class  : "a";   

 if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //���ϱ��
      
	 
}



$maxday=getMonthLastDay($date);//��ȡÿ����������

$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//Ĭ��DESC����110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by integral_date,integral_empid desc ";
	$neworderway = "";
}


 

$sql = "Select integral_empid  From `#@__integral`  $wheresql group by integral_empid $neworderby $neworderway ";

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


$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("date",$date);      //�ؼ���
$dlist->SetParameter("orderby",$orderby);      //�����ֶ�
$dlist->SetParameter("orderway",$orderway);      //�����½�
$dlist->SetParameter("emp_dep",$emp_dep);      ////150122�޸����ͻ�ѡ���Ų鿴ʱ�޷���ҳ
$dlist->SetParameter("integral_class",$integral_class);       


$tplfile = "integral_day.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ











?>