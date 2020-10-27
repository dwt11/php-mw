<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 员工信息小助手
 *
 * @version        $Id: archive.helper.php 2 23:00 2010年7月5日Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */


//通过员工ID获取员工编号
if ( ! function_exists('GetEmpCodeByEmpId'))
{
    function GetEmpCodeByEmpId($empid)
    {
		
	global $dsql;
	
		$questr1="SELECT emp_code FROM `#@__emp` where emp_isdel=0 and  emp_id='".$empid."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="无记录";
		}
		else
		{
		
			$str=$rowarc1['emp_code'];
		
		
		}
			
		if(strlen($str)<3){
		  for ($i = 0; $i <=3-strlen($str); $i++) 
		  { 
			$str="0".$str;
		  }
		}
	

		return $str;
	}
}


//根据员工ID获取员工姓名 
if ( ! function_exists('GetEmpNameById'))
{
		function GetEmpNameById($empid)
	{
	
			 $str="";
			if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取的相关数据
	
				global $dsql;
				$questr1="SELECT emp_realname FROM `#@__emp` where emp_isdel=0 and emp_id='".$empid."'";
				
				//echo $questr1;
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
				  $str="无匹配的员工姓名";
				}
				else
				{
				
					$str=$rowarc1['emp_realname'];
				
				
				}
			}
		
	
	        return $str;
	
	
	}
}



//根据员工CODE获取员工姓名 
if ( ! function_exists('GetEmpNameByCode'))
{
		function GetEmpNameByCode($empcode)
	{
	
			 $str="";
			if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取的相关数据
	
				global $dsql;
				$questr1="SELECT emp_realname FROM `#@__emp` where emp_isdel=0 and emp_code='".$empcode."'";
				
				//echo $questr1;
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
				  $str="无匹配的员工姓名";
				}
				else
				{
				
					$str=$rowarc1['emp_realname'];
				
				
				}
			}
		
	
	        return $str;
	
	
	}
}


//根据登录ID获取员工姓名 
if ( ! function_exists('GetEmpNameByUserId'))
{
	function GetEmpNameByUserId($userid)
	{
	
			global $dsql;
			
			$str="";
            if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取的相关数据
			
				$str="无";
				$questr="SELECT userName,empid FROM `#@__sys_admin` WHERE  id='".$userid."'";
				
				$row = $dsql->GetOne($questr);
	
				if(is_array($row))
				{
					$empid=$row['empid'];
					$questr1="SELECT emp_realname FROM `#@__emp` where emp_id='".$empid."'";
					
					//echo $questr1;
					$rowarc1 = $dsql->GetOne($questr1);
					if(is_array($rowarc1))
					{
						$str=$rowarc1['emp_realname'];
					}else
					{
						$str=$row['userName'];
						}
				}
			}
		
	
			return $str;
	
	
	}
}

//根据登录ID获取员工工种ID
if ( ! function_exists('GetEmpWorkTypeIdByUserId'))
{
	function GetEmpWorkTypeIdByUserId($userid)
	{
	
			global $dsql;
			
			$str="";
            if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取的相关数据
			
				$str="无";
				$questr="SELECT userName,empid FROM `#@__sys_admin` WHERE  id='".$userid."'";
				
				$row = $dsql->GetOne($questr);
	
				if(is_array($row))
				{
					$empid=$row['empid'];
					$questr1="SELECT emp_worktype FROM `#@__emp` where emp_id='".$empid."'";
					
					//echo $questr1;
					$rowarc1 = $dsql->GetOne($questr1);
					if(is_array($rowarc1))
					{
						$str=$rowarc1['emp_worktype'];
					}else
					{
						$str="";
						}
				}
			}
		
	
			return $str;
	
	
	}
}



	//显示最后一级的部门名称 ，
