<?php
/**
 * ���Ų���
 *
 * @version        $Id: dep.do.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');
if(empty($dopost))
{
    ShowMsg("�Բ�����ָ�����Ų�����","dep.php");
    exit();
}
$cid = empty($cid) ? 0 : intval($cid);


/*--------------------------
//�鿴 ���Ű�����Ա��
function listEmp();
---------------------------*/
 if($dopost=="listEmp")
{
    if(empty($gurl)) $gurl = 'emp.php';
    header("location:{$gurl}?emp_dep={$did}");
    exit();
}

/*-----------
������������-----�˵�����  ������
function GetSunListsMenu();
-----------
else if($dopost=="GetSunListsMenu")
{
    $userChannel = $cuserLogin->getUserChannel();
    require_once("depunit.class.php");
    AjaxHead();
    PutCookie('lastCidMenu',$cid,3600*24,"/");
    $tu = new depUnit($userChannel);
    $tu->LogicListAllSunType($cid,"��");
}*/
/*-----------
������������
function GetSunLists();
-----------*/
else if($dopost=="GetSunLists")
{
    require_once("depunit.class.php");
    AjaxHead();
    PutCookie('lastCid', $cid, 3600*24, "/");
    $tu = new depUnit();
    $tu->dsql = $dsql;
    echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $tu->LogicListAllSunDep($cid, "��");
    echo "    </table>\r\n";
    $tu->Close();
}
