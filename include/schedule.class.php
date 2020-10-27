<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 未完成工作类 用于在弹窗和首页显示 
 *
 * @version        $Id: diyform.cls.php 1 10:31 2010年7月6日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * diyform
 *
 * @package          diyform
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class schedule
{
    var $dsql;
    var $totalNumb;   //未完成记录的总数
    var $urlsstr;   //正常的url
    var $urlsjs;    //js用的连接
    function schedule(){
        $this->__construct();
        $this->totalNumb=0;
        $this->urlsjs="";
        $this->urlsstr="";
		
    }
    /**
     *  析构函数
     *
     * @access    public
     * @param     string  $diyid  自定义表单ID
     * @return    string
     */
    function __construct()
	{
		      $this->dsql = $GLOBALS['dsql'];
			  if(file_exists($GLOBALS['cfg_basedir'].'/archives')&&$GLOBALS['cuserLogin']->getUserType()<10)
			  {
				  //获取文档未读数
				  require_once("archives/catalog.inc.class.php");
				  $cl = new archivesCatalogInc();
				  $arcNoViewdArray=$cl->GetTopNoViewdArchives(10);
				  $arcNoNumb=$arcNoViewdArray["totalNumb"];
				  $this->totalNumb=$arcNoNumb;
			  
					//输出未读的文档
				  if($arcNoNumb>0)
				  {
					  foreach($arcNoViewdArray["url"] as $arcNoUrl)
					  {
						  $this->urlsjs.= "strbody+='".$arcNoUrl."<br>';\r\n";
						  
						  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$arcNoUrl."</td></tr>\r\n";

					  }
					  
				  }
			  }
			  
			  
			  //如果有订单管理功能和权限,则未完成工作 输出未完成的订单
			  if(file_exists($GLOBALS['cfg_basedir'].'/sales')&&Test_webRole("sales/sales.php"))
			  {
				  //实物未完成总数
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where  sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?status=100\"  target=\"main\">订单未完成".$salesrow['dd']."条</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$trueurl."</td></tr>\r\n";
				  }
				  
				/*虚拟
				//成品未完成总数
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where sa.salestype = 2 and sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?salestype=2&status=100\"  target=\"main\">成品订单未完成".$salesrow['dd']."条</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$trueurl."</td></tr>\r\n";
				  }
				  
				  
				  //订做未完成总数
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where sa.salestype =1 and sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?salestype=1&status=100\"  target=\"main\">订做订单未完成".$salesrow['dd']."条</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$trueurl."</td></tr>\r\n";
				  }
				  */
	  
			  }
			  
			  
			  
			  
			  //如果有商品日志管理的权限,则未完成工作 输出
			  if(file_exists($GLOBALS['cfg_basedir'].'/goods/goodslog.php')&&Test_webRole("goods/goodslog.php"))
			  {
				  //商品记录待办总数
				  
																							//近一月内(先将uxix时间转为普通时间 再计算30日内) 
							  /*今天  select * from 表名 where to_days(时间字段名) = to_days(now());
							  昨天   SELECT * FROM 表名 WHERE TO_DAYS( NOW( ) ) - TO_DAYS( 时间字段名) <= 1
							  7天  SELECT * FROM 表名 where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(时间字段名)
							  近30天   SELECT * FROM 表名 where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(时间字段名)
							  本月  SELECT * FROM 表名 WHERE DATE_FORMAT( 时间字段名, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )
							  上一月  SELECT * FROM 表名 WHERE PERIOD_DIFF( date_format( now( ) , '%Y%m' ) , date_format( 时间字段名, '%Y%m' ) ) =1*/
			  
			  
				  $sql=" SELECT  count(id) as dd FROM dede_goods_log   where logflag ='2'  and DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(FROM_UNIXTIME(senddate))";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"goods/goodslog.php?logflag=2\"  target=\"main\">近一月商品操作记录待办".$salesrow['dd']."条</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$trueurl."</td></tr>\r\n";
				  }
				  
				  
			  }
			  
			  
			  
			  //如果有工作日志管理的权限,则未完成工作 输出
			  if(file_exists($GLOBALS['cfg_basedir'].'/other/worklog.php')&&Test_webRole("other/worklog.php"))
			  {
				  //工作日志待办总数
				  
																							//近一月内(先将uxix时间转为普通时间 再计算30日内) 
							  /*今天  select * from 表名 where to_days(时间字段名) = to_days(now());
							  昨天   SELECT * FROM 表名 WHERE TO_DAYS( NOW( ) ) - TO_DAYS( 时间字段名) <= 1
							  7天  SELECT * FROM 表名 where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(时间字段名)
							  近30天   SELECT * FROM 表名 where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(时间字段名)
							  本月  SELECT * FROM 表名 WHERE DATE_FORMAT( 时间字段名, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )
							  上一月  SELECT * FROM 表名 WHERE PERIOD_DIFF( date_format( now( ) , '%Y%m' ) , date_format( 时间字段名, '%Y%m' ) ) =1*/
			  
			  
				  $sql=" SELECT  count(id) as dd FROM dede_other_worklog   where logflag ='2'  ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"other/worklog.php?logflag=2\"  target=\"main\">工作日志待办".$salesrow['dd']."条</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>·".$trueurl."</td></tr>\r\n";
				  }
				  
				  
			  }
			 //dump($this->totalNumb."---");
    }


}//End Class