if ( ! function_exists('GetEmpDepNameByEmpId'))
{
	function GetEmpDepNameByEmpId($empid)
	{
			global $dsql;
		
			$questr1="SELECT dep_name FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_id='".$empid."')";
			
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
}

	//显示最后一级的部门名称 ，
if ( ! function_exists('GetEmpDepNameByEmpCode'))
{
	function GetEmpDepNameByEmpCode($empcode)
	{
			global $dsql;
		
			$questr1="SELECT dep_name FROM `#@__emp_dep` where  dep_id=(SELECT emp_dep FROM `#@__emp` where emp_isdel=0 and emp_code='".$empcode."')";
			
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
}



//根据员工code 显示全部的部门名称150130
if ( ! function_exists('GetEmpDepAllNameByEmpCode'))
{
	function GetEmpDepAllNameByEmpCode($empcode)
	{
			global $dsql;
			global $sunDep;
			$str="";
			$sunDep="";
			
			
			$questr="SELECT emp_dep FROM `#@__emp`  where emp_isdel=0 and  emp_code='".$empcode."'";
			
			//echo $questr1;
			$rowarc = $dsql->GetOne($questr);
			if(!is_array($rowarc))
			{
			  $str="无员工记录";
			}
			else
			{
			
				$questr1="SELECT dep_name,dep_topid,dep_id FROM `#@__emp_dep` where dep_id='".$rowarc['emp_dep']."'";
				
				//echo $questr1;
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
				  $str="无部门记录";
				}
				else
				{
				
					if($rowarc1['dep_topid']!=0)$str=LogicGetSunDeps($rowarc1['dep_topid']);
					$str.=$rowarc1['dep_name'];
				
				}
			
			}
			
			
			
	return $str;
	
	}
}





//根据员工ID 显示全部的部门名称
if ( ! function_exists('GetEmpDepAllNameByEmpId'))
{
	function GetEmpDepAllNameByEmpId($empid)
	{
			global $dsql;
			global $sunDep;
			$str="";
			$sunDep="";
			$questr1="SELECT dep_name,dep_topid,dep_id FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_id='".$empid."')";
			
			//echo $questr1;
			$rowarc1 = $dsql->GetOne($questr1);
			if(!is_array($rowarc1))
			{
			  $str="无部门记录";
			}
			else
			{
			
			    if($rowarc1['dep_topid']!=0)$str=LogicGetSunDeps($rowarc1['dep_topid']);
				$str.=$rowarc1['dep_name'];
			
			}
	return $str;
	
	}
}





//获取当前部门名称
//缺陷记录使用
//$id部门ID
function GetDepsNameByDepId($id)
{
	global $dsql;
	$depName="";
	
	//150108添加 判断传入ID是否为空
	if($id!="")
	{
		$sql="SELECT dep_name FROM `#@__emp_dep` WHERE dep_id=$id";
		$row = $dsql->GetOne($sql);
		if(is_array($row))
		{
			$depName=$row['dep_name'];
		}
	}
	return $depName;
}


//获取登录用户ID对应的部门ID
//userid用户ID
function GetDepsIdByUserId($userid)
{
			global $dsql;
			
			$str="";
            if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取的相关数据
			
				$str="无";
				$questr="SELECT userName,empid FROM `#@__sys_admin` WHERE  id='".$userid."'";
				
				$row = $dsql->GetOne($questr);
	
				if(is_array($row))
				{
					$empid=$row['empid'];
					$questr1="SELECT emp_dep FROM `#@__emp` where emp_id='".$empid."'";
					
					//echo $questr1;
					$rowarc1 = $dsql->GetOne($questr1);
					if(is_array($rowarc1))
					{
						$str=$rowarc1['emp_dep'];
					}else
					{
						$str=$row['userName'];
						}
				}
			}
		
	
			return $str;
	
}







//递归获取上级部门名称
function LogicGetSunDeps($id)
{
	global $dsql;
	global $sunDep;
	$sql="SELECT dep_name,dep_topid FROM `#@__emp_dep` WHERE dep_id=$id";   //141214修改
	$dsql->SetQuery($sql);
	//dump($sql);
	$dsql->Execute("gs".$id);

	while($row=$dsql->GetObject("gs".$id))
	{
		$sunDep = $row->dep_name."-".$sunDep;
		$nid = $row->dep_topid;
		//dump($str);
		if($nid!=0)LogicGetSunDeps($nid);
	}
	//dump($sunDep);
	return $sunDep;
}





//根据登录ID 显示全部的部门名称
if ( ! function_exists('GetEmpDepAllNameByUserId'))
{
	//$userid   用户登录 ID
	//$usertype 用户权限值 默认为0  
	//如果包含部门和员工的功能,则根据USERID获取部门数据 ,
	//如果不包含,则用USERTYPE获取权限名称,这里只是跳转一下
	function GetEmpDepAllNameByUserId($userid,$usertype=0)
	{

            if(file_exists(DEDEPATH.'/emp'))
			{//如果系统有EMP的功能,获取部门的相关数据
				global $dsql;
				global $sunDep;
				$str="";
				$sunDep="";
	
				$questr="SELECT userName,empid FROM `#@__sys_admin` WHERE  id='".$userid."'";
				
				$row = $dsql->GetOne($questr);
	
				if(is_array($row))
				{
					$empid=$row['empid'];
	
					$questr1="SELECT dep_name,dep_topid,dep_id FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_id='".$empid."')";
					
					//echo $questr1;
					$rowarc1 = $dsql->GetOne($questr1);
					if(!is_array($rowarc1))
					{
						$str=$row['userName'];
	
					}
					else
					{
					
						if($rowarc1['dep_topid']!=0)$str=LogicGetSunDeps($rowarc1['dep_topid']);
						$str.=$rowarc1['dep_name'];
					
					}
				}
				//dump($str);
			}else
			{//没有部门数据
			//直接输出用户的权限组名称
				$str=	GetUserTypeNames($usertype);
			}
			return $str;
	
	}
}
























