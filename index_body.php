<?php
/**
 * 管理后台首页主体
 *
 * @version        $Id: index_body.php 1 11:06 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require('config.php');
require(DEDEINC.'/dedetag.class.php');
require_once("sys/sys_function.class.php");
//$t1 = ExecTime();

   //2获取其他连接
	$defaultQuickMenu = DEDEDATA.'/quickmenu/quickmenu.txt';
	$myQuickMenu = DEDEDATA.'/quickmenu/quickmenu-'.$cuserLogin->getUserId().'.txt';
	//dump($myQuickMenu);
	if(!file_exists($myQuickMenu)) $myQuickMenu = $defaultQuickMenu;


//默认主页
if(empty($dopost))
{
	
	
	//1\获取快捷菜单
	$parents = $childs = array();
	$fun = new sys_function();
	$menuArray=$fun->getSysFunArray(true,true);
	foreach ($menuArray as $menu)
	{
		if(count($menu)>1)
		{	$parentMenu=explode(',',$menu[0]);  //获取父文件夹数组
			$parentMenuTitle=$parentMenu[3];
			$isputred=$parentMenu[7];
			
			 if(getchildfilename($menu)!="")
			  {
			    if($isputred=="1")$parentMenuTitle="<span  style=\"color:red\">$parentMenuTitle</span></li>\r\n";
				
		        $parents[]=$parentMenuTitle;  //父功能数组  HTM页面调用 
				$childs[$parentMenuTitle]=getchildfilename($menu);  //子功能数组  HTM页面调用 
		   	  }
			
		}
	}




   
   
   
   
   
   //3获取用户信息
   $userName=$cuserLogin->getUserName();
   $realName=GetEmpNameByUserId($cuserLogin->getUserId());
   $depAllName=GetEmpDepAllNameByUserId($cuserLogin->getUserId(),$cuserLogin->getUserType());


	//获取权限级名称
	$groupNames=GetUserTypeNames($cuserLogin->getUserType());
	
	//直接从数据 库获取 权限内容,如有多个权限组的话 合并输出
	$sql="SELECT logintime,loginip,loginnumb FROM `#@__sys_admin` WHERE id=".$cuserLogin->getUserId()."";
	$groupSet = $dsql->GetOne($sql);
	$loginTime=GetDateTimeMk($groupSet['logintime']);
	$loginIp=$groupSet['loginip'];
	$loginNumb=$groupSet['loginnumb'];
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    include DedeInclude('index_body.htm');
	
}
/*-----------------------
添加新项
function _AddNew() {   }
-------------------------*/
else if($dopost=='addnew')
{
    if(empty($link) || empty($title))
    {
        ShowMsg("链接网址或标题不能为空！","-1");
        exit();
    }

    $fp = fopen($myQuickMenu,'r');
    $oldct = trim(fread($fp, filesize($myQuickMenu)));
    fclose($fp);

    $link = preg_replace("#['\"]#", '`', $link);
    $title = preg_replace("#['\"]#", '`', $title);
    $ico = preg_replace("#['\"]#", '`', $ico);
    $oldct .= "\r\n<menu:item ico=\"{$ico}\" link=\"{$link}\" title=\"{$title}\" />";

    $myQuickMenuTrue = DEDEDATA.'/quickmenu/quickmenu-'.$cuserLogin->getUserId().'.txt';
    $fp = fopen($myQuickMenuTrue, 'w');
    fwrite($fp, $oldct);
    fclose($fp);

    ShowMsg("成功添加！","index_body.php?".time());
    exit();
}
/*---------------------------
保存修改的项
function _EditSave() {   }
----------------------------*/
else if($dopost=='editsave')
{
    $quickmenu = stripslashes($quickmenu);

    $myQuickMenuTrue = DEDEDATA.'/quickmenu/quickmenu-'.$cuserLogin->getUserId().'.txt';
    $fp = fopen($myQuickMenuTrue,'w');
    fwrite($fp,$quickmenu);
    fclose($fp);

    ShowMsg("成功修改快捷操作项目！","index_body.php?".time());
    exit();
}
/*-----------------------------
显示修改表单
function _EditShow() {   }
-----------------------------*/
else if($dopost=='editshow')
{
    $fp = fopen($myQuickMenu,'r');
    $oldct = trim(fread($fp,filesize($myQuickMenu)));
    fclose($fp);
?>
<form name='editform' action='index_body.php' method='post'>
<input type='hidden' name='dopost' value='editsave' />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td height='28' background="images/tbg.gif">
         <div style='float:left'><b>修改链接操作项</b></div>
      <div style='float:right;padding:3px 10px 0 0;'>
             <a href="javascript:CloseTab('editTab')"><b>关闭</b></a>
      </div>
     </td>
   </tr>
      <tr><td style="height:6px;font-size:1px;border-top:1px solid #8DA659">&nbsp;</td></tr>
   <tr>
     <td>
         按原格式修改/添加XML项。
     </td>
   </tr>
   <tr>
     <td align='center'>
         <textarea name="quickmenu" rows="10" cols="50" style="width:94%;height:220px"><?php echo $oldct; ?></textarea>
     </td>
   </tr>
   <tr>
     <td height="45" align="center">
         <input type="submit" name="Submit" value="保存项目" class="np coolbg" style="width:80px;cursor:pointer" />
         &nbsp;
         <input type="reset" name="reset" value="重设" class="np coolbg" style="width:50px;cursor:pointer" />
     </td>
   </tr>
  </table>
</form>
<?php


exit();
}






//获取子功能,
//$dir 父功能名称

function getchildfilename($menu)
{
				//将子功能菜单连接，按分组存入数组中
			$isputred="";
			$retuStr_temp="";
			for($childi=1;$childi<count($menu);$childi++)
			{
					$childMenu=explode(',',$menu[$childi]);  //获取子功能数组
					$childid=$childMenu[0];
					$urladd=$childMenu[1];
					$childtitle=$childMenu[3];
					$isputred=$childMenu[7];
					
					
						
						if(UrlAddFileExists($urladd))   //
						{
							 if($isputred=="1"){
								 $retuStr_temp.="<li><a href='$urladd'><span style=\"color:red\">$childtitle</span></a></li>\r\n";
							 }else{
								 $retuStr_temp.="<li><a href='$urladd'>$childtitle</a></li>\r\n";
							}
						}else
						{
							
						  $retuStr_temp.="<li><span style=\"color:#999\">$childtitle</span></li>\r\n";
						}
					
					
			}

			return $retuStr_temp;
}	
	



?>
       
    

