<?php
/**
 * �༭��־
 *
 * @version        $Id: log_edit.php 1 8:48 2010��7��13��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost))
{
    ShowMsg("��ûָ���κβ�����","javascript:;");
    exit();
}

//���������־
if($dopost=="clear")
{
    $dsql->ExecuteNoneQuery("DELETE FROM #@__sys_log");
    ShowMsg("�ɹ����������־��","log.php");
    exit();
}
else if($dopost=="del")
{
    $bkurl = isset($_COOKIE['ENV_GOBACK_URL']) ? $_COOKIE['ENV_GOBACK_URL'] : "log.php";
    $ids = explode('`',$ids);
    $dquery = "";
    foreach($ids as $id)
    {
        if($dquery=="")
        {
            $dquery .= " lid='$id' ";
        }
        else
        {
            $dquery .= " Or lid='$id' ";
        }
    }
    if($dquery!="") $dquery = " where ".$dquery;
    
	$sql="DELETE FROM #@__sys_log".$dquery;   //141130�޸�BUG  
	//dump($sql);
	$dsql->ExecuteNoneQuery($sql);
    ShowMsg("�ɹ�ɾ��ָ������־��",$bkurl);
    exit();
}
else
{
    ShowMsg("�޷�ʶ���������","javascript:;");
    exit();
}