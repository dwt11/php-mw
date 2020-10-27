<?php
/**
 * 用户管理
 *
 * @version        $Id: sys_user.php 1 16:22 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$keyword = isset($keyword) ? $keyword : "";   
$whereSql="";
if($keyword!="")
{
  
	  $whereSql  = " where admin.userName like '%$keyword%'"; //编号
	  //$whereSql  .= " or emp_realname LIKE '%$keyword%')";  //姓名
	 // $wheresql  .= " or crm.aid  LIKE '%$keyword%'";  //CRM的自增长编号
	 // $wheresql  .= " or emp_sfz  LIKE '%$keyword%'";  //编号
	//  $wheresql  .= " or emp_phone  LIKE '%$keyword%' ";    //资料编号
      
	 
}
$orderby = empty($orderby) ? 'id' : preg_replace("#[^a-z0-9]#", "", $orderby);
$orderbyField = 'admin.'.$orderby;

//$query = "SELECT admin.*,emp.emp_realname empname FROM #@__sys_admin admin left join #@__emp emp on emp.emp_id=admin.empid $whereSql
          //ORDER BY $orderbyField DESC";
		  //左连接在HTM页面获取不到empname
$query = "SELECT admin.* FROM #@__sys_admin admin  $whereSql
          ORDER BY $orderbyField DESC";


//dump($query);
$dlist = new DataListCP();
$dlist->SetParameter("keyword",$keyword);      //关键词
$dlist->SetParameter("orderby",$orderby);      //关键词


$dlist->SetTemplet("sys_user.htm");
$dlist->SetSource($query);
$dlist->Display();


