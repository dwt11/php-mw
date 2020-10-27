<?php
/**
 * 工种编辑
 *
 * @version        $Id: worktype_edit.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
if(empty($dopost)) $dopost = '';
$id = isset($id) ? intval($id) : 0;


/*-----------------------
function action_save()
----------------------*/
if($dopost=="save")
{
    $worktype_info = Html2Text($worktype_info,1);
    
    $upquery = "UPDATE `#@__emp_worktype` SET
     worktype_name='$worktype_name',
     worktype_info='$worktype_info'    WHERE worktype_id='$id' ";

    if(!$dsql->ExecuteNoneQuery($upquery))
    {
        ShowMsg("保存当前工种更改时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }

    
    ShowMsg("成功更改！",$ENV_GOBACK_URL);
    exit();
}

//读取工种信息
$dsql->SetQuery("SELECT * FROM `#@__emp_worktype`  WHERE worktype_id=$id");
////dump("SELECT * FROM `#@__em_dep`  WHERE worktype_id=$id");
$myrow = $dsql->GetOne();
$topid = $myrow['worktype_topid'];

//PutCookie('lastCid',GetTopid($id),3600*24,"/");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script language="javascript">

  
function checkSubmit()
{
   if(document.form1.worktype_name.value==""){
          alert("工种名称不能为空！");
          document.form1.worktype_name.focus();
          return false;
     }
     return true;
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
  <form name="form1" action="worktype_edit.php" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="save" />
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
  <input type="hidden" name="topid" value="<?php echo $myrow['topid']; ?>" />
    
          <tr> 
            <td  width="10%" class="bline" align="right">工种名称：</td>
            <td class='bline'><input name="worktype_name" type="text" id="worktype_name" size="30" value="<?php echo $myrow['worktype_name']?>" class="pubinputs" /></td>
          </tr>
          <tr> 
            <td  class="bline" align="right">工种描述：</td>
            <td class='bline'>  <textarea name="worktype_info" cols="70" style="height:50px" rows="4" id="worktype_info" class="alltxt"><?php echo $myrow['worktype_info']?></textarea> </td>
          </tr>
                <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" 保  存 " class="coolbg np" /></td>
          </tr>        </form> 
	</table>
	</td>
     
  </tr>
</table>
</body>
</html>