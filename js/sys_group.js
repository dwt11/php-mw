function checkSubmit()
{
   if(document.form1.groupname.value==""){
          alert("�����Ʋ���Ϊ�գ�");
          document.form1.groupname.focus();
          return false;
     }
   if(document.form1.rank.value==""){
          alert("����ֵ����Ϊ�գ�");
          document.form1.rank.focus();
          return false;
     }
     return true;
}


//��ȫѡ
function row_Sel($rowi)
{
    
	
	var deps = document.getElementsByName('dep'+$rowi+'[]');
	var oldstu=deps[0].checked;
    for(i=0; i < deps.length; i++)
    {
         deps[i].checked=oldstu;
    }
	
}

//��ȫѡ
//$coli  ��ǰ�������,
//$rowNumb  Ҫȫѡ��������
function col_Sel($coli,$rowNumb)
{
    
	
	var files = document.getElementById('file_'+$coli);  //��ͷ,���ڻ�ȡԭʼ״̬
	var oldstu=files.checked;

    //������ܲ�������������  ���е�������0  ��ֻ�������ص�һ��checkbox��ѡ��״̬
	//������ܰ����������� ���е������ǲ��ŵ����� 
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
