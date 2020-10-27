<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * ʱ���С����
 *
 * @version        $Id: time.helper.php 1 2010-07-05 11:43:09Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

/**
 *  ���ظ������α�׼ʱ��
 *
 * @param     string  $format  �ַ�����ʽ
 * @param     string  $timest  ʱ���׼
 * @return    string
 */
if ( ! function_exists('MyDate'))
{
    function MyDate($format='Y-m-d H:i:s', $timest=0)
    {
        global $cfg_cli_time;
        $addtime = $cfg_cli_time * 3600;
        if(empty($format))
        {
            $format = 'Y-m-d H:i:s';
        }
        return gmdate ($format, $timest+$addtime);
    }
}


/**
 * ����ͨʱ��ת��ΪLinuxʱ���
 *
 * @param     string   $dtime  ��ͨʱ��
 * @return    string
 */
if ( ! function_exists('GetMkTime'))
{
    function GetMkTime($dtime)
    {
        if(!preg_match("/[^0-9]/", $dtime))
        {
            return $dtime;
        }
        $dtime = trim($dtime);
        $dt = Array(1970, 1, 1, 0, 0, 0);
        $dtime = preg_replace("/[\r\n\t]|��|��/", " ", $dtime);
        $dtime = str_replace("��", "-", $dtime);
        $dtime = str_replace("��", "-", $dtime);
        $dtime = str_replace("ʱ", ":", $dtime);
        $dtime = str_replace("��", ":", $dtime);
        $dtime = trim(preg_replace("/[ ]{1,}/", " ", $dtime));
        $ds = explode(" ", $dtime);
        $ymd = explode("-", $ds[0]);
        if(!isset($ymd[1]))
        {
            $ymd = explode(".", $ds[0]);
        }
        if(isset($ymd[0]))
        {
            $dt[0] = $ymd[0];
        }
        if(isset($ymd[1])) $dt[1] = $ymd[1];
        if(isset($ymd[2])) $dt[2] = $ymd[2];
        if(strlen($dt[0])==2) $dt[0] = '20'.$dt[0];
        if(isset($ds[1]))
        {
            $hms = explode(":", $ds[1]);
            if(isset($hms[0])) $dt[3] = $hms[0];
            if(isset($hms[1])) $dt[4] = $hms[1];
            if(isset($hms[2])) $dt[5] = $hms[2];
        }
        foreach($dt as $k=>$v)
        {
            $v = preg_replace("/^0{1,}/", '', trim($v));
            if($v=='')
            {
                $dt[$k] = 0;
            }
        }
        $mt = mktime($dt[3], $dt[4], $dt[5], $dt[1], $dt[2], $dt[0]);
        if(!empty($mt))
        {
              return $mt;
        }
        else
        {
              return time();
        }
    }
}


/**
 *  ��ȥʱ��
 *
 * @param     int  $ntime  ��ǰʱ��
 * @param     int  $ctime  ���ٵ�ʱ��
 * @return    int
 */
if ( ! function_exists('SubDay'))
{
    function SubDay($ntime, $ctime)
    {
        $dayst = 3600 * 24;
        $cday = ceil(($ntime-$ctime)/$dayst);
        return $cday;
    }
}


/**
 *  �������
 *
 * @param     int  $ntime  ��ǰʱ��
 * @param     int  $aday   �������
 * @return    int
 */
if ( ! function_exists('AddDay'))
{
    function AddDay($ntime, $aday)
    {
        $dayst = 3600 * 24;
        $oktime = $ntime + ($aday * $dayst);
        return $oktime;
    }
}


/**
 *  ���ظ�ʽ��(Y-m-d H:i:s)����ʱ��
 *
 * @param     int    $mktime  ʱ���
 * @return    string
 */
if ( ! function_exists('GetDateTimeMk'))
{
    function GetDateTimeMk($mktime)
    {
        if($mktime=="0"||empty($mktime)) return "";   //141127��  141205ԭ""��Ϊ����,��ΪҪ��ǰһ���������  ������ɾ��
        return MyDate('Y-m-d H:i:s',$mktime);
    }
}

/**
 *  ���ظ�ʽ��(Y-m-d)������
 *
 * @param     int    $mktime  ʱ���
 * @return    string
 */
