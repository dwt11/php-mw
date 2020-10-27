<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	


if(empty($dopost)) $dopost = '';

if($dopost=='bb')
{
	
	$dsql->ExecuteNoneQuery("update `#@__emp` set emp_bb='".$bb."' where emp_id='$aid';");
	ShowMsg("更新成功！",$ENV_GOBACK_URL);
	exit();
}


if($dopost=='bx')
{
	
	$dsql->ExecuteNoneQuery("update `#@__emp` set emp_bx='".$bx."' where emp_id='$aid';");
	ShowMsg("更新成功！",$ENV_GOBACK_URL);
	exit();
}

$wheresql=" where emp_isdel=0 "; //默认语句 不显示 删除了的员工
//$title="员工管理"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And (emp_code = '$keyword'"; //编号
	  $wheresql  .= " or emp_realname LIKE '%$keyword%')";  //姓名
	 // $wheresql  .= " or crm.aid  LIKE '%$keyword%'";  //CRM的自增长编号
	 // $wheresql  .= " or emp_sfz  LIKE '%$keyword%'";  //编号
	//  $wheresql  .= " or emp_phone  LIKE '%$keyword%' ";    //资料编号
      
	 
}
$emp_dep = isset($emp_dep) ? $emp_dep : "";   
if($emp_dep!=0)
{
	   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and   emp_dep in (".$emp_depids.") ";    //资料编号
}


$wheresql  .= getDepRole($funAllName,"emp_dep");    //返回可以管理的部门ID的 查询语句



$neworderby = isset($neworderby) ? $neworderby : "";   

//默认DESC降序
$neworderby =  " order by emp_code desc ";


 

$sql = "Select *  From `#@__emp`  $wheresql $neworderby  ";

//dump($funAllName);
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
$emp_ste = isset($emp_ste) ? $emp_ste : "";   


$dlist->SetParameter("emp_dep",$emp_dep);  //员工状态参数
$dlist->SetParameter("emp_ste",$emp_ste);  //员工状态参数
$dlist->SetParameter("keyword",$keyword);      //关键词


$tplfile = "emp.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示

//dump(getDepRole());




//显示完整的部门名称 
function GetGz($id)
{
			global $dsql;
	
		$questr1="SELECT worktype_name FROM `#@__emp_worktype` where worktype_id='".$id."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无工种记录";
		}
		else
		{
		
			$str=$rowarc1['worktype_name'];
		
		
		}
	

return $str;

}


//显示登录用户名 
function GetUserName($id)
{
		global $dsql;
		$questr1="SELECT userName FROM `#@__sys_admin` where empid='".$id."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无";
		}
		else
		{
		
			$str=$rowarc1['userName'];
		
		
		}
	

return $str;

}






?>