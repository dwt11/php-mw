<?php
/**
 * 删除部门
 *
 * @version        $Id: dep_del.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');

//权限值ID有可能出现小数位,所以不过滤了  140820
//$rank = trim(preg_replace("#[^0-9]#", '', $rank));



$questr="SELECT usertype FROM `#@__sys_admin` where  `usertype` = '$rank' ";
$rowarc = $dsql->GetOne($questr);
//dump($questr);
if(is_array($rowarc))
{
	ShowMsg("删除失败,请先删除属于此权限组的登录用户！","-1");
	exit(); 
}

    $sql="DELETE FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='$rank' ;";
    //dump($sql);
    $dsql->ExecuteNoneQuery($sql);
    ShowMsg("成功删除一个用户组!","sys_group.php");
    exit();
