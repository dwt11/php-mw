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

$questr="SELECT empid FROM `#@__sys_admin` where  CONCAT(`empid`)='$aid' ";
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("ɾ��ʧ��,����ɾ�����ڴ�Ա���ĵ�¼�û���","-1");
	exit(); 
}

$dsql->ExecuteNoneQuery("update `#@__emp` set emp_isdel=1 where emp_id='$aid';");
ShowMsg("ɾ���ɹ���",$ENV_GOBACK_URL);
exit();
