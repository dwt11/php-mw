<?php
/**
 * 部门选项函数
 *
 * @version        $Id: inc_catalog_options.php 1 10:32 2010年7月21日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  获取选项列表
 *
 * @access    public
 * @param     string  $selid  选择ID
 * @return    string
 */
function GetGzOptionList($selid=0)
{
    global $OptionGzArrayList, $dsql;


    //当前选中的部门
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp_worktype` WHERE worktype_id='$selid'");
         $OptionGzArrayList .= "<option value='".$row['worktype_id']."' selected='selected'>".$row['worktype_name']."</option>\r\n";
    }

        $query = " SELECT * FROM `#@__emp_worktype`  WHERE worktype_topid=0 ORDER BY worktype_id ASC ";

    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
        $sonCats = '';
        LogicGetGzOptionArray($row->worktype_id, '─', $dsql, $sonCats);
        if($sonCats != '')
        {
            $OptionGzArrayList .= "<option value='".$row->worktype_id."' class='option1'>".$row->worktype_name."</option>\r\n";
            $OptionGzArrayList .= $sonCats;
        }
       
    }
    return $OptionGzArrayList;
}

function LogicGetGzOptionArray($id,$step,&$dsql, &$sonCats)
{
    global $OptionGzArrayList;
    $dsql->SetQuery("Select * From `#@__emp_worktype` where worktype_topid='".$id."'  order by worktype_id asc");
    $dsql->Execute($id);
    while($row=$dsql->GetObject($id))
    {
            $sonCats .= "<option value='".$row->worktype_id."' class='option3'>$step".$row->worktype_name."</option>\r\n";
        LogicGetGzOptionArray($row->worktype_id,$step.'─',$dsql, $sonCats);
    }
}