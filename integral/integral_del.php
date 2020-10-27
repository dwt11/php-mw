<?php
/**
 * 删除部门
 *
 * @version        $Id: dep_del.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');

$aid = isset($aid) ? preg_replace("#[^0-9]#", '', $aid) : '';


//单个删除 
if($dopost=='del')
{

	$dsql->ExecuteNoneQuery("delete from  `#@__integral`  where integral_id='$aid';");
	ShowMsg("删除成功！",$ENV_GOBACK_URL);
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
            ShowMsg("参数无效！",$ENV_GOBACK_URL);
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
        ShowMsg("成功删除指定的内容！",$ENV_GOBACK_URL);
        exit();
    }

    else
    {
        $wintitle = "积分管理-打量删除";
        $wecome_info = "<a href='".$ENV_GOBACK_URL."'>积分管理</a>::批量删除";
        $win = new OxWindow();
        $win->Init("integral_del.php","js/blank.js","POST");
        $win->AddHidden("fmdo","yes");
        $win->AddHidden("dopost",$dopost);
        $win->AddHidden("qstr",$qstr);
        $win->AddHidden("aid",$aid);
        $win->AddTitle("你确实要删除“ $qstr 和 $aid ”这些内容？");
        $winform = $win->GetWindow("ok");
        $win->Display();
    }
}
