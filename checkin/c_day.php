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
  
	  $wheresql  .= " And (e.emp_realname LIKE '%$keyword%' or e.emp_code LIKE '%$keyword%') ";    //���ϱ��
      
	 
}



if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	$wheresql  .= " and  e.emp_dep in (".$emp_depids.") ";    //���ϱ��
 
      
	 
}


//����Ȩ������
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  e.emp_dep in (".$emp_depidRoles.") ";    //���ϱ��

/*
if($date!="")
{
  
	  $wheresql  .= " and    date_format(kq_hw_emptime, '%Y-%m') = '$date' ";    //���ϱ��
      
	 
}
*/
$maxday=getMonthLastDay($date);//��ȡÿ����������

$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//Ĭ��DESC����110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by kq_hw_emptime,kq_hw_empcode desc ";
	$neworderway = "";
}


 

$sql = "Select kq_hw_empcode  From dede_checkin c
left JOIN dede_emp e on e.emp_code=c.kq_hw_empcode
  $wheresql and e.emp_isdel=0 group by kq_hw_empcode $neworderby $neworderway ";

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


$tplfile = "c_day.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ





 




?>