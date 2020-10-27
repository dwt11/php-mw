<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');


$url=$_SESSION["url"];//从父页面获取的页面参数
if(!isset($_SESSION["inlNextUrlNumb"]))$_SESSION["inlNextUrlNumb"]=0; //如果没有当前页则 当前页键值为0
if($_SESSION["inlNextUrlNumb"]>=count($url))$_SESSION["inlNextUrlNumb"]=0;   //如果当前页键值大于 父页面生成的URL数组的最大值 则清0
//dump( " ".$_SESSION["inlNextUrlNumb"]." ".$url[$_SESSION["inlNextUrlNumb"]]);

$urls=$url[$_SESSION["inlNextUrlNumb"]];
$pagesParameter=explode('|', $urls);
//格式 deptopid主部门ID|pageSize分页大小|pageno当前页面码(如果无分页刚为1)

$deptopid=$pagesParameter[0];
$pageSize=$pagesParameter[1];
$pageno=$pagesParameter[2];
$totalresult=$pagesParameter[3];  //记录总数 如果无此项则 如果分页的话,跳转页数后 一直显示第一页内容
//格式 deptopid主部门ID|pageSize分页大小|pageno当前页面码(如果无分页刚为1)|$rowNumb总记录数
$_SESSION["inlNextUrlNumb"]=$_SESSION["inlNextUrlNumb"]+1;


	

$date =  date("Y-m", time()) ;   //默认显示当前月的数据

$class = isset($class) ? $class : "";   


$row = $dsql->GetOne("SELECT dep_name FROM `#@__emp_dep` WHERE dep_id='$deptopid'");
$title=str_replace("-","年",$date)."月 ".$row['dep_name']." 所有员工阶段 ".strtoupper($class)." 积分";

//获取当前主部门的所有子部门 字符串
$childStr=GetDepChildArray($deptopid); 


$wheresql="";
if($class!="")$wheresql=" and 	inl.integral_class ='$class' ";
$sql = "SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '$date' $wheresql
				WHERE
					emp.emp_isdel = 0  
				
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in ($childStr) order by emp_dep";

//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = $pageSize;
$dlist->SetParameter("deptopid",$deptopid);      //当前父部门ID


$tplfile = "trundle.do.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL

$dlist->Display();                  //显示


//获取 员工的历史分值
function getOldEmpFz($empid,$class="")
{

			global $dsql;
	
	    $wheresql="";
	    if($class!="")$wheresql=" and integral_class='$class' ";
		$questr1="SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  integral_empid='".$empid."' $wheresql ";
		
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


	

//PS这段没有加部门数据权限  因为这段用于管理页面的查询,查询的同时已经加了部门数据权限
//返回当前所选定的部门  的所有下级部门的子ID，列表供查询相关部门下包含的记录时使用
function GetDepChildArray($selid)
{
    global $DepArray, $dsql;

    $DepArray="";
    //当前选中的部门
    if($selid > 0)
    {
        //$row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $DepArray .= $selid.",";
        LogicGetDepArray($selid,$dsql);
    }

	//echo $OptionDepArrayList;
    return rtrim($DepArray, ",");
}
function LogicGetDepArray($selid,&$dsql)
{
    global $DepArray;
    $dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$selid."'  order by dep_id asc");
    $dsql->Execute($selid);
    while($row=$dsql->GetObject($selid))
    {
        $DepArray .= $row->dep_id.",";
        LogicGetDepArray($row->dep_id,$dsql);
    }
	
	
}








?>