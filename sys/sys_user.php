<?php
/**
 * �û�����
 *
 * @version        $Id: sys_user.php 1 16:22 2010��7��20��Z tianya $
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
  
	  $whereSql  = " where admin.userName like '%$keyword%'"; //���
	  //$whereSql  .= " or emp_realname LIKE '%$keyword%')";  //����
	 // $wheresql  .= " or crm.aid  LIKE '%$keyword%'";  //CRM�����������
	 // $wheresql  .= " or emp_sfz  LIKE '%$keyword%'";  //���
	//  $wheresql  .= " or emp_phone  LIKE '%$keyword%' ";    //���ϱ��
      
	 
}
$orderby = empty($orderby) ? 'id' : preg_replace("#[^a-z0-9]#", "", $orderby);
$orderbyField = 'admin.'.$orderby;

//$query = "SELECT admin.*,emp.emp_realname empname FROM #@__sys_admin admin left join #@__emp emp on emp.emp_id=admin.empid $whereSql
          //ORDER BY $orderbyField DESC";
		  //��������HTMҳ���ȡ����empname
$query = "SELECT admin.* FROM #@__sys_admin admin  $whereSql
          ORDER BY $orderbyField DESC";


//dump($query);
$dlist = new DataListCP();
$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("orderby",$orderby);      //�ؼ���


$dlist->SetTemplet("sys_user.htm");
$dlist->SetSource($query);
$dlist->Display();


