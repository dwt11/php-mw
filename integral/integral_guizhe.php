<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');





$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
	  $wheresql  .= " And (gz_name LIKE '%$keyword%') ";    //���ϱ��
}



$integral_class = isset($integral_class) ? $integral_class : "";   
if($integral_class!="")
{
  
	  $wheresql  .= " and  gz_class = '$integral_class' ";    //���ϱ��
      
	 
}

	$neworderby =  " order by gz_class asc, gz_id asc ";


 

$sql = "Select *  From `#@__integral_guizhe`  $wheresql $neworderby  ";
//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;


$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("integral_class",$integral_class);      //�����ֶ�


$tplfile = "integral_guizhe.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ









?>