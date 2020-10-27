<?php
/**
 * 部门SELECT OPTIONS选项函数-外部引用
 *
 * @version        $Id: inc_catalog_options.php 1 10:32 2010年7月21日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  获取带权限查询的选项列表
 *
 * @access    public
 * @param     string  $selid  选择ID
 * @return    string
 */
function GetDepOptionList($selid=0)
{
    global $OptionDepArrayList;    //返回OPTION的语句
	global $dsql;
	global $DepArray;    //保存已经查询过的部门ID

	$wheresql="";
    //当前选中的部门
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $OptionDepArrayList .= "<option value='".$row['dep_id']."' selected='selected'>".$row['dep_name']."</option>\r\n";
    }
   global $funAllName;
//   echo $funAllName;
   $wheresql  .= getDepRole($funAllName,"dep_id");    //返回可以管理的部门ID的 查询语句
 //由于权限查出来的部门有可能,是没有子部门的权限的,所以这里和下面的部门查询部分,要检查 查询出来的子ID是否在部门权限里
 //返回的权限查询语句,里面包含所有的可以查询的ID,所以在获取子分类时 要检测是否已经查询过此ID
 
 
    global $DepRole;
 	$DepRole=getDepRole($funAllName);  //获得具有权限的ID,如果没有权限则跳过

    //dump ($wheresql);
    
    if($wheresql==""){$wheresql=" and dep_topid=0";}  
	$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
		
        //检查已经查询过的部门ID,如果已经查询过,则跳过		
		$DepArrays = explode(',', rtrim($DepArray,","));
        if(in_array($row->dep_id,$DepArrays ))
        {
            //dump($row->dep_id);
            continue;
        }

        
		
		
		$sonCats = '';
        LogicGetDepOptionArray($row->dep_id, '─', $dsql, $sonCats);
		$OptionDepArrayList .= "<option value='".$row->dep_id."' class='option1'>".$row->dep_name."</option>\r\n";
		$OptionDepArrayList .= $sonCats;
		$DepArray .= $row->dep_id.",";

       
    }
	//dump($DepArray);
    return $OptionDepArrayList;
}








/**

150130添加

美味integral_query.htm 积分查询页面使用
HC 设备检修记录汇总 更换汇总中使用
 *  获取不带权限查询的选项列表
 *
 * @access    public
 * @param     string  $selid  选择ID
 * @return    string
 */
function GetDepOptionList_norole($selid=0)
{
    global $OptionDepArrayList;    //返回OPTION的语句
	global $dsql;
	global $DepArray;    //保存已经查询过的部门ID

	$wheresql="";
    //当前选中的部门
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $OptionDepArrayList .= "<option value='".$row['dep_id']."' selected='selected'>".$row['dep_name']."</option>\r\n";
    }

    //dump ($wheresql);
    
    if($wheresql==""){$wheresql=" and dep_topid=0";}  
	$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
		
        //检查已经查询过的部门ID,如果已经查询过,则跳过		
		$DepArrays = explode(',', rtrim($DepArray,","));
        if(in_array($row->dep_id,$DepArrays ))
        {
            //dump($row->dep_id);
            continue;
        }

        
		
		
		$sonCats = '';
        LogicGetDepOptionArray($row->dep_id, '─', $dsql, $sonCats);
		$OptionDepArrayList .= "<option value='".$row->dep_id."' class='option1'>".$row->dep_name."</option>\r\n";
		$OptionDepArrayList .= $sonCats;
		$DepArray .= $row->dep_id.",";

       
    }
	//dump($DepArray);
    return $OptionDepArrayList;
}



function LogicGetDepOptionArray($id,$step,&$dsql, &$sonCats)
{
    global $OptionDepArrayList;    //返回OPTION的语句
	global $DepArray;    //保存已经查询过的部门ID
	global $DepRole;    //保存已经查询过的部门ID
    $dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$id."'  order by dep_id asc");
    $dsql->Execute($id);
    while($row=$dsql->GetObject($id))
    {
        	
		if($DepRole!="")
		{
			$DepRoleArrays = explode(',', $DepRole);
			if(!in_array($row->dep_id,$DepRoleArrays ))
			{
				//dump($row->dep_id);
				continue;
			}
		}

        $sonCats .= "<option value='".$row->dep_id."' class='option3'><span style='color:#666666'>$step</span>".$row->dep_name."</option>\r\n";
        LogicGetDepOptionArray($row->dep_id,$step.'─',$dsql, $sonCats);
		$DepArray .= $row->dep_id.",";
    }
	
	
}




























//PS这段没有加部门数据权限  因为这段用于管理页面的查询,查询的同时已经加了部门数据权限
//返回当前所选定的部门  的所有下级部门的子ID，列表供查询相关部门下包含的记录时使用
function GetDepChildArray($selid=0)
{
    global $DepArray, $dsql;


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
