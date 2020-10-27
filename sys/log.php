<?php
/**
 * 日志列表
 *
 * @version        $Id: log.php 1 8:48 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

require_once(DEDEINC."/datalistcp.class.php");
require_once(DEDEINC."/common.func.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
$sql = $where = "";

if(empty($userName)) $userName = "";
if(empty($logfilename)) $logfilename = "";
if(empty($cip)) $cip = "";
if(empty($dtime)) $dtime = 0;
if($userName!="") $where .= " AND #@__sys_admin.userName like '%$userName%' ";
if($cip!="") $where .= " AND #@__sys_log.cip LIKE '%$cip%' ";
if($logfilename!="") $where .= " AND #@__sys_log.filename LIKE '%$logfilename%' ";

if($dtime>0)
{
    $nowtime = time();
    $starttime = $nowtime - ($dtime*24*3600);
    $where .= " AND #@__sys_log.dtime>'$starttime' ";
}
$sql = "SELECT #@__sys_log.*,#@__sys_admin.userName FROM #@__sys_log
     LEFT JOIN #@__sys_admin ON #@__sys_admin.id=#@__sys_log.adminid
     WHERE 1=1 $where ORDER BY #@__sys_log.lid DESC";

//dump($sql);
$dlist = new DataListCP();
$dlist->pageSize = 20;
//$dlist->SetParameter("adminid",$adminid);
$dlist->SetParameter("userName",$userName);
$dlist->SetParameter("cip",$cip);
$dlist->SetParameter("logfilename",$logfilename);
$dlist->SetParameter("dtime",$dtime);
$dlist->SetTemplate("log.htm");
$dlist->SetSource($sql);
$dlist->Display();




function getFileTitle($fileName="")
{
        $dsql = $GLOBALS['dsql'];
/*		$sysFunInfo = $dsql->getone("select title from #@__sys_function where  urladd like '%$fileName%'");
		//dump($sysFunInfo["title"]);
		if(is_array($sysFunInfo))
		{
			$fileTitle=$sysFunInfo["title"];
			return $fileTitle;
		}
*/		
		  $sysFunInfo = $dsql->getone("select title from #@__sys_function where urladd like '%$fileName%'");
		  if($sysFunInfo=="")
		  {
			  
					require_once("../baseconfig/sys_baseconfg.class.php");
					$fun = new sys_baseconfg();
					$oneBaseConfigs = $fun->getOneBaseConfig($fileName);  //供栏目选择
					if($oneBaseConfigs!="")
					{
						$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
						$sysFunTitle=$oneBaseConfigsArray[2];
					}else
					{
						$sysFunTitle=""; 
					}
		   }else
		   {
			  $sysFunTitle = $sysFunInfo['title'];
		   }
			return $sysFunTitle;
		   
		   

	
}