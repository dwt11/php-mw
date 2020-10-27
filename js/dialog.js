/**
 * 
 * @version        $Id: dialog.js 1 22:28 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 
 通用页面弹出框140722
 
 自适应对话框显示的左和上的位置
 */

document.write("<style type=\"text/css\">.close{float:right;cursor:default;}</style>")



/*
e点击的元素
title标题
url调用的地址
width宽
 height高
*/


//140814修改为自适应高度 输入的 height不起作用
//宽度必须输入，高度不需要可以自适应，但最下面的显示超出了边界141103
function AlertMsg(e,title,url, width, height){
    var msgw,msgh,msgbg,msgcolor,bordercolor,titlecolor,titlebg,content; 
	//弹出窗口设置
	msgw = width;		//窗口宽度 
	//msgh = height;		//窗口高度 
   // if(msgw='')msgw = 300;
   // if(msgh='')msgh = 300;
	msgbg = "#FFF";			//内容背景
	msgcolor = "#000";		//内容颜色
	bordercolor = "#5A6D58"; 	//边框颜色 
	titlecolor = "#254015";	//标题颜色
	titlebg = "#369 url(../images/tbg.gif)";		//标题背景
	//遮罩背景设置  	
	content = "<div id=show_news>对不起，载入失败</div>";	
	var sWidth,sHeight; 
	sWidth = document.body.scrollWidth; 
	if(screen.availHeight > document.body.scrollHeight){
		sHeight = screen.availHeight;	//少于一屏
	}else{
		sHeight = document.body.scrollHeight;	//多于一屏 
	}
	//创建遮罩背景 
	var maskObj = document.createElement("div"); 
	maskObj.setAttribute('id','maskdiv'); 
	//maskObj.onclick="CloseMsg()";
	maskObj.setAttribute("onclick", "CloseMsg();");   //点击遮罩层后关闭  
	maskObj.style.position = "absolute"; 
	maskObj.style.top = "0"; 
	maskObj.style.left = "0"; 
	maskObj.style.background = "#777"; 
	maskObj.style.filter = "Alpha(opacity=30);"; 
	maskObj.style.opacity = "0.3"; 
	maskObj.style.width = sWidth + "px"; 
	maskObj.style.height = sHeight + "px"; 
	maskObj.style.zIndex = "10000"; 
	document.body.appendChild(maskObj); 
	//创建弹出窗口
	var msgObj = document.createElement("div") 
	msgObj.setAttribute("id","msgdiv"); 
	msgObj.style.position ="absolute";


    //窗体显示位置
	if($Nav()=='IE')
	{ 
		if(window.event)
		{
			var posLeft = window.event.clientX - 20;
			var posTop = window.event.clientY - 30;
		}
		else
		{
			var posLeft = e.clientX - 20;
			var posTop = e.clientY + 30;
		}
	}
	else
	{
		var posLeft = e.pageX - 20;
		var posTop = e.pageY - 30;
	}
	//posTop += MyGetScrollTop();
	posLeft = posLeft - width;
	//alert(posTop+"---"+sHeight);
	if(posTop>(sHeight-300))   //这个显示有问题，因为改为了根据内容自动高度，但如果元素在最下面弹出窗口的话，因为没有窗口的实际高度，无法计算窗口的TOP？？141103
	{ posTop =sHeight- 550; //如果距上位置超出页面 则屏幕高-窗体高
	}
	if(posLeft<0) posLeft =20;//如果距左小于0 则为20
	msgObj.style.top = posTop + "px";
	msgObj.style.left = posLeft+ "px";
	//msgObj.style.top = "100px";
	//msgObj.style.left = "100px";
	
	//if(msgw!='')msgObj.style.width = msgw + "px";
	//if(msgh!='')msgObj.style.height = msgh + "px";
	
	msgObj.style.fontSize = "12px";
	msgObj.style.background = msgbg;
	msgObj.style.border = "1px solid " + bordercolor; 
	msgObj.style.zIndex = "10001"; 
	//创建标题
	var thObj = document.createElement("div");
	thObj.setAttribute("id","msgth"); 
	thObj.className = "DragAble";
	thObj.title = "按住鼠标左键可以拖动窗口！";
	thObj.style.cursor = "move";
	thObj.style.padding = "4px 6px";
	thObj.style.color = titlecolor;
	thObj.style.fontWeight = 'bold';
	thObj.style.background = titlebg;
	var titleStr = "<a class='close' title='关闭' style='cursor:pointer' onclick='CloseMsg()'>关闭</a>"+"<span>"+ title +"</span>";
	thObj.innerHTML = titleStr;
	//创建内容
	var bodyObj = document.createElement("div");
	bodyObj.setAttribute("id","msgbody"); 
	bodyObj.style.padding = "5px";
	bodyObj.style.lineHeight = "1.5em";
	var txt = document.createTextNode(content);
	bodyObj.appendChild(txt);
	bodyObj.innerHTML = content;
	//生成窗口
	document.body.appendChild(msgObj);
	$DE("msgdiv").appendChild(thObj);
	$DE("msgdiv").appendChild(bodyObj);

    var show = document.getElementById("show_news");
    var myajax = new DedeAjax(show,false,false,"","","");
    myajax.SendGet2(url);
	//alert(document.getElementById('msgdiv').offsetHeight);获取生成窗口的高度
 DedeXHTTP = null;

}

function MyGetScrollTop()
{
    return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
}

function CloseMsg(){
	//移除对象
	document.body.removeChild($DE("maskdiv")); 
	$DE("msgdiv").removeChild($DE("msgth")); 
	$DE("msgdiv").removeChild($DE("msgbody")); 
	document.body.removeChild($DE("msgdiv")); 
}
//拖动窗口
var ie = document.all;   
var nn6 = document.getElementById&&!document.all;   
var isdrag = false;   
var y,x;   
var oDragObj;   
  
function moveMouse(e) {   
	if (isdrag) {   
		oDragObj.style.top  = (nn6 ? nTY + e.clientY - y : nTY + event.clientY - y)+"px";   
		oDragObj.style.left  = (nn6 ? nTX + e.clientX - x : nTX + event.clientX - x)+"px";   
		return false;   
	}   
}   
  
function initDrag(e) {   
	var oDragHandle = nn6 ? e.target : event.srcElement;   
	var topElement = "HTML";   
	while (oDragHandle.tagName != topElement && oDragHandle.className != "DragAble") {   
		oDragHandle = nn6 ? oDragHandle.parentNode : oDragHandle.parentElement;   
	}   
	if (oDragHandle.className=="DragAble") {   
		isdrag = true;   
		oDragObj = oDragHandle.parentNode;   
		nTY = parseInt(oDragObj.style.top);   
		y = nn6 ? e.clientY : event.clientY;   
		nTX = parseInt(oDragObj.style.left);   
		x = nn6 ? e.clientX : event.clientX;   
		document.onmousemove = moveMouse;   
		return false;   
	}   
}   
document.onmousedown = initDrag;   
document.onmouseup = new Function("isdrag=false");  



