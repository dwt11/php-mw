function checkSubmit()
{
   if(document.form1.groupname.value==""){
          alert("组名称不能为空！");
          document.form1.groupname.focus();
          return false;
     }
   if(document.form1.rank.value==""){
          alert("级别值不能为空！");
          document.form1.rank.focus();
          return false;
     }
     return true;
}


//行全选
function row_Sel($rowi)
{
    
	
	var deps = document.getElementsByName('dep'+$rowi+'[]');
	var oldstu=deps[0].checked;
    for(i=0; i < deps.length; i++)
    {
         deps[i].checked=oldstu;
    }
	
}

//列全选
//$coli  当前点击的列,
//$rowNumb  要全选的总行数
function col_Sel($coli,$rowNumb)
{
    
	
	var files = document.getElementById('file_'+$coli);  //列头,用于获取原始状态
	var oldstu=files.checked;

    //如果功能不包含部门数据  则行的总数是0  则只操作隐藏的一个checkbox的选中状态
	//如果功能包含部门数据 则行的总数是部门的总数 
    if($rowNumb==0)
	{
			 var files_checkbox = document.getElementById('file_'+$coli+"_-100"); 
			 files_checkbox.checked=oldstu;
	}else
	{
		for(i=0; i < $rowNumb; i++)
		{
			 var files_checkbox = document.getElementById('file_'+$coli+"_"+i); 
			 files_checkbox.checked=oldstu;
		}
	}
}
