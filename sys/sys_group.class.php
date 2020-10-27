<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 功能管理
 *
 * @version        $Id: depunit.class.php 1 15:21 2010年7月5日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * 系统功能管理   
 *
 * @package          DepUnit
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class sys_group
{
    var $dsql;
    var $funFileName;  //
    var $fileTitle;  //    第三行 输出带有扩展功能的标题
    var $depName;
	var $depId;
	var $allFileNumb;   //全部子功能的总个数
	var $childFileNumbArray;  //格式$childFileNumbArray[$key]   $key是主功能从数据库中读取出的ID //父功能包含的子功能的个数=数据库中子功能个数+sys_function_date.PHP中读取出的子功能的附加功能(新建-编辑-删除)
	var $childFilePlusNumbArray;  //格式$childFilePlusNumbArray[$key]   $key是子功能从数据库中读取出的ID //=子功能包含的扩展功能(新建-编辑-删除)的个数+自身的个数
	var $allDepNumb;   //全部部门的总个数
	var $save_webRole; //保存获取到的用户选择的权限
	var $save_depRole;//保存获取到的用户选择的权限



    var $funArray;    //此数据 不可以在类创建时 赋值,容易引起循环调用  造成死循环  必须在每个过程里调用
    //php5构造函数
    function __construct()
    {
		$this->dsql = $GLOBALS['dsql'];
        $this->depName = array();
        $this->depId = array();
        $this->funFileName = array();
        $this->fileTitle = array();
        $this->childFileNumbArray = array();
        $this->childFilePlusNumbArray = array();
        $this->allFileNumb = 0;
        $this->allDepNumb = 0;
        $this->save_webRole = "";
        $this->save_depRole = "";
		
		require_once(DEDEDATA."/sys_function_data.php");
			
		//引入功能类
		require_once("sys_function.class.php");
		$fun = new sys_function();
		$this->fucArray=$fun->getSysFunArray();
			
	    $this->getFileArray();   //获取子功能相关数据 并存入数组
	   $this->getAllDepArray();   //获取部门信息 并存入数组
	   $this->getDepNumb();   //获取部门总数
    }


    function sys_function()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }




	//输出
	function getRoleTable($groupWebRanks="",$groupDepRanks="",$isView=false)
	{
            
			$disp="";
            if(!$isView&&$groupWebRanks!=""&&!in_array("admin_AllowAll",$groupWebRanks))$disp= "style='display:none'";//如果是管理员输出显示,页面加载时自动隐藏;不是管理员输出隐藏,页面加栽时自动显示,因为showHide取的是反 
            echo "       <table  id='roleTable' width='98%'  border='0' cellspacing='1' cellpadding='1' $disp >\r\n";
            
			
			foreach ($this->fucArray as $key=>$menu)
			{
				 //$retuStr="";
				echo "<tr>\r\n
					  <td>\r\n
					  <table border='0' cellspacing='1'  cellpadding='1' style='margin:10px' bgcolor='#D6D6D6' align='left'>\r\n
				  <tr  align='center' bgcolor='#FBFCE2'>\r\n";
				$this->getDirs($key,$menu);   //直接输出 父功能名称
				echo "</tr>\r\n";
				  
	  
	  
				//输出两行文字:页面的功能名称
				//第一行 数据库中的功能名称(菜单显示)
				//第二行 功能的附加功能 从文件中读取 (新建 编辑 删除等)
				$this->getFiles($key,$menu);   //直接输出
	  
	  

				echo "<tr  align='center' bgcolor='#ffffff'  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">";
				//输出一行checkbox:用于列全选
				$this->getCheckbox($key,$menu,$groupWebRanks,$groupDepRanks,$isView);   //直接输出
				echo "</tr>";
	  
				//输出所有部门的行:部门
				//第一列部门名称,第二列CHECKBOX用于行全选 
				$this->getDeps($key,$menu,$groupWebRanks,$groupDepRanks,$isView);   //直接输出
	  
	  
	  
				echo "</table>\r\n
				             </td>\r\n
            </tr>\r\n";
			}
			
			echo "</table>\r\n";
	}




  

	//输出第一行 父功能代码
	//$key   父功能的数据库ID
	//$menu  父功能的名称
	function getDirs($key,$menu)
	{


            //if(file_exists(DEDEPATH.'/emp'))
			//echo "        <td rowspan=\"4\"  colspan=\"2\" ><!--第一列和第一行的左上角空白--></td>";   //如果有员工和部门的相关功能,才输出这个第一列
					  //如果没有部门,则输出单行 全选checkbox
				if($this->allDepNumb==0)
				{
					echo "        <td rowspan=\"3\" width='30'><!--第一列和第一行的左上角空白--></td>";   //如果有员工和部门的相关功能,才输出这个第一列
				}else
				{
					echo "        <td rowspan=\"4\"  colspan=\"2\" ><!--第一列和第一行的左上角空白--></td>";   //如果有员工和部门的相关功能,才输出这个第一列	
				}
				
				
				
				
			//dump($this->fucArray);
				
				
				//如果子功能记录数大于0才输出父功能 
				if($this->childFileNumbArray[$key]>0)
				{
					$parentMenu=explode(',',$menu[0]);  
					//$parentId=$parentMenu[0];
					$parentTitle=$parentMenu[3];
					
					$childNumb=count($menu)-1;
					$this->allFileNumb+=$childNumb;
					//dump($childNumb);
					//dump($this->childFileNumbArray[$key]."-----0--------");
					//输出父功能名称
					echo     "<td colspan=\"".$this->childFileNumbArray[$key]."\"><strong>$parentTitle</strong></td>\r\n";
				}



	}
	

          //输出两行文字:页面的功能名称
	//$key   父功能的数据库ID
	//$menu  父功能的名称
	function getFiles($key,$menu)
	{       
		  //第二行 数据库中的子功能名称(菜单显示)
			echo "      <tr  align=\"center\" bgcolor=\"#FBFCE2\">\r\n";
			for($childi=1;$childi<count($menu);$childi++)
			{
				$childMenu=explode(',',$menu[$childi]);  
				$childId=$childMenu[0];
				$childTitle=$childMenu[3];
				//dump($this->childFilePlusNumbArray);
				$plusi=0;
				//if($this->childFileNumbArray[$childId]!=NULL)
				$plusi=$this->childFilePlusNumbArray[$childId];
				$colspan="";
				if($plusi>1)
				{
					$td_row= "colspan=\"".$plusi."\"";
				}else
				{
					$td_row= " rowspan=\"2\"  ";
				}
				echo "<td $td_row  nowrap style='min-width:60px'>".$childTitle."</td>\r\n";
			}
			echo "</tr>\r\n";

			echo "      <tr  align=\"center\" bgcolor=\"#FBFCE2\">\r\n";
		  
		  
		  
		  //第三行 子功能的附加功能 从文件中读取 (新建 编辑 删除等)
			if(array_key_exists($key,$this->fileTitle))
			{
				for($i1=0; $i1<=count($this->fileTitle[$key])-1; $i1++)
				{
					echo "<td  valign=\"top\" align=\"center\" nowrap; style='min-width:60px'>".$this->fileTitle[$key][$i1]."</td>\r\n";
				}
				echo "</tr>";
			}
			
		  
	}

    //输出第四行 checkbox :用于列全选
	//$key   父功能的数据库ID
	//$menu  父功能的名称
	//$groupWebRanks=""    编辑或查看时传过来的用户的页面权限值
	//,$groupDepRanks="",  编辑或查看时传过来的用户的部门权限值
	//$isView=false        false输出checkbox   TRUE输出五角星,查看权限页面用
	function getCheckbox($key,$menu,$groupWebRanks="",$groupDepRanks="",$isView=false)
	{

		  //如果没有部门,则输出单行 全选checkbox
		  if($this->allDepNumb==0)
		  {
			  echo "<td align=\"center\"  height='30' >";
				  if(!$isView)echo "<input name=\"dep".$key."[]\" type='checkbox' class='np' value=\"\"  onClick='row_Sel(\"$key\")'   >";   //没有部门数据时的 列全选
			  echo "</td >";
		  }
		  for($i1=0; $i1<=count($this->funFileName[$key])-1; $i1++)
          {
              echo "<td align=\"center\"  height='30' >";
			  if($this->isDepDate($this->funFileName[$key][$i1]))  //如果此功能包含部门数据输出部门的总数 否则输出0 用于JS判断 列的CHECKBOX的全选
			  {
				  if(!$isView)echo "<input  type='checkbox' class='np' id='file_".$i1.$key."'  value=\"\"  onClick='col_Sel(\"".$i1.$key."\",\"".$this->allDepNumb."\")'  >";
			  }else
			  {
				   //这个是隐藏的
//				   if(!$isView)echo "<input name=\"onlyfile[]\"  type=\"checkbox\" class='np'  id='file_".$i1."_-100'  value=\"".$this->funFileName[$key][$i1]."\"";
//				   if(!$isView&&($groupWebRanks!=""||$groupDepRanks!=""))echo $this->CRank(0,$this->funFileName[$key][$i1],$groupWebRanks,$groupDepRanks,$isView);  //是否选中
//				   //if(!$isView)echo " style=\"display:none\"> ";
//				   if(!$isView)echo " > ";
				  
				   //如果此功能 不包含部门数据 则输出下面这个checkbox 用于保存页面直接获取 只文件功能的名称
					if(!$isView)echo "<input name=\"dep".$key."[]\" type='checkbox' class='np' id='file_".$i1."_-100' value=\"".$this->funFileName[$key][$i1]."\" ";
					if($groupWebRanks!=""||$groupDepRanks!="")echo $this->CRank(0,$this->funFileName[$key][$i1],$groupWebRanks,$groupDepRanks,$isView);
					if(!$isView)echo ">";
				  
				  
			  }
			  //echo "";
			  echo "</td>\r\n";
          }
	}


		  //输出所有部门的行:部门
		  //第一列部门名称,第二列CHECKBOX用于行全选 
          //$groupWebRanks="",$groupDepRanks="" 编辑和查看时使用的  数据库中保存的用户的权限 是数组
		  //isview 是否查看页面  为1的话 不输出checkbox
	function getDeps($key,$menu,$groupWebRanks="",$groupDepRanks="",$isView=false)
	{
				//dump($this->allDepNumb);
				//dump($fun->depName);
		  
		  
		  if($this->allDepNumb>0)
		  { 
				for($i2=0; $i2<$this->allDepNumb; $i2++)
				{
					
					$colspan="";
					if($isView)$colspan=" colspan='2'";//如果是权限查看则将此列设置为2
					echo "<tr align=\"left\" bgcolor=\"#FFFFFF\" height=\"26\"  onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"> 
							   <td style='white-space:nowrap;padding-left:5px'  bgcolor=\"#FBFCE2\" $colspan>".$this->depName[$i2]."</td>";
							   
					if(!$isView)echo "<td align=\"center\" bgcolor=\"#FBFCE2\"><input name=\"dep".$i2.$key."[]\" type='checkbox' class='np' value=\"\"  onClick='row_Sel(\"".$i2.$key."\")'   ></td>\r\n";
					
					//输出checkbox
					for($i3=0; $i3<=count($this->funFileName[$key])-1; $i3++)
					  {
						  //页面文件名称 用于存入数据库 $funFileName[$i3]
						  //部门ID,用于存入数据库$depId[$i2]
						  
						  
						  //CHECKBOX  行全选用getElementsByName  以dep[]命名
						  //CHECKBOX  列全选用getElementById  以file[]命名
						  // 判断 是否选中 ".CWebRank($row->dir)."
						  echo "<td nowrap  align=\"center\">";
						  
						  if($this->isDepDate($this->funFileName[$key][$i3]))  //如果此功能包含部门数据才输出checkbox 否则输出"-"
						  {
							  if(!$isView)echo "<input name=\"dep".$i2.$key."[]\" type='checkbox' class='np' id='file_".$i3.$key."_".$i2."' value=\"".$this->depId[$i2].",".$this->funFileName[$key][$i3]."\" ";
							  if($groupWebRanks!=""||$groupDepRanks!="")echo $this->CRank($this->depId[$i2],$this->funFileName[$key][$i3],$groupWebRanks,$groupDepRanks,$isView);
							  if(!$isView)echo ">";
						  }else
						  {
							  echo "-";
							  }
						  echo "</td>\r\n";
					  }
					echo "</tr>";
				  }
		  }

	}















































		//检查是否已经有此权限
		//$depId  部门ID
		//$funFileName 页面文件名称
		//$groupWebRanks,$groupDepRanks数组库中保存的值
		/*
		说明:
		web_role保存数据为:
		
		emp/emp.php|emp/emp_add.php|salary/salary.php|sys/sys_user_add.php|emp/dep.php|emp/dep_add.php|emp/worktype.php|emp/worktype_add.php|emp/dep_del.php|emp/dep_edit.php|emp/emp_do.php|emp/emp_edit.php|emp/worktype_del.php|emp/worktype_do.php|emp/worktype_edit.php|emp/emp_del.php|checkin/c_input.php|checkin/c_check.php|checkin/c_list.php|checkin/c_config.php|checkin/c_check_1.php|checkin/c_input_1.php|integral/integral.php|integral/integral_add.php|integral/integral_input.php|integral/integral_checkinConfig.php|integral/integral_guizhe.php|integral/integral_guizhe_add.php|integral/trundle.php|integral/integral_query.php|integral/integral_do.php|integral/integral_guizhe_edit.php|integral/integral_input_1.php|integral/integral_del.php|salary/salary_add.php|salary/salary_day.php|salary/salary_t.php|salary/salary_config.php|salary/salary_do.php|salary/salary_edit.php|salary/salary_del.php|sys/sys_info.php|sys/sys_stepselect.php|sys/log.php|sys/sys_function.php|sys/sys_cache_up.php|sys/sys_data.php|sys/sys_data_revert.php|sys/sys_group.php|sys/sys_group_add.php|sys/sys_user.php|sys/log_del.php|sys/sys_user_edit.php|sys/sys_data.done.php|sys/sys_group_edit.php|sys/sys_group_del.php|sys/sys_user_del.php
		
		
		
		
		
		
		dep_role保存数据为:
		
		1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28
		
		
		数据以|为分隔符   web和dep是对应的个数
		
		检查权限时,先搜索当前页面名称filename在web_role中以|分隔的数组中的索引key
		然后获取 dep_role以|分隔的数组KEY为filenameKEY的值,将这个值以","分隔为数组,然后查找depId是否在此数组中,如果在则返回checked
		*/

		function CRank($depId,$funFileName,$groupWebRanks,$groupDepRanks,$isView=false)
		{
			$return_str="";
			//dump($funFileName);
			//dump($groupWebRanks);
			$funFileNameKey = array_search($funFileName, $groupWebRanks);
				if($funFileNameKey!==false)     //当用 === 或 !== 进行比较时则不进行类型转换，因为此时类型和数值都要比对(因为key值有可能是0,如果用!=比较的话0也是false)
				{
					if($depId==0)//如果部门数据为0则表示 不包含部门数据  直接输出判断  
					{
							  $return_str=" checked";
							  if($isView)$return_str=" ★";	
					}else
					{
						  if(in_array($depId,explode(',',$groupDepRanks[$funFileNameKey])))
						  {
							  $return_str=" checked";
							  if($isView)$return_str=" ★";	
						  }
					}
				}

			return  $return_str;
		}











