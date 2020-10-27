<!--

//左侧菜单使用
//子菜单 拉伸
function showHide(objname)
{

	var obj = document.getElementById(objname);
	var objsun = document.getElementById('sun'+objname);

		if(obj.style.display == 'block' || obj.style.display =='')
			{obj.style.display = 'none';
			objsun.className = 'bitem2';}
		else
		{	obj.style.display = 'block';
        objsun.className = 'bitem';}
		return true;

 
}




//主菜单 切换
var curitem = 1;
function ShowMainMenu(n)
{
	var curLink = $DE('link'+curitem);
	var targetLink = $DE('link'+n);
	var curCt = $DE('ct'+curitem);
	var targetCt = $DE('ct'+n);
	if(curitem==n) return false;
	if(targetCt.innerHTML!='')
	{
		curCt.style.display = 'none';
		targetCt.style.display = 'block';
		curLink.className = 'mm';
		targetLink.className = 'mmac';
		curitem = n;
	}
	else
	{
		var myajax = new DedeAjax(targetCt);
		myajax.SendGet2("index_menu_load.php?openitem="+n);
		if(targetCt.innerHTML!='')
		{
			curCt.style.display = 'none';
			targetCt.style.display = 'block';
			curLink.className = 'mm';
			targetLink.className = 'mmac';
			curitem = n;
		}
		DedeXHTTP = null;
	}
}

-->