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

$questr="SELECT integral_id FROM `#@__integral` where  integral_gzid='$aid' ";
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("删除失败,请先删除属于此规则的积分记录！","-1");
	exit(); 
}


	if(!$dsql->ExecuteNoneQuery("delete from `#@__integral_guizhe` where gz_id='$aid';"))
	{
        ShowMsg("删除数据时出错，请检查原因！", "-1");
        exit();
		
	}else
	{
	
		ShowMsg("删除成功！","integral_guizhe.php");
		exit();
	}

