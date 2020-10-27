<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');

	require_once(DEDEPATH."/emp/dep.inc.options.php");	




$wheresql=" where 1=1 "; //默认语句 不显示子记录
$date = isset($date) ? $date : date("Y-m", time());   
$title=$date."积分每日报表"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //资料编号
      
	 
}

/*if($date!="")
{
  
	  $wheresql  .= " and  integral_date = '$date' ";    //资料编号
      
	 
}
*/


if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //资料编号
 
	//  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //资料编号
      
	 
}


//部门权限限制
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //资料编号


if($date!="")
{
  
	  $wheresql  .= " and    date_format(integral_date, '%Y-%m') = '$date' ";    //资料编号
      
	 
}





$integral_class  = isset($integral_class ) ? $integral_class  : "a";   

 if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //资料编号
      
	 
}



$maxday=getMonthLastDay($date);//获取每月最大的天数

$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//默认DESC降序，110716
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

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;
/*$dlist->SetParameter("mid",$mid);
	$dlist->SetParameter("search_type",$search_type);
	$dlist->SetParameter("startdate",$startdate);
	$dlist->SetParameter("enddate",$enddate);



if(isset($sta))
{
	$dlist->SetParameter("sta",$sta);
}*/


$dlist->SetParameter("keyword",$keyword);      //关键词
$dlist->SetParameter("date",$date);      //关键词
$dlist->SetParameter("orderby",$orderby);      //排序字段
$dlist->SetParameter("orderway",$orderway);      //上升下降
$dlist->SetParameter("emp_dep",$emp_dep);      ////150122修复当客户选择部门查看时无法翻页
$dlist->SetParameter("integral_class",$integral_class);       


$tplfile = "integral_day.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示











?>