<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');





$wheresql=" where 1=1 "; //默认语句 不显示子记录
$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
	  $wheresql  .= " And (gz_name LIKE '%$keyword%') ";    //资料编号
}



$integral_class = isset($integral_class) ? $integral_class : "";   
if($integral_class!="")
{
  
	  $wheresql  .= " and  gz_class = '$integral_class' ";    //资料编号
      
	 
}

	$neworderby =  " order by gz_class asc, gz_id asc ";


 

$sql = "Select *  From `#@__integral_guizhe`  $wheresql $neworderby  ";
//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;


$dlist->SetParameter("keyword",$keyword);      //关键词
$dlist->SetParameter("integral_class",$integral_class);      //排序字段


$tplfile = "integral_guizhe.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示









?>