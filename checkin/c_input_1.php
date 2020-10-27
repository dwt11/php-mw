<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$inputdate=$inputdate;  //input 传过来的要导入的月份 
////dump ($inputdate);

if(empty($dopost))$dopost="";


//导入时先将数据存入数组,然后再分批导入数据库
//如果直接分页导入数据库的话,因为要比较导入的内容,会引起数据出错
if($dopost=='input')
{
		  
	 ShowMsg("正在获取".$inputdate ."考勤数据","c_input_1.php?dopost=input_1&inputdate=$inputdate","","",1);
 exit();
}



//导入时先将数据存入数组,然后再分批导入数据库
//如果直接分页导入数据库的话,因为要比较导入的内容,会引起数据出错
if($dopost=='input_1')
{
$t1 = ExecTime();

	$querys=array(); //声明数组并清空
	//global $querys;  
	$get_no_input_data="SELECT
	c.CardID,
	c.EmployeeID,
	c.CardTime,
	c.DevID,
	e.EmployeeCode,
	e.EmployeeName,
	d.DevName,
	d.IPAddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID 
ORDER BY c.CardTime
";
//这里直接获取当前月的全部数据  不查询已经导入的数据了，试了 not IN太慢 not exits查询不到数据   left join然后not null 数据多了太慢
	// dump($get_no_input_data);
    $dsql->Execute('c', $get_no_input_data);
    while($row = $dsql->GetArray('c'))
    {
          //$kq_empid= $row['EmployeeID'];//这个要根据员工编号来查询mw中对应的员工ID,暂时不用,看只有员工编号是否可以行
		  $kq_hw_CARDID= $row['CardID'] ;
		  $kq_hw_emptime= $row['CardTime'] ;
		  $kq_hw_devname= $row['DevName'] ;
		  $kq_hw_devip= $row['IPAddress'] ;
		  //$kq_hw_empid= $row['EmployeeID'] ;
		  $kq_hw_empname= $row['EmployeeName'] ;
		  $kq_hw_empcode= $row['EmployeeCode'] ;
		  $kq_markdate= date("Y-m-d", time()) ;
		  
		  //$querys[] = " INSERT  ignore  INTO `dede_checkin` (kq_empid,kq_hw_CARDID,kq_hw_emptime,kq_hw_devname,kq_hw_devip,kq_hw_empid,kq_hw_empname,kq_hw_empcode,kq_markdate,kq_integralid,kq_salaryid,kq_czy,kq_zt)
							//	VALUES (null, '".$kq_hw_CARDID."', '".$kq_hw_emptime."', '".$kq_hw_devname."', '".$kq_hw_devip."', null, '".$kq_hw_empname."', '".$kq_hw_empcode."','".$kq_markdate."', 0,0,".$cuserLogin->getUserID().",0);";
		 //这里不用INSERT  ignore  INTO  直接使用MYSQL执行事务  可以返回成功导入数据库不重复的条数  错误会自动过滤  因为数据表 对kq_hw_CARDID,kq_hw_emptime，kq_hw_devip设置了不可以重复
		 $querys[] = " INSERT  INTO `dede_checkin` (kq_empid,kq_hw_CARDID,kq_hw_emptime,kq_hw_devname,kq_hw_devip,kq_hw_empid,kq_hw_empname,kq_hw_empcode,kq_markdate,kq_integralid,kq_salaryid,kq_czy,kq_zt)
								VALUES (null, '".$kq_hw_CARDID."', '".$kq_hw_emptime."', '".$kq_hw_devname."', '".$kq_hw_devip."', null, '".$kq_hw_empname."', '".$kq_hw_empcode."','".$kq_markdate."', 0,0,".$cuserLogin->getUserID().",0);";
    }
    $_SESSION["querysArray"]="";  //注销SESSION
    $_SESSION["querysArray"]=$querys;   //使用session来传递要导入的考勤数据
    //导入前清空记数
	$_SESSION["truenumb"]="0"; //数据清空
	$_SESSION["falsenumb"]="0"; //数据清空
// $t2 = ExecTime();
//echo $t2-$t1;

	//dump($querys);		  
	ShowMsg("开始导入".$inputdate ."考勤数据","c_input_1.php?dopost=input_2&inputdate=$inputdate","","",1);
 exit();
 
}


