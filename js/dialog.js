/**
 * 
 * @version        $Id: dialog.js 1 22:28 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 
 ͨ��ҳ�浯����140722
 
 ����Ӧ�Ի�����ʾ������ϵ�λ��
 */

document.write("<style type=\"text/css\">.close{float:right;cursor:default;}</style>")



/*
e�����Ԫ��
title����
url���õĵ�ַ
width��
 height��
*/


//140814�޸�Ϊ����Ӧ�߶� ����� height��������
//��ȱ������룬�߶Ȳ���Ҫ��������Ӧ�������������ʾ�����˱߽�141103
function AlertMsg(e,title,url, width, height){
    var msgw,msgh,msgbg,msgcolor,bordercolor,titlecolor,titlebg,content; 
	//������������
	msgw = width;		//���ڿ�� 
	//msgh = height;		//���ڸ߶� 
   // if(msgw='')msgw = 300;
   // if(msgh='')msgh = 300;
	msgbg = "#FFF";			//���ݱ���
	msgcolor = "#000";		//������ɫ
	bordercolor = "#5A6D58"; 	//�߿���ɫ 
	titlecolor = "#254015";	//������ɫ
	titlebg = "#369 url(../images/tbg.gif)";		//���ⱳ��
	//���ֱ�������  	
	content = "<div id=show_news>�Բ�������ʧ��</div>";	
	var sWidth,sHeight; 
	sWidth = document.body.scrollWidth; 
	if(screen.availHeight > document.body.scrollHeight){
		sHeight = screen.availHeight;	//����һ��
	}else{
		sHeight = document.body.scrollHeight;	//����һ�� 
	}
	//�������ֱ��� 
	var maskObj = document.createElement("div"); 
	maskObj.setAttribute('id','maskdiv'); 
	//maskObj.onclick="CloseMsg()";
	maskObj.setAttribute("onclick", "CloseMsg();");   //������ֲ��ر�  
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
	//������������
	var msgObj = document.createElement("div") 
	msgObj.setAttribute("id","msgdiv"); 
	msgObj.style.position ="absolute";


    //������ʾλ��
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
	if(posTop>(sHeight-300))   //�����ʾ�����⣬��Ϊ��Ϊ�˸��������Զ��߶ȣ������Ԫ���������浯�����ڵĻ�����Ϊû�д��ڵ�ʵ�ʸ߶ȣ��޷����㴰�ڵ�TOP����141103
	{ posTop =sHeight- 550; //�������λ�ó���ҳ�� ����Ļ��-�����
	}
	if(posLeft<0) posLeft =20;//�������С��0 ��Ϊ20
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
	//��������
	var thObj = document.createElement("div");
	thObj.setAttribute("id","msgth"); 
	thObj.className = "DragAble";
	thObj.title = "��ס�����������϶����ڣ�";
	thObj.style.cursor = "move";
	thObj.style.padding = "4px 6px";
	thObj.style.color = titlecolor;
	thObj.style.fontWeight = 'bold';
	thObj.style.background = titlebg;
	var titleStr = "<a class='close' title='�ر�' style='cursor:pointer' onclick='CloseMsg()'>�ر�</a>"+"<span>"+ title +"</span>";
	thObj.innerHTML = titleStr;
	//��������
	var bodyObj = document.createElement("div");
	bodyObj.setAttribute("id","msgbody"); 
	bodyObj.style.padding = "5px";
	bodyObj.style.lineHeight = "1.5em";
	var txt = document.createTextNode(content);
	bodyObj.appendChild(txt);
	bodyObj.innerHTML = content;
	//���ɴ���
	document.body.appendChild(msgObj);
	$DE("msgdiv").appendChild(thObj);
	$DE("msgdiv").appendChild(bodyObj);

    var show = document.getElementById("show_news");
    var myajax = new DedeAjax(show,false,false,"","","");
    myajax.SendGet2(url);
	//alert(document.getElementById('msgdiv').offsetHeight);��ȡ���ɴ��ڵĸ߶�
 DedeXHTTP = null;

}

function MyGetScrollTop()
{
    return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
}

function CloseMsg(){
	//�Ƴ�����
	document.body.removeChild($DE("maskdiv")); 
	$DE("msgdiv").removeChild($DE("msgth")); 
	$DE("msgdiv").removeChild($DE("msgbody")); 
	document.body.removeChild($DE("msgdiv")); 
}
//�϶�����
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



