<?php
/**
 * ɾ������
 *
 * @version        $Id: worktype_del.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');


$id = trim(preg_replace("#[^0-9]#", '', $id));
require_once('worktypeunit.class.php');

$questr="SELECT worktype_topid FROM `dede_emp_worktype` where  worktype_topid =".$id;
$rowarc = $dsql->GetOne($questr);
if(is_array($rowarc))
{
	ShowMsg("ɾ��ʧ��,����ɾ���ӹ��֣�","-1");
	exit(); 
}


$ut = new WorktypeUnit();

if($ut->GetOnlyTotalEmp($id)>0)
{
	ShowMsg("ɾ��ʧ��,���ȴ˹����е�Ա����","-1");
	exit(); 
}

$ut->DelWorktype($id);

ShowMsg("�ɹ�ɾ��һ�����֣�","worktype.php");


exit();
