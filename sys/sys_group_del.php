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

//Ȩ��ֵID�п��ܳ���С��λ,���Բ�������  140820
//$rank = trim(preg_replace("#[^0-9]#", '', $rank));



$questr="SELECT usertype FROM `#@__sys_admin` where  `usertype` = '$rank' ";
$rowarc = $dsql->GetOne($questr);
//dump($questr);
if(is_array($rowarc))
{
	ShowMsg("ɾ��ʧ��,����ɾ�����ڴ�Ȩ����ĵ�¼�û���","-1");
	exit(); 
}

    $sql="DELETE FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='$rank' ;";
    //dump($sql);
    $dsql->ExecuteNoneQuery($sql);
    ShowMsg("�ɹ�ɾ��һ���û���!","sys_group.php");
    exit();
