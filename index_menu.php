<?php
/**
 * 菜单项
 *
 * @version        $Id: index_menu.php 1 11:06 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require('config.php');
require_once("sys/sys_function.class.php");
//$t1 = ExecTime();

$fun = new sys_function();
$menuArray=$fun->getSysFunArray(true);//获取具有权限的功能 的相关信息 并存入数组




$diri=0;
$diri=0;
$diri_temp=0;
$dirs="";
$files="";

//此段要优化到别的地方 ,因为很多地方 使用了????优化到sys/sys_function.class.php   150118
foreach ($menuArray as $menu)
{
	//dump( $menu[0]);
	$parentMenu=explode(',',$menu[0]);  //获取父文件夹数组
	$parentMenuTitle=$parentMenu[3];
	

			  $diri_temp++;//另时的计数
			  
			  
			  if(getchildfilename($parentMenuTitle,$menu,$diri_temp)!="")
			  {
				  $diri++;//如果有子分类功能 才实际的计数
				  $class=$diri==1? 'mmac' : 'mm';
				  //dump(getchildfilename($rowtitle,$rowdir,$diri));
				  $dirs[]="<div class=\"mmt\"></div><a id='link$diri' class='$class'><div onClick=\"ShowMainMenu($diri)\">$parentMenuTitle</div></a><div class=\"mmb\"></div>\r\n";
				  $files[]=getchildfilename($parentMenuTitle,$menu,$diri);
			  }
}




//150124增加判断是否包含分类功能,
//返回树形菜单 代码
function getCatalogMenu($urladd,$dirtitle)
{
	
			  $restr="";

			  $urlParameter="";   //连接地址中的参数
			  $urladdArray=explode('/',$urladd);  //分隔地址 用于获取文件名称

			  //150118  自动搜索是否包含分类连接,如果有分类 则输出下接连接
			  $dirName=$urladdArray[0];//获得文件夹名称
			  $filenameArray=explode('?',$urladdArray[1]);  //按?分隔
			  $filename=$filenameArray[0];  //文件名称
			  //如果当前文件名称与目录名称+.PHP相同 并且不是系统目录 ,则扫描当前目录下是否有catalog.php分类功能,如果有分类功能,则自动加载分类的树形菜单

			  if($filename==$dirName.".php"&&$dirtitle!="系统") 
			  {
					$dh = dir(DEDEPATH."/".$dirName);  //引段扫描目录 下的文件,可优化使用scandir获得目录下的所有文件存为数组,但PHP中一般是禁用的,故未使用
					while(($file = $dh->read()) !== false)
					{
						//屏蔽系统目录
						if(preg_match("#^_(.*)$#i",$file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
						if(preg_match("#^\.(.*)$#i",$file)) continue;
						 //屏蔽 XXX.do.php xxx.class.php的页面
						 $doClassFiles = explode('.', $file);
						 if(count($doClassFiles)>2)continue;
						 
						 //当前文件是否有catalog.php分类功能
						 if($file=="catalog.php")
						 {
								if(count($filenameArray)>1)$urlParameter=$filenameArray[1]; //连接参数
								$catalogId=0;
								
								if($urlParameter!=""){
									$parameterArray=explode('=',$urlParameter);
									$catalogId=$parameterArray[1];   //分隔参数，获得栏目的ID
								}
								require_once(DEDEPATH."/".$dirName."/catalog.inc.class.php");
								
								$classname=$dirName."CatalogInc";
								$newClassName=$dirName."ClI";
								$$newClassName = new $classname();
								$restr=$$newClassName->GetListToMenu($catalogId,true);  
								 break;
						 }
					}
			  }
			  return $restr;
	
}



//获取子功能,
//$dir 父功能名称
//$diri 父功能记数

function getchildfilename($dirtitle,$menu,$diri)
{

	$childMenuStr="";
	$display=$diri==1? '' : 'style=\'display:none\'';
	$childMenuStr_temp="";
	
//dump($dirtitle);		//将子功能菜单连接，按分组存入数组中
		//将子功能菜单连接，按分组存入数组中
		for($childi=1;$childi<count($menu);$childi++)
		{
			$childMenuLink="";
	
					$childMenu=explode(',',$menu[$childi]);  //获取子功能数组
					$childid=$childMenu[0];
					$urladd=$childMenu[1];
					$groupName=$childMenu[2];
				    if($groupName==""){$groupName="默认功能";}
					$childtitle=$childMenu[3];

					//if(Test_webRole($urladd))
					//{
						
						
						if(UrlAddFileExists($urladd))   //
						{//如果文件存在 则输出连接
							
							
							//dump($filename);
							$linkstr=getCatalogMenu($urladd,$dirtitle);
							if($linkstr!="") 
							{
								 $childMenuLink=$linkstr;  
								
							}else
							{
								$childMenuLink="<li><a href='$urladd' target='main' title='$childtitle'>$childtitle</a></li>\r\n";
							}
						
						    //dump($childMenuLink);
						
						}else
						{//如果文件不存在  则只输出灰色文字
							$childMenuLink="                                          <li>$childtitle</li>\r\n";
						}
						
					//}
//dump($childtitle);		//将子功能菜单连接，按分组存入数组中
//dump($urladd);		//将子功能菜单连接，按分组存入数组中
//dump(Test_webRole($urladd));		//将子功能菜单连接，按分组存入数组中
					if(!empty($childMenuLink))
					{
						$childMenuLinkArray[$groupName][]=$childMenuLink;
					}
		}    
					
		//分隔上步获取的数组
		$groupi=0;
		if(!empty($childMenuLinkArray))
		{
			  foreach ($childMenuLinkArray as $key=>$group)
			  {
				  
						  $groupi++;
						  $childlink="";
						  for($iii=0;$iii<count($group);$iii++)
						  {					  
							  $childlink.= $group[$iii];
						  }
						   $childMenuStr_temp.= "<dl class='bitem' id='sunitems".$diri."_".$groupi."'>\r\n
											  <dt onClick='showHide(\"items".$diri."_".$groupi."\")'><b>$key</b></dt>\r\n
											  <dd style='display:block' class='sitem' id='items".$diri."_".$groupi."'>\r\n
												<ul class='sitemu'>\r\n
													$childlink
											   </ul>
											  </dd>\r\n
											</dl>\r\n";
			  }
		}
		$childMenuLinkArray="";//清空数组 用于下一个父功能包含的 子功能

	if($childMenuStr_temp!="")$childMenuStr.="<div id='ct$diri' $display>$childMenuStr_temp</div>\r\n";
	return $childMenuStr;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>menu</title>
<link rel="stylesheet" href="/css/base.css" type="text/css" />
<script src="js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="js/dedeajax2.js"></script>
<script language="javascript" type="text/javascript" src="js/leftmenu.js"></script>
<script src="../js/main.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>

<script language="javascript">
function arcLoadSuns(ctid,tid)
{
  //150120这三段就放这里,不能往程序里放,因为程序里会循环多次
  if($DE(ctid).innerHTML.length < 10){
      $DE('arcimg'+tid).src = 'images/contract.gif';
	  var myajax = new DedeAjax($DE(ctid));
	  myajax.SendGet('archives/catalog.do.php?dopost=GetMenuSunLists&cid='+tid);
  }
  else{ 
	  showHideImg(ctid,tid,'arcimg'+tid); 
  }
}
function devLoadSuns(ctid,tid,step)
{
  if($DE(ctid).innerHTML.length < 10){
      $DE('devimg'+tid).src = 'images/contract.gif';
	  var myajax = new DedeAjax($DE(ctid));
	  myajax.SendGet('device/devicecatalog.do.php?dopost=GetMenuSunLists&cid='+tid+'&step='+step);
  }
  else{ 
	  showHideImg(ctid,tid,'devimg'+tid); 
  }
}
function goodsLoadSuns(ctid,tid,step)
{
  if($DE(ctid).innerHTML.length < 10){
      $DE('goodsimg'+tid).src = 'images/contract.gif';
	  var myajax = new DedeAjax($DE(ctid));
	  myajax.SendGet('goods/catalog.do.php?dopost=GetMenuSunLists&cid='+tid+'&step='+step);
  }
  else{ 
	  showHideImg(ctid,tid,'goodsimg'+tid); 
  }
}
</script>

<style>



/*树形菜单用*/
div,dd{ margin:0px; padding:0px }
.dlf { margin-right:3px; margin-left:6px; margin-top:2px; float:left }
.dlr { float:left }
.topcc { margin-top:5px }
/*树形菜单用*/














