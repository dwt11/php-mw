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


$aid = trim(preg_replace("#[^0-9]#", '', $aid));

$questr="SELECT empid FROM `#@__sys_admin` where  CONCAT(`empid`)='$aid' ";
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("删除失败,请先删除属于此员工的登录用户！","-1");
	exit(); 
}

$dsql->ExecuteNoneQuery("update `#@__emp` set emp_isdel=1 where emp_id='$aid';");
ShowMsg("删除成功！",$ENV_GOBACK_URL);
exit();
