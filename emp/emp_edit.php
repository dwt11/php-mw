<?php
/**
 * Ա���༭
 *
 * @version        $Id: spec_edit.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�
if(empty($dopost)) $dopost = '';
/*--------------------------------
function __save(){  }
-------------------------------*/
 if($dopost=='save')
{
	$emp_code = trim($emp_code);
	$emp_realname = trim($emp_realname);
	$emp_csdate = trim($emp_csdate);
	$emp_phone = trim($emp_phone);
	$emp_add = trim($emp_add);
	$emp_sex = trim($emp_sex);
	$emp_ste = trim($emp_ste);
	$emp_bb = trim($emp_bb);
	$emp_rzdate = trim($emp_rzdate);
	//$emp_lzdate = "";
	$emp_update = date("Y-m-d", time());
	$emp_csxl = trim($emp_csxl);
	$emp_dqxl = trim($emp_dqxl);
	$emp_dep = trim($emp_dep);
	$emp_worktype = trim($emp_worktype);
	$emp_photo = trim($picname);
	$emp_hy = trim($emp_hy);


if($emp_photo==""){//�����ƬΪ���򲻸�����Ƭ
    //����
    $inQuery = "UPDATE `#@__emp` SET 
emp_code='$emp_code',
	emp_realname='$emp_realname',
	emp_sfz='$emp_sfz',
	emp_csdate='$emp_csdate',
	emp_phone='$emp_phone',
	emp_sex='$emp_sex',
	emp_ste='$emp_ste',
	emp_rzdate='$emp_rzdate',
	emp_lzdate='$emp_lzdate',
	emp_update='$emp_update',
	emp_csxl='$emp_csxl',
	emp_dqxl='$emp_dqxl',
	emp_dep='$emp_dep',
	emp_bb='$emp_bb',
	emp_worktype='$emp_worktype',
	emp_hy='$emp_hy',
	emp_add='$emp_add'   WHERE (`emp_id`='$aid')";
}else
{
	    $inQuery = "UPDATE `#@__emp` SET 
emp_code='$emp_code',
	emp_realname='$emp_realname',
	emp_sfz='$emp_sfz',
	emp_csdate='$emp_csdate',
	emp_phone='$emp_phone',
	emp_sex='$emp_sex',
	emp_ste='$emp_ste',
	emp_rzdate='$emp_rzdate',
	emp_lzdate='$emp_lzdate',
	emp_update='$emp_update',
	emp_csxl='$emp_csxl',
	emp_dqxl='$emp_dqxl',
	emp_dep='$emp_dep',
	emp_bb='$emp_bb',
	emp_worktype='$emp_worktype',
	emp_photo='$emp_photo',
	emp_hy='$emp_hy',
	emp_add='$emp_add'  WHERE (`emp_id`='$aid')
	";
	
	}
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("��������ʱ��������ԭ��", "-1");
        exit();
    }

    ShowMsg("�޸�Ա����Ϣ�ɹ���",$ENV_GOBACK_URL);
    exit();
}

