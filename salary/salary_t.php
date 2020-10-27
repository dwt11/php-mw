<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');

	require_once(DEDEPATH."/emp/dep.inc.options.php");	


$wheresql=" where 1=1 "; //默认语句 不显示子记录
$title="工资报表"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And salary_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //资料编号
      
	 
}

$date = isset($date) ? $date : "";   
/*if($date!="")
{
  
	  $wheresql  .= " and  salary_yf = '$date' ";    //资料编号
      
	 
}
*/


if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //资料编号
 
	//  $wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //资料编号
      
	 
}

//部门权限限制
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //资料编号



if($date!="")
{
  
	  $wheresql  .= " and    date_format(salary_yf, '%Y-%m') = '$date' ";    //资料编号
      
	 
}


$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//默认DESC降序，110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by salary_yf,salary_empid desc ";
	$neworderway = "";
}


 

$sql = "Select *, date_format(salary_yf, '%Y-%m') as salary_yf, sum(salary_jb) as salary_jb,sum(salary_kq) as salary_kq,sum(salary_qtadd) as salary_qtadd,sum(salary_qtsub) as salary_qtsub,sum(salary_yfmoney) as salary_yfmoney  From `#@__salary`  $wheresql group by salary_empid, date_format(salary_yf, '%Y-%m') $neworderby $neworderway ";

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

$dlist->SetParameter("emp_dep",$emp_dep);      //关键词

$tplfile = "salary_t.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示













?>