<?php
/**
150112修改文件名称加DO,否则要判断权限
* FILE_NAME:getajaxtag.php 
* 接收到ajax参数，处理关键字，注意编码
* 
* @copyright Copyright (c) 2010-2015  www.phpwebgo.com
* @author  phpwebgo@gmail.com
* @package core
* @version 2010-7-31  下午03:06:35
*/
 require_once('../../config.php');

$keyword = iconv ( 'utf-8', 'GBK', js_unescape ( $q ) );
			
	$i=0;		
	global $dsql;
    $dsql->Execute('f', "Select DISTINCT(".$datafield.") From ".$datatable." where  ".$datafield." LIKE '%" . $keyword . "%'  ");
	//dump( "Select DISTINCT(".$datafield.") From ".$datatable." where  ".$datafield." LIKE '%" . $keyword . "%'  ");
	while($frow = $dsql->GetArray('f'))
	{
	 $i++;
	 echo $keyword =  $frow[$datafield]  . "\n";

	}



function js_unescape($str) {
	$ret = '';
	$len = strlen ( $str );
	for($i = 0; $i < $len; $i ++) {
		if ($str [$i] == '%' && $str [$i + 1] == 'u') {
			$val = hexdec ( substr ( $str, $i + 2, 4 ) );
			if ($val < 0x7f)
				$ret .= chr ( $val );
			else if ($val < 0x800)
				$ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
			else
				$ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
			$i += 5;
		} else if ($str [$i] == '%') {
			$ret .= urldecode ( substr ( $str, $i, 3 ) );
			$i += 2;
		} else
			$ret .= $str [$i];
	}
	return $ret;
}
?>