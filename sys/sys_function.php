<?php
/**
 *
 * @version        $Id: file_manage_main.php 1 8:48 2010��7��13��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_function.class.php");


/*

��

A�Ƿ�����
B�Ƿ���
C�Ƿ�Ӻ�
	 
	 
	 




//������INPUTѡ��������
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId Ԫ��INPUT checbox �� NAME id
//EnameByIdId  Ԫ��INPUT checbox �� ID id

	 �������е� A ѡ�� ��,�����ӹ���AΪ ѡ��
	 �������е� B ѡ�� ��,�����ӹ���BΪ ѡ��
	 �������е� C ѡ�� ��,�����ӹ���CΪ ѡ��



		// �������е� B��C ѡ���,����AΪ ��
	//	 �������е� A ѡ�� ��,�����ӹ���B��CΪ ��
 //�������е� C ѡ���,����BΪ ѡ��

		 //�������е� BΪ��,����CΪ ��











//�ӹ��ܵ�INPUTѡ��������
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId Ԫ��INPUT checbox �� NAME id
//EnameByIdId  Ԫ��INPUT checbox �� ID id
	    //�ӹ��ܵ���Aѡ���  ��Ӧ�е�B��C Ϊ��
		 //�ӹ��������е�A ѡ��� ������AΪ ѡ��
		  //�ӹ���A��һ�� �� ������A Ϊ��
		   //�ӹ��ܵ���B ѡ�� ��,������BΪ ѡ��, AΪ ��.��Ӧ�ӹ����е�AΪ ��
			 //�ӹ��ܵ���C ѡ�� ��,������CΪ ѡ��, AΪ ��.��Ӧ�ӹ����е�AΪ ��,BΪѡ��



ע�� input �ؼ��е�ID���ڵ�������ʱJS��ȡֵ
                   NAMe�м�[]������ҳ����ʾʱJS������ʾ
*/


//���µ�������
if(empty($dopost)) $dopost = '';
if($dopost=='upsysfunction')
{
	if($groups=='Ĭ�Ϲ���')$groups='';
    if($title==''){ ShowMsg("��ʾ���ⲻ��Ϊ�գ�", "-1");exit();}
    if($urladd==''){ ShowMsg("���ܵ�ַ����Ϊ�գ�", "-1");exit();}


	$sql="UPDATE `dede_sys_function` SET  `urladd`='$urladd', `groups`='$groups',`title`='$title', `disorder`='$disorder',  `ishidden`='$ishidden', `isshartcut`='$isshartcut', `isputred`='$isputred',  `remark`='$remark' WHERE id='$id' ";
	$dsql->ExecuteNoneQuery($sql);
    
    ShowMsg("�ɹ��޸�һ�����ݣ�", "sys_function.php");
    exit();
}

//����Ϊ��תҳ������תҳ��
if($dopost=='del')
{
    //1ɾ����admintype��webrole�����˹������Ƶ�Ȩ����
	$questr="SELECT urladd FROM `#@__sys_function` where  id='$id'";
	//echo $query;
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
	{
		$dirFileName=$rowarc["urladd"];
		//1.1���Ұ����˹������Ƶ�Ȩ����
		$query = "SELECT rank FROM `dede_sys_admintype` WHERE web_role like '%$dirFileName%'";	   //�˴������û�FIND_IN_SET  ��Ϊ������ֶ���û�ж��ŷָ�
		//dump($query);
		$db->SetQuery($query);
		$db->Execute(0);
		while($row1=$db->GetObject(0))
		{
			  
			  //1.2��ȡ �������� �ڴ�Ȩ����WEB_ROLE,�������ָ�Ϊ�����,��ȡ�˹��������������е�λ��
			  $groupSet = $dsql->GetOne("SELECT department_role,web_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='{$row1->rank}' ");
			  $groupWebRanks = explode('|', $groupSet['web_role']);
			  $groupDepRanks = explode('|', $groupSet['department_role']);
			  $funFileNameKey = array_search($dirFileName, $groupWebRanks);   //��ȡ �������� ���ڵļ�ֵ
			  if($funFileNameKey!=false)
			  {
				  // dump($funFileNameKey);  //???����Ҫ�ж�һ��,����û��,�򲻸���Ȩ��
				  //1.3��1.2��ȡ�ļ�ֵ �ֱ𽫶�Ӧ��web_role��dep_role��� Ȼ��������ϳ��ַ����������ݿ�
				  unset($groupWebRanks[$funFileNameKey]);   //�Ƴ���ֵ��Ӧ������
				  unset($groupDepRanks[$funFileNameKey]);
				  $All_webRole = implode("|",$groupWebRanks);  //������ϲ�Ϊ�ַ���
				  $All_depRole = implode("|",$groupDepRanks);
				  //���µ�Ȩ��ֵ���µ����ݿ�
				  $sql="UPDATE `#@__sys_admintype` SET web_role='$All_webRole',department_role='$All_depRole' WHERE CONCAT(`rank`)='{$row1->rank}'";
			      //dump( $sql);
			  }
			  //$dsql->ExecuteNoneQuery($sql);
		}
	}

    //2����Ƿ����ӹ���
	$questr="SELECT topid FROM `#@__sys_function` where  topid='$id'";
	//echo $query;
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
	{
		ShowMsg("ɾ��ʧ��,����ɾ���������ӹ��ܣ�","-1");
		exit(); 
	}

    //3 ɾ�����ܱ��е�����
	$id = trim(preg_replace("#[^0-9]#", '', $id));
	$dsql->ExecuteNoneQuery("delete from  `#@__sys_function`  where id='$id';");
	ShowMsg("ɾ���ɹ���","sys_function.php");
	exit();
}



