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

$questr="SELECT integral_id FROM `#@__integral` where  integral_gzid='$aid' ";
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("ɾ��ʧ��,����ɾ�����ڴ˹���Ļ��ּ�¼��","-1");
	exit(); 
}


	if(!$dsql->ExecuteNoneQuery("delete from `#@__integral_guizhe` where gz_id='$aid';"))
	{
        ShowMsg("ɾ������ʱ��������ԭ��", "-1");
        exit();
		
	}else
	{
	
		ShowMsg("ɾ���ɹ���","integral_guizhe.php");
		exit();
	}

