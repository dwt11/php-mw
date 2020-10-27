<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * δ��ɹ����� �����ڵ�������ҳ��ʾ 
 *
 * @version        $Id: diyform.cls.php 1 10:31 2010��7��6��Z tianya $
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
    var $totalNumb;   //δ��ɼ�¼������
    var $urlsstr;   //������url
    var $urlsjs;    //js�õ�����
    function schedule(){
        $this->__construct();
        $this->totalNumb=0;
        $this->urlsjs="";
        $this->urlsstr="";
		
    }
    /**
     *  ��������
     *
     * @access    public
     * @param     string  $diyid  �Զ����ID
     * @return    string
     */
    function __construct()
	{
		      $this->dsql = $GLOBALS['dsql'];
			  if(file_exists($GLOBALS['cfg_basedir'].'/archives')&&$GLOBALS['cuserLogin']->getUserType()<10)
			  {
				  //��ȡ�ĵ�δ����
				  require_once("archives/catalog.inc.class.php");
				  $cl = new archivesCatalogInc();
				  $arcNoViewdArray=$cl->GetTopNoViewdArchives(10);
				  $arcNoNumb=$arcNoViewdArray["totalNumb"];
				  $this->totalNumb=$arcNoNumb;
			  
					//���δ�����ĵ�
				  if($arcNoNumb>0)
				  {
					  foreach($arcNoViewdArray["url"] as $arcNoUrl)
					  {
						  $this->urlsjs.= "strbody+='".$arcNoUrl."<br>';\r\n";
						  
						  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$arcNoUrl."</td></tr>\r\n";

					  }
					  
				  }
			  }
			  
			  
			  //����ж��������ܺ�Ȩ��,��δ��ɹ��� ���δ��ɵĶ���
			  if(file_exists($GLOBALS['cfg_basedir'].'/sales')&&Test_webRole("sales/sales.php"))
			  {
				  //ʵ��δ�������
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where  sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?status=100\"  target=\"main\">����δ���".$salesrow['dd']."��</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$trueurl."</td></tr>\r\n";
				  }
				  
				/*����
				//��Ʒδ�������
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where sa.salestype = 2 and sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?salestype=2&status=100\"  target=\"main\">��Ʒ����δ���".$salesrow['dd']."��</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$trueurl."</td></tr>\r\n";
				  }
				  
				  
				  //����δ�������
				  $sql=" SELECT count(id) as dd   FROM #@__sales sa  where sa.salestype =1 and sa.status!=10 and sa.status!=-1 ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"sales/sales.php?salestype=1&status=100\"  target=\"main\">��������δ���".$salesrow['dd']."��</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$trueurl."</td></tr>\r\n";
				  }
				  */
	  
			  }
			  
			  
			  
			  
			  //�������Ʒ��־�����Ȩ��,��δ��ɹ��� ���
			  if(file_exists($GLOBALS['cfg_basedir'].'/goods/goodslog.php')&&Test_webRole("goods/goodslog.php"))
			  {
				  //��Ʒ��¼��������
				  
																							//��һ����(�Ƚ�uxixʱ��תΪ��ͨʱ�� �ټ���30����) 
							  /*����  select * from ���� where to_days(ʱ���ֶ���) = to_days(now());
							  ����   SELECT * FROM ���� WHERE TO_DAYS( NOW( ) ) - TO_DAYS( ʱ���ֶ���) <= 1
							  7��  SELECT * FROM ���� where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ʱ���ֶ���)
							  ��30��   SELECT * FROM ���� where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(ʱ���ֶ���)
							  ����  SELECT * FROM ���� WHERE DATE_FORMAT( ʱ���ֶ���, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )
							  ��һ��  SELECT * FROM ���� WHERE PERIOD_DIFF( date_format( now( ) , '%Y%m' ) , date_format( ʱ���ֶ���, '%Y%m' ) ) =1*/
			  
			  
				  $sql=" SELECT  count(id) as dd FROM dede_goods_log   where logflag ='2'  and DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(FROM_UNIXTIME(senddate))";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"goods/goodslog.php?logflag=2\"  target=\"main\">��һ����Ʒ������¼����".$salesrow['dd']."��</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$trueurl."</td></tr>\r\n";
				  }
				  
				  
			  }
			  
			  
			  
			  //����й�����־�����Ȩ��,��δ��ɹ��� ���
			  if(file_exists($GLOBALS['cfg_basedir'].'/other/worklog.php')&&Test_webRole("other/worklog.php"))
			  {
				  //������־��������
				  
																							//��һ����(�Ƚ�uxixʱ��תΪ��ͨʱ�� �ټ���30����) 
							  /*����  select * from ���� where to_days(ʱ���ֶ���) = to_days(now());
							  ����   SELECT * FROM ���� WHERE TO_DAYS( NOW( ) ) - TO_DAYS( ʱ���ֶ���) <= 1
							  7��  SELECT * FROM ���� where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ʱ���ֶ���)
							  ��30��   SELECT * FROM ���� where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(ʱ���ֶ���)
							  ����  SELECT * FROM ���� WHERE DATE_FORMAT( ʱ���ֶ���, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )
							  ��һ��  SELECT * FROM ���� WHERE PERIOD_DIFF( date_format( now( ) , '%Y%m' ) , date_format( ʱ���ֶ���, '%Y%m' ) ) =1*/
			  
			  
				  $sql=" SELECT  count(id) as dd FROM dede_other_worklog   where logflag ='2'  ";
				  $salesrow = $this->dsql->GetOne($sql);
				  if(is_array($salesrow)&&$salesrow['dd']>0)
				  {
					  $this->totalNumb+=$salesrow['dd'];
					  $trueurl="<a href=\"other/worklog.php?logflag=2\"  target=\"main\">������־����".$salesrow['dd']."��</a>";
					  $this->urlsjs.= "strbody+='".$trueurl."<br>';\r\n";
					  $this->urlsstr.="<tr>\r\n<td class='nline'  style='text-align:left'>��".$trueurl."</td></tr>\r\n";
				  }
				  
				  
			  }
			 //dump($this->totalNumb."---");
    }


}//End Class