//文档阅读页面 ,获取已经阅读的用户的顶级部门,然后分类

//根据登录ID 显示最顶级的部门名称
if ( ! function_exists('GetEmpDepTopNameByUserId'))
{
	function GetEmpDepTopNameByUserId($userid)
	{

			global $dsql;
			global $sunDep;
			$str="";
			$sunDep="";
			$questr="SELECT userName,empid FROM `#@__sys_admin` WHERE  id='".$userid."'";
			
			$row = $dsql->GetOne($questr);

			if(is_array($row))
			{
				$empid=$row['empid'];

				$questr1="SELECT dep_name,dep_topid,dep_id FROM `#@__emp_dep` where dep_id=(SELECT emp_dep FROM `#@__emp` where emp_id='".$empid."')";
				
				//echo $questr1;
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
					$str="无";
				}
				else
				{
					$str=$rowarc1['dep_name'];
					if($rowarc1['dep_topid']!=0)GetTopDeps($rowarc1['dep_topid']);
					if($sunDep!="")$str=$sunDep;
				}
			}
			
			
	return $str;
	
	}
}


//递归获取上级部门名称
function GetTopDeps($id)
{
	global $dsql;
	global $sunDep;
	$sql="SELECT * FROM `#@__emp_dep` WHERE dep_id=$id";
	$dsql->SetQuery($sql);
	$dsql->Execute("gs".$id);
	while($row=$dsql->GetObject("gs".$id))
	{
		$sunDep = $row->dep_name;
		$nid = $row->dep_topid;
		if($nid!=0)GetTopDeps($nid);
	}
}






//获取部门中所有员工的登录ID
//用于：于文档管理等有保存登录用户ID发布的内容，与这个返回的用户ID比较 显示内容
//部门数据  string 格式 1，2
//RETURN  string 格式 1，2
if ( ! function_exists('GetDepAllUserId'))
{
	function GetDepAllUserId($depids)
	{
			global $dsql;
			$str="0";   ///141205修改 默认值原为空  要引起错误 改为0:如果查看不到值则默认为0 代表什么也查询不到

			$questr="SELECT admin.id FROM  dede_sys_admin  admin  LEFT JOIN `dede_emp` emp on admin.empid=emp.emp_id where emp.emp_dep in (".$depids.") ";  //141206优化此句,此句是获得userid,所以先查询admin在左连emp
			//dump($questr);
			$dsql->SetQuery($questr);
			$dsql->Execute();
				while($row=$dsql->GetObject())
				{
					
						$str.=",".$row->id;
				}
			//$str="0,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,498,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,144,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,499,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,418,419,420,421,422,423,424,425,426,427,428,429,430,431,432,433,434,435,436,437,438,439,440,441,442,443,444,445,446,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,465,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,487,489,490,491,492,493,494,495,500,501,502,504,505,453";
	//dump("555555");
			return rtrim($str,",");
	
	}
}




//获取指定部门中含有的指定工种 的所有员工的登录ID
//用于：工作日志 获取 厂领导 车间领导 专工的员工登录ID
//工种数据  string 格式 1，2
//部门数据  string 格式 1，2
//RETURN  string 格式 1，2
if ( ! function_exists('GetWorkTypeAllUserId'))
{
	function GetWorkTypeAllUserId($worktypeids,$depids="")
	{
			global $dsql;
			$str="";
            $wheresql="";
			 if($depids!="")$wheresql=" emp.emp_dep in (".$depids.") and ";
			$questr="SELECT admin.id FROM dede_sys_admin  admin LEFT JOIN `dede_emp` emp on admin.empid=emp.emp_id where $wheresql emp.emp_worktype in (".$worktypeids.") order by emp_dep asc,emp.emp_id asc";
			$dsql->SetQuery($questr);
			$dsql->Execute();

				while($row=$dsql->GetObject())
				{
					
						$str.=$row->id.",";
				}
			return rtrim($str,",");
	
	}
}
