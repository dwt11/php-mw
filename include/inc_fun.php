<?php   if(!defined('DEDEINC')) exit('dedecms');
/**
 * 基本函数
 *
 * @version        $Id:inc_fun_funAdmin.php 1 13:58 2010年7月5日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

function SpHtml2Text($str)
{
	$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
	$alltext = "";
	$start = 1;
	for($i=0;$i<strlen($str);$i++)
	{
		if($start==0 && $str[$i]==">")
		{
			$start = 1;
		}
		else if($start==1)
		{
			if($str[$i]=="<")
			{
				$start = 0;
				$alltext .= " ";
			}
			else if(ord($str[$i])>31)
			{
				$alltext .= $str[$i];
			}
		}
	}
	$alltext = str_replace("　"," ",$alltext);
	$alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
	$alltext = preg_replace("/[ ]+/s"," ",$alltext);
	return $alltext;
}


/**
 *  创建目录
 *
 * @access    public
 * @param     string  $spath 目录名称
 * @return    string
 */
function SpCreateDir($spath)
{
    global $cfg_dir_web_role,$cfg_basedir,$cfg_ftp_mkdir,$isSafeMode;
    if($spath=='')
    {
        return true;
    }
    $flink = false;
    $truepath = $cfg_basedir;
    $truepath = str_replace("\\","/",$truepath);
    $spaths = explode("/",$spath);
    $spath = "";
    foreach($spaths as $spath)
    {
        if($spath=="")
        {
            continue;
        }
        $spath = trim($spath);
        $truepath .= "/".$spath;
        if(!is_dir($truepath) || !is_writeable($truepath))
        {
            if(!is_dir($truepath))
            {
                $isok = MkdirAll($truepath,$cfg_dir_web_role);
            }
            else
            {
                $isok = ChmodAll($truepath,$cfg_dir_web_role);
            }
            if(!$isok)
            {
                echo "创建或修改目录：".$truepath." 失败！<br>";
                CloseFtp();
                return false;
            }
        }
    }
    CloseFtp();
    return true;
}




/**
 * 删除文件
 *
 * @param unknown_type $filename
 * @return unknown
 */
function SpDeleteFile($filename)
{
	//$filename = $this->baseDir.$this->activeDir."/$filename";
	if(is_file($filename))
	{
		@unlink($filename);;
	} else
        {
                RmDirFiles($filename);
           
            }
            
	return ture;
}





 /**
     * 删除目录
     *
     * @param unknown_type $indir
     */
    function RmDirFiles($indir)
    {
        if(!is_dir($indir))
        {
            return ;
        }
        $dh = dir($indir);
 // dump($indir);
         while($filename = $dh->read())
        {
           if($filename == "." || $filename == "..")
            {
                continue;
            }
            else if(is_file("$indir/$filename"))
            {
                       // dump($filename);
			 @unlink("$indir/$filename");
            }
            else
            {
                RmDirFiles("$indir/$filename");
            }
        }
        $dh->close();
        //dump(@rmdir($indir));
		@rmdir($indir);
    }
?>