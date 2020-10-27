<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	

if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("delete from  `#@__salary`  where salary_id='$aid';");
	ShowMsg("删除成功！",$ENV_GOBACK_URL);
	exit();
}



$wheresql=" where 1=1 "; //默认语句 不显示子记录
$title="工资管理"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And salary_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //资料编号
      
	 
}


if($emp_dep!=0)
{
  $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //资料编号
 
	  //$wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //资料编号
      
	 
}


//部门权限限制
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  salary_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //资料编号





//4日期    
$startdate = isset($startdate) ? $startdate : "";  
$enddate = isset($enddate) ? $enddate : "";   
if ($startdate!="" && $enddate!="")
{
 // $title.="日期:从".$startdate."到".$enddate;
 // $startdate1=GetMkTime($startdate);      //(时间戳)获得选定开始日期的开始时间 格式  2014-11-04 00:00:00
 // $enddate1=GetMkTime($enddate)+86399;    //(时间戳)获得选定结束日期的结束时间格式2014-11-04 23:59:59   86399代表23小时59分59秒
  //dump(GetDateTimeMk($startdate1).GetDateTimeMk($enddate1));
  $wheresql  .= " And (salary_yf>= '$startdate' and salary_yf<= '$enddate')"; //qq
}

$date = isset($date) ? $date : "";   
/*if($date!="")
{
  
	  $wheresql  .= " and  salary_yf = '$date' ";    //资料编号
      
	 
}
*/


$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
$orderby = isset($orderby) ? $orderby : "";   

//默认DESC降序，110716
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

$dlist->SetParameter("emp_dep",$emp_dep);  //员工状态参数

$dlist->SetParameter("keyword",$keyword);      //关键词
$dlist->SetParameter("startdate",$startdate);      //关键词
$dlist->SetParameter("enddate",$enddate);      //关键词
$dlist->SetParameter("orderby",$orderby);      //排序字段
$dlist->SetParameter("orderway",$orderway);      //上升下降


$tplfile = "salary.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示







	







?>