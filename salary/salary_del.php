<?php
/**
 * ɾ������
 *
 * @version        $Id: dep_del.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');


$aid = trim(preg_replace("#[^0-9]#", '', $aid));


	$dsql->ExecuteNoneQuery("delete from  `#@__salary`  where salary_id='$aid';");
	ShowMsg("ɾ���ɹ���",$ENV_GOBACK_URL);
	exit();
