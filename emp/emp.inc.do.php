<?php
/**
 * �ĵ�����
 *
 * @version        $Id: emp.inc.do.php 1 8:26 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once('../config.php');

if(empty($dopost))
{
    ShowMsg('�Բ�����ûָ�����в�����','-1');
    exit();
}
$id = isset($id) ? preg_replace("#[^0-9]#", '', $id) : '';


/*--------------------------
//Ա����ϸ��Ϣ���
function empview(){ }
---------------------------*/
 if($dopost=="empview")
{

    //��ȡ������Ϣ
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
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>���</b>��</td>
          <td  class="bline"><?php echo $row['emp_code']?></td>
        </tr>
        <tr height='32'>
          <td width="80" class='bline' align="right">&nbsp;<b>����</b>��</td>
          <td class='bline'><?php echo $row['emp_realname']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>�Ա�</b>��</td>
          <td  class="bline"><?php echo $row['emp_sex']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right"><b>��������</b>��</td>
          <td  class="bline"><?php echo  date("Y-m-d",strtotime($row['emp_csdate']))?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>�绰</b>��</td>
          <td  class="bline"><?php echo $row['emp_phone']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>��ְ����</b>��</td>
          <td  class="bline"><?php echo  date("Y-m-d",strtotime($row['emp_rzdate']))?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>״̬</b>��</td>
          <td  class="bline"><?php echo $row['emp_ste']?></td>
        </tr>
        <tr>
          <td  width="80" height="26"  class="bline" align="right">&nbsp;<b>��ǰѧ��</b>��</td>
          <td  class="bline"><?php echo $row['emp_dqxl']?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height='26' colspan="2" align="right" class='bline'><table width="98%" align="center">
        <tr>
          <td width="276" class='bline' align="right" height='26'>&nbsp;<b>��ʼѧ��</b>��</td>
          <td width="1223" class='bline'>&nbsp;<?php echo $row['emp_csxl']?></td>
        </tr>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>���֤��</b>��</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_sfz']?></td>
        </tr>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>����</b>��</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_hy']?></td>
        <tr>
          <td  width="276" height="26"  class="bline" align="right">&nbsp;<b>��ͥ��ַ</b>��</td>
          <td  class="bline">&nbsp;<?php echo $row['emp_add']?></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 
}
/*--------------------------
//�첽�ϴ�Ա����Ƭ
function uploadLitpic(){ }
---------------------------*/
else if($dopost=="uploadLitpic")
{
    //$upfile = AdminUpload($emp_code,'litpic', 'imagelit', 0, false );
  
  
  
    $emp_code=$emp_code;
	$uploadname='litpic';//�û�ѡ����ļ�
	
		//��Ա�����Ϊǰ��ϴ���Ƭ
        global $dsql,$cfg_basedir;
        
		//dump($emp_code);
        $file_tmp = isset($GLOBALS[$uploadname]) ? $GLOBALS[$uploadname] : '';
        if($file_tmp=='' || !is_uploaded_file($file_tmp) )
        {
            $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('��ûָ��Ҫ�ϴ����ļ����ļ���С�������ƣ�');
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
			alert('�ļ����Ͳ���ȷ��');
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
                alert('�ϴ��ļ�ʧ�ܣ�����ԭ��');
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
				  //������Ϣ�����ݿ�
				  $title = "Ա�����:".$emp_code."����Ƭ";
				  
				  $inquery = "INSERT INTO `#@__uploads`(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
					  VALUES ('$title','$fileurl','$filetype','0','0','0','$file_size','".time()."',".$cuserLogin->getUserId()."); ";
				  echo ($inquery);
				  $dsql->ExecuteNoneQuery($inquery);
			  }
			

        
  
  
    echo $msg;
    exit();
}













