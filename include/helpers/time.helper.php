<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 时间戳小助手
 *
 * @version        $Id: time.helper.php 1 2010-07-05 11:43:09Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

/**
 *  返回格林威治标准时间
 *
 * @param     string  $format  字符串格式
 * @param     string  $timest  时间基准
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
 * 从普通时间转换为Linux时间截
 *
 * @param     string   $dtime  普通时间
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
        $dtime = preg_replace("/[\r\n\t]|日|秒/", " ", $dtime);
        $dtime = str_replace("年", "-", $dtime);
        $dtime = str_replace("月", "-", $dtime);
        $dtime = str_replace("时", ":", $dtime);
        $dtime = str_replace("分", ":", $dtime);
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
 *  减去时间
 *
 * @param     int  $ntime  当前时间
 * @param     int  $ctime  减少的时间
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
 *  添加天数
 *
 * @param     int  $ntime  当前时间
 * @param     int  $aday   添加天数
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
 *  返回格式化(Y-m-d H:i:s)的是时间
 *
 * @param     int    $mktime  时间戳
 * @return    string
 */
if ( ! function_exists('GetDateTimeMk'))
{
    function GetDateTimeMk($mktime)
    {
        if($mktime=="0"||empty($mktime)) return "";   //141127加  141205原""内为暂无,因为要做前一天连接输出  将暂无删除
        return MyDate('Y-m-d H:i:s',$mktime);
    }
}

/**
 *  返回格式化(Y-m-d)的日期
 *
 * @param     int    $mktime  时间戳
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
 *  返回格式化(Y-m-d)的日期,如果是当年的则无年
 *
 * @param     int    $mktime  时间戳
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
 *  将时间转换为距离现在的精确时间
 *
 * @param     int   $seconds  秒数
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
        if($seconds >= 1) $times .= $seconds.'秒';
        if($minutes >= 1) $times = $minutes.'分钟 '.$times;
        if($hours >= 1) $times = $hours.'小时 '.$times;
        if($days >= 1)  $times = $days.'天';
        if($days > 30) return false;
        $times .= '前';
        return str_replace(" ", '', $times);
    }
}



/**
 *  获取指定日期的前一天,或后一天的连接
 *
 * @param     datetime   $senddate  日期格式   指定的日期
 * @param     str   $datefromname  表单名称
 * @param     int   $daynumb  要加减的天数
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
		
		
		if(count($url_arr)>1)  //如果连接包含参数
		{
			$retuUrl=preg_replace("#".$datefromname."=[0-9\-]*#", $newParameter,$nowUrl);  //则将参数替换为新的内容
		//dump($retuUrl);
		
		}else
		{//不包含参数,直接附加
			$retuUrl=$nowUrl."?".$newParameter;
		}
		
		
		
        return $retuUrl;
    }
}


/**
 *  获取指定日期的上一年,或下一年的连接  返回的连接 包含日期期间  startdate:2014-1-1 ;enddate=2014-12-31
 *  引用此函数 的页面  表单名称 必须是startdate enddate=2014-12-31
 * @param     datetime   $startdate  日期格式   指定的日期
 * @param     int   $numb  要加减的年数
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
		
		
		if(count($url_arr)>1)  //如果连接包含参数
		{
		//dump($nowUrl);
			$retuUrl=preg_replace("#startdate=[0-9\-]*#", $newstartParameter,$nowUrl);  //则将参数替换为新的内容
			$retuUrl=preg_replace("#enddate=[0-9\-]*#", $newendParameter,$retuUrl);  //则将参数替换为新的内容
		
		}else
		{//不包含参数,直接附加
			$retuUrl=$nowUrl."?".$newstartParameter."&".$newendParameter;
		}
		
		
		
        return $retuUrl;
    }
}




/**
 *  获取指定日期的上一月,或下一月的连接  返回的连接 包含日期期间  startdate:2014-1-1 ;enddate=2014-12-31
 *  引用此函数 的页面  表单名称 必须是startdate enddate=2014-12-31
 * @param     datetime   $startdate  日期格式   指定的日期
 * @param     int   $numb  要加减的年数
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

					//date('Y年m月',strtotime('- 2 month',$t)), 原函数
		$nowmonth=date('Y-m',strtotime($numb.' month',$t));
		$nowmonthmaxday=date('t', strtotime($nowmonth));//上下月的最大天数
		$newstartdate=$nowmonth."-01";
		$newenddate=$nowmonth."-".$nowmonthmaxday;
		
		$newstartParameter="startdate=".$newstartdate;
		$newendParameter="enddate=".$newenddate;
		
		
		if(count($url_arr)>1)  //如果连接包含参数
		{
		//dump($nowUrl);
			$retuUrl=preg_replace("#startdate=[0-9\-]*#", $newstartParameter,$nowUrl);  //则将参数替换为新的内容
			$retuUrl=preg_replace("#enddate=[0-9\-]*#", $newendParameter,$retuUrl);  //则将参数替换为新的内容
		
		}else
		{//不包含参数,直接附加
			$retuUrl=$nowUrl."?".$newstartParameter."&".$newendParameter;
		}
		
		
		
        return $retuUrl;
    }
}





/**141218
 *  获取指定日期的 随后几个月
 周检里面计算 下次日期用
 * @param     datetime   $startdate  日期格式   指定的日期
 * @param     int   $numb  要加减的月数
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
		//date('Y年m月',strtotime('- 2 month',$t)), 原函数
		$nowmonth=date('Y-m',strtotime($numb.' month',$t));
                //  dump($numb);
		$day=date('d', strtotime($startdate));//天
		$retuDate=$nowmonth."-".$day;
		
		
		
		
        return $retuDate;
    }
}


/**150528
 *  获取指定日期的 最大天数
  * @param     datetime   $startdate  日期格式   指定的日期
 * @param     int   $numb  要加减的月数
 * @return    string
 */
if ( ! function_exists('getMonthLastDay'))
{
	//获取每月最大天数
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