//��������ʵ���ļ����ܵı�ע��Ϣ
if($dopost=='batupdate')
{
	
    $query = " SELECT id,topid FROM `#@__sys_function`   ";

    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
         // dump(  $row->id );
		  $id=$row->id;
		  $title=${'title'.$id};
		  if($title=="")$title="���޸ı���";
		  $disorder=${'disorder'.$id};
		  $urladd=${'urladd'.$id};
		  
		  if($row->topid==0)
		  {
			  $parentId_id=${'parentId_'.$id}; //����¼��ID
		  }
		  else
		  {
			  $parentId_id=${'parentId_'.$row->topid}; //����¼��ID
		  }
		 
		 
		  $ishidden=0;
		  //�жϵ�ǰ��¼��ishidden�Ƿ�ѡ��(��INPUT CHECKBOX�������ȡֵ,Ȼ���ж�)
		  //dump(${'ishidden'.$parentId_id});
		  if(!empty(${'ishidden'.$parentId_id}))
		  {
			  $nn = count(${'ishidden'.$parentId_id});  
			  for($n=0;$n < $nn;$n++)  
			  { 
				  if(${'ishidden'.$parentId_id}[$n]=='ishidden'.$id) {
					  $ishidden=1; 
							continue;
				  }
			  }
		  }

		  
		  
		  $isshartcut=0;
		  if(!empty(${'isshartcut'.$parentId_id}))
		  {
			  $nn = count(${'isshartcut'.$parentId_id});  
			  for($n=0;$n < $nn;$n++)  
			  { 
				  if(${'isshartcut'.$parentId_id}[$n]=='isshartcut'.$id) {
					  $isshartcut=1; 
							continue;
				  }
			  }  
		  }  
		  
		  
		  
		  
		  $isputred=0;
		  if(!empty(${'isputred'.$parentId_id}))
		  {
			  $nn = count(${'isputred'.$parentId_id});  
			  for($n=0;$n < $nn;$n++)  
			  { 
				  if(${'isputred'.$parentId_id}[$n]=='isputred'.$id) {
					  $isputred=1; 
							continue;
				  }
			  }  
		  }  
		  $remark=${'Remark'.$id};
		  $groups=${'groups'.$id};
		  
		  if($title=='')continue;   //�����ʾ����Ϊ��������
          if($groups=='Ĭ�Ϲ���')$groups='';
		  $sql="UPDATE `dede_sys_function` SET `urladd`='$urladd', `groups`='$groups',`title`='$title', `disorder`='$disorder',  `ishidden`='$ishidden', `isshartcut`='$isshartcut', `isputred`='$isputred',  `remark`='$remark' WHERE id='$id' ";
		  $dsql->ExecuteNoneQuery($sql);
//dump($sql);
				//echo "<br>����:". $sql;//exit();		
				
		  
       
    }
	
 



   ShowMsg("�ɹ����¶������ݣ�", "sys_function.php");

   exit();
}




























