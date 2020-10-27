<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEPATH."/emp/dep.inc.options.php");	
if(empty($dopost))$dopost="";
$emp_dep = isset($emp_dep) ? $emp_dep : "";   
if($dopost=='clear')
{
	//140915 kq_integralid=0 and kq_salaryid=0  此SQL中的这两个没有用,因为添加工资和积分时未更新这两个字段 一直是0
	//$dsql->ExecuteNoneQuery("DELETE from `#@__checkin` where kq_integralid=0 and kq_salaryid=0;");
	$dsql->ExecuteNoneQuery("DELETE from `#@__checkin`");
	ShowMsg("清除全部考勤记录成功！","c_list.php");
	exit();
}

if($dopost=='clearDate')
{
	//140915 kq_integralid=0 and kq_salaryid=0  此SQL中的这两个没有用,因为添加工资和积分时未更新这两个字段 一直是0
	$query="DELETE from `#@__checkin` where kq_integralid=0 and kq_salaryid=0 and   date_format(kq_hw_emptime, '%Y-%m') = '$clearDate' ;";
	//dump($query);
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("清除".$clearDate."的考勤记录成功！","c_list.php");
	exit();
}

if($dopost=='update')
{
	
	$dsql->ExecuteNoneQuery("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	//	dump("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	ShowMsg("更新成功！","c_list.php");
	exit();
}


if($dopost=='updates')
{
    
    if($qstr=='')
    {
        ShowMsg('参数无效！',$ENV_GOBACK_URL);
        exit();
    }
	//dump($qstr);
    $qstrs = explode('`',$qstr);
    $i = 0;
    foreach($qstrs as $aid)
    {
		//dump("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	   $dsql->ExecuteNoneQuery("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
    }
	ShowMsg("更新成功！","c_list.php");
	exit();
}



$wheresql=" where 1=1 "; //默认语句 不显示子记录
$title="考勤记录管理"; //页面显示的标题




$keyword = isset($keyword) ? $keyword : "";
//$keyword_temp=str_replace("0","",$keyword);这个数据表存储的员工编号是字符的,所以要把多余的0清除掉再搜索员工编号????150130
//	  or kq_hw_empcode='$keyword'
if($keyword!="")
{
  
	  $wheresql  .= " And (kq_hw_empname LIKE '%$keyword%'
	  ) ";    //资料编号
      
	 
}

$date = isset($date) ? $date : "";   
if($date!="")
{
  
	  $wheresql  .= " and    date_format(kq_hw_emptime, '%Y-%m-%d') = '$date' ";    //资料编号
      
	 
}



//$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
//$orderby = isset($orderby) ? $orderby : "";   
//
////默认DESC降序，110716
//if($orderby!="")
//{
//	$neworderby =" order by ". $orderby ." " ;
//}else
//{
//	$neworderby =  " order by kq_hw_emptime desc ";
//	$neworderway = "";
//}
//

 if($emp_dep!=0)
{
 $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);

	  $wheresql  .= " and  kq_hw_empcode in (select emp_code from dede_emp where emp_isdel=0 and emp_dep in (".$emp_depids.")) ";    //资料编号
      
	 
}



$sql = "Select *  From `#@__checkin`  $wheresql order by kq_hw_emptime desc ";

//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;
$dlist->SetParameter("emp_dep",$emp_dep);
$dlist->SetParameter("date",$date);


$dlist->SetParameter("keyword",$keyword);      //关键词


$tplfile = "c_list.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示



// 
function getste($kq_zt)
{
		  if($kq_zt==0)$kqzt_temp="未审核";
		  if($kq_zt==1000)$kqzt_temp="<strong>不正常数据</strong>";
		  if($kq_zt==2000)$kqzt_temp="<strong>倒班数据</strong>";
		  if($kq_zt==100)$kqzt_temp="<strong><font color='#009900'>正常</font></strong>";
          if($kq_zt==1)$kqzt_temp="<strong><font color='#66CCFF'>一级迟到</font></strong>";
          if($kq_zt==2)$kqzt_temp="<strong><font color='#FF9900'>二级迟到</font></strong>";
          if($kq_zt==3)$kqzt_temp="<strong><font color='#FF0000'>三级迟到</font></strong>";
          if($kq_zt==11)$kqzt_temp="<strong><font color='#66CCFF'>一级早退</font></strong>";
          if($kq_zt==12)$kqzt_temp="<strong><font color='#FF9900'>二级早退</font></strong>";
          if($kq_zt==13)$kqzt_temp="<strong><font color='#FF0000'>三级早退</font></strong>";
	      if($kq_zt==21)$kqzt_temp="<strong><font color='#66CCFF'>旷工半天</font></strong>";
          if($kq_zt==22)$kqzt_temp="<strong><font color='#FF9900'>旷工一天</font></strong>";


return $kqzt_temp;

}

//获取员工的班别
function getbb($kq_hw_empcode)
{
	
			global $dsql;
		//150527修复   加了 isdel的判断 ,原来没有 当删除员工工后 添加相同的编号员工 查询考勤会出错
		$questr1="SELECT emp_bb FROM `#@__emp` where emp_code='".$kq_hw_empcode."' and emp_isdel=0";

		 	
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无记录";
		}
		else
		{
		
			$str=$rowarc1['emp_bb'];
		
		
		}
	

return $str;
}







?>