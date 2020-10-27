<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 字符串小助手
 *
 * @version        $Id: string.helper.php 5 14:24 2010年7月5日Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
//拼音的缓冲数组
$pinyins = Array();





/**
 *  获取拼音以gbk编码为准
 *
 * @access    public
 * @param     string  $str     字符串信息
 * @param     int     $ishead  是否取头字母
 * @param     int     $isclose 是否关闭字符串资源
 * @param     int     $isonehead  是否第一个字全拼 ,其他的字取头字母  此值为0时  ishead才起作用
 * @return    string
 */
if ( ! function_exists('GetPinyin'))
{
    function GetPinyin($str, $ishead=0, $isclose=1,$isonehead=0 )
    {

		global $pinyins;
		$restr = '';
		$str = trim($str);
		$slen = strlen($str);
		if($slen < 2)
		{
			return $str;
		}
		if(count($pinyins) == 0)
		{
			$fp = fopen(DEDEINC.'/data/pinyin.dat', 'r');
			while(!feof($fp))
			{
				$line = trim(fgets($fp));
				$pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
			}
			fclose($fp);
		}
		for($i=0; $i<$slen; $i++)
		{//dump($slen);
			if(ord($str[$i])>0x80)
			{
				$c = $str[$i].$str[$i+1];
				$i++;
				if(isset($pinyins[$c]))
				{
				   // dump($i."---".$pinyins[$c]);
					if($isonehead==0)
					{
						if($ishead==0)
						{
							$restr .= $pinyins[$c];
						}
						else
						{
							$restr .= $pinyins[$c][0];
						}
					}else
					{
						if($i==1)
						{
							$restr .= $pinyins[$c];
						}else
						{
							$restr .= $pinyins[$c][0];
							}
						
					}
				
				
				}else
				{
					$restr .= "_";
				}
			}else if( preg_match("/[a-z0-9]/i", $str[$i]) )
			{
				$restr .= $str[$i];
			}
			else
			{
				$restr .= "_";
			}
		}
		if($isclose==0)
		{
			unset($pinyins);
		}
		return $restr;




    }
}

































/**
 *  中文截取2，单字节截取模式
 *  如果是request的内容，必须使用这个函数
 *
 * @access    public
 * @param     string  $str  需要截取的字符串
 * @param     int  $slen  截取的长度
 * @param     int  $startdd  开始标记处
 * @return    string
 */
if ( ! function_exists('cn_substrR'))
{
    function cn_substrR($str, $slen, $startdd=0)
    {
        $str = cn_substr(stripslashes($str), $slen, $startdd);
        return addslashes($str);
    }
}



//高亮专用

if ( ! function_exists('GetRedKeyWord'))
{
//$FSTR 字符串
//$K 关键词
 function GetRedKeyWord($fstr,$k)
    {
        //echo $fstr;
       // $ks = explode(' ',$this->Keywords);
      
            $fstr = str_replace($k, "<b><font color='red'>$k</font></b>", $fstr);
        return $fstr;
    }
}
/**
 *  中文截取2，单字节截取模式
 *
 * @access    public
 * @param     string  $str  需要截取的字符串
 * @param     int  $slen  截取的长度
 * @param     int  $startdd  开始标记处
 * @return    string
 */
if ( ! function_exists('cn_substr'))
{
    function cn_substr($str, $slen, $startdd=0)
    {
        global $cfg_soft_lang;
        if($cfg_soft_lang=='utf-8')
        {
            return cn_substr_utf8($str, $slen, $startdd);
        }
        $restr = '';
        $c = '';
        $str_len = strlen($str);
        if($str_len < $startdd+1)
        {
            return '';
        }
        if($str_len < $startdd + $slen || $slen==0)
        {
            $slen = $str_len - $startdd;
        }
        $enddd = $startdd + $slen - 1;
        for($i=0;$i<$str_len;$i++)
        {
            if($startdd==0)
            {
                $restr .= $c;
            }
            else if($i > $startdd)
            {
                $restr .= $c;
            }

            if(ord($str[$i])>0x80)
            {
                if($str_len>$i+1)
                {
                    $c = $str[$i].$str[$i+1];
                }
                $i++;
            }
            else
            {
                $c = $str[$i];
            }

            if($i >= $enddd)
            {
                if(strlen($restr)+strlen($c)>$slen)
                {
                    break;
                }
                else
                {
                    $restr .= $c;
                    break;
                }
            }
        }
        return $restr;
    }
}