//获取用户选中的 功能权限和部门权限 字符串 用于保存到数据库
    function getSaveValue($checkBoxArrary)
	{
			 //2将 页面文件名称相同的数组,对应的部门ID合并
			  $tmpArray = array();
			  foreach ($checkBoxArrary as $row) {
				  $key = $row['webRole'];
				  if (array_key_exists($key, $tmpArray)) {
					  $tmpArray[$key]['depRole'] = $tmpArray[$key]['depRole']  . ',' . $row['depRole'];
				  } else {
					  $tmpArray[$key] = $row;
				  }
			  }
			  
			  //dump($tmpArray);
	/*		  array(2) {
						["emp/emp.php"] => array(2) {
						  ["webRole"] => string(11) "emp/emp.php"
						  ["depRole"] => string(89) "1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51"
						}
						["emp/emp_add.php"] => array(2) {
						  ["webRole"] => string(15) "emp/emp_add.php"
						  ["depRole"] => string(89) "1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51"
						}
					  }
	*/
	
	
				$All_Role=""; 
				 $All_webRole ="";
				 $All_depRole ="";
			  //3将合并后的数组 组合为字符串
			  foreach ($tmpArray as $row) {
				 $All_Role.=$row["webRole"]."|".$row["depRole"]." ";
				 $All_webRole .=$row["webRole"]."|";
				 $All_depRole .=$row["depRole"]."|";
			  }
			  
	
	
	
	
			  $this->save_webRole = rtrim($All_webRole,"|");
			  $this->save_depRole = rtrim($All_depRole,"|");

		
		}


    
    //是否包含部门数据 包含返回TRUE 不包含FALSE
	//	$dirFileName  功能的文件名称 需要分隔开/号使用
	function isDepDate($dirFileName)
	{
		$dirFileName=ClearUrlAddParameter($dirFileName);   //清除地址里的参数
		$dirFileNames=explode('/',$dirFileName);
		//dump($dirFileName);
		//dump(is_array($dirFileNames));
		if(count($dirFileNames)>1)
		{
			$dirName=$dirFileNames[0];
			$fileName=ClearUrlAddParameter($dirFileNames[1]);   //清除了文件连接后带的参数
		
		
			
					//在文本文件里判断
				$row=$GLOBALS['baseConfigFunArray'][$dirName];
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //这里不用!==了  这个!==是怕找出字符串在0位,我们就是不要用0位的
					 if ( strpos( $row[$funi] , $fileName ) >0 )   
					 {
						  $oneBaseConfigs= $row[$funi];	
						  if($oneBaseConfigs!="")
						  {
							  $oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
							  $isdep=$oneBaseConfigsArray[4];
							if($isdep==1)
							{
							  return true;
							}else{
								return false;
							}
						  }
					 }
				}
						
	
		}
		
		
	
	}
	
	
	
    //判断是否包含部门数据,并且是EDIT和DEL页面(系统中如果包含部门数据,列表页和添加页分别在自己的页面使用SQL语句列表可以的部门数据.编辑页和删除页在TestRole中判断)
	// 包含返回TRUE 不包含FALSE
	//	$dirFileName  功能的文件名称 需要分隔开/号使用
	function isDepRoleToTestRole($dirFileName)
	{
		$dirFileName=ClearUrlAddParameter($dirFileName);   //清除地址里的参数
		$dirFileNames=explode('/',$dirFileName);
		$iseditdel=strpos($dirFileName , "_edit" )!== false||strpos($dirFileName , "_del" )!== false;
		if(count($dirFileNames)>1&&$iseditdel)
		{
		//dump($dirFileName);
			$dirName=$dirFileNames[0];
			$fileName=ClearUrlAddParameter($dirFileNames[1]);   //清除了文件连接后带的参数
		
		
		
					//在文本文件里判断
				$row=$GLOBALS['baseConfigFunArray'][$dirName];
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //这里不用!==了  这个!==是怕找出字符串在0位,我们就是不要用0位的
					 if ( strpos( $row[$funi] , $fileName ) >0 )   
					 {
					  $oneBaseConfigs= $row[$funi];	
						if($oneBaseConfigs!="")
						{
							$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
							$isdep=$oneBaseConfigsArray[4];    //是否包含部门数据
							
						  if($isdep==1)
						  {
							return true;
						  }else{
							return false;
						  }
						}
					 }
				}
		}
		
		
	
	}
	
	
	




	