if ( ! function_exists('GetDateMk'))
{
    function GetDateMk($mktime)
    {
        if($mktime=="0"||empty($mktime)) return "";
		else  return MyDate("Y-m-d", $mktime);
		
    }
}


/**
 *  ���ظ�ʽ��(Y-m-d)������,����ǵ����������
 *
 * @param     int    $mktime  ʱ���
 * @return    string
 */
if ( ! function_exists('GetDateNoYearMk'))
{
    function GetDateNoYearMk($mktime)
    {
        if($mktime=="0"||empty($mktime)) return "";
        //else return MyDate("Y-m-d", $mktime);
		elseif (MyDate("Y", $mktime)==date('Y')) return MyDate("m-d", $mktime);
		else  return MyDate("Y-m-d", $mktime);
		
    }
}



/**
 *  ��ʱ��ת��Ϊ�������ڵľ�ȷʱ��
 *
 * @param     int   $seconds  ����
 * @return    string
 */
if ( ! function_exists('FloorTime'))
{
    function FloorTime($seconds)
    {
        $times = '';
        $days = floor(($seconds/86400)%30);
        $hours = floor(($seconds/3600)%24);
        $minutes = floor(($seconds/60)%60);
        $seconds = floor($seconds%60);
        if($seconds >= 1) $times .= $seconds.'��';
        if($minutes >= 1) $times = $minutes.'���� '.$times;
        if($hours >= 1) $times = $hours.'Сʱ '.$times;
        if($days >= 1)  $times = $days.'��';
        if($days > 30) return false;
        $times .= 'ǰ';
        return str_replace(" ", '', $times);
    }
}



/**
 *  ��ȡָ�����ڵ�ǰһ��,���һ�������
 *
 * @param     datetime   $senddate  ���ڸ�ʽ   ָ��������
 * @param     str   $datefromname  ������
 * @param     int   $daynumb  Ҫ�Ӽ�������
 * @return    string
 */
if ( ! function_exists('getDateUrl'))
{
    function getDateUrl($senddate,$datefromname,$daynumb)
    {
		
		$retuUrl="";
		if($senddate=="")$senddate=date("Y-m-d", time());
		$nowUrl=GetCurUrl();
		$url_arr=explode("?",$nowUrl);
		//dump(AddDay(GetMkTime($senddate),$daynumb));
		
		$newdate=GetDateMk(AddDay(GetMkTime($senddate),$daynumb));
		
		$newParameter=$datefromname."=".$newdate;
		
		
		if(count($url_arr)>1)  //������Ӱ�������
		{
			$retuUrl=preg_replace("#".$datefromname."=[0-9\-]*#", $newParameter,$nowUrl);  //�򽫲����滻Ϊ�µ�����
		//dump($retuUrl);
		
		}else
		{//����������,ֱ�Ӹ���
			$retuUrl=$nowUrl."?".$newParameter;
		}
		
		
		
        return $retuUrl;
    }
}


/**
 *  ��ȡָ�����ڵ���һ��,����һ�������  ���ص����� ���������ڼ�  startdate:2014-1-1 ;enddate=2014-12-31
 *  ���ô˺��� ��ҳ��  ������ ������startdate enddate=2014-12-31
 * @param     datetime   $startdate  ���ڸ�ʽ   ָ��������
 * @param     int   $numb  Ҫ�Ӽ�������
 * @return    string
 */
if ( ! function_exists('getYearUrl'))
{
    function getYearUrl($startdate,$numb)
    {
		//dump(date("Y",GetMkTime($startdate)));
		$retuUrl="";
		//if($startdate=="")$startdate=date("Y", time());
		$nowUrl=GetCurUrl();
		$url_arr=explode("?",$nowUrl);
		//dump(AddDay(GetMkTime($senddate),$daynumb));
		
		$nowYear=date("Y",GetMkTime($startdate))+$numb;
		$newstartdate=$nowYear."-01-01";
		$newenddate=$nowYear."-12-31";
		
		$newstartParameter="startdate=".$newstartdate;
		$newendParameter="enddate=".$newenddate;
		
		
		if(count($url_arr)>1)  //������Ӱ�������
		{
		//dump($nowUrl);
			$retuUrl=preg_replace("#startdate=[0-9\-]*#", $newstartParameter,$nowUrl);  //�򽫲����滻Ϊ�µ�����
			$retuUrl=preg_replace("#enddate=[0-9\-]*#", $newendParameter,$retuUrl);  //�򽫲����滻Ϊ�µ�����
		
		}else
		{//����������,ֱ�Ӹ���
			$retuUrl=$nowUrl."?".$newstartParameter."&".$newendParameter;
		}
		
		
		
        return $retuUrl;
    }
}