?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<style>
.linerow {
	border-bottom: 1px solid #CBD8AC;
	height: 24px
}
</style>
<script src="../js/jquery.min.js"></script>
<SCRIPT src="../js/dedeajax2.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../js/main.js"></SCRIPT>
<script type="text/javascript">

function updateItem(id)
{
	var upsysfunction = document.getElementById('upsysfunction');
   upsysfunction.urladd.value = $DE('urladd'+id).value;
   upsysfunction.groups.value = $DE('groups'+id).value;
   upsysfunction.title.value = $DE('title'+id).value;
   upsysfunction.disorder.value = $DE('disorder'+id).value;
   
	
	if($DE('ishidden'+id).checked){
		upsysfunction.ishidden.value =1
	}else{
		upsysfunction.ishidden.value =0
	} 
	if($DE('isshartcut'+id).checked){
		upsysfunction.isshartcut.value =1
	}else{
		upsysfunction.isshartcut.value =0
	} 
	if($DE('isputred'+id).checked){
		upsysfunction.isputred.value =1
	}else{
		upsysfunction.isputred.value =0
	} 
   
   
   
   upsysfunction.remark.value = $DE('Remark'+id).value;
   upsysfunction.id.value = id;
   if(upsysfunction.title.value==""){
          alert("��ʾ���Ʋ���Ϊ�գ�");
		  $DE('title'+id).focus();
          return false;
     }

   if(upsysfunction.urladd.value==""){
          alert("���ܵ�ַ����Ϊ�գ�");
		  $DE('urladd'+id).focus();
          return false;
     }
   
   
   upsysfunction.submit();
}





/*
A�Ƿ�����
     B�Ƿ���
	 C�Ƿ�Ӻ�
	 
	 
	 

*/



//������INPUTѡ��������
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId Ԫ��INPUT checbox �� NAME id
//EnameByIdId  Ԫ��INPUT checbox �� ID id
function dir_Sel(Ename,EnameByNameId,EnameByIdId)
{
    
	/*	 �������е� A ѡ�� ��,�����ӹ���AΪ ѡ��
	 �������е� B ѡ�� ��,�����ӹ���BΪ ѡ��
	 �������е� C ѡ�� ��,�����ӹ���CΪ ѡ��
*/
	var ems = document.getElementsByName(Ename+EnameByNameId+'[]');
	var oldstu=ems[0].checked;
    for(i=0; i < ems.length; i++)
    {
         ems[i].checked=oldstu;
    }
	
	
		// �������е� B��C ѡ���,����AΪ ��
	if(Ename!="ishidden")
	{
		var ems1 = document.getElementsByName('ishidden'+EnameByNameId+'[]');
	    //var oldstu=ems1[0].checked;
		if(oldstu)
		{
			for(i=0; i < ems1.length; i++)
			{
				 ems1[i].checked=false;
			}
		}
	}else
	//	 �������е� A ѡ�� ��,�����ӹ���B��CΪ ��
	{
		var ems2 = document.getElementsByName('isshartcut'+EnameByNameId+'[]');
		if(oldstu)
		{
			for(i=0; i < ems2.length; i++)
			{
				 ems2[i].checked=false;
			}
		}
		
		
		var ems3 = document.getElementsByName('isputred'+EnameByNameId+'[]');
		if(oldstu)
		{
			for(i=0; i < ems3.length; i++)
			{
				 ems3[i].checked=false;
			}
		}
		
		
	}
	
	
	
	 //�������е� C ѡ���,����BΪ ѡ��
	if(Ename=="isputred")
	{
		var ems4 = document.getElementsByName('isshartcut'+EnameByNameId+'[]');
		if(oldstu)
		{
			for(i=0; i < ems4.length; i++)
			{
				 ems4[i].checked=true;
			}
		}
	}

		 //�������е� BΪ��,����CΪ ��
	if(Ename=="isshartcut")
	{
		var ems5 = document.getElementsByName('isputred'+EnameByNameId+'[]');
		if(!oldstu)
		{
			for(i=0; i < ems5.length; i++)
			{
				 ems5[i].checked=false;
			}
		}
	}

}


	 

/*   
	 
	 
	 
*/
//�ӹ��ܵ�INPUTѡ��������
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId Ԫ��INPUT checbox �� NAME id
//EnameByIdId  Ԫ��INPUT checbox �� ID id