//-------------------------------------以下只在本页面内调用  外部不引用 --------------------------------------------------



//获取子功能,并存入数组
//$dir 父功能名称
//$diri 父功能记记数
	function getFileArray()
	{
		
		
		    //先获取数据库中的功能,然后根据数据库的功能,获取文本文件里的扩展功能
			foreach ($this->fucArray as $parentIdKey=>$menu)
			{
				$this->childFileNumbArray[$parentIdKey]=count($menu)-1;    //这里累加父功能的子功能数
					//dump($parentIdKey);
				
				
				for($childi=1;$childi<count($menu);$childi++)
				{
					//先获取数据库中的 父功能下的子功能的相关信息
					$childMenu=explode(',',$menu[$childi]);  
					$childId=$childMenu[0];
					$childUrlAdd=$childMenu[1];
					$childTitle=$childMenu[3];

                    //dump($childUrlAdd);
					$this->childFilePlusNumbArray[$childId]=1;
					
					//再获取子功能的扩展功能
					$isFilePlus=$this->getIsFilePlusArray($childUrlAdd,$parentIdKey,$childId); //是否包含扩展功能
					
					
					$this->funFileName[$parentIdKey][] =$childUrlAdd;              //这个是第四行开始的CHECKBOX使用的功能的 实际文件地址,这个要每个都在入数组    //1201修改为带KEY的数组  便于按父功能分组显示
					
					
					
					  //如果包含扩展功能,则将数据库包含的功能加入数组 用于第三行的 标题输出
					  //不包含扩展功能,则第二行已经输出了这个标题,就不再输出了
					  //????这里有问题,如果列表页不是管理,怎么显示141026
					  //这个是从数据库获取的,如何确认与文本文件中的_后面的对应上,以后考虑
					
					if($isFilePlus)
					{
						$this->fileTitle[$parentIdKey][] ="管理";//1201修改为带KEY的数组  便于按父功能分组显示
					
						$this->getFilePlusArray($childUrlAdd,$parentIdKey,$childId);
					}
					
					
					//$filename=$filenameArray[1];
					//dump($filename);
					//dump($baseConfigFunArray[$dirname]);
					

					
					///dump(array_search("dep_add.php",$baseConfigFunArray[$dirname]));
					
				}
			}

				
	}
	
	
	
	//判断子功能 是否包含扩展功能 
	//$childUrlAdd//子功能的实际地址
	//$parentIdKey /父功能的数据库ID
	//$childId   //子功能的数据库ID
	//RETURN bool 带表 当前数据库中的子功能 是否包含扩展功能
	function getIsFilePlusArray($childUrlAdd,$parentIdKey,$childId)
	
	{
		    //引入功能的文本文件
			require_once(DEDEDATA."/sys_function_data.php");		
			global $baseConfigFunArray;
		    $retuBool=false;
			//得到所有包含filename的字符串
			//dump($childUrlAdd);
			$filenameArray=explode('/',$childUrlAdd);
			$dirname=$filenameArray[0];//父功能的目录名称
			//dump($filenameArray[1]);
            
			if(count($filenameArray)>1)
		   {

				  $filename=str_replace(".php","",ClearUrlAddParameter($filenameArray[1]))."_"; //获取功能名称的前缀名称 例 emp_,用于在文件数据中搜索 扩展有功能
				  
			//dump($filename);
				  
				  //dump($baseConfigFunArray[$dirname]);
				  foreach( $baseConfigFunArray[$dirname] as $key_plus=>$s )
				  {
					 if ( strpos( $s , $filename ) >0 && $key_plus > 0)    //如果包含  emp_，并且是子功能 
					 {
							$childMenu_plus=explode(',', $baseConfigFunArray[$dirname][$key_plus]);  
							$isjeep=$childMenu_plus[3];
							
							//只将跳转的数据 列出
							//不是跳转的 在系统功能中添加
							if($isjeep==1)
							{
								return true;  //只要有一个数据 就代表包含扩展功能  然后跳出
							}
						   
					 }
				  }
		   }
			return false;
		
		
		
		
	}
	//获取扩展功能的数据 并存入数组
	//$childUrlAdd//子功能的实际地址
	//$parentIdKey /父功能的数据库ID
	//$childId   //子功能的数据库ID
	//不返回数据
	function getFilePlusArray($childUrlAdd,$parentIdKey,$childId)
	
	{
		    //引入功能的文本文件
			require_once(DEDEDATA."/sys_function_data.php");		
			global $baseConfigFunArray;
			$filenameParameter="";//文档相关页面地址后的 CID参数
			
			//得到所有包含filename的字符串
			$filenameArray=explode('/',$childUrlAdd);
			$dirname=$filenameArray[0];//父功能的目录名称
			$filename=str_replace(".php","",ClearUrlAddParameter($filenameArray[1]))."_"; //获取功能名称的前缀名称 例 emp_,用于在文件数据中搜索 扩展有功能
			$filenameParameter=ReturnUrlAddParameter($filenameArray[1]); //获取文档相关页面地址后的 CID参数
			//dump($childUrlAdd);
			
			
			//dump($baseConfigFunArray[$dirname]);
			foreach( $baseConfigFunArray[$dirname] as $key_plus=>$s )
			{
			   //if ( strpos( $s , $filename ) !== false )   //这里不用!==了  这个!==是怕找出字符串在0位,我们就是不要用0位的
						
			   if ( strpos( $s , $filename ) >0 && $key_plus > 0 )     //如果包含  emp_，并且是子功能 
			   {
					 //dump( $baseConfigFunArray[$dirname][$key_plus] );
					  $childMenu_plus=explode(',', $baseConfigFunArray[$dirname][$key_plus]);  
					  //$childId_plus=$childMenu_plus[0];
					  $childUrlAdd_plus=$dirname."/".$childMenu_plus[1];   //文本文件中的数据地址只有文件名称无目录名称 所以要加上目录名称,供存入数组调取
					  if($filenameParameter!="")$childUrlAdd_plus.=$filenameParameter;
					  
					  $childTitle_plus_array=explode('_',$childMenu_plus[2]);  
					  if(is_array($childTitle_plus_array)&&count($childTitle_plus_array)>1)$childTitle_plus=$childTitle_plus_array[1];     //150131修复BUG原来没有计算长度
					  $isjeep=$childMenu_plus[3];
					  
					  //只将跳转的数据 列出
					  //不是跳转的 在系统功能中添加
					  if($isjeep==1)
					  {
						  $this->childFileNumbArray[$parentIdKey]++;    //这里累加父功能的子功能数  第一行
						  $this->childFilePlusNumbArray[$childId]++;   //子功能的扩展功能记数  第二行
						  $this->allFileNumb++;  //第三行的列数
						  //dump($childUrlAdd_plus);
						  $this->funFileName[$parentIdKey][] =$childUrlAdd_plus;   //1201修改为带KEY的数组  便于按父功能分组显示
						  $this->fileTitle[$parentIdKey][] =$childTitle_plus;      //1201修改为带KEY的数组  便于按父功能分组显示
						 // dump($childTitle_plus);
						  
					  }
					 
			   }
			}
	}
	

	 //获取部门个数,用于输出表格的个数
	function getDepNumb()
	{
			//1\按分组显示 直接在列表里显示的功能
			//根据父分类名称返回 子分类
			if(file_exists(DEDEPATH.'/emp'))
			{
				$query = " SELECT  count(*) as dd FROM `#@__emp_dep`  ORDER BY dep_id ASC  ";	    //echo $query."<br>";//exit;
				$row = $this->dsql->GetOne($query);
				$this->allDepNumb=$row['dd'];
			}else
			{
				$this->allDepNumb=0;
			}
	}


	 //获取部门的数组
	function getAllDepArray()
	{
			if(file_exists(DEDEPATH.'/emp'))
			{
				  $query = " SELECT * FROM `#@__emp_dep`  WHERE dep_topid=0 ORDER BY dep_id ASC ";
				  $this->dsql->SetQuery($query);
				  $this->dsql->Execute();
			  
				  while($row=$this->dsql->GetObject())
				  {
					  $this->depName[] = $row->dep_name;
					  $this->depId[] = $row->dep_id;
					  $this->LogicGetDepArray($row->dep_id, '&nbsp;&nbsp;', $dsql);
				  }
			}
	}
	
	/*($selid 选中的ID
	,$id,  父ID
	$step, 第几级
	&$dsql, SQL
	*/
	function LogicGetDepArray($id,$step,&$dsql)
	{
		$this->dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$id."'  order by dep_id asc");
		$this->dsql->Execute($id);
		while($row=$this->dsql->GetObject($id))
		{
			$this->depName[] = $step.$row->dep_name;
			$this->depId[] = $row->dep_id;
			$this->LogicGetDepArray($row->dep_id,$step.'&nbsp;&nbsp;',$dsql);
			
		}
		
		
	}
//-------------------------------------以上只在本页面内调用  外部不引用 --------------------------------------------------


}//End Class