if($dopost=='')
{
	require_once(DEDEPATH."/emp/dep.inc.options.php");	
	require_once(DEDEPATH."/emp/worktype.inc.options.php");	

    //��ȡ�鵵��Ϣ
    $arcQuery = "SELECT *  from #@__emp  WHERE emp_id='$aid' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">



function checkSubmit()
{
   if(document.form1.emp_code.value==""){
          alert("����дԱ����ţ�");
          document.form1.emp_code.focus();
          return false;
     }
	 
   if(document.form1.emp_realname.value==""){
          alert("����дԱ��������");
          document.form1.emp_realname.focus();
          return false;
     }
	 
	 
	if(document.form1.emp_dep.value==0)
	{
		alert('��ѡ���ţ�');
		return false;
	}
	 	if(document.form1.emp_worktype.value==0)
	{
		alert('��ѡ���֣�');
		return false;
	}

     return true;
}




//Ա���ϴ�ͼƬ��----�˹���Ҫ���ϵ�����ļ�  ʹ�õ���  ֱ���ڱ��ϴ�ͼƬ��������ʾ
function SeePicNew(f, imgdid, frname, hpos, acname)
{
	//�첽�ϴ�����ͼ��ر���
	var nForm = null;
	var nFrame = null;
	var picnameObj = null;
	var vImg = null;
	
	var newobj = null;
	

	if(f.value=='') return ;
	vImg = $DE(imgdid);
	picnameObj = document.getElementById('picname');
	nFrame = $Nav()=='IE' ? eval('document.frames.'+frname) : $DE(frname);
	nForm = f.form;
	//�޸�form��action�Ȳ���
	if(nForm.detachEvent) nForm.detachEvent("onsubmit", checkSubmit);
  else nForm.removeEventListener("submit", checkSubmit, false);
	nForm.action = 'emp.inc.do.php';
	nForm.target = frname;
	nForm.dopost.value = 'uploadLitpic';
	nForm.submit();
	
	picnameObj.value = '';
	newobj = $DE('uploadwait');
	if(!newobj)
	{
		newobj = document.createElement("DIV");
		newobj.id = 'uploadwait';
		newobj.style.position = 'absolute';
		newobj.className = 'uploadwait';
		newobj.style.width = 120;
		newobj.style.height = 20;
		newobj.style.top = hpos;
		newobj.style.left = 100;
		newobj.style.display = 'block';
		document.body.appendChild(newobj);
		newobj.innerHTML = '<img src="../images/loadinglit.gif" width="16" height="16" alit="" />�ϴ���...';
	}
	newobj.style.display = 'block';
	//�ύ��ԭform��action�Ȳ���
	nForm.action = acname;
	nForm.dopost.value = 'save';
	nForm.target = '';
	nForm.litpic.disabled = true;
	//nForm.litpic = null;
	//if(nForm.attachEvent) nForm.attachEvent("onsubmit", checkSubmit);
  //else nForm.addEventListener("submit", checkSubmit, true);
}

</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
    
    
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="emp_edit.php" method="post"  enctype="multipart/form-data"  onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
          <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
          <tr>
            <td  width="10%" class="bline" align="right">&nbsp;<b>Ա�����</b>��</td>
            <td  class="bline"><input name="emp_code" type="text" value="<?php echo $arcRow['emp_code'];?>" size="14" readonly="readonly"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline"><input type="text" name="emp_realname" size="14"   value="<?php echo $arcRow['emp_realname'];?>" /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline"><span id='typeidct'>
              <?php
          $depOptions = GetDepOptionList($arcRow['emp_dep']);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>��ѡ����...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
              </span></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline"><span id='typeidct'>
              <?php
          $gzOptions = GetGzOptionList($arcRow['emp_worktype']);
          echo "<select name='emp_worktype' id='emp_worktype'  >\r\n";
          echo "<option value='0'>��ѡ����...</option>\r\n";
          echo $gzOptions;
          echo "</select>";
			?>
              </span></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>�Ա�</b>��</td>
            <td  class="bline"><label>
                <input name="emp_sex" type="radio" id="RadioGroup1_0" value="��"  <?php if($arcRow['emp_sex']=='��')echo  "checked='checked'";?>/>
                ��</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_sex" type="radio" id="RadioGroup1_1" value="Ů"  <?php if($arcRow['emp_sex']=='Ů')echo  "checked='checked'";?>/>
                Ů</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>�绰</b>��</td>
            <td  class="bline"><input type="text" name="emp_phone" size="14"  value="<?php echo $arcRow['emp_phone'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>סַ</b>��</td>
            <td  class="bline"><input type="text" name="emp_add" size="30"  value="<?php echo $arcRow['emp_add'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��ְ����</b>��</td>
            <td  class="bline"><?php
            
            if($arcRow['emp_rzdate']=="")  {
            $nowtime =date("Y-m-d", time());}
            else{
            $nowtime =date("Y-m-d",strtotime($arcRow['emp_rzdate']));}

            
                          ?>
              <input type="text" name="emp_rzdate" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��������</b>��</td>
            <td  class="bline"><?php
            
            
               if($arcRow['emp_csdate']=="")  {
            $nowtime =date("Y-m-d", time());}
            else{
            $nowtime =date("Y-m-d",strtotime($arcRow['emp_csdate']));}
         
                          ?>
              <input type="text" name="emp_csdate" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>״̬</b>��</td>
            <td  class="bline"><label>
                <input name="emp_ste" type="radio" id="RadioGroup1_0" value="��ְ"   <?php if($arcRow['emp_ste']=='��ְ')echo  "checked='checked'";?>/>
                ��ְ</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_ste" type="radio" id="RadioGroup1_1" value="��ְ"   <?php if($arcRow['emp_ste']=='��ְ')echo  "checked='checked'";?>/>
                ��ְ</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>���ڰ��</b>��</td>
            <td  class="bline"><label>
                <input name="emp_bb" type="radio" id="RadioGroup1_0" value="���װ�"   <?php if($arcRow['emp_bb']=='���װ�')echo  "checked='checked'";?>/>
                ���װ�</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_bb" type="radio" id="RadioGroup1_1" value="����"   <?php if($arcRow['emp_bb']=='����')echo  "checked='checked'";?>/>
                ����</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>���֤��</b>��</td>
            <td  class="bline"><input type="text" name="emp_sfz" size="18"  value="<?php echo $arcRow['emp_code'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��ʼѧ��</b>��</td>
            <td  class="bline"><?php echo GetEnumsForm('education',$arcRow['emp_csxl'], 'emp_csxl', $seltitle='','')?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>��ǰѧ��</b>��</td>
            <td  class="bline"><?php echo GetEnumsForm('education',$arcRow['emp_dqxl'], 'emp_dqxl', $seltitle='')?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>����</b>��</td>
            <td  class="bline">
            
            <?php 
			
			echo GetEnumsForm('marital',$arcRow['emp_hy'], 'emp_hy', $seltitle='')?>
            
         
         </td>
          </tr>
          <tr id="pictable" >
            <td   class="bline" align="right">&nbsp; <strong>��Ƭ</strong>��</td>
            <td  class="bline">���޸�������
              <input name="picname" type="text" id="picname" style="width:240px" />
              <input type="button"  value="�ϴ�"  class="coolbg np"  />
              <iframe name='uplitpicfra' id='uplitpicfra' src='' style='display:none'></iframe>
              <span class="litpic_span">
              <input name="litpic" type="file" id="litpic"  onChange="SeePicNew(this, 'divpicview', 'uplitpicfra', 165, 'emp_edit.php');" size="1" class='np coolbg'/>
              </span>
              <div id='divpicview' class='divpre'></div></td>
          </tr>
          <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" ��  �� " class="coolbg np" /></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
