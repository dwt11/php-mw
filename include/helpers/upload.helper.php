<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * �ϴ�����С����
 *
 * @version        $Id: upload.helper.php 1 2010-07-05 11:43:09Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */



//140814-----------------------------�˴�����Ա���ϴ���Ƭʱ���޸�,���Ѿ�������,���ϵ�Ա�����ҳ����,
//-----------------------------����������ط�Ҫ�õ����ϴ�ͼƬ��,����������һ������Ĵ��� ��һ��ͨ�õ�

/**
 *  ����Ա�ϴ��ļ���ͨ�ú���
 *
 * @access    public
 * @param     string  $uploadname  �ϴ�����
 * @param     string  $ftype  �ļ�����
 * @param     string  $rnddd  ��׺����
 * @param     bool  $watermark  �Ƿ�ˮӡ
 * @param     string  $filetype  image��media��addon
 *      $file_type='' ����swfupload�ϴ����ļ��� ��Ϊû��filetype��������ָ����������Щ����֮����ͬ
 * @return    int   -1 ûѡ���ϴ��ļ���0 �ļ����Ͳ�����, -2 ����ʧ�ܣ������������ϴ�����ļ���
 */
if ( ! function_exists('AdminUpload'))
{   // $upfile = AdminUpload($emp_code,'litpic', 'imagelit', 0, false );

    function AdminUpload($emp_code,$uploadname, $ftype='image', $rnddd=0, $watermark=TRUE, $filetype='' )
    {
		//��Ա�����Ϊǰ��ϴ���Ƭ
        global $dsql,$cfg_basedir;
        
		//dump($emp_code);
        $file_tmp = isset($GLOBALS[$uploadname]) ? $GLOBALS[$uploadname] : '';
        if($file_tmp=='' || !is_uploaded_file($file_tmp) )
        {
            return -1;
        }
       
        $file_tmp = $GLOBALS[$uploadname];
        $file_size = filesize($file_tmp);
        $file_type = $filetype=='' ? strtolower(trim($GLOBALS[$uploadname.'_type'])) : $filetype;
        
        $file_name = isset($GLOBALS[$uploadname.'_name']) ? $GLOBALS[$uploadname.'_name'] : '';
        $file_snames = explode('.', $file_name);
        $file_sname = strtolower(trim($file_snames[count($file_snames)-1]));
        
        if($ftype=='image' || $ftype=='imagelit')
        {
            $filetype = '1';
            $sparr = Array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/xpng', 'image/wbmp');
            if(!in_array($file_type, $sparr)) return 0;
            if($file_sname=='')
            {
                if($file_type=='image/gif') $file_sname = 'jpg';
                else if($file_type=='image/png' || $file_type=='image/xpng') $file_sname = 'png';
                else if($file_type=='image/wbmp') $file_sname = 'bmp';
                else $file_sname = 'jpg';
            }
            $filedir = MyDate($cfg_addon_savetype, time());
        }
      
	  
        /*if(!is_dir(DEDEPATH.$filedir))
        {
            MkdirAll($cfg_basedir.$filedir, $cfg_dir_web_role);
            CloseFtp();
        }*/
        $filename = $emp_code.'-'.dd2char(MyDate('ymdHis', time())).$rnddd;
        //if($ftype=='imagelit') $filename .= '-L';
       /* if( file_exists($cfg_basedir.$filedir.'/'.$filename.'.'.$file_sname) )
        {
            for($i=50; $i <= 5000; $i++)
            {
                if( !file_exists($cfg_basedir.$filedir.'/'.$filename.'-'.$i.'.'.$file_sname) )
                {
                    $filename = $filename.'-'.$i;
                    break;
                }
            }
        }*/
		

        $fileurl = $filename.'.'.$file_sname;
		       		//dump( $cfg_basedir."/uploads/".$fileurl);
        $rs = move_uploaded_file($file_tmp, $cfg_basedir."/uploads/".$fileurl);
        if(!$rs) return -2;
        if($ftype=='image' && $watermark)
        {
            WaterImg($cfg_basedir.$fileurl, 'up');
        }
        
        //������Ϣ�����ݿ�
        $title = $filename.'.'.$file_sname;
        $inquery = "INSERT INTO `#@__uploads`(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
            VALUES ('$title','$fileurl','$filetype','0','0','0','".filesize($cfg_basedir.$fileurl)."','".time()."',''); ";
        $dsql->ExecuteNoneQuery($inquery);
        $fid = $dsql->GetLastID();
        AddMyAddon($fid, $fileurl);
        return $fileurl;
    }
}



