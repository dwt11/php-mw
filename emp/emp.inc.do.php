<?php
/**
 * 文档处理
 *
 * @version        $Id: emp.inc.do.php 1 8:26 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');

if(empty($dopost))
{
    ShowMsg('对不起，你没指定运行参数！','-1');
    exit();
}
$id = isset($id) ? preg_replace("#[^0-9]#", '', $id) : '';


/*--------------------------
//员工详细信息浏览
function empview(){ }
---------------------------*/
 if($dopost=="empview")
{

    //获取主表信息
    $query = "SELECT *
           FROM `#@__emp` 
           WHERE emp_id='$id' ";
//		   //dump($query);
    $row = $dsql->GetOne($query);
        AjaxHead();
    ?>

<table width='100%' style='z-index:9000;'>
  <tr>
    <td  width="243" height="26"  class="bline" align="right"><b> <img src="
			<?php 
	
	
	if($row['emp_photo']==""){
	echo "/images/defaultpic.gif";
		
		}else{
	echo "/uploads/".$row['emp_photo'];
		}
	
	?>
            
            " width="180" height="260"></b></td>
    <td width="1295" valign="top"  class="bline"><table width='100%' >
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>编号</b>：</td>
          <td  class="bline"><?php echo $row['emp_code']?></td>
        </tr>
        <tr height='32'>
          <td width="80" class='bline' align="right">&nbsp;<b>姓名</b>：</td>
          <td class='bline'><?php echo $row['emp_realname']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>性别</b>：</td>
          <td  class="bline"><?php echo $row['emp_sex']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right"><b>出生日期</b>：</td>
          <td  class="bline"><?php echo  date("Y-m-d",strtotime($row['emp_csdate']))?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>电话</b>：</td>
          <td  class="bline"><?php echo $row['emp_phone']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>入职日期</b>：</td>
          <td  class="bline"><?php echo  date("Y-m-d",strtotime($row['emp_rzdate']))?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>状态</b>：</td>
          <td  class="bline"><?php echo $row['emp_ste']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>当前学历</b>：</td>
          <td  class="bline"><?php echo $row['emp_dqxl']?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height='26' colspan="2" align="right" class='bline'><table width="98%" align="center">
        <tr>
          <td width="276" class='bline' align="right" height='26'>&nbsp;<b>初始学历</b>：</td>
          <td width="1223" class='bline'>&nbsp;<?php echo $row['emp_csxl']?></td>
        </tr>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>身份证号</b>：</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_sfz']?></td>
        </tr>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>婚姻</b>：</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_hy']?></td>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>家庭地址</b>：</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_add']?></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 
}
/*--------------------------
//异步上传员工照片
function uploadLitpic(){ }
---------------------------*/
else if($dopost=="uploadLitpic")
{
    //$upfile = AdminUpload($emp_code,'litpic', 'imagelit', 0, false );
  
  
  
    $emp_code=$emp_code;
	$uploadname='litpic';//用户选择的文件
	
		//以员工编号为前辍上传照片
        global $dsql,$cfg_basedir;
        
		//dump($emp_code);
        $file_tmp = isset($GLOBALS[$uploadname]) ? $GLOBALS[$uploadname] : '';
        if($file_tmp=='' || !is_uploaded_file($file_tmp) )
        {
            $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('你没指定要上传的文件或文件大小超过限制！');
            </script>";
        }
       
        $file_tmp = $GLOBALS[$uploadname];
        $file_type = $filetype=='' ? strtolower(trim($GLOBALS[$uploadname.'_type'])) : $filetype;
        
        $file_name = isset($GLOBALS[$uploadname.'_name']) ? $GLOBALS[$uploadname.'_name'] : '';
        $file_snames = explode('.', $file_name);
        $file_sname = strtolower(trim($file_snames[count($file_snames)-1]));
        
       
	   
		$sparr = Array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/xpng', 'image/wbmp');
		if(!in_array($file_type, $sparr))
		{
			$msg = "<script language='javascript'>
			parent.document.getElementById('uploadwait').style.display = 'none';
			alert('文件类型不正确！');
			</script>";
		}
		if($file_sname=='')
		{
			if($file_type=='image/gif') $file_sname = 'jpg';
			else if($file_type=='image/png' || $file_type=='image/xpng') $file_sname = 'png';
			else if($file_type=='image/wbmp') $file_sname = 'bmp';
			else $file_sname = 'jpg';
		}
		$filedir = MyDate($cfg_addon_savetype, time());
      
	  
	  
        $filename = $emp_code.'-'.dd2char(MyDate('ymdHis', time()));
		

        $fileurl = $filename.'.'.$file_sname;
		       		//dump( $cfg_basedir."/uploads/".$fileurl);
        $rs = move_uploaded_file($file_tmp, $cfg_basedir."/uploads/".$fileurl);
        if(!$rs)
		 {
			$msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('上传文件失败，请检查原因！');
            </script>";
		  }else
		  {
			          $file_size = filesize($cfg_basedir."/uploads/".$fileurl);

				 $msg = "<script language='javascript'>
								  parent.document.getElementById('uploadwait').style.display = 'none';
								  parent.document.getElementById('picname').value = '{$fileurl}';
								  if(parent.document.getElementById('divpicview'))
								  {
									  parent.document.getElementById('divpicview').style.width = '150px';
									  parent.document.getElementById('divpicview').innerHTML = \"<img src='/uploads/{$fileurl}?n' width='150' />\";
								  }
							  </script>";				
				  //保存信息到数据库
				  $title = "员工编号:".$emp_code."的照片";
				  
				  $inquery = "INSERT INTO `#@__uploads`(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
					  VALUES ('$title','$fileurl','$filetype','0','0','0','$file_size','".time()."',".$cuserLogin->getUserId()."); ";
				  echo ($inquery);
				  $dsql->ExecuteNoneQuery($inquery);
			  }
			

        
  
  
    echo $msg;
    exit();
}