//分页导入数据
if($dopost=='input_2')
{
	$t1 = ExecTime();
$t1 = ExecTime();
	
	$truenumb=$_SESSION["truenumb"]; //获得已经导入的数据 
	$falsenumb=$_SESSION["falsenumb"]; //获得导入错误的数据 


	$querys=$_SESSION["querysArray"];   //获取数据
	//分页导入的设置
	$pageSize=5000;    //每页数据
	if(!isset($pageNo))$pageNo=1; //当前页数
	if(!isset($totalResult))$totalResult=count($querys);//要导入的总数
    $totalPage = ceil($totalResult / $pageSize);//总页数
    $iStart=($pageNo-1) * $pageSize;
    $iEnd=$pageNo*$pageSize;
	if($iEnd>$totalResult)$iEnd=$totalResult;
	
	   // dump($iStart."--".$iEnd."--".$totalResult);



	$lnk = mysql_connect('localhost', 'root', 'xiaoxiao') or die ('Not connected : ' . mysql_error());
	mysql_select_db('mw', $lnk) or die ('Can\'t use bl_db : ' . 
	mysql_error());
	mysql_query("set names 'gbk'");
    //mysql_query("SET AUTOCOMMIT=0");//设置为1是自动提交  0不自动提交
	
	mysql_query("begin");
    for($i1=$iStart; $i1<($iEnd); $i1++)
    {
		if(!mysql_query($querys[$i1]))
				  {
					  $falsenumb++;
				  }else{
					  $truenumb++;
				 }

	}
	 
	mysql_query('COMMIT'); //执行事务
    //echo "成功  ".$truenumb." 条,失败 ".$falsenumb." 条<br>";
 $t2 = ExecTime();
//echo $t2-$t1;
   if($totalPage>$pageNo)
   {//分页导入
        $toPage=$pageNo+1;
	   ShowMsg("正在导入".$inputdate."第".$pageNo."页数据,共".$totalPage."页！ 执行时间：".number_format($t2-$t1,1)."秒 ","c_input_1.php?dopost=input_2&inputdate=$inputdate&pageNo=$toPage&totalResult=$totalResult","","",1);
   }else
   {
	  ShowMsg("考勤记录导入月份: ".$inputdate .",成功导入  ".$truenumb." 条","c_input.php","",10000,"");
	}

exit();
}




//获取记录数
Get_numb($inputdate);




//得到选择的月份的 汉王数据库里的记录
$sql = "SELECT
	c.Cardid,
	c.employeeid,
	c.cardtime,
	c.devid,
	e.employeecode,
	e.employeename,
	d.devname,
	d.ipaddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID";

//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;


$dlist->SetParameter("inputdate",$inputdate);  //员工状态参数


$tplfile = "c_input_1.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示




function Get_numb($inputdate)
{

//得到当前月的总条数
		//
		global $dsql,$allResult;
		$sql="SELECT
	 count(*) as dd
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID";
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $allResult=0;
		}
		else
		{
		
			$allResult=$rowarc1['dd'];
		
		
		}
		



         //获取已经导入的
			global $yes_input_numb;
        //$sql="select count(*) as dd from hwatt.kqz_card hw , mw.dede_checkin dz WHERE hw.CardID = dz.kq_hw_CARDID and hw.CardTime=dz.kq_hw_emptime  AND date_format(hw.CardTime, '%Y-%m') = '$inputdate'";
		$sql="SELECT
	count(*) AS dd
FROM
	dede_checkin
WHERE
	kq_hw_CARDID IN (
		SELECT
			c.Cardid
		FROM
			hwatt.kqz_card AS c,
			hwatt.kqz_employee AS e,
			hwatt.kqz_devinfo AS d
		WHERE
			date_format(CardTime, '%Y-%m') = '$inputdate'
		AND c.EmployeeID = e.EmployeeID
		AND c.DevID = d.DevID
	)";
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $yes_input_numb=0;
		}
		else
		{
		
			$yes_input_numb=$rowarc1['dd'];
		
		
		}
		




			global $no_input_numb;  //未导入的
			
       
		
			$no_input_numb=$allResult-$yes_input_numb;
}
		
		
		












?>