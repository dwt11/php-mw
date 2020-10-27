<?php
/**
 * 部门添加
 *
 * @version        $Id: dep_add.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost)) $dopost = '';

$id = isset($id) ? intval($id) : 0;

if($id==0 )
{
    
}
else
{
    $checkID = empty($id) ? $reid : $id;
    
}




/*---------------------
function action_save(){ }
---------------------*/
if($dopost=="save")
{

    
    $in_query = "INSERT INTO `#@__emp_dep`(dep_name,dep_info,dep_topid)
    VALUES('$dep_name','$dep_info','$dep_topid')";

    if(!$dsql->ExecuteNoneQuery($in_query))
    {
        ShowMsg("保存数据时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }
    //if($dep_topid>0)  //如果添加的是子部门,可获取顶级部门,然后添加后自动展开顶级部门   ??140912未处理
    //{
    //    PutCookie('lastCid',GetTopid($dep_topid),3600*24,'/');
    //}
    ShowMsg("成功创建一个部门！","dep.php");
    exit();

}//End dopost==save

//获取从父目录继承的默认参数
if($dopost=='')
{
    $topid = 0;
    if($id>0)
    {
        $myrow = $dsql->GetOne(" SELECT * FROM `#@__emp_dep` WHERE dep_id=$id ");
        $dep_topid = $myrow['dep_topid'];
    }

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script language="javascript">


function checkSubmit()
{
   if(document.form1.dep_name.value==""){
          alert("部门名称不能为空！");
          document.form1.dep_name.focus();
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
 
  <form name="form1" action="dep_add.php" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="save" />
  <input type='hidden' name='dep_topid' id='dep_topid' value='<?php echo $id; ?>' />
 
 
        
       
       
          <tr> 
            <td  width="10%" class="bline" align="right">部门名称：</td>
            <td class='bline'><input name="dep_name" type="text" id="dep_name" size="30" class="pubinputs" /></td>
          </tr>
          <tr>
            <td class='bline'  align="right"> 部门描述： </td>
             <td class='bline'>          <textarea name="dep_info" cols="70" style="height:50px" rows="4" id="dep_info" class="alltxt"></textarea>
                  </td>
                 
               
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
