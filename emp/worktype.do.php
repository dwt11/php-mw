<?php
/**
 * 工种操作
 *
 * @version        $Id: worktype.do.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');
if(empty($dopost))
{
    ShowMsg("对不起，请指定工种参数！","worktype.php");
    exit();
}
$cid = empty($cid) ? 0 : intval($cid);


/*--------------------------
//查看 包含的员工
---------------------------*/
 if($dopost=="listEmp")
{
}

/*-----------
获得子类的内容-----菜单里用  暂无用
function GetSunListsMenu();
-----------
else if($dopost=="GetSunListsMenu")
{
    $userChannel = $cuserLogin->getUserChannel();
    require_once("worktypeunit.class.php");
    AjaxHead();
    PutCookie('lastCidMenu',$cid,3600*24,"/");
    $tu = new WorktypeUnit($userChannel);
    $tu->LogicListAllSunWorktype($cid,"　");
}*/
/*-----------
获得子类的内容
function GetSunLists();
-----------*/
else if($dopost=="GetSunLists")
{
    require_once("worktypeunit.class.php");
    AjaxHead();
    PutCookie('lastCid', $cid, 3600*24, "/");
    $tu = new WorktypeUnit();
    $tu->dsql = $dsql;
    echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $tu->LogicListAllSunWorktype($cid, "　");
    echo "    </table>\r\n";
    $tu->Close();
}
