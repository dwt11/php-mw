<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	


$emp_dep = isset($emp_dep) ? $emp_dep : "";   
$totalhj=0;

$wheresql=" where 1=1 "; //默认语句 不显示子记录
$title="积分管理"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code = '$keyword') ";    //资料编号
      
	 
}

$date = isset($date) ? $date : "";   
if($date!="")
{
  
	  $wheresql  .= " and    date_format(integral_date, '%Y-%m') = '$date' ";    //资料编号
      
	 
}


$integral_class = isset($integral_class) ? $integral_class : "";   
if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //资料编号
      
	 
}

if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //资料编号
 
	  //$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //资料编号
      
	 
}



//部门权限限制
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //资料编号




$neworderway = 'desc';
$orderby = isset($orderby) ? $orderby : "";   

//默认DESC降序，110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by integral_date desc,integral_id desc ";
	$neworderway = "";
}


 

$sql = "Select *  From `#@__integral`  $wheresql $neworderby $neworderway ";

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
$dlist->SetParameter("integral_class",$integral_class);      //排序字段
$dlist->SetParameter("emp_dep",$emp_dep);      //排序字段


$tplfile = "integral.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示






	

//获取规则内容 
function getgz($gzid)
{

			global $dsql;
	
		$questr1="SELECT gz_name,gz_ms FROM `#@__integral_guizhe` where gz_id='".$gzid."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无记录";
		}
		else
		{
		
			$str=$rowarc1['gz_name'].",".$rowarc1['gz_ms'];
		
		
		}
	    if($gzid==0)$str="来自考勤批量导入";
	    if($gzid==-1)$str="其他分值,手动输入";

return $str;


}


	








?>