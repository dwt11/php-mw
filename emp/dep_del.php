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
$id = trim(preg_replace("#[^0-9]#", '', $id));
require_once('depunit.class.php');

$questr="SELECT dep_topid FROM `dede_emp_dep` where  dep_topid =".$id;
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("ɾ��ʧ��,����ɾ���Ӳ��ţ�","-1");
	exit(); 
}


$ut = new DepUnit();

if($ut->GetOnlyTotalEmp($id)>0)
{
	ShowMsg("ɾ��ʧ��,���ȴ˲����е�Ա����","-1");
	exit(); 
}

$ut->DelDep($id);
ShowMsg("�ɹ�ɾ��һ�����ţ�","dep.php");
exit();
