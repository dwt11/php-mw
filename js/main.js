<!--









//�ж����������    δ�ҵ�ʹ�õĵط� ����ɾ�� 140814
var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','maxthon':'','mozilla':'','webkit':''});
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;
function browserVersion(types) {
	var other = 1;
	for(i in types) {
		var v = types[i] ? types[i] : i;
		if(USERAGENT.indexOf(v) != -1) {
			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
			var matches = re.exec(USERAGENT);
			var ver = matches != null ? matches[2] : 0;
			other = ver !== 0 ? 0 : other;
		}else {
			var ver = 0;
		}
		eval('BROWSER.' + i + '= ver');
	}
	BROWSER.other = other;
}










//1��Ԫ�ص����غ���ʾ ����ͼ��
//objnameԪ������
function ShowHide(objname)
{
	var obj = $DE(objname);
	if(obj.style.display == "block" ||obj.style.display ==''||obj.style.display !='none') obj.style.display = "none";
	else obj.style.display = BROWSER.firefox? "" : "block";
}


//2��Ԫ�ص����غ���ʾ ��+ -ͼ��
//objnameԪ������
//tidԪ��ID,��������ͼƬ
//objimgname150116����  ���������豸���ĵ���������ʾ
function showHideImg(objname,tid,objimgname)
{
    
	var obj = $DE(objname);
	var objImg = $DE(objimgname);
    if(obj.style.display=="none")
    {
        objImg.src = '../images/contract.gif';
        obj.style.display = BROWSER.firefox? "" : "block";
    } else {
        objImg.src = '../images/explode.gif';
        obj.style.display="none";
    }
}
















//---------------------------------3�������е����غ���ʾ   tr����ʽΪ class='hid'

//��ʾ��������COOKIEдΪ1 ����ʾдΪ��
//������˽�����ʹ�� �Ƿ���ʾ�������ݿ���



//3.1ҳ��BODY�У�����ʱҪ�ж�COOKIE�е�ֵ�������Ƿ���ʾ
//listname  �������,���ڱ��浽COOK�����ж����Ǹ�����ҳ���
function checkShowHidelist(listname)
{
	
	//setCookie('menuitems','');
	var ckstr = getCookie(listname);
	var trs = $("tr[class='hid']"); 
	
	if(ckstr==1)
	{
		for(i = 0; i < trs.length; i++){   
				
			  trs[i].style.display = '';
			  $("#hidchild").attr("checked",true);//��ʾ�ĸ�ѡ���
		}	
	}else
	{
		for(i = 0; i < trs.length; i++){   
				//trs[i].style.display = "none"; //�����ȡ��trs[i]��DOM���������jQuery������˲���ֱ��ʹ��hide()���� 
		
				trs[i].style.display = 'none';
				$("#hidchild").attr("checked",false);//��ʾ�ĸ�ѡ�򲻴�
		}	
	}
	
}




//3.2���ҳ�渴ѡ���,���غ���ʾ��,�������д��COOK
//listname  �������,���ڱ��浽COOK�����ж����Ǹ�����ҳ���
function showHidelist(listname)
{
	var trs = $("tr[class='hid']"); 
	for(i = 0; i < trs.length; i++){   
			//trs[i].style.display = "none"; //�����ȡ��trs[i]��DOM���������jQuery������˲���ֱ��ʹ��hide()���� 
	
		if(trs[i].style.display == 'block' || trs[i].style.display =='')
		{
			trs[i].style.display = 'none';
			setCookie(listname,'',7);
		}
		else
		{
			trs[i].style.display = '';
			setCookie(listname,'1',7);
			$("#hidchild").attr("checked",true);//��ʾ�ĸ�ѡ���
		}//return true;
	}
}


//3.3��cookie����
function getCookie(listname)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(listname + "=")
		if (c_start != -1)
		{
			c_start = c_start + listname.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1)
			{
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null
}

//3.4дcookie����
function setCookie(listname,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = listname + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //ʹ���õ���Чʱ����ȷ�����toGMTString()
}













//4�����ѡ�е�INPUT����CHECK����ȫѡ��ȫ��

