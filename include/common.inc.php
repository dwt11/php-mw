<?php
/**
 * @version        $Id: common.inc.php 3 17:44 2010-11-23 tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

// �������趨,һ���ڿ�����������E_ALL,�����ܹ��������д�����ʾ
// ϵͳ�������к�,ֱ���趨ΪE_ALL || ~E_NOTICE,ȡ��������ʾ
//error_reporting(E_ALL );
error_reporting(E_ALL & ~E_NOTICE);//ֻ��ʾ ���� ����ʾ����
define('DEDEINC', str_replace("\\", '/', dirname(__FILE__) ) );
if(!defined("DEDEPATH"))define('DEDEPATH', str_replace("\\", '/', substr(DEDEINC,0,-8) ) );   //�˾䲻��ɾ�� ��config.php���ж��� ,��login.php��������config.PHP��������Ҫ���µĶ���һ��140919
define('DEDEDATA', DEDEPATH.'/data');
// ------------------------------------------------------------------------
define('DEBUG_LEVEL', TRUE);//�Ƿ����õ���ģʽ
if (version_compare(PHP_VERSION, '5.3.0', '<')) 
{
    set_magic_quotes_runtime(0);
}

//echo (DEDEPATH);

//�Ƿ�����mb_substr�滻cn_substr�����Ч��
$cfg_is_mb = $cfg_is_iconv = FALSE;
if(function_exists('mb_substr')) $cfg_is_mb = TRUE;
if(function_exists('iconv_substr')) $cfg_is_iconv = TRUE;

function _RunMagicQuotes(&$svar)
{
    if(!get_magic_quotes_gpc())
    {
        if( is_array($svar) )
        {
            foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
        }
        else
        {
            $svar = trim(addslashes($svar));////141024 ���,������������ύ�Ĳ���,������ȥ��ǰ��ո�
        }
    }
		
    return $svar; 
}

if (!defined('DEDEREQUEST')) 
{
    //����ע���ⲿ�ύ�ı���   (2011.8.10 �޸ĵ�¼ʱ��ع���)
    function CheckRequest(&$val) {
        if (is_array($val)) {
            foreach ($val as $_k=>$_v) {
            if($_k == 'nvarname') continue;  //140204��
			    CheckRequest($_k); 
                CheckRequest($val[$_k]);
            }
        } else
        {
            //140204ע�͵�,Ҫ����CFG��ͷ��ϵͳ��������
//			if( strlen($val)>0 && preg_match('#^(cfg_|GLOBALS)#',$val) )
//            {
//                exit('Request var not allow!');
//            }
        }
    }
    CheckRequest($_REQUEST);

    foreach(Array('_GET','_POST','_COOKIE') as $_request)
    {
        foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
    }
}



//ϵͳ��ر������
//if(!isset($needFilter))
//{
//    $needFilter = false;//141008  δ������ʹ�õط� 
//}

//����register_globals���ÿ���PHP�������ʷ�Χ,������������𲻱�Ҫ�İ�ȫ����,����������������ǿ�ƹر�.ʹ�õ�DEDEAMPZ���׼���1�򿪵�141008
//���������ԭDEDE�� DEDE/INC/inc_list_functions.php��ʹ�� inc_list_functions.php�еĹ������Ѿ��Ƶ�channelunit.helper.php��
//$registerGlobals = @ini_get("register_globals");//141008  δ������ʹ�õط� 
//$isUrlOpen = @ini_get("allow_url_fopen");//141008�ദ��ֵ�˱���  ��ֻ��customfields11111.func.php��ʹ����
$isSafeMode = @ini_get("safe_mode"); //141008����֮����Ҫ���ϵͳ�������ļ���Ȩ�����õȷ�������Ӱ��.����õ����ǿ�ֵ
if( preg_match('/windows/i', @getenv('OS')) )
{
    $isSafeMode = false;
}

//Session����·��
$sessSavePath = DEDEDATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
    session_save_path($sessSavePath);
}

//ϵͳ���ò���,��������ʱ������
require_once(DEDEDATA."/config.cache.inc.php");


//���ݿ������ļ�
require_once(DEDEDATA.'/common.inc.php');

//����ϵͳ��֤��ȫ����
if(file_exists(DEDEDATA.'/safe/inc_safe_config.php'))
{
    require_once(DEDEDATA.'/safe/inc_safe_config.php');
    if(!empty($safe_faqs)) $safefaqs = unserialize($safe_faqs);
}

//Session��������
if(!empty($cfg_domain_cookie))
{
    @session_set_cookie_params(0,'/',$cfg_domain_cookie);
}

//php5.1�汾����ʱ������
//�����������������php5.1���°汾�������壬���ʵ���ϵ�ʱ����ã�Ӧ����MyDate��������
if(PHP_VERSION > '5.1')
{
    $time51 = $cfg_cli_time * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}




//ϵͳ��һЩ����������Ϣ   ���÷��� $GLOBALS['cfg_install_path']


//$cfg_install_path  ����װĿ¼   �ڳ��������б���  data/config.cache.inc.php
//���÷��� $GLOBALS['cfg_install_path'];


//վ���Ŀ¼   Ҫ��120603
$cfg_basedir = preg_replace('#'.$cfg_install_path.'\/include$#i', '', DEDEINC);
//echo ($cfg_basedir );  //����ʵ�ʰ�װ·��I:/hc/code

//ǰ̨WEBģ��Ĵ��Ŀ¼141015  ���Ҫ���� �����ļ��У�ֻ���ĵ�������
$cfg_web_templets_dir = $cfg_basedir.$cfg_install_path.'/web/templets';







$cfg_version = 'V1.0';
$cfg_soft_lang = 'gb2312';









if(!isset($cfg_NotPrintHead)) {
    header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

//�Զ�������⴦��
function __autoload($classname)
{
    global $cfg_soft_lang;
    $classname = preg_replace("/[^0-9a-z_]/i", '', $classname);
    if( class_exists ( $classname ) )
    {
        return TRUE;
    }
    $classfile = $classname.'.php';
    $libclassfile = $classname.'.class.php';
        if ( is_file ( DEDEINC.'/'.$libclassfile ) )
        {
            require DEDEINC.'/'.$libclassfile;
        }
        else if( is_file ( DEDEMODEL.'/'.$classfile ) ) 
        {
            require DEDEMODEL.'/'.$classfile;
        }
        else
        {
            if (DEBUG_LEVEL === TRUE)
            {
                echo '<pre>';
				echo $classname.'���Ҳ���';
				echo '</pre>';
				exit ();
            }
            else
            {
                header ( "location:/404.html" );
                die ();
            }
        }
}

//�������ݿ���
require_once(DEDEINC.'/dedesql.class.php');  //�����������ݿ�
	


//ȫ�ֳ��ú���
require_once(DEDEINC.'/common.func.php');

// ģ��MVC�����Ҫ�Ŀ�������ģ�ͻ���
require_once(DEDEINC.'/control.class.php');
require_once(DEDEINC.'/model.class.php');

//����С��������,���������Ĭ�ϳ�ʼ��
if(file_exists(DEDEDATA.'/helper.inc.php'))
{
    require_once(DEDEDATA.'/helper.inc.php');
    // ��û����������,���ʼ��һ��Ĭ��С��������
    if (!isset($cfg_helper_autoload))
    {
        $cfg_helper_autoload = array('util', 'charset', 'string', 'time', 'cookie');
    }
    // ��ʼ��С����
    helper($cfg_helper_autoload);
}