div {
	padding: 0px;
	margin: 0px;
}
body {
	padding: 0px;
	margin: auto;
	text-align: center;
	background-color: #eff5ed;
	background: url(images/leftmenu/leftmenu_bg.gif);
	padding-left: 3px;
	overflow: scroll;
	overflow-x: hidden;
	scrollbar-face-color: #eff8e6;
	scrollbar-shadow-color: #edf2e3;
	scrollbar-highlight-color: #ffffff;
	scrollbar-3dlight-color: #F2F2F2;
	scrollbar-darkshadow-color: #bdbcbd;
	scrollbar-arrow-color: #bdbcbd
}




dl.bitem {
	clear: both;
	width: 140px;
	margin: 0px 0px 5px 12px;
	background: url(images/leftmenu/menubg.gif) repeat-x;
}
dl.bitem2 {
	clear: both;
	width: 140px;
	margin: 0px 0px 5px 12px;
	background: url(images/leftmenu/menubg2.gif) repeat-x;
}
dl.bitem dt, dl.bitem2 dt {
	height: 25px;
	line-height: 25px;
	padding-left: 35px;
	cursor: pointer;
}
dl.bitem dt b, dl.bitem2 dt b {
	color: #4D6C2F;
}
dl.bitem dd, dl.bitem2 dd {
	padding: 3px 3px 3px 3px;
	background-color: #fff;
}
div.items {
	clear: both;
	padding: 0px;
	height: 0px;
}
.fllct {
	float: left;
	width: 85px;
}
.flrct {
	padding-top: 3px;
	float: left;
}
.sitemu li {
	padding: 0px 0px 0px 18px;
	line-height: 22px;
	background: url(images/leftmenu/arr.gif) no-repeat 5px 9px;
}
ul {
	padding-top: 3px;
}
li {
	height: 22px;
	color:#999;
}
a.mmac div {
	background: url(images/leftmenu/leftbg2.gif) repeat;
	/*height:37px!important;
	height:47px;131119删除高度，用于菜单自应高度*/
	padding: 6px 4px 4px 10px;
	word-wrap: break-word;
	word-break : break-all;
	font-weight: bold;
	color: #325304;
}
a.mm div {
	background: url(images/leftmenu/leftmbg1.gif) repeat;
	/*
	height:141px;131119删除高度，用于菜单自应高度*/
	padding: 6px 4px 4px 10px;
	word-wrap: break-word;
	word-break : break-all;
	font-weight: bold;
	color: #475645;
	cursor: pointer;
}
/*131119，用于菜单自应高度 头*/
.mmt {
	background: url(images/leftmenu/leftmbg1-t.gif) no-repeat;
	height: 4px;
	overflow: hidden;
	margin-top: 2PX;
	width: 28px
}
/*131119，用于菜单自应高度 底*/

