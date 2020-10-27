<!--









//判断浏览器类型    未找到使用的地方 随后可删除 140814
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










//1、元素的隐藏和显示 不带图标
//objname元素名称
function ShowHide(objname)
{
	var obj = $DE(objname);
	if(obj.style.display == "block" ||obj.style.display ==''||obj.style.display !='none') obj.style.display = "none";
	else obj.style.display = BROWSER.firefox? "" : "block";
}


//2、元素的隐藏和显示 带+ -图标
//objname元素名称
//tid元素ID,用于区分图片
//objimgname150116增加  用于区分设备和文档的下拉显示
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
















//---------------------------------3、设置行的隐藏和显示   tr的样式为 class='hid'

//显示正常内容COOKIE写为1 不显示写为空
//考勤审核界面有使用 是否显示正常内容开关



//3.1页面BODY中，加载时要判断COOKIE中的值，用以是否显示
//listname  表格名称,用于保存到COOK中来判断是那个功能页面的
function checkShowHidelist(listname)
{
	
	//setCookie('menuitems','');
	var ckstr = getCookie(listname);
	var trs = $("tr[class='hid']"); 
	
	if(ckstr==1)
	{
		for(i = 0; i < trs.length; i++){   
				
			  trs[i].style.display = '';
			  $("#hidchild").attr("checked",true);//显示的复选框打勾
		}	
	}else
	{
		for(i = 0; i < trs.length; i++){   
				//trs[i].style.display = "none"; //这里获取的trs[i]是DOM对象而不是jQuery对象，因此不能直接使用hide()方法 
		
				trs[i].style.display = 'none';
				$("#hidchild").attr("checked",false);//显示的复选框不打勾
		}	
	}
	
}




//3.2点击页面复选框后,隐藏和显示行,并将结果写入COOK
//listname  表格名称,用于保存到COOK中来判断是那个功能页面的
function showHidelist(listname)
{
	var trs = $("tr[class='hid']"); 
	for(i = 0; i < trs.length; i++){   
			//trs[i].style.display = "none"; //这里获取的trs[i]是DOM对象而不是jQuery对象，因此不能直接使用hide()方法 
	
		if(trs[i].style.display == 'block' || trs[i].style.display =='')
		{
			trs[i].style.display = 'none';
			setCookie(listname,'',7);
		}
		else
		{
			trs[i].style.display = '';
			setCookie(listname,'1',7);
			$("#hidchild").attr("checked",true);//显示的复选框打勾
		}//return true;
	}
}


//3.3读cookie函数
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

//3.4写cookie函数
function setCookie(listname,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = listname + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //使设置的有效时间正确。添加toGMTString()
}













//4、获得选中的INPUT，对CHECK进行全选和全否

//4.1获得选中的input
//inputname  checkbox的元素名称
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


//4.2反选列表中的input  并将按钮改名称
//inputname  checkbox的元素名称
//一个页面中一组CHECKBOX
function selAll(inputname){
	var inputs=document.getElementsByName(inputname);
	//var selAllButs=document.getElementsById(inputname);
	if(selAllBut.innerText=="全否"){
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = false;
		}
		 selAllBut.innerHTML="全选";
	}
	else {
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = true;
		}
		 selAllBut.innerHTML="全否";
	}
}



//4.3反选列表中的input  并将按钮改名称 150527添加用于积分选择员工时多选
//inputname  checkbox的元素名称
//一个页面中多组checkbox 供选择
function selAllMore(inputname){
	var inputs=document.getElementsByName(inputname);
	var selAllBut=document.getElementById(inputname);
	if(selAllBut.innerText=="全否"){
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = false;
		}
		 selAllBut.innerHTML="全选";
	}
	else {
		for(i=0;i<inputs.length;i++){
			inputs[i].checked = true;
		}
		 selAllBut.innerHTML="全否";
	}
}



//5、确认是否删除 
//actionUrl  跳转网址
//id         删除的编号
function isdel(actionUrl,id){
		if(confirm('您确定要删除此内容吗？')){
			location.href=actionUrl+id;
		}
	}






//6\选项卡切换
//tabname,切换的元素名称
//em当前元素记记数
//allgr元素总个数
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

//用户点击页面显示的连接,自动将连接中的值 插入页面中的inputk中
//value  源值
//ename  目标INPUT的元素名称
function PutValueToE(value,ename)
{
	var ename = $Obj(ename);
	if(ename) ename.value = value;
}













/* input中显示的提示文字

使用方法
 <label><span>这里是提示文字</span>
        <input type='text' name='goodscode' value='{dede:global.goodscode/}' style='width:120px' class='inputTips' />
        </label>
*/

 $(document).ready(function(){

     //聚焦型输入框验证 
   $("input[class*=inputTips]").each(function(){
   //$("#focus .inputTips").each(function(){
     var thisVal=$(this).val();
     //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
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
     //判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
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