<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	



$wheresql=" where 1=1 "; //默认语句 不显示子记录
$title="积分统计"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code LIKE '%$keyword%') ";    //资料编号
      
	 
}

$startdate = isset($startdate) ? $startdate : "";  
$enddate = isset($enddate) ? $enddate : "";   

//4日期
if($startdate=="")$startdate=date("Y-m",time())."-01";
if($enddate=="")
{
		$nowmonthmaxday=date('t', strtotime($startdate));//上下月的最大天数
		$enddate=date("Y-m",time())."-".$nowmonthmaxday;
	
}
       

    
if ($startdate!="" && $enddate!="")
{
 // $title.="日期:从".$startdate."到".$enddate;
 // $startdate1=GetMkTime($startdate);      //(时间戳)获得选定开始日期的开始时间 格式  2014-11-04 00:00:00
 // $enddate1=GetMkTime($enddate)+86399;    //(时间戳)获得选定结束日期的结束时间格式2014-11-04 23:59:59   86399代表23小时59分59秒
  //dump(GetDateTimeMk($startdate1).GetDateTimeMk($enddate1));
  $wheresql  .= " And (date_format(integral_date, '%Y-%m-%d')>= '$startdate' and date_format(integral_date, '%Y-%m-%d')<= '$enddate')"; //qq
}

$date = isset($date) ? $date : "";   

$emp_dep  = isset($emp_dep ) ? $emp_dep  : 0;   
if($emp_dep!=0)
{
  
	   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //资料编号
//  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //资料编号
      
	 
}



$integral_class  = isset($integral_class ) ? $integral_class  : "a";   

 if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //资料编号
      
	 
}


//部门权限限制
//$emp_depidRoles= getDepRole($funAllName,"");
//if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //资料编号


//$sql = "SELECT *,SUM(integral_fz) as totalfz from dede_integral   $wheresql and integral_class='b'   GROUP BY integral_empid";
$sql = "SELECT *,SUM(integral_fz) as totalfz from dede_integral   $wheresql    GROUP BY integral_empid order by totalfz desc";

//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 300;


$dlist->SetParameter("keyword",$keyword);      //关键词
$dlist->SetParameter("date",$date);      //关键词
$dlist->SetParameter("integral_class",$integral_class);      //排序字段
$dlist->SetParameter("emp_dep",$emp_dep);      //排序字段


$tplfile = "integral_query.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示





//获取
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