function file_Sel(Ename,EnameByNameId,EnameByIdId)
{
    var ems = document.getElementsByName(Ename+EnameByNameId+'[]');
   
   


	if(Ename=="ishidden")
	{
	    //�ӹ��ܵ���Aѡ���  ��Ӧ�е�B��C Ϊ��
		  $DE('isshartcut'+EnameByIdId).checked=false;
		  $DE('isputred'+EnameByIdId).checked=false;
		
		
		 //�ӹ��������е�A ѡ��� ������AΪ ѡ��
		  var oldstu=true;
		  for(i=1; i < ems.length; i++)
		  {
			 if(ems[i].checked==false){
				 ems[0].checked=false;
				 oldstu=false;
				 continue;
			   }
			  
		  //�ӹ���A��һ�� �� ������A Ϊ��
		  if(oldstu)ems[0].checked=true;
		  }
	}else if(Ename=="isshartcut")
	{
		   	var oldstu1=$DE('isshartcut'+EnameByIdId).checked;

		   //�ӹ��ܵ���B ѡ�� ��,������BΪ ѡ��, AΪ ��.��Ӧ�ӹ����е�AΪ ��
		   if(oldstu1){
			   ems[0].checked=true;
			   document.getElementsByName('ishidden'+EnameByNameId+'[]')[0].checked=false;
			   $DE('ishidden'+EnameByIdId).checked=false;
		   }else{
				 //�ӹ��ܵ���B ��   ��,��Ӧ�е�CΪ��
				$DE('isputred'+EnameByIdId).checked=false;
		   }
	
		}else if(Ename=="isputred")
		{

			 //�ӹ��ܵ���C ѡ�� ��,������CΪ ѡ��, AΪ ��.��Ӧ�ӹ����е�AΪ ��,BΪѡ��
			  var oldstu2=$DE('isputred'+EnameByIdId).checked;
  
			 if(oldstu2){
				 ems[0].checked=true;
				 document.getElementsByName('ishidden'+EnameByNameId+'[]')[0].checked=false;
				 $DE('ishidden'+EnameByIdId).checked=false;
				 $DE('isshartcut'+EnameByIdId).checked=true;
			 }

		}
	
	
}


</SCRIPT>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><div style="color:red"><img src='../images/ico/help.gif' /> �޸Ĵ�ҳ�����з��գ���С�Ĳ�����</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> ÿ�е�<strong>�Ƿ�����</strong>��ѡ��,����<strong>�Ƿ��ݷ�ʽ,�Ƿ�Ӻ�</strong>,����Զ�ȡ����ѡ</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> ÿ�е�<strong>�Ƿ��ݷ�ʽ</strong>ȡ����ѡ��,����<strong>�Ƿ�Ӻ�</strong>,����Զ�ȡ����ѡ</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> "������"��<strong>�Ƿ�����</strong>��ѡ��,�����������"�ӹ���"��<strong>�Ƿ��ݷ�ʽ,�Ƿ�Ӻ�</strong>,����Զ���ѡ</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> ���ܵ�ַ,<span style="color:red">������ɫ</span>����ʵ���ļ�������,��Ҫɾ��          </div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> ���ܵ�ַ,<span style="color:#FF0">������ɫ</span>������ļ�����ת����,����ֱ���ڴ�ҳ��ʾ,��Ҫɾ��)
            <div style="color:#333333"><img src='../images/ico/help.gif' /> �ӹ��������"�ĵ���Ϣ"�е�����Ŀ,��ϵͳ����ʾ������Ϊ��Ŀ����
            </div>
            </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-bottom:8px">
  <tr >
    <td  height="28"  width="150"  background='../images/tbg.gif'><div class="toolbox"> <a href="sys_function_add.php" >��Ӷ�������</a> </div></td>
  </tr>
</table>
<!--���ڵ������� .JS����ֵ-->
<form action='' name='upsysfunction' method='post' id='upsysfunction'  onSubmit="return checkSubmit();">
  <INPUT TYPE='hidden' NAME='id' value='' />
  <input type='hidden' name='dopost' value='upsysfunction' />
  <input type='hidden' name='urladd' value=''  />
  <input type='hidden' name='title' value=''  />
  <input type='hidden' name='groups'  />
  <input type='hidden' name='disorder'  />
  <input name='ishidden' type='hidden' >
  <input name='isshartcut' type='hidden' >
  <input name='isputred' type='hidden' >
  <input type='hidden' name='remark' />
