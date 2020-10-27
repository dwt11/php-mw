<?php
/**
 * �˵���
 *
 * @version        $Id: index_menu.php 1 11:06 2010��7��13��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require('config.php');
require_once("sys/sys_function.class.php");
//$t1 = ExecTime();

$fun = new sys_function();
$menuArray=$fun->getSysFunArray(true);//��ȡ����Ȩ�޵Ĺ��� �������Ϣ ����������




$diri=0;
$diri=0;
$diri_temp=0;
$dirs="";
$files="";

//�˶�Ҫ�Ż�����ĵط� ,��Ϊ�ܶ�ط� ʹ����????�Ż���sys/sys_function.class.php   150118
foreach ($menuArray as $menu)
{
	//dump( $menu[0]);
	$parentMenu=explode(',',$menu[0]);  //��ȡ���ļ�������
	$parentMenuTitle=$parentMenu[3];
	

			  $diri_temp++;//��ʱ�ļ���
			  
			  
			  if(getchildfilename($parentMenuTitle,$menu,$diri_temp)!="")
			  {
				  $diri++;//������ӷ��๦�� ��ʵ�ʵļ���
				  $class=$diri==1? 'mmac' : 'mm';
				  //dump(getchildfilename($rowtitle,$rowdir,$diri));
				  $dirs[]="<div class=\"mmt\"></div><a id='link$diri' class='$class'><div onClick=\"ShowMainMenu($diri)\">$parentMenuTitle</div></a><div class=\"mmb\"></div>\r\n";
				  $files[]=getchildfilename($parentMenuTitle,$menu,$diri);
			  }
}




//150124�����ж��Ƿ�������๦��,
//�������β˵� ����
function getCatalogMenu($urladd,$dirtitle)
{
	
			  $restr="";

			  $urlParameter="";   //���ӵ�ַ�еĲ���
			  $urladdArray=explode('/',$urladd);  //�ָ���ַ ���ڻ�ȡ�ļ�����

			  //150118  �Զ������Ƿ������������,����з��� ������½�����
			  $dirName=$urladdArray[0];//����ļ�������
			  $filenameArray=explode('?',$urladdArray[1]);  //��?�ָ�
			  $filename=$filenameArray[0];  //�ļ�����
			  //�����ǰ�ļ�������Ŀ¼����+.PHP��ͬ ���Ҳ���ϵͳĿ¼ ,��ɨ�赱ǰĿ¼���Ƿ���catalog.php���๦��,����з��๦��,���Զ����ط�������β˵�

			  if($filename==$dirName.".php"&&$dirtitle!="ϵͳ") 
			  {
					$dh = dir(DEDEPATH."/".$dirName);  //����ɨ��Ŀ¼ �µ��ļ�,���Ż�ʹ��scandir���Ŀ¼�µ������ļ���Ϊ����,��PHP��һ���ǽ��õ�,��δʹ��
					while(($file = $dh->read()) !== false)
					{
						//����ϵͳĿ¼
						if(preg_match("#^_(.*)$#i",$file)) continue; #����FrontPage��չĿ¼��linux����Ŀ¼
						if(preg_match("#^\.(.*)$#i",$file)) continue;
						 //���� XXX.do.php xxx.class.php��ҳ��
						 $doClassFiles = explode('.', $file);
						 if(count($doClassFiles)>2)continue;
						 
						 //��ǰ�ļ��Ƿ���catalog.php���๦��
						 if($file=="catalog.php")
						 {
								if(count($filenameArray)>1)$urlParameter=$filenameArray[1]; //���Ӳ���
								$catalogId=0;
								
								if($urlParameter!=""){
									$parameterArray=explode('=',$urlParameter);
									$catalogId=$parameterArray[1];   //�ָ������������Ŀ��ID
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



//��ȡ�ӹ���,
//$dir ����������
//$diri �����ܼ���

function getchildfilename($dirtitle,$menu,$diri)
{

	$childMenuStr="";
	$display=$diri==1? '' : 'style=\'display:none\'';
	$childMenuStr_temp="";
	
//dump($dirtitle);		//���ӹ��ܲ˵����ӣ����������������
		//���ӹ��ܲ˵����ӣ����������������
		for($childi=1;$childi<count($menu);$childi++)
		{
			$childMenuLink="";
	
					$childMenu=explode(',',$menu[$childi]);  //��ȡ�ӹ�������
					$childid=$childMenu[0];
					$urladd=$childMenu[1];
					$groupName=$childMenu[2];
				    if($groupName==""){$groupName="Ĭ�Ϲ���";}
					$childtitle=$childMenu[3];

					//if(Test_webRole($urladd))
					//{
						
						
						if(UrlAddFileExists($urladd))   //
						{//����ļ����� ���������
							
							
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
						{//����ļ�������  ��ֻ�����ɫ����
							$childMenuLink="                                          <li>$childtitle</li>\r\n";
						}
						
					//}
//dump($childtitle);		//���ӹ��ܲ˵����ӣ����������������
//dump($urladd);		//���ӹ��ܲ˵����ӣ����������������
//dump(Test_webRole($urladd));		//���ӹ��ܲ˵����ӣ����������������
					if(!empty($childMenuLink))
					{
						$childMenuLinkArray[$groupName][]=$childMenuLink;
					}
		}    
					
		//�ָ��ϲ���ȡ������
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
		$childMenuLinkArray="";//������� ������һ�������ܰ����� �ӹ���

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
  //150120�����ξͷ�����,�������������,��Ϊ�������ѭ�����
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



/*���β˵���*/
div,dd{ margin:0px; padding:0px }
.dlf { margin-right:3px; margin-left:6px; margin-top:2px; float:left }
.dlr { float:left }
.topcc { margin-top:5px }
/*���β˵���*/














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
	height:47px;131119ɾ���߶ȣ����ڲ˵���Ӧ�߶�*/
	padding: 6px 4px 4px 10px;
	word-wrap: break-word;
	word-break : break-all;
	font-weight: bold;
	color: #325304;
}
a.mm div {
	background: url(images/leftmenu/leftmbg1.gif) repeat;
	/*
	height:141px;131119ɾ���߶ȣ����ڲ˵���Ӧ�߶�*/
	padding: 6px 4px 4px 10px;
	word-wrap: break-word;
	word-break : break-all;
	font-weight: bold;
	color: #475645;
	cursor: pointer;
}
/*131119�����ڲ˵���Ӧ�߶� ͷ*/
.mmt {
	background: url(images/leftmenu/leftmbg1-t.gif) no-repeat;
	height: 4px;
	overflow: hidden;
	margin-top: 2PX;
	width: 28px
}
/*131119�����ڲ˵���Ӧ�߶� ��*/

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
		  //alert('��ѡ���������:'+dp.cal.getDateStr())
	  }
  }
)
</script>
</body>
</html>
<?php 
$t2 = ExecTime();

//echo $t2-$t1;?>