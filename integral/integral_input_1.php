<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$inputdate=$inputdate;  //input 传过来的要导入的月份 
$integral_class=$integral_class;  //积分类型


////dump ($inputdate);

if(empty($dopost)) $dopost = '';
$totalhj=0;
getconfig($integral_class);  //获取扣分规则
if($dopost=='input')
{
	$truenumb=0;  //成功导入的条数
	$falsenumb=0;  //导入失败的条数
    
	
	$get_no_input_data="Select *,count(*) as dd  From `dede_checkin` WHERE
	                     date_format(kq_hw_emptime, '%Y-%m') = '$inputdate' and kq_zt>0 and kq_zt<100
                         GROUP BY kq_zt,kq_hw_empcode,kq_hw_emptime";
    $dsql->Execute('c', $get_no_input_data);
    while($row = $dsql->GetArray('c'))
    {
				$integral_empid=getempid($row['kq_hw_empcode']);
				$integral_date=$row['kq_hw_emptime'];
				$integral_gzid=$row['kq_hw_empcode'];
				//$integral_class="b";
				$integral_gzid=0;
				$integral_aors="sub";
				$integral_fz="-".(double)(GetSub($row['kq_zt'],$row['dd']));
				$integral_bz="考勤违规".strtoupper($integral_class)."分扣分项".$row['kq_hw_emptime'].GetSm($row['kq_zt']);
				$integral_markdate=date("Y-m-d", time());
				$questr="SELECT * FROM `dede_integral` where integral_class='$integral_class' and  integral_date ='".$integral_date."' and integral_empid=".$integral_empid;
				$rowarc = $dsql->GetOne($questr);
				if(is_array($rowarc))
				{
					//此时间的记录已经导入忽略过
									  $falsenumb++;
				  } else
						{	$query = "
							 INSERT INTO `dede_integral` (`integral_empid`, `integral_date`, `integral_gzid`, `integral_class`, `integral_aors`, `integral_fz`, `integral_bz`, `integral_markdate`, `integral_czy`)
							  VALUES ('".$integral_empid."', '".$integral_date."', '".$integral_gzid."', '".$integral_class."', '".$integral_aors."', '".$integral_fz."', '".$integral_bz."', '".$integral_markdate."',".$cuserLogin->getUserID().")";
							
					  
							if(!$dsql->ExecuteNoneQuery($query))
							  {
								  $falsenumb++;
							  }else{
								  $truenumb++;
								  }
								  
						}
						 
					  
				}
    
  ShowMsg("考勤违规".strtoupper($integral_class)."分扣分项,导入月份: ".$inputdate .",成功  ".$truenumb." 条,因存在重复记录失败 ".$falsenumb." 条！","integral_input.php");
   exit();
}














$wheresql=" where 1=1 "; //默认语句 不显示子记录
$sql = "Select *,count(*) as dd  From `dede_checkin` WHERE
	date_format(kq_hw_emptime, '%Y-%m') = '$inputdate' and kq_zt>0 and kq_zt<100
    GROUP BY kq_zt,kq_hw_empcode,kq_hw_emptime";

//dump($sql);
$dlist = new DataListCP();

//设定每页显示记录数（默认25条）
$dlist->pageSize = 30;


$dlist->SetParameter("inputdate",$inputdate);  //员工状态参数


$tplfile = "integral_input_1.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示




//获取员工编号 
function getempid($empcode)
{

			global $dsql;
	
		$questr1="SELECT emp_id FROM `#@__emp` where emp_code='".$empcode."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无记录";
		}
		else
		{
		
			$str=$rowarc1['emp_id'];
		
		
		}
	
		
	

return $str;


}
//显示完整的部门名称 




//获取扣项分值
//$kqzt 状态 
//
//$numb次数
function GetSub($kq_zt,$numb)
{
			 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;


					    if($kq_zt==1)$integral_kq = $numb*$yjcd;  //一级迟到每次10元
	
	
					   if($kq_zt==2)$integral_kq = $numb*$ejcd;  //一级迟到每次10元
					   if($kq_zt==3)$integral_kq = $numb*$sjcd;  //一级迟到每次10元

					  if($kq_zt==11) $integral_kq = $numb*$yjzt;  //一级迟到每次10元

					  if($kq_zt==12) $integral_kq = $numb*$ejzt;  //一级迟到每次10元


					  if($kq_zt==13) $integral_kq = $numb*$sjzt;  //一级迟到每次10元

					  if($kq_zt==21) $integral_kq = $numb*$kgbt;  //一级迟到每次10元

					  if($kq_zt==22) $integral_kq = $numb*$kgyt;  //一级迟到每次10元


return $integral_kq;


}



function GetSm($kq_zt)
{


          if($kq_zt==1)$kqzt_temp="一级迟到";
          if($kq_zt==2)$kqzt_temp="二级迟到";
          if($kq_zt==3)$kqzt_temp="三级迟到";
          if($kq_zt==11)$kqzt_temp="一级早退";
          if($kq_zt==12)$kqzt_temp="二级早退";
          if($kq_zt==13)$kqzt_temp="三级早退";
	      if($kq_zt==21)$kqzt_temp="旷工半天";
          if($kq_zt==22)$kqzt_temp="旷工一天";

//dump($kqzt_temp);
//dump($kqzt_zt);
return $kqzt_temp;




}



//获取考勤扣款规则  全局
function getconfig($integral_class)
 {  
 
	  global $dsql;
	  
	  global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
	  $yjcd=0;//一级迟到</td>
	  $ejcd=0;//二级迟到</td>
	  $sjcd=0;//三级迟到</td>
	  
	  $yjzt=0;//一级早退</td>
	  $ejzt=0;//二级早退</td>
	  $sjzt=0;//三级早退</td>
	  
	  $id=0;
	  for($i=65;$i<74;$i++)
	 { 
		 if(strtolower(chr($i))==$integral_class)$id=$i-64;
	 }
               

	if($id!=0)
	{
	
		  $arcQuery = "SELECT *  from #@__integral_checkinConfig  WHERE id='$id' ";
		  // //dump($arcQuery);
			$arcRow = $dsql->GetOne($arcQuery);
			if(!is_array($arcRow))
			{
				ShowMsg("读取考勤扣分配置信息出错!","-1");
				exit();
			}else{
				  
				  
				  $yjcd=$arcRow['yjcd'];//一级迟到</td>
				  $ejcd=$arcRow['ejcd'];//二级迟到</td>
				  $sjcd=$arcRow['sjcd'];//三级迟到</td>
				  
				  $yjzt=$arcRow['yjzt'];//一级早退</td>
				 $ejzt=$arcRow['ejzt'];//二级早退</td>
				 $sjzt=$arcRow['sjzt'];//三级早退</td>
		
				 $kgbt=$arcRow['kgbt'];//三级早退</td>
				 $kgyt=$arcRow['kgyt'];//三级早退</td>
				
			}
	}
}



//显示完整的部门名称 
function GetDep($empcode)
{
			global $dsql;
	
		$questr1="SELECT dep_name FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_code='".$empcode."')";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无部门记录";
		}
		else
		{
		
			$str=$rowarc1['dep_name'];
		
		
		}
	

return $str;

}





?>