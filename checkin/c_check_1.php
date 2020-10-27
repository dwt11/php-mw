<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$checkdate=$checkdate;  //check 传过来的要导入的月份 
getconfig(); ///得到全局考勤规则

if(empty($dopost))$dopost="";

////dump ($checkdate);



if($dopost=='check')
{
	
	$querys=array(); //声明数组并清空

	$get_check_data="Select *  From `#@__checkin`   where kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' order by kq_hw_emptime desc";
	$dsql->Execute('c', $get_check_data);
    while($row = $dsql->GetArray('c'))
    {

		  $kq_zt=0;
          $kqzt_temp=returncheck($row['kq_hw_emptime'],$row['kq_hw_empcode']);
        //  //dump($kqzt_temp);
		  if($kqzt_temp=="<font color='#009900'>正常</font>")$kq_zt=100;
          if($kqzt_temp=="<font color='#66CCFF'>一级迟到</font>")$kq_zt=1;
          if($kqzt_temp=="<font color='#FF9900'>二级迟到</font>")$kq_zt=2;
          if($kqzt_temp=="<font color='#FF0000'>三级迟到</font>")$kq_zt=3;
          if($kqzt_temp=="<font color='#66CCFF'>一级早退</font>")$kq_zt=11;
          if($kqzt_temp=="<font color='#FF9900'>二级早退</font>")$kq_zt=12;
          if($kqzt_temp=="<font color='#FF0000'>三级早退</font>")$kq_zt=13;
		  if($kqzt_temp=="不正常数据")$kq_zt=1000;
		  if($kqzt_temp=="倒班数据")$kq_zt=2000;
// 100为正常 。1一级迟到 2二级迟到 3三级迟到  11一级早退 12二级早退 13三级早退  21 旷工半天 22旷工一天

			  $querys[] = " UPDATE `dede_checkin` SET `kq_zt`='".$kq_zt."' WHERE (`kq_id`='".$row['kq_id']."') ";
		
    }

    $_SESSION["querysArray"]="";  //注销SESSION
    $_SESSION["querysArray"]=$querys;   //使用session来传递要导入的考勤数据
    //导入前清空记数
	$_SESSION["truenumb"]="0"; //数据清空
	$_SESSION["falsenumb"]="0"; //数据清空

	//dump($querys);		  
	 ShowMsg("正在获取".$checkdate ."审核数据","c_check_1.php?dopost=check_1&checkdate=$checkdate","","",1);
    exit();
	
}


//分页导入数据
if($dopost=='check_1')
{
	//$t1 = ExecTime();
	
	
	$truenumb=$_SESSION["truenumb"]; //获得已经导入的数据 
	$falsenumb=$_SESSION["falsenumb"]; //获得导入错误的数据 


	$querys=$_SESSION["querysArray"];   //获取数据
	//分页导入的设置
	$pageSize=50;    //每页数据
	if(!isset($pageNo))$pageNo=1; //当前页数
	if(!isset($totalResult))$totalResult=count($querys);//要导入的总数
    $totalPage = ceil($totalResult / $pageSize);//总页数
    $iStart=($pageNo-1) * $pageSize;
    $iEnd=$pageNo*$pageSize;
	if($iEnd>$totalResult)$iEnd=$totalResult;
	
	   // dump($iStart."--".$iEnd."--".$totalResult);
	
    for($i1=$iStart; $i1<$iEnd; $i1++)
    {
	   // dump($i1."--".$querys[$i1]);
					 // dump($querys[$i1]."--".$i1);
				if(!$dsql->ExecuteNoneQuery($querys[$i1]))
				  {
					  $falsenumb++;
				  }else{
					  $truenumb++;
				 }
	//dump($truenumb."--".$falsenumb);
	}
	 
    
   if($totalPage>$pageNo)
   {//分页导入
        $toPage=$pageNo+1;
	   ShowMsg("正在审核".$checkdate."第".$pageNo."页数据,共".$totalPage."页！","c_check_1.php?dopost=check_1&checkdate=$checkdate&pageNo=$toPage&totalResult=$totalResult","","",1);
   }else
   {
	  ShowMsg("考勤记录审核月份: ".$checkdate .",成功  ".$truenumb." 条,失败 ".$falsenumb." 条！","c_check.php");
	}

exit();
}












