<?php
/**
 * ���ֲ���
 *
 * @version        $Id: worktype.do.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');
if(empty($dopost))
{
    ShowMsg("�Բ�����ָ�����ֲ�����","worktype.php");
    exit();
}
$cid = empty($cid) ? 0 : intval($cid);


/*--------------------------
//�鿴 ������Ա��
---------------------------*/
 if($dopost=="listEmp")
{
}

/*-----------
������������-----�˵�����  ������
function GetSunListsMenu();
-----------
else if($dopost=="GetSunListsMenu")
{
    $userChannel = $cuserLogin->getUserChannel();
    require_once("worktypeunit.class.php");
    AjaxHead();
    PutCookie('lastCidMenu',$cid,3600*24,"/");
    $tu = new WorktypeUnit($userChannel);
    $tu->LogicListAllSunWorktype($cid,"��");
}*/
/*-----------
������������
function GetSunLists();
-----------*/
else if($dopost=="GetSunLists")
{
    require_once("worktypeunit.class.php");
    AjaxHead();
    PutCookie('lastCid', $cid, 3600*24, "/");
    $tu = new WorktypeUnit();
    $tu->dsql = $dsql;
    echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $tu->LogicListAllSunWorktype($cid, "��");
    echo "    </table>\r\n";
    $tu->Close();
}