.mmb {
	background: url(images/leftmenu/leftmbg1-b.gif) no-repeat;
	height: 4px;
	overflow: hidden;
	margin-bottom: 2px;
	width: 28px
}
a.mm:hover div {
	background: url(images/leftmenu/leftbg2.gif) repeat;
	color: #4F7632;
}
.mmf {
	height: 1px;
	padding: 5px 7px 5px 7px;
}
#mainct {
	padding-top: 8px;
	background: url(images/leftmenu/idnbg1.gif) repeat-y;
}
#footer {
	position:fixed;
	left:0px;
	bottom:0px;
	height:165px;
	width:100%;
}
</style>
<base target="main" />
</head>
<body  target="main">
<table width="180" align="left" border='0' cellspacing='0' cellpadding='0' style="text-align:left;">
  <tr>
    <td valign='top' style='padding-top:10px' width='20'><?php
if(is_array($dirs))
{
	foreach ($dirs as $dir)
	{
		echo $dir;
	}
}
?></td>
    <td width='160' id='mainct' valign="top" ><?php
if(is_array($files))
{
		foreach ($files as $file)
	{
		echo $file;
	}
}
?></td>
  </tr>
  <tr>
    <td width='26'></td>
    <td width='160' valign='top'><img src='images/leftmenu/idnbgfoot.gif' /></td>
  </tr>
</table>
<div id="footer"></div>
<script>
WdatePicker(
  {
	  eCont:'footer',onpicked:function(dp)
	  {
		  //alert('你选择的日期是:'+dp.cal.getDateStr())
	  }
  }
)
</script>
</body>
</html>
<?php 
$t2 = ExecTime();

//echo $t2-$t1;?>