$wheresql=" where 1=1 "; //默认语句 不显示子记录
$sql = "Select *  From `#@__checkin`   where kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' order by kq_hw_emptime  desc";

////dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;


$dlist->SetParameter("checkdate",$checkdate);  //员工状态参数


$tplfile = "c_check_1.htm";



//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示






//得到总条数
function Get_all_check($checkdate)
{
			global $dsql;
	
        $sql="select count(*) as dd from  `#@__checkin`   where kq_zt=0 and  date_format(kq_hw_emptime, '%Y-%m') = '$checkdate'";
	//	//dump($sql);
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $all_check_numb=0;
		}
		else
		{
		
			$all_check_numb=$rowarc1['dd'];
		
		
		}
		
return $all_check_numb;

}


//得到正常的条数
function Get_yes_check($checkdate)
{
			global $dsql;
	
        $sql="select count(*) as dd from dede_checkin  WHERE kq_zt=0 and  date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' AND (
	


		
		(
					date_format(kq_hw_emptime, '%H') >=7
					AND date_format(kq_hw_emptime, '%H')<8
				)
				
		or 
				
					(
						date_format(kq_hw_emptime, '%H') >= 18
						AND date_format(kq_hw_emptime, '%H') <= 20
					)
		
			)";
				////dump($sql);

		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $yes_check_numb=0;
		}
		else
		{
		
			$yes_check_numb=$rowarc1['dd'];
		
		
		}
		
return $yes_check_numb;

}



//得到违规条数  这个有问题 先不弄了
function Get_no_check($checkdate)
{
			global $dsql;

 $sql="select count(*) as dd from dede_checkin  WHERE  kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate'
 AND (
	


(
			(date_format(kq_hw_emptime, '%H') >=8 )
			AND (date_format(kq_hw_emptime, '%H')<12 )
		)
		
or 
		
			(
				date_format(kq_hw_emptime, '%H') >= 12
				AND date_format(kq_hw_emptime, '%H') < 18
			)

	)";
			////dump($sql);
				//echo 
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $no_check_numb=0;
		}
		else
		{
		
			$no_check_numb=$rowarc1['dd'];
		
		
		}
		
return $no_check_numb;

}



//获取考勤规则  全局
function getconfig()
 {  
 
 			global $dsql;

 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$djorxj;
	  $yjcd=0;//一级迟到</td>
          $ejcd=0;//二级迟到</td>
		  $sjcd=0;//三级迟到</td>
          
		  $yjzt=0;//一级早退</td>
		 $ejzt=0;//二级早退</td>
         $sjzt=0;//三级早退</td>

  $arcQuery = "SELECT *  from #@__checkin_config  WHERE id='1' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("读取信息出错!","-1");
        exit();
    }else{
		  
		  
		  $yjcd=$arcRow['yjcd'];//一级迟到</td>
          $ejcd=$arcRow['ejcd'];//二级迟到</td>
		  $sjcd=$arcRow['sjcd'];//三级迟到</td>
          
		  $yjzt=$arcRow['yjzt'];//一级早退</td>
		 $ejzt=$arcRow['ejzt'];//二级早退</td>
         $sjzt=$arcRow['sjzt'];//三级早退</td>
         $djorxj=$arcRow['djorxj'];

		
		}
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

