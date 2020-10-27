<?php
/**
 * 员工编辑
 *
 * @version        $Id: spec_edit.php 1 16:22 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单
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


if($emp_photo==""){//如果照片为空则不更新照片
    //更新
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
        ShowMsg("更新数据时出错，请检查原因！", "-1");
        exit();
    }

    ShowMsg("修改员工信息成功！",$ENV_GOBACK_URL);
    exit();
}

if($dopost=='')
{
	require_once(DEDEPATH."/emp/dep.inc.options.php");	
	require_once(DEDEPATH."/emp/worktype.inc.options.php");	

    //读取归档信息
    $arcQuery = "SELECT *  from #@__emp  WHERE emp_id='$aid' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("读取信息出错!","-1");
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
          alert("请添写员工编号！");
          document.form1.emp_code.focus();
          return false;
     }
	 
   if(document.form1.emp_realname.value==""){
          alert("请添写员工姓名！");
          document.form1.emp_realname.focus();
          return false;
     }
	 
	 
	if(document.form1.emp_dep.value==0)
	{
		alert('请选择部门！');
		return false;
	}
	 	if(document.form1.emp_worktype.value==0)
	{
		alert('请选择工种！');
		return false;
	}

     return true;
}




//员工上传图片用----此功能要整合到别的文件  使用的少  直接在表单上传图片后立即显示
function SeePicNew(f, imgdid, frname, hpos, acname)
{
	//异步上传缩略图相关变量
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
	//修改form的action等参数
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
		newobj.innerHTML = '<img src="../images/loadinglit.gif" width="16" height="16" alit="" />上传中...';
	}
	newobj.style.display = 'block';
	//提交后还原form的action等参数
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
            <td  width="10%" class="bline" align="right">&nbsp;<b>员工编号</b>：</td>
            <td  class="bline"><input name="emp_code" type="text" value="<?php echo $arcRow['emp_code'];?>" size="14" readonly="readonly"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>姓名</b>：</td>
            <td  class="bline"><input type="text" name="emp_realname" size="14"   value="<?php echo $arcRow['emp_realname'];?>" /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>部门</b>：</td>
            <td  class="bline"><span id='typeidct'>
              <?php
          $depOptions = GetDepOptionList($arcRow['emp_dep']);
          echo "<select name='emp_dep' id='emp_dep'  >\r\n";
          echo "<option value='0'>请选择部门...</option>\r\n";
          echo $depOptions;
          echo "</select>";
			?>
              </span></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>工种</b>：</td>
            <td  class="bline"><span id='typeidct'>
              <?php
          $gzOptions = GetGzOptionList($arcRow['emp_worktype']);
          echo "<select name='emp_worktype' id='emp_worktype'  >\r\n";
          echo "<option value='0'>请选择工种...</option>\r\n";
          echo $gzOptions;
          echo "</select>";
			?>
              </span></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>性别</b>：</td>
            <td  class="bline"><label>
                <input name="emp_sex" type="radio" id="RadioGroup1_0" value="男"  <?php if($arcRow['emp_sex']=='男')echo  "checked='checked'";?>/>
                男</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_sex" type="radio" id="RadioGroup1_1" value="女"  <?php if($arcRow['emp_sex']=='女')echo  "checked='checked'";?>/>
                女</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>电话</b>：</td>
            <td  class="bline"><input type="text" name="emp_phone" size="14"  value="<?php echo $arcRow['emp_phone'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>住址</b>：</td>
            <td  class="bline"><input type="text" name="emp_add" size="30"  value="<?php echo $arcRow['emp_add'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>入职日期</b>：</td>
            <td  class="bline"><?php
            
            if($arcRow['emp_rzdate']=="")  {
            $nowtime =date("Y-m-d", time());}
            else{
            $nowtime =date("Y-m-d",strtotime($arcRow['emp_rzdate']));}

            
                          ?>
              <input type="text" name="emp_rzdate" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>出生日期</b>：</td>
            <td  class="bline"><?php
            
            
               if($arcRow['emp_csdate']=="")  {
            $nowtime =date("Y-m-d", time());}
            else{
            $nowtime =date("Y-m-d",strtotime($arcRow['emp_csdate']));}
         
                          ?>
              <input type="text" name="emp_csdate" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>状态</b>：</td>
            <td  class="bline"><label>
                <input name="emp_ste" type="radio" id="RadioGroup1_0" value="在职"   <?php if($arcRow['emp_ste']=='在职')echo  "checked='checked'";?>/>
                在职</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_ste" type="radio" id="RadioGroup1_1" value="离职"   <?php if($arcRow['emp_ste']=='离职')echo  "checked='checked'";?>/>
                离职</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>考勤班别</b>：</td>
            <td  class="bline"><label>
                <input name="emp_bb" type="radio" id="RadioGroup1_0" value="常白班"   <?php if($arcRow['emp_bb']=='常白班')echo  "checked='checked'";?>/>
                常白班</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input name="emp_bb" type="radio" id="RadioGroup1_1" value="倒班"   <?php if($arcRow['emp_bb']=='倒班')echo  "checked='checked'";?>/>
                倒班</label></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>身份证号</b>：</td>
            <td  class="bline"><input type="text" name="emp_sfz" size="18"  value="<?php echo $arcRow['emp_code'];?>"  /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>初始学历</b>：</td>
            <td  class="bline"><?php echo GetEnumsForm('education',$arcRow['emp_csxl'], 'emp_csxl', $seltitle='','')?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>当前学历</b>：</td>
            <td  class="bline"><?php echo GetEnumsForm('education',$arcRow['emp_dqxl'], 'emp_dqxl', $seltitle='')?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>婚姻</b>：</td>
            <td  class="bline">
            
            <?php 
			
			echo GetEnumsForm('marital',$arcRow['emp_hy'], 'emp_hy', $seltitle='')?>
            
         
         </td>
          </tr>
          <tr id="pictable" >
            <td   class="bline" align="right">&nbsp; <strong>照片</strong>：</td>
            <td  class="bline">不修改请留空
              <input name="picname" type="text" id="picname" style="width:240px" />
              <input type="button"  value="上传"  class="coolbg np"  />
              <iframe name='uplitpicfra' id='uplitpicfra' src='' style='display:none'></iframe>
              <span class="litpic_span">
              <input name="litpic" type="file" id="litpic"  onChange="SeePicNew(this, 'divpicview', 'uplitpicfra', 165, 'emp_edit.php');" size="1" class='np coolbg'/>
              </span>
              <div id='divpicview' class='divpre'></div></td>
          </tr>
          <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" 保  存 " class="coolbg np" /></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
