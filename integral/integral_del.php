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

$aid = isset($aid) ? preg_replace("#[^0-9]#", '', $aid) : '';


//����ɾ�� 
if($dopost=='del')
{

	$dsql->ExecuteNoneQuery("delete from  `#@__integral`  where integral_id='$aid';");
	ShowMsg("ɾ���ɹ���",$ENV_GOBACK_URL);
	exit();

}
else if($dopost=="delAll")
{
    require_once(DEDEINC."/oxwindow.class.php");
    if(empty($fmdo)) $fmdo = '';

    if($fmdo=='yes')
    {
        if( !empty($aid) && empty($qstr) )
        {
            $qstr = $aid;
        }
        if($qstr=='')
        {
            ShowMsg("������Ч��",$ENV_GOBACK_URL);
            exit();
        }
        $qstrs = explode("`",$qstr);
        $okaids = Array();

        foreach($qstrs as $aid)
        {
            if(!isset($okaids[$aid]))
            {
				$dsql->ExecuteNoneQuery("delete from  `#@__integral`  where integral_id='$aid';");
            }
            else
            {
                $okaids[$aid] = 1;
            }
        }
        ShowMsg("�ɹ�ɾ��ָ�������ݣ�",$ENV_GOBACK_URL);
        exit();
    }

    else
    {
        $wintitle = "���ֹ���-����ɾ��";
        $wecome_info = "<a href='".$ENV_GOBACK_URL."'>���ֹ���</a>::����ɾ��";
        $win = new OxWindow();
        $win->Init("integral_del.php","js/blank.js","POST");
        $win->AddHidden("fmdo","yes");
        $win->AddHidden("dopost",$dopost);
        $win->AddHidden("qstr",$qstr);
        $win->AddHidden("aid",$aid);
        $win->AddTitle("��ȷʵҪɾ���� $qstr �� $aid ����Щ���ݣ�");
        $winform = $win->GetWindow("ok");
        $win->Display();
    }
}