//4.1���ѡ�е�input
//inputname  checkbox��Ԫ������
function getCheckboxItem(inputname)
{
	var allSel="";
	var inputs=document.getElementsByName(inputname);
	if(inputs.value) return inputs.value;
	for(i=0;i<inputs.length;i++)
	{
		if(inputs[i].checked)
		{
			if(allSel=="")
				allSel=inputs[i].value;
			else
				allSel=allSel+"`"+inputs[i].value;
		}
	}
	return allSel;
}


//4.2��ѡ�б��е�input  ������ť������
//inputname  checkbox��Ԫ������
//һ��ҳ����һ��CHECKBOX
function selAll(inputname){
	var inputs=document.getElementsByName(inputname);
	//var selAllButs=document.getElementsById(inputname);
	if(selAllBut.innerText=="ȫ��"){
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = false;
		}
		 selAllBut.innerHTML="ȫѡ";
	}
	else {
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = true;
		}
		 selAllBut.innerHTML="ȫ��";
	}
}



//4.3��ѡ�б��е�input  ������ť������ 150527������ڻ���ѡ��Ա��ʱ��ѡ
//inputname  checkbox��Ԫ������
//һ��ҳ���ж���checkbox ��ѡ��
function selAllMore(inputname){
	var inputs=document.getElementsByName(inputname);
	var selAllBut=document.getElementById(inputname);
	if(selAllBut.innerText=="ȫ��"){
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = false;
		}
		 selAllBut.innerHTML="ȫѡ";
	}
	else {
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = true;
		}
		 selAllBut.innerHTML="ȫ��";
	}
}



//5��ȷ���Ƿ�ɾ�� 
//actionUrl  ��ת��ַ
//id         ɾ���ı��
function isdel(actionUrl,id){
		if(confirm('��ȷ��Ҫɾ����������')){
			location.href=actionUrl+id;
		}
	}






//6\ѡ��л�
//tabname,�л���Ԫ������
//em��ǰԪ�ؼǼ���
//allgrԪ���ܸ���
function ShowTab(tabname,em,allgr)
{
	for(var i=1;i<=allgr;i++)
	{
		if(i==em) $DE(tabname+i).style.display = ($Nav()=='IE' ? 'block' : 'table');
		else $DE(tabname+i).style.display = 'none';
	}
}






function $Obj(objname)
{
	return document.getElementById(objname);
}

//�û����ҳ����ʾ������,�Զ��������е�ֵ ����ҳ���е�inputk��
//value  Դֵ
//ename  Ŀ��INPUT��Ԫ������
function PutValueToE(value,ename)
{
	var ename = $Obj(ename);
	if(ename) ename.value = value;
}













/* input����ʾ����ʾ����

ʹ�÷���
 <label><span>��������ʾ����</span>
        <input type='text' name='goodscode' value='{dede:global.goodscode/}' style='width:120px' class='inputTips' />
        </label>
*/

 $(document).ready(function(){

     //�۽����������֤ 
   $("input[class*=inputTips]").each(function(){
   //$("#focus .inputTips").each(function(){
     var thisVal=$(this).val();
     //�ж��ı����ֵ�Ƿ�Ϊ�գ���ֵ�������������ʾ�û��ֵ����ʾ
     if(thisVal!=""){
       $(this).siblings("span").hide();
      }else{
       $(this).siblings("span").show();
      }
     $(this).focus(function(){
       $(this).siblings("span").hide();
      }).blur(function(){
        var val=$(this).val();
        if(val!=""){
         $(this).siblings("span").hide();
        }else{
         $(this).siblings("span").show();
        } 
      });
    })
     //�ж��ı����ֵ�Ƿ�Ϊ�գ���ֵ�������������ʾ�û��ֵ����ʾ
    $("#keydown .inputTips").each(function(){
     var thisVal=$(this).val();
     if(thisVal!=""){
       $(this).siblings("span").hide();
      }else{
       $(this).siblings("span").show();
      }
      $(this).keyup(function(){
       var val=$(this).val();
       $(this).siblings("span").hide();
      }).blur(function(){
        var val=$(this).val();
        if(val!=""){
         $(this).siblings("span").hide();
        }else{
         $(this).siblings("span").show();
        }
       })
     }) 
  })



-->