</form>
<form name='form1' action='' method='post' >
  <table width='98%' border='0' cellspacing='1' cellpadding='0' align='center' style="background:#cfcfcf;" >
  <tr bgcolor="#cfcfcf" height="28" align="center">
    <td   height="35"  background="../images/tbg.gif" ><strong>��ʾ����</strong></td>
    <td background="../images/tbg.gif"><strong>����</strong></td>
    <td background="../images/tbg.gif"><strong>�Ƿ�����</strong></td>
    <td background="../images/tbg.gif"><strong>�Ƿ��ݷ�ʽ</strong></td>
    <td background="../images/tbg.gif"><strong>�Ƿ�Ӻ�</strong></td>
    <td background="../images/tbg.gif"><strong>��ע</strong></td>
    <td  background="../images/tbg.gif"><strong>����</strong></td>
  </tr>
  <?php 
$fun = new sys_function();
$funArray=$fun->getSysFunArray();
$parenti=0;
foreach ($funArray as $key=>$menu)
{
    $parenti++;

	$parentMenu=explode(',',$menu[0]);  
	$parentId=$parentMenu[0];
	$parentTitle=$parentMenu[3];
	$parentDis=$parentMenu[4];
	$parentIshidden=$parentMenu[5]==1? ' checked' : '';
	$parentIsshartcut=$parentMenu[6]==1? ' checked' : '';
	$parentIsputred=$parentMenu[7]==1? ' checked' : '';
	$parentRemark=$parentMenu[8];
	$parentIsbasefuc=$parentMenu[9];
 
    //���������
    $parentStr=  "<tr  bgcolor=\"#ffffff\"  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
      <td   style='padding-left:5px'>
	  <img style='cursor:pointer' id='img{$parentId}' onClick=\"showHideImg('info{$parentId}',{$parentId},'img{$parentId}');\" src='../images/explode.gif' width='11' height='11'>
					 <!--parentId  ������������ʱ��ȡishidden isshartcut isputred�ĸ���¼ID,��������ʱͨ����ID��ȡINPUT��״̬--> 
							  <input name='parentId_".$parentId."'  type='hidden' value='".$parentId."'>";
	  if($parentIsbasefuc==0)
	   {
		  $parentStr.=  " <input type='text' id='title{$parentId}'  name='title{$parentId}' value='{$parentTitle}' class='abt' />";
	   }else{
		  $parentStr.=  " {$parentTitle}<input  type=\"hidden\" id='title{$parentId}'  name='title{$parentId}' value='{$parentTitle}' class='abt' />";
	   }
	   
		
		$parentStr.="  </td>
      <td align='center'><input type='text' id='disorder{$parentId}'  name='disorder{$parentId}' value='{$parentDis}' class='abt'  style='width:20px'  />
        <input type='hidden' id='urladd{$parentId}' name='urladd{$parentId}' value='#'  />
        <input type='hidden' id='groups{$parentId}' name='groups{$parentId}' value=''  /></td>
      <td align='center'>";
	  if($parentIsbasefuc==0)
	   {
		  $parentStr.=  " <input name='ishidden{$parentId}[]' type='checkbox' class='np' id='ishidden{$parentId}'  value='ishidden{$parentId}'   {$parentIshidden}  onClick='dir_Sel(\"ishidden\",{$parentId},{$parentId})' >";
	   }else{
		   $parentStr.= $parentIshidden==' checked'? ' �� ' : ' �� ';
		  $parentStr.=  " <input name='ishidden{$parentId}[]'  style=\"display:none\"  type='checkbox' class='np' id='ishidden{$parentId}'  value='ishidden{$parentId}'   {$parentIshidden}  onClick='dir_Sel(\"ishidden\",{$parentId},{$parentId})' >";
	   }
	   
		
		
		$parentStr.="</td>
      <td align='center'><input name='isshartcut{$parentId}[]' type='checkbox' class='np' id='isshartcut{$parentId}'  value='isshartcut{$parentId}' {$parentIsshartcut}   onClick='dir_Sel(\"isshartcut\",{$parentId},{$parentId})' ></td>
      <td align='center'><input name='isputred{$parentId}[]' type='checkbox' class='np' id='isputred{$parentId}' value='isputred{$parentId}'  {$parentIsputred}  onClick='dir_Sel(\"isputred\",{$parentId},{$parentId})' ></td>
      <td align='center'><input type='text' id='Remark{$parentId}'  name='Remark{$parentId}' value='{$parentRemark}' class='abt' /></td>
      <td align='center'><a href='javascript:updateItem($parentId);'>����</a> 
			   
			 <a href=\"sys_function_add.php?topid={$parentId}&parentTitle={$parentTitle}\">����ӹ���</a> ";

		//���û���ӹ��ܣ����Ҳ���ϵͳ���ܣ���ʾɾ��
		
	   if(count($menu)==1&&$parentIsbasefuc==0)
	   {
		   $parentStr.=  " <a href='javascript:isdel(\"?dopost=del&id=\",{$parentId});'>ɾ��</a>";
	   }
	  
	  
	$parentStr.= "</td>
    </tr>";
	
	
	echo $parentStr;
	
	
	//����ӹ���
    $childStr= "<tr bgcolor='#FFFFFF' ><td  colspan='7'    id='info{$parentId}' style='padding:10px;display:none'>";


     if(count($menu)>1) 
	 {
			$childStr.= "  <table   width='98%'   border='0' cellspacing='1' cellpadding='0' align='center' style='background:#cfcfcf;'>
				<tr bgcolor='#cfcfcf'  height='35' align='center'>
				  <td background='../images/tbg.gif'><strong>��������</strong></td>
				  <td  background='../images/tbg.gif'><strong>��ʾ����</strong></td>
				  <td background='../images/tbg.gif'><strong>��������</strong></td>
				  <td background='../images/tbg.gif'><strong>���ܵ�ַ</strong></td>
				  <td background='../images/tbg.gif'><strong>�Ƿ�����</strong></td>
				  <td background='../images/tbg.gif'><strong>�Ƿ���</strong></td>
				  <td background='../images/tbg.gif'><strong>�Ƿ�Ӻ�</strong></td>
				  <td background='../images/tbg.gif'><strong>��ע</strong></td>
				  <td background='../images/tbg.gif'><strong>����</strong></td>
				</tr>";
				//���ӹ��ܲ˵����ӣ����������������
			for($childi=1;$childi<count($menu);$childi++)
			{
					$childMenu=explode(',',$menu[$childi]);  //��ȡ�ӹ�������
					$childId=$childMenu[0];
					$childUrladd=$childMenu[1];
					$childGroup=$childMenu[2]==""?'Ĭ�Ϲ���':$childMenu[2];
					$childTitle=$childMenu[3];
					$childDis=$childMenu[4];
					$childIshidden=$childMenu[5]==1? ' checked' : '';
					$childIsshartcut=$childMenu[6]==1? ' checked' : '';
					$childIsputred=$childMenu[7]==1? ' checked' : '';
					$childRemark=$childMenu[8];
					$childIsbasefuc=$childMenu[9];
		
					$childStr .= "\n<tr bgcolor='#FFFFFF'  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n
					 <!--parentId  ������������ʱ��ȡishidden isshartcut isputred�ĸ���¼ID,��������ʱͨ����ID��ȡINPUT��״̬--> 
							  <input name='parentId_".$parentId."'  type='hidden' value='".$parentId."'>";
					
					
					if($childIsbasefuc==0)
					 {

		
						  $childStr .= "<td align='center'><input type='text' id='groups".$childId."' name='groups".$childId."' value='".$childGroup."'  /></td>\r\n";
						  
						  $childStr .= " <td align='center'><input type='text' id='title".$childId."'  name='title".$childId."' value='".$childTitle."' class='abt' /></td>";
					 }else
					 {
						  $childStr .= "<td align='center'>$childGroup<input type='hidden' id='groups".$childId."' name='groups".$childId."' value='".$childGroup."'  /></td>\r\n";
						  
						  $childStr .= " <td align='center'>$childTitle<input type='hidden' id='title".$childId."'  name='title".$childId."' value='".$childTitle."' class='abt' /></td>";
						 
					 }
					$childStr .= " <td align='center'><strong>{$parenti}</strong>-<input type='text' id='disorder".$childId."'  name='disorder".$childId."' value='".$childDis."' size='5'  /></td>\r\n";



                    
					$bgcolor="";
					if(!UrlAddFileExists("../".$childUrladd))
					{
						$bgcolor=" bgcolor=\"#FF0000\"";  //���ʵ���ļ������� �򱳾���ʾ��ɫ
					}else
					{//���ʵ���ļ�����,���ж��Ƿ�Ϊ��ת����
							
					//dump($childUrladd);
					    
						//???141130 �˴������� ��� ϵͳ���ܽ���goods_edit.php������תҳ��,û������Ϊ��תҳ��,����ʾ���������Ҳ���
						//BUG��������ʱ �����ֲ��˴��� ???
						
						
						
						 //�ж��ļ��Ƿ���ת����,
						$filenameArray=explode('/',$childUrladd);
						$filename=ClearUrlAddParameter($filenameArray[1]); //�õ�������Ŀ¼���ļ���ַ���������ַ�а����Ĳ�������������������
						
						require_once("../baseconfig/sys_baseconfg.class.php");
						$fun = new sys_baseconfg();
						$oneBaseConfigs = $fun->getOneBaseConfig($filename);  //����Ŀѡ��
						$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
						
						if(count($oneBaseConfigsArray)>3)$isjeep=$oneBaseConfigsArray[3];
						if($isjeep==1)$bgcolor=" bgcolor=\"#FFFF00\"";  //�������ת�ļ�,����ʾ��ɫ����
					}
					






					if($childIsbasefuc==0)
					 {
						  $childStr .= "  <td align='center' $bgcolor><input type='text' id='urladd".$childId."'  name='urladd".$childId."' value='".$childUrladd."'  size='50'  />
						   </td>\r\n";
					 }
					 else
					 {
						  $childStr .= "  <td align='center' $bgcolor>$childUrladd
						   <input type='hidden' id='urladd".$childId."'  name='urladd".$childId."' value='".$childUrladd."'  size='50'  /></td>\r\n";
					 }
					 
					 
					
					if($childIsbasefuc==0)
					 {
		   
						  $childStr .= "  <td align='center'>";
						  $childStr .= "<input name='ishidden".$parentId."[]' type='checkbox' class='np' id='ishidden".$childId."' value='ishidden".$childId."'  onClick='file_Sel(\"ishidden\",".$parentId.",".$childId.")'  ".$childIshidden." ></td>\r\n";
					 }
					 else
					 {
						  $childStr .= "  <td align='center'>";
						  $childStr.= $childIshidden==' checked'? ' �� ' : ' �� ';

						  $childStr .= "<input style=\"display:none\" name='ishidden".$parentId."[]' type='checkbox' class='np' id='ishidden".$childId."' value='ishidden".$childId."'  onClick='file_Sel(\"ishidden\",".$parentId.",".$childId.")'  ".$childIshidden." ></td>\r\n";
					 }
					
					
					
					
					
					
					
					 $childStr .= " <td align='center'><input name='isshartcut".$parentId."[]' type='checkbox' class='np' id='isshartcut".$childId."'  value='isshartcut".$childId."'  onClick='file_Sel(\"isshartcut\",".$parentId.",".$childId.")' ".$childIsshartcut."  ></td>\r\n";
					
					 $childStr .= " <td align='center'><input name='isputred".$parentId."[]' type='checkbox' class='np' id='isputred".$childId."'  value='isputred".$childId."'   onClick='file_Sel(\"isputred\",".$parentId.",".$childId.")' ".$childIsputred."  ></td>\r\n";
					  
					  
					  
					  
					  
					 $childStr .= "  <td align='center'><input type='text' id='Remark".$childId."'  name='Remark".$childId."' value='".$childRemark."' class='abt' /></td>";
					 
					 $childStr .= "  <td align='center'> <a href='javascript:updateItem($childId);'>����</a> ";
					  //�������ϵͳ���ܣ����ɾ�� 
					 if($childIsbasefuc==0)
					 {
						 $childStr.= " <a href='javascript:isdel(\"?dopost=del&id=\",{$childId});'>ɾ��</a>";
					 }
		
					 $childStr .= "</td></tr>  ";
			}
			
			
			$childStr.="      </table>";
    }else
	{
			$childStr.="<div align=\"center\"><strong>���ӹ���</strong></div>";
		
		}
   
   
   
    $childStr.="  </td>
    </tr>";
	//$childs[$parentMenuTitle]=$retuStr_temp;  //�ӹ�������  HTMҳ����� 
	echo $childStr;
}

?>
  <tr bgcolor="#cfcfcf" height="35" align="center">
    <td colspan="12" background="../images/tbg.gif" >
      <input  type="hidden"  name="dopost" value='batupdate' class='abt' />
      <input name="imageField" type="submit" value="ȫ������" class='np coolbg' /></td>
  </tr>
  </table>
</form>
</body>
</html>
