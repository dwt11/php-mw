<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");


$_SESSION["inlNextUrlNumb"]=0;  //子页面记数清空
$_SESSION["url"]="";             //URL地址数据清空

$class = isset($class) ? $class : "f";   


//此为积分滚动显示的主页面,用于获取积分滚动显示的URL地址参数
//1\先获取所有顶级部门和他的所有子部门的ID,
$query = " SELECT * FROM `#@__emp_dep`  WHERE dep_topid=0 ORDER BY dep_id ASC ";
$dsql->SetQuery($query);
$dsql->Execute(0);
while($row = $dsql->GetObject(0))
{
    $dep_id[]=$row->dep_id;
	$childStr[]=GetDepChildArray($row->dep_id);
}






$pageSize=50;    //框架子页面也引用此值  便于统一每页显示的数量


foreach($childStr as $k=>$str)
{
//2查询员工表,将当前部门ID所包含的员工个数列出
	$totalPage=1;
	$sql = "SELECT count(*) as rownumb 	FROM dede_emp emp where emp_isdel=0 and emp_dep in ($str) ";
	$row = $dsql->GetOne($sql);
	$rowNumb=$row["rownumb"];
	//dump($rowNumb);
    
	
	//dump($dep_id[$k]);
	
	
	//如果总记录数大于0 才有连接地址
	if($rowNumb>0)
	{
		//如果得到的记录数大于每页分页的记录数  则连接地址加上分页
		//否则只有第一页
		if($rowNumb>$pageSize)
		{
			$totalPage=ceil($rowNumb/$pageSize);
			for($ii=1;$ii<=$totalPage;$ii++)
			{
				//生成子页面要用的参数,存入session
	//格式 deptopid主部门ID|pageSize分页大小|pageno当前页面码(如果无分页刚为1)|$rowNumb总记录数
				$url[]=$dep_id[$k]."|".$pageSize."|".$ii."|".$rowNumb;
			}
		}else
		{
				$url[]=$dep_id[$k]."|".$pageSize."||";
			
		}
		
	}
	//dump($totalPage);
}

//dump($url);
			

$_SESSION["url"]=$url;



 


	

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




<script language="JavaScript"> 
function myrefresh() 
{
   parent.main.location.reload();

} 
setInterval("myrefresh()",10000); //指定1000=1秒刷新一次 
</script> 

<!--This is IE DTD patch , Don't delete this line.-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
</head>
<body  >
    <iframe id="main" width="100%" height="98%" name="main" frameborder="0" src="trundle.do.php?class=<?php echo $class;?>"></iframe>
</body>
</html>

<?php
exit();

?>