//返回考勤结果
//$kq_hw_emptime,原始考勤时间
//$kq_hw_empcode //引入员工编号 以判断考勤班别
function returncheck($kq_hw_emptime,$kq_hw_empcode)
{
	
	 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$djorxj;

	//dump($kq_hw_emptime);
	
	$restr="<font color='#009900'>正常</font>";
	
	 //原始考勤记录时间 按时间得到int
    $timeold_int=strtotime(date("H:i:s",strtotime($kq_hw_emptime)));
        
        
        $kqbb=getbb($kq_hw_empcode) ;
	
	
	
	
		if($kqbb=="常白班"){
									   //分别判断是否属于8 12 14 18点的数据  如果是则出考勤结果  如果都不是 则提示不正常
									 //echo date("H",strtotime($fields['kq_hw_emptime']));
									 //判断 8点的考勤
									  if(date("H",strtotime($kq_hw_emptime))==8 ||(date("H",strtotime($kq_hw_emptime))>=7  && date("H",strtotime($kq_hw_emptime))<9 )){
								   
									  
											//8点的INT
											 $time8_int=strtotime("08:00:00");
											//考勤时间int和8点int相减后得到  差值分钟
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($timeold_int-$time8_int)/60; 
											
											//与规则判断
										//       echo $timecheck_minute;
											if( $timecheck_minute>$yjcd &&  $timecheck_minute<=$ejcd) $restr= "<font color='#66CCFF'>一级迟到</font>";
											if( $timecheck_minute>$ejcd &&  $timecheck_minute<=$sjcd) $restr= "<font color='#FF9900'>二级迟到</font>";
											if( $timecheck_minute>$sjcd) $restr= "<font color='#FF0000'>三级迟到</font>";
									 //  echo "八";
									   
									  
									  }
									  
									  
									 //判断 12点的考勤
									 else if(date("H",strtotime($kq_hw_emptime))==12 ||(date("H",strtotime($kq_hw_emptime))>=11 && date("H",strtotime($kq_hw_emptime))<13 )){
									 
									  
											//8点的INT
											 $time8_int=strtotime("12:00:00");
											//考勤时间int和8点int相减后得到  差值分钟
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($time8_int-$timeold_int)/60; 
											
											//与规则判断
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjzt &&  $timecheck_minute<=$ejzt) $restr= "<font color='#66CCFF'>一级早退</font>";
											if( $timecheck_minute>$ejzt &&  $timecheck_minute<$sjzt) $restr= "<font color='#FF9900'>二级早退</font>";
											if( $timecheck_minute>$sjzt ) $restr= "<font color='#FF0000'>三级早退</font>";
									   
								   //   echo "十二";
									  }
									  
									  
									 //判断 14点的考勤
									 
									 else if(date("H",strtotime($kq_hw_emptime))==14 ||(date("H",strtotime($kq_hw_emptime))>=13 && date("H",strtotime($kq_hw_emptime))<16 )){
									 
									  
											//8点的INT
											 $time8_int=strtotime("14:00:00");
									 if($djorxj=="夏季"){ $time8_int=strtotime("15:00:00");}
if($djorxj=="春秋季"){ $time8_int=strtotime("14:30:00");}
											//考勤时间int和8点int相减后得到  差值分钟
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($timeold_int-$time8_int)/60; 
											
											//与规则判断
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjcd &&  $timecheck_minute<=$ejcd) $restr= "<font color='#66CCFF'>一级迟到</font>";
											if( $timecheck_minute>$ejcd &&  $timecheck_minute<=$sjcd) $restr= "<font color='#FF9900'>二级迟到</font>";
											if( $timecheck_minute>$sjcd) $restr= "<font color='#FF0000'>三级迟到</font>";
									  // echo "十四";
									  
									  }
									  
									  
									  
									  
									  
									  
									 //判断 18点的考勤
									 else if(date("H",strtotime($kq_hw_emptime))==18 ||( date("H",strtotime($kq_hw_emptime))>=17 && date("H",strtotime($kq_hw_emptime))<20 )){
									 
									  
											//8点的INT
											 $time8_int=strtotime("18:00:00");
									 if($djorxj=="夏季"){ $time8_int=strtotime("19:00:00");}
if($djorxj=="春秋季"){ $time8_int=strtotime("18:30:00");}
											//考勤时间int和8点int相减后得到  差值分钟
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($time8_int-$timeold_int)/60; 
											
											//与规则判断
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjzt &&  $timecheck_minute<=$ejzt) $restr= "<font color='#66CCFF'>一级早退</font>";
											if( $timecheck_minute>$ejzt &&  $timecheck_minute<$sjzt) $restr= "<font color='#FF9900'>二级早退</font>";
											if( $timecheck_minute>$sjzt ) $restr= "<font color='#FF0000'>三级早退</font>";
										   // if( $timecheck_minute>120) $restr= "<font color='#FFFF00'>旷工半天</font>";
									  //      echo "ff";
									  //echo "十八";
									  }
									  
									  else
									  {
										  $restr= "不正常数据";
										  }
									  
									  //echo "考勤时间INT:".$timeold_int."<br>考勤时间格式".$timeold_date."<br>8点INT".$time8_int."<br>超过的分钟int".$timecheck_int."<br>超过的分钟数".$timecheck_minute;
        
      
		}
		
		
		
		if($kqbb=="倒班"){
								
										  $restr= "倒班数据";
										 
      
		}
	        return $restr;

	
	
	
	}



?>