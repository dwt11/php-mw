<?php
/**
 * 管理目录配置文件
 *
 * @version        $Id: config.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
define('DEDEPATH', str_replace("\\", '/', dirname(__FILE__) ) );//定义系统的目录为当前目录 
require_once(DEDEPATH.'/include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/role.func.php');

header('Cache-Control:private');
$dsql->safeCheck = FALSE;
$dsql->SetLongLink();

//获得当前脚本名称，如果你的系统被禁用了$_SERVER变量，请自行更改这个选项
$dedeNowurl = $s_scriptName = '';
//$isUrlOpen = @ini_get('allow_url_fopen');//141008多处赋值此变量  但只在customfields11111.func.php中使用了
$dedeNowurl = GetCurUrl();

$dedeNowurls = explode('?', $dedeNowurl);


//提示框150128加
if($dedeNowurl!="/main.php"&&$dedeNowurl!="/index_menu.php"&&$dedeNowurl!="/index_body.php"){
//此段不需要使用缓存,用户注册后,这段就很少运行了
//

		$obj = new COM("PHPdll.dwt11");//调用VB写的DLL，PHPdll是工程名，test是类名
		$output=$obj->getCode(); // Call the "sum()" 方法  150305优化
		//echo $output;
		$reg_code=$obj->getRegCode($output); // 获得注册码
		
		global $dsql;
		//获取数据库中的注册码
		$sql="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='1001'";
		$dsql->SetQuery($sql);
		$dsql->Execute();
        $row = $dsql->GetObject();
        if($reg_code!=$row->value)
        {//如果未注册
			 
			  //获取系统开始运行时间
			  $sql1="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='2001'";
			  $dsql->SetQuery($sql1);
			  $dsql->Execute(1);
			  $row1 = $dsql->GetObject(1);
			  $startdate_sys=$row1->value;//150304修改变量名称,不然的话,和系统中冲突 
			 
			  //获取系统运行次数
			  $sql2="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='2000'";
			  $dsql->SetQuery($sql2);
			  $dsql->Execute(2);
			  $row2 = $dsql->GetObject(2);
			  $runnumb=$row2->value;
			 
              $daynumb=(time()-$startdate_sys)/86400;
			  
			  //如果运行天数大于30天,或运行(登录)次数超过300次 则提示用户未注册
			  if($daynumb>30||$runnumb>300)echo PutStr();

			  
			  //dump($daynumb."  ".$runnumb);
        }


}




$s_scriptName = $dedeNowurls[0];  ////    默认只取不带参数的地址 用于权限判断   

//如果地址中带有参数 并且参数中有cid 则判断地址改为带有CID的,用于文档\简单记录\设备这引起带有分类功能的地方 权限判断
//150111优化,原使用功能的名称判断,修改为直接用CID判断, 
if(count($dedeNowurls)>1&&strpos( $dedeNowurls[1] , "cid" ) !== false)
{
		$s_scriptName = $dedeNowurl;
		$s_scriptNames = explode('&', $s_scriptName);   //去除掉 & 后的参数
		$s_scriptName = $s_scriptNames[0];  ////      
}
//$s_scriptName = $dedeNowurl;

//$cfg_remote_site = empty($cfg_remote_site)? 'N' : $cfg_remote_site;
//echo $s_scriptName;
//检验用户登录状态
$cuserLogin = new userLogin();
//dump($cuserLogin->getUserId());
if($cuserLogin->getUserId()==-1)
{
	//ShowMsg("用户登录信息失效,请重新登录!",""); 此名不能用  被 header忽略了
    
	
	//如果直接打开网站主页 不提示用户 输入用户名和密码
	//如果是打开的其他网页 则要提示用户 输入 用户名和密码登录 
	if($dedeNowurl=="/"||$dedeNowurl=="/main.php")
	{
		$jumpurl="$cfg_install_path/login.php?gotopage=".urlencode($dedeNowurl);
	}else
	{
		$jumpurl="$cfg_install_path/login.php?msg=nologin&gotopage=".urlencode($dedeNowurl);
		}
	header("location:$jumpurl");
    exit();
}



//操作权限判断
//获取当前打开页面的地址,如果是子目录下的,则判断是否具有操作权限
$s_scriptNames = explode('/', $s_scriptName);
if(count($s_scriptNames)>2)
{
	  $filename = $s_scriptNames[2];//当前操作的文件名
	  $funDirName = $s_scriptNames[1];//当前操作的文件名
	  
	  global $funAllName;
	  $funAllName=$funDirName."/".$filename;
	   // dump($s_scriptNames);//sys/sys_data.done.php   //140927如果页面是数据库还原的页面  则不检查权限  因为检查权限是从数据库读取的，当还原数据库时会清空数据库  引起没有权限
	  // dump($funAllName);
	   //??这里要加上 如果是管理员了，才不检查 否则检查
	  if($filename!=""&&$filename!="sys_data.done.php")Check_webRole($funAllName);



	  //从数据库获取当前打开网页的标题
	  
	  //屏蔽 XXX.do.php xxx.class.php的页面
	  //dump($funAllName);
	  $doClassFiles = explode('.', $funAllName);
	  if(count($doClassFiles)<3)
	  {
		  $sysFunInfo = $dsql->getone("select title from #@__sys_function where urladd='$funAllName'");
		  if($sysFunInfo=="")
		  {
			  
					$filenameArray=explode('/',$funAllName);
					$filename=$filenameArray[1];
					require_once("baseconfig/sys_baseconfg.class.php");
					$fun = new sys_baseconfg();
					$oneBaseConfigs = $fun->getOneBaseConfig($filename);  //供栏目选择
					if($oneBaseConfigs!="")
					{
						$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
						$sysFunTitle=$oneBaseConfigsArray[2];
					}else
					{
						$sysFunTitle="跳转页面或未设置标题"; 
					}
		   }else
		   {
			  $sysFunTitle = $sysFunInfo['title'];
		   }
	  }
}




//记录系统操作日志
if($cfg_dede_log=='Y')
{
    //$s_nologfile = '_main|_list';
    $s_needlogfile = 'sys_|file_';
    $s_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    $s_query = isset($dedeNowurls[1]) ? $dedeNowurls[1] : '';
    $s_scriptNames = explode('/', $s_scriptName);
    $s_scriptNames = $s_scriptNames[count($s_scriptNames)-1];
    $s_userip = GetIP();
    //if( $s_method=='POST' || (!preg_match("#".$s_nologfile."#i", $s_scriptNames) && $s_query!='') || preg_match("#".$s_needlogfile."#i",$s_scriptNames) )
    //{
    
	    $inquery = "INSERT INTO `#@__sys_log`(adminid,filename,method,query,cip,dtime)
             VALUES ('".$cuserLogin->getUserId()."','{$s_scriptNames}','{$s_method}','".addslashes($s_query)."','{$s_userip}','".time()."');";
	//dump($inquery);
       
	    $dsql->ExecuteNoneQuery($inquery);
   // }
}


















function PutStr()
{
	
	  $bootomRand=dotrand(0,545);
	  $str="<style type='text/css'>
	  * {
		  margin: 0;
		  padding: 0;
		  list-style-type: none;
	  }
	  a, img {
		  border: 0;
	  }
	  #mintbar {
		  filter: alpha(opacity=90);
		  -moz-opacity:0.9;  
		  -khtml-opacity: 0.3;  
		  opacity: 0.9;  
		  position: absolute;
		  z-index: 2147483647;
		  background: url('../images/top_bg.jpg') repeat-x 0px 3px;
		  font-size: 14px;
		  font-family: Arial, Helvetica, Sans-serif;
		  color: #FFF;
		  padding: 0;
		  bottom: ".$bootomRand."px;/*这里要0-545随机位置*/
		  width: 100%;
		  text-align: center;
		  height: 40px;
	  }
	  #mintbar div {
		  position: relative;
		  margin: 0 auto;
		  padding-top: 10px;
		  
		  height: 30px;
	  }
	  #mintbar div h2 {
		  font-size: 16px;
		  color:ffffff
	  }
	  </style>
	  <div id='mintbar'>
		<div>
		  <h2 align='center'><img src='../images/tips.gif'> 注册后此提示框将不显示,请联系电话    获取注册码 </h2>
		</div>
	  </div>";
		  
		  
	  return $str;	
}









// 清空缓存tplcache目录
function ClearCache()
{
    $tplCache = DEDEDATA.'/tplcache/';
    $fileArray = glob($tplCache."*.*");
    if (count($fileArray) > 1)
    {
        foreach ($fileArray as $key => $value)
        {
           // dump($value);
			if (file_exists($value)) unlink($value);
            else continue;
        }
        return TRUE;
    }
    return FALSE;
}


/**
 *  引入模板文件  这个很少用了,一般原DEDE是EDIT ADD页面用 ,现在改为直接在PHP页面引用 140821
 *
 * @access    public
 * @param     string  $filename  文件名称
 * @param     bool  $isabs  是否为管理目录
 * @return    string
*/ 
function DedeInclude($filename, $isabs=FALSE)
{
    return $isabs ? $filename : DEDEPATH.'/'.$filename;
}

helper('cache');
