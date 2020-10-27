<?php
/**
 * @version        $Id: common.inc.php 3 17:44 2010-11-23 tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

// 报错级别设定,一般在开发环境中用E_ALL,这样能够看到所有错误提示
// 系统正常运行后,直接设定为E_ALL || ~E_NOTICE,取消错误显示
//error_reporting(E_ALL );
error_reporting(E_ALL & ~E_NOTICE);//只显示 错误 不显示警告
define('DEDEINC', str_replace("\\", '/', dirname(__FILE__) ) );
if(!defined("DEDEPATH"))define('DEDEPATH', str_replace("\\", '/', substr(DEDEINC,0,-8) ) );   //此句不能删除 在config.php里有定义 ,但login.php不能引起config.PHP所以这里要重新的定义一下140919
define('DEDEDATA', DEDEPATH.'/data');
// ------------------------------------------------------------------------
define('DEBUG_LEVEL', TRUE);//是否启用调试模式
if (version_compare(PHP_VERSION, '5.3.0', '<')) 
{
    set_magic_quotes_runtime(0);
}

//echo (DEDEPATH);

//是否启用mb_substr替换cn_substr来提高效率
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
            $svar = trim(addslashes($svar));////141024 添加,这里过滤所有提交的参数,将参数去除前后空格
        }
    }
		
    return $svar; 
}

if (!defined('DEDEREQUEST')) 
{
    //检查和注册外部提交的变量   (2011.8.10 修改登录时相关过滤)
    function CheckRequest(&$val) {
        if (is_array($val)) {
            foreach ($val as $_k=>$_v) {
            if($_k == 'nvarname') continue;  //140204加
			    CheckRequest($_k); 
                CheckRequest($val[$_k]);
            }
        } else
        {
            //140204注释掉,要搜索CFG开头的系统参数配置
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



//系统相关变量检测
//if(!isset($needFilter))
//{
//    $needFilter = false;//141008  未搜索到使用地方 
//}

//由于register_globals设置控制PHP变量访问范围,如果开启会引起不必要的安全问题,所以这里对其进行了强制关闭.使用的DEDEAMPZ的套件是1打开的141008
//这个变量在原DEDE的 DEDE/INC/inc_list_functions.php里使用 inc_list_functions.php中的功能现已经移到channelunit.helper.php中
//$registerGlobals = @ini_get("register_globals");//141008  未搜索到使用地方 
//$isUrlOpen = @ini_get("allow_url_fopen");//141008多处赋值此变量  但只在customfields11111.func.php中使用了
$isSafeMode = @ini_get("safe_mode"); //141008开启之后，主要会对系统操作、文件、权限设置等方法产生影响.这里得到的是空值
if( preg_match('/windows/i', @getenv('OS')) )
{
    $isSafeMode = false;
}

//Session保存路径
$sessSavePath = DEDEDATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
    session_save_path($sessSavePath);
}

//系统配置参数,这里面有时区设置
require_once(DEDEDATA."/config.cache.inc.php");


//数据库配置文件
require_once(DEDEDATA.'/common.inc.php');

//载入系统验证安全配置
if(file_exists(DEDEDATA.'/safe/inc_safe_config.php'))
{
    require_once(DEDEDATA.'/safe/inc_safe_config.php');
    if(!empty($safe_faqs)) $safefaqs = unserialize($safe_faqs);
}

//Session跨域设置
if(!empty($cfg_domain_cookie))
{
    @session_set_cookie_params(0,'/',$cfg_domain_cookie);
}

//php5.1版本以上时区设置
//由于这个函数对于是php5.1以下版本并无意义，因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
    $time51 = $cfg_cli_time * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}




//系统的一些常用配置信息   调用方法 $GLOBALS['cfg_install_path']


//$cfg_install_path  程序安装目录   在程序配置中保存  data/config.cache.inc.php
//引用方法 $GLOBALS['cfg_install_path'];


//站点根目录   要用120603
$cfg_basedir = preg_replace('#'.$cfg_install_path.'\/include$#i', '', DEDEINC);
//echo ($cfg_basedir );  //程序实际安装路径I:/hc/code

//前台WEB模板的存放目录141015  这个要放入 其他文件中，只有文档管理用
$cfg_web_templets_dir = $cfg_basedir.$cfg_install_path.'/web/templets';







$cfg_version = 'V1.0';
$cfg_soft_lang = 'gb2312';









if(!isset($cfg_NotPrintHead)) {
    header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

//自动加载类库处理
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
				echo $classname.'类找不到';
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

//引入数据库类
require_once(DEDEINC.'/dedesql.class.php');  //本程序主数据库
	


//全局常用函数
require_once(DEDEINC.'/common.func.php');

// 模块MVC框架需要的控制器和模型基类
require_once(DEDEINC.'/control.class.php');
require_once(DEDEINC.'/model.class.php');

//载入小助手配置,并对其进行默认初始化
if(file_exists(DEDEDATA.'/helper.inc.php'))
{
    require_once(DEDEDATA.'/helper.inc.php');
    // 若没有载入配置,则初始化一个默认小助手配置
    if (!isset($cfg_helper_autoload))
    {
        $cfg_helper_autoload = array('util', 'charset', 'string', 'time', 'cookie');
    }
    // 初始化小助手
    helper($cfg_helper_autoload);
}