/**
 *  ��ȡָ�����ڵ���һ��,����һ�µ�����  ���ص����� ���������ڼ�  startdate:2014-1-1 ;enddate=2014-12-31
 *  ���ô˺��� ��ҳ��  ������ ������startdate enddate=2014-12-31
 * @param     datetime   $startdate  ���ڸ�ʽ   ָ��������
 * @param     int   $numb  Ҫ�Ӽ�������
 * @return    string
 */
if ( ! function_exists('getMonthUrl'))
{
    function getMonthUrl($startdate,$numb)
    {
		$retuUrl="";
		$nowUrl=GetCurUrl();
		$url_arr=explode("?",$nowUrl);
		
		
		
		
		date_default_timezone_set('Asia/Shanghai');
		$first_day_of_month = date('Y-m',strtotime($startdate)) . '-01 00:00:01';
		$t = strtotime($first_day_of_month);

					//date('Y��m��',strtotime('- 2 month',$t)), ԭ����
		$nowmonth=date('Y-m',strtotime($numb.' month',$t));
		$nowmonthmaxday=date('t', strtotime($nowmonth));//�����µ��������
		$newstartdate=$nowmonth."-01";
		$newenddate=$nowmonth."-".$nowmonthmaxday;
		
		$newstartParameter="startdate=".$newstartdate;
		$newendParameter="enddate=".$newenddate;
		
		
		if(count($url_arr)>1)  //������Ӱ�������
		{
		//dump($nowUrl);
			$retuUrl=preg_replace("#startdate=[0-9\-]*#", $newstartParameter,$nowUrl);  //�򽫲����滻Ϊ�µ�����
			$retuUrl=preg_replace("#enddate=[0-9\-]*#", $newendParameter,$retuUrl);  //�򽫲����滻Ϊ�µ�����
		
		}else
		{//����������,ֱ�Ӹ���
			$retuUrl=$nowUrl."?".$newstartParameter."&".$newendParameter;
		}
		
		
		
        return $retuUrl;
    }
}





/**141218
 *  ��ȡָ�����ڵ� ��󼸸���
 �ܼ�������� �´�������
 * @param     datetime   $startdate  ���ڸ�ʽ   ָ��������
 * @param     int   $numb  Ҫ�Ӽ�������
 * @return    string
 */
if ( ! function_exists('getMonth'))
{
    function getMonth($startdate,$numb)
    {
		$retuDate="";
		
		date_default_timezone_set('Asia/Shanghai');
		$first_day_of_month = date('Y-m',strtotime($startdate)) . '-01 00:00:01';
		$t = strtotime($first_day_of_month);
		//date('Y��m��',strtotime('- 2 month',$t)), ԭ����
		$nowmonth=date('Y-m',strtotime($numb.' month',$t));
                //  dump($numb);
		$day=date('d', strtotime($startdate));//��
		$retuDate=$nowmonth."-".$day;
		
		
		
		
        return $retuDate;
    }
}


/**150528
 *  ��ȡָ�����ڵ� �������
  * @param     datetime   $startdate  ���ڸ�ʽ   ָ��������
 * @param     int   $numb  Ҫ�Ӽ�������
 * @return    string
 */
if ( ! function_exists('getMonthLastDay'))
{
	//��ȡÿ���������
	function getMonthLastDay($date) {
		   $month=date("m", strtotime($date."-1"));
		   $year=date("Y", strtotime($date."-1"));
	   
		
		switch ($month) {
			case 4 :
			case 6 :
			case 9 :
			case 11 :
				$days = 30;
				break;
			case 2 :
				if ($year % 4 == 0) {
					if ($year % 100 == 0) {
						$days = $year % 400 == 0 ? 29 : 28;
					} else {
						$days = 29;
					}
				} else {
					$days = 28;
				}
				break;
	 
			default :
				$days = 31;
				break;
		}
		return $days;
	}
}







