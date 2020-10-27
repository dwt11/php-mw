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
require_once("sys_function.class.php");

if(empty($dopost)) $dopost = '';

$topid = isset($topid) ? intval($topid) : 0;




/*---------------------
function action_save(){ }
---------------------*/
if($dopost=="save")
{

	if($urladd=="0")
	{
        ShowMsg("所选功能不可用,请选择非灰色背景选项！","-1");
        exit();
	}
	//dump("SELECT title,disorder FROM `dede_sys_function` where topid={$topid} and title='$title' ORDER BY disorder desc");
	
	$row = $dsql->GetOne("SELECT title,disorder FROM `dede_sys_function` where topid={$topid}  ORDER BY disorder desc");
//	dump($title==$row["title"]);
	//dump($title);
//	dump($row["title"]);
	if(is_array($row))
	{
		if( $title==$row["title"])
		{
			ShowMsg("已经存在相同名称的功能,请修改！","-1");
			exit();
		}
		$disorder=$row["disorder"]+1;
	}else
	{
		$disorder=1;
	}
	
	//如果添加的功能为暂时功能 ，则地址采用 “父栏目ID_随机数”
	if($urladd=="#")
	{
		$urladd=$topid."_".mt_rand(10000,99999);
	}
	
	$in_query = "INSERT INTO `dede_sys_function` (`topid`,`urladd`,  `groups` ,`title`, `disorder`, `remark`) 
	VALUES ('{$topid}','{$urladd}','',  '{$title}', '{$disorder}', '{$remark}')";
    //dump($in_query);
    if(!$dsql->ExecuteNoneQuery($in_query))
    {
        ShowMsg("保存数据时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }
    ShowMsg("成功添加功能！","sys_function.php");
    exit();

}//End dopost==save

$fun = new sys_function();

$optionarr = $fun->getDirFileOption();  //供栏目选择

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
    if(document.form1.title.value==""){
          alert("显示名称不能为空！");
          document.form1.title.focus();
          return false;
     }
	 
     return true;
}


</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><?php echo $sysFunTitle?></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF">
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
 
  <form name="form1" action="sys_function_add.php" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="save" />
  <input type='hidden' name='topid' id='topid' value='<?php echo $topid; ?>' />
 
 
        
       
       
<?php
if($topid>0)
{
?>
          <tr>
            <td  width="10%" class="bline" align="right">上级功能：</td>
            <td class='bline'><?php echo $parentTitle;?></td>
          </tr>
          <?php }?>
          <tr>
            <td  width="10%" class="bline" align="right">显示名称：</td>
            <td class='bline'><input name="title" type="text" id="title" size="30"   /></td>
          </tr>
          <?php
if($topid>0)
{
?>
          <tr>
            <td class='bline'  align="right"> 选择功能： </td>
            <td class='bline'><?php
            echo "<select name='urladd' >\r\n";
            echo "<option value='#' style=''  selected>暂无功能...</option>\r\n";
            echo $optionarr;
            echo "</select>";
			     ?>
                 
                 <br><img src='../images/ico/help.gif' /> <strong>暂无功能</strong>代表临时功能，可随后在列表页面编辑实际对应的功能地址！
                 <br><img src='../images/ico/help.gif' /> <strong>灰色背景</strong>代表功能父分类，不可选择！
                 <br><img src='../images/ico/help.gif' /> <strong>白色背景</strong>代表功能子分类，不可选择！
                 <br><img src='../images/ico/help.gif' /> <strong>黄色背景</strong>代表功能父功能所包含的子栏目分类，可选择！选择后默认在菜单中自动加载栏目的所有下级子栏目。
              </td>
          </tr>
          <?php }else
{
	
	echo "<input name=\"urladd\"  type=\"hidden\"   />";
	}


?>
          <tr>
            <td class='bline'  align="right"> 备注： </td>
             <td class='bline'>          <textarea name="remark" cols="70" style="height:50px" rows="4" id="dep_info" class="alltxt"></textarea>
                  </td>
          </tr>
                <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" 保  存 " class="coolbg np" /></td>
          </tr>  
          
          
                </form> 
	</table>
	</td>
     
  </tr>
</table>
</body>
</html>