/**
 *  utf-8中文截取，单字节截取模式
 *
 * @access    public
 * @param     string  $str  需要截取的字符串
 * @param     int  $slen  截取的长度
 * @param     int  $startdd  开始标记处
 * @return    string
 */
if ( ! function_exists('cn_substr_utf8'))
{
    function cn_substr_utf8($str, $length, $start=0)
    {
        if(strlen($str) < $start+1)
        {
            return '';
        }
        preg_match_all("/./su", $str, $ar);
        $str = '';
        $tstr = '';

        //为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
        for($i=0; isset($ar[0][$i]); $i++)
        {
            if(strlen($tstr) < $start)
            {
                $tstr .= $ar[0][$i];
            }
            else
            {
                if(strlen($str) < $length + strlen($ar[0][$i]) )
                {
                    $str .= $ar[0][$i];
                }
                else
                {
                    break;
                }
            }
        }
        return $str;
    }
}

/**
 *  HTML转换为文本
 *
 * @param    string  $str 需要转换的字符串
 * @param    string  $r   如果$r=0直接返回内容,否则需要使用反斜线引用字符串
 * @return   string
 */
if ( ! function_exists('Html2Text'))
{
    function Html2Text($str,$r=0)
    {
        if(!function_exists('SpHtml2Text'))
        {
            require_once(DEDEINC."/inc_fun.php");
        }
        if($r==0)
        {
            return SpHtml2Text($str);
        }
        else
        {
            $str = SpHtml2Text(stripslashes($str));
            return addslashes($str);
        }
    }
}


/**
 *  文本转HTML
 *
 * @param    string  $txt 需要转换的文本内容
 * @return   string
 */
if ( ! function_exists('Text2Html'))
{
    function Text2Html($txt)
    {
        $txt = str_replace("  ", "　", $txt);
        $txt = str_replace("<", "&lt;", $txt);
        $txt = str_replace(">", "&gt;", $txt);
        $txt = preg_replace("/[\r\n]{1,}/isU", "<br/>\r\n", $txt);
        return $txt;
    }
}

/**
 *  获取半角字符
 *
 * @param     string  $fnum  数字字符串
 * @return    string
 */
if ( ! function_exists('GetAlabNum'))
{
    function GetAlabNum($fnum)
    {
        $nums = array("０","１","２","３","４","５","６","７","８","９");
        //$fnums = "0123456789";
        $fnums = array("0","1","2","3","4","5","6","7","8","9");
        $fnum = str_replace($nums, $fnums, $fnum);
        $fnum = preg_replace("/[^0-9\.-]/", '', $fnum);
        if($fnum=='')
        {
            $fnum=0;
        }
        return $fnum;
    }
}



/**
 *  将实体html代码转换成标准html代码（兼容php4）
 *
 * @access    public
 * @param     string  $str     字符串信息
 * @param     long    $options  替换的字符集
 * @return    string
 */

if ( ! function_exists('htmlspecialchars_decode'))
{
        function htmlspecialchars_decode($str, $options=ENT_COMPAT) {
                $trans = get_html_translation_table(HTML_SPECIALCHARS, $options);

                $decode = ARRAY();
                foreach ($trans AS $char=>$entity) {
                        $decode[$entity] = $char;
                }

                $str = strtr($str, $decode);

                return $str;
        }
}


//随机数字小助手，生成随机数 
if ( ! function_exists('dotrand'))
{
	function dotrand($startnum,$endnum)
	{
			$newnum = rand($startnum,$endnum);
//			$newdot = rand($sdot,$edot);
//			if (strlen($newdot) == "1"){
//					$newdot = "0".$newdot;
//			}
			return $newnum;
	}

}


//150203将数字编号按要求的位数补充全(前面加000)
//用在员工编号\订做的商品的编号 补充

//$numbInt  数字,
//$digit  要求的位数

//return string
if ( ! function_exists('GetIntAddZero'))
{
    function GetIntAddZero($numbInt,$digit=3)
    {		//$numbInt="1";
		if(strlen($numbInt)<$digit){
			$addnumb=$digit-strlen($numbInt);
			//dump($addnumb);
			//150305优化算法 
		  for ($i = 0; $i <$addnumb; $i++) 
		  { 
			$numbInt="0".$numbInt;
			//dump($i);
		  }
		}
		return $numbInt;
	}
}
