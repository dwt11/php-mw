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

$id = preg_replace("#[^0-9]#", '', $id);
$dopost = isset($dopost) ? $dopost : "";   

    if(empty($userok)) $userok="";
    if($userok!="yes")
    {
        $randcode = mt_rand(10000, 99999);
        $safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
        require_once(DEDEINC."/oxwindow.class.php");
        $wintitle = "ɾ���û�";
        $wecome_info = "<a href='sys_user.php'>ϵͳ�ʺŹ���</a>::ɾ���û�";
        $win = new OxWindow();
        $win->Init("sys_user_del.php","js/blank.js","POST");
        $win->AddHidden("dopost", $dopost);
        $win->AddHidden("userok", "yes");
        $win->AddHidden("randcode", $randcode);
        $win->AddHidden("safecode", $safecode);
        $win->AddHidden("id", $id);
        $win->AddTitle("ϵͳ���棡");
        $win->AddMsgItem("��ȷ��Ҫɾ���û���$userName ��","50");
        $win->AddMsgItem("��ȫ��֤����<input name='safecode' type='text' id='safecode' size='16' style='width:200px' />&nbsp;(���Ʊ����룺 <font color='red'>$safecode</font>)","30");
        $winform = $win->GetWindow("ok");
        $win->Display();
        exit();
    }
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode),0,24);
    if($safecodeok!=$safecode)
    {
        ShowMsg("����д��ȷ�İ�ȫ��֤����", "sys_user.php");
        exit();
    }

    //����ɾ��idΪ1�Ĵ������ʺţ�����ɾ���Լ�
    $rs = $dsql->ExecuteNoneQuery2("DELETE FROM `#@__sys_admin` WHERE id='$id' AND id<>1 AND id<>'".$cuserLogin->getUserId()."' ");
    if($rs>0)
    {
        ShowMsg("�ɹ�ɾ��һ���ʻ���",$ENV_GOBACK_URL);
    }
    else
    {
        ShowMsg("����ɾ��idΪ1�Ĵ������ʺţ�����ɾ���Լ���","sys_user.php",0,3000);
    }
    exit();
