<?php
/**
 * ��ҳ�����ڼ���û���¼���������Ҫ�ֹ�����ϵͳ���ã������common.inc.php
 *
 * @version        $Id: config.php 1 9:43 2010��7��8��Z tianya $
 * @package        DedeCMS.Dialog
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../common.inc.php");
require_once(dirname(__FILE__)."/../userlogin.class.php");

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl   =  '';
$s_scriptName = '';
//$isUrlOpen = @ini_get('allow_url_fopen');//141008�ദ��ֵ�˱���  ��ֻ��customfields11111.func.php��ʹ����

$dedeNowurl = GetCurUrl();
$dedeNowurls = explode("?",$dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//�����û���¼״̬
$cuserLogin = new userLogin();

 

if($cuserLogin->getUserId() <=0 )
{
    if(empty($adminDirHand))
    {
        ShowMsg("<b>��ʾ���������̨����Ŀ¼���ܵ�¼</b><br /><form>�������̨����Ŀ¼����<input type='hidden' name='gotopage' value='".urlencode($dedeNowurl)."' /><input type='text' name='adminDirHand' value='dede' style='width:120px;' /><input style='width:80px;' type='submit' name='sbt' value='ת���¼' /></form>", "javascript:;");
        exit();
    }
    $gurl = "../../{$adminDirHand}/login.php?gotopage=".urlencode($dedeNowurl);
    echo "<script language='javascript'>location='$gurl';</script>";
    exit();
}

