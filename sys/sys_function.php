<?php
/**
 *
 * @version        $Id: file_manage_main.php 1 8:48 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_function.class.php");


/*

二

A是否隐藏
B是否快捷
C是否加红
	 
	 
	 




//父功能INPUT选择后的运作
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId 元素INPUT checbox 的 NAME id
//EnameByIdId  元素INPUT checbox 的 ID id

	 父功能行的 A 选择 后,所有子功能A为 选择
	 父功能行的 B 选择 后,所有子功能B为 选择
	 父功能行的 C 选择 后,所有子功能C为 选择



		// 父功能行的 B或C 选择后,所有A为 非
	//	 父功能行的 A 选择 后,所有子功能B和C为 非
 //父功能行的 C 选择后,所有B为 选择

		 //父功能行的 B为非,所有C为 非











//子功能的INPUT选择后的运作
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId 元素INPUT checbox 的 NAME id
//EnameByIdId  元素INPUT checbox 的 ID id
	    //子功能单行A选择后  对应行的B和C 为非
		 //子功能所有行的A 选择后 父功能A为 选择
		  //子功能A有一个 非 父功能A 为非
		   //子功能单行B 选择 后,父功能B为 选择, A为 非.对应子功能行的A为 非
			 //子功能单行C 选择 后,父功能C为 选择, A为 非.对应子功能行的A为 非,B为选择



注意 input 控件中的ID用于单条更新时JS获取值
                   NAMe中加[]的用于页面显示时JS联动显示
*/


//更新单个功能
if(empty($dopost)) $dopost = '';
if($dopost=='upsysfunction')
{
	if($groups=='默认功能')$groups='';
    if($title==''){ ShowMsg("显示标题不能为空！", "-1");exit();}
    if($urladd==''){ ShowMsg("功能地址不能为空！", "-1");exit();}


	$sql="UPDATE `dede_sys_function` SET  `urladd`='$urladd', `groups`='$groups',`title`='$title', `disorder`='$disorder',  `ishidden`='$ishidden', `isshartcut`='$isshartcut', `isputred`='$isputred',  `remark`='$remark' WHERE id='$id' ";
	$dsql->ExecuteNoneQuery($sql);
    
    ShowMsg("成功修改一个内容！", "sys_function.php");
    exit();
}

//设置为跳转页面或非跳转页面
if($dopost=='del')
{
    //1删除在admintype中webrole包含此功能名称的权限组
	$questr="SELECT urladd FROM `#@__sys_function` where  id='$id'";
	//echo $query;
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
	{
		$dirFileName=$rowarc["urladd"];
		//1.1查找包含此功能名称的权限组
		$query = "SELECT rank FROM `dede_sys_admintype` WHERE web_role like '%$dirFileName%'";	   //此处不能用户FIND_IN_SET  因为保存的字段里没有逗号分隔
		//dump($query);
		$db->SetQuery($query);
		$db->Execute(0);
		while($row1=$db->GetObject(0))
		{
			  
			  //1.2获取 功能名称 在此权限组WEB_ROLE,并把它分隔为数组后,获取此功能名称在数组中的位置
			  $groupSet = $dsql->GetOne("SELECT department_role,web_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='{$row1->rank}' ");
			  $groupWebRanks = explode('|', $groupSet['web_role']);
			  $groupDepRanks = explode('|', $groupSet['department_role']);
			  $funFileNameKey = array_search($dirFileName, $groupWebRanks);   //获取 功能名称 所在的键值
			  if($funFileNameKey!=false)
			  {
				  // dump($funFileNameKey);  //???这里要判断一下,发果没有,则不更新权限
				  //1.3按1.2获取的键值 分别将对应的web_role和dep_role清空 然后将数组组合成字符串存入数据库
				  unset($groupWebRanks[$funFileNameKey]);   //移除键值对应的数组
				  unset($groupDepRanks[$funFileNameKey]);
				  $All_webRole = implode("|",$groupWebRanks);  //将数组合并为字符串
				  $All_depRole = implode("|",$groupDepRanks);
				  //将新的权限值更新到数据库
				  $sql="UPDATE `#@__sys_admintype` SET web_role='$All_webRole',department_role='$All_depRole' WHERE CONCAT(`rank`)='{$row1->rank}'";
			      //dump( $sql);
			  }
			  //$dsql->ExecuteNoneQuery($sql);
		}
	}

    //2检测是否有子功能
	$questr="SELECT topid FROM `#@__sys_function` where  topid='$id'";
	//echo $query;
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
	{
		ShowMsg("删除失败,请先删除包含的子功能！","-1");
		exit(); 
	}

    //3 删除功能表中的数据
	$id = trim(preg_replace("#[^0-9]#", '', $id));
	$dsql->ExecuteNoneQuery("delete from  `#@__sys_function`  where id='$id';");
	ShowMsg("删除成功！","sys_function.php");
	exit();
}



//批量更新实体文件功能的备注信息
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
		  if($title=="")$title="请修改标题";
		  $disorder=${'disorder'.$id};
		  $urladd=${'urladd'.$id};
		  
		  if($row->topid==0)
		  {
			  $parentId_id=${'parentId_'.$id}; //父记录的ID
		  }
		  else
		  {
			  $parentId_id=${'parentId_'.$row->topid}; //父记录的ID
		  }
		 
		 
		  $ishidden=0;
		  //判断当前记录的ishidden是否被选择(用INPUT CHECKBOX的数组获取值,然后判断)
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
		  
		  if($title=='')continue;   //如果显示标题为空则跳过
          if($groups=='默认功能')$groups='';
		  $sql="UPDATE `dede_sys_function` SET `urladd`='$urladd', `groups`='$groups',`title`='$title', `disorder`='$disorder',  `ishidden`='$ishidden', `isshartcut`='$isshartcut', `isputred`='$isputred',  `remark`='$remark' WHERE id='$id' ";
		  $dsql->ExecuteNoneQuery($sql);
//dump($sql);
				//echo "<br>更新:". $sql;//exit();		
				
		  
       
    }
	
 



   ShowMsg("成功更新多条内容！", "sys_function.php");

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
          alert("显示名称不能为空！");
		  $DE('title'+id).focus();
          return false;
     }

   if(upsysfunction.urladd.value==""){
          alert("功能地址不能为空！");
		  $DE('urladd'+id).focus();
          return false;
     }
   
   
   upsysfunction.submit();
}





/*
A是否隐藏
     B是否快捷
	 C是否加红
	 
	 
	 

*/



//父功能INPUT选择后的运作
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId 元素INPUT checbox 的 NAME id
//EnameByIdId  元素INPUT checbox 的 ID id
function dir_Sel(Ename,EnameByNameId,EnameByIdId)
{
    
	/*	 父功能行的 A 选择 后,所有子功能A为 选择
	 父功能行的 B 选择 后,所有子功能B为 选择
	 父功能行的 C 选择 后,所有子功能C为 选择
*/
	var ems = document.getElementsByName(Ename+EnameByNameId+'[]');
	var oldstu=ems[0].checked;
    for(i=0; i < ems.length; i++)
    {
         ems[i].checked=oldstu;
    }
	
	
		// 父功能行的 B或C 选择后,所有A为 非
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
	//	 父功能行的 A 选择 后,所有子功能B和C为 非
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
	
	
	
	 //父功能行的 C 选择后,所有B为 选择
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

		 //父功能行的 B为非,所有C为 非
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
//子功能的INPUT选择后的运作
//Ename:ishidden,isshartcut ,isputred
//EnameByNameId 元素INPUT checbox 的 NAME id
//EnameByIdId  元素INPUT checbox 的 ID id

function file_Sel(Ename,EnameByNameId,EnameByIdId)
{
    var ems = document.getElementsByName(Ename+EnameByNameId+'[]');
   
   


	if(Ename=="ishidden")
	{
	    //子功能单行A选择后  对应行的B和C 为非
		  $DE('isshartcut'+EnameByIdId).checked=false;
		  $DE('isputred'+EnameByIdId).checked=false;
		
		
		 //子功能所有行的A 选择后 父功能A为 选择
		  var oldstu=true;
		  for(i=1; i < ems.length; i++)
		  {
			 if(ems[i].checked==false){
				 ems[0].checked=false;
				 oldstu=false;
				 continue;
			   }
			  
		  //子功能A有一个 非 父功能A 为非
		  if(oldstu)ems[0].checked=true;
		  }
	}else if(Ename=="isshartcut")
	{
		   	var oldstu1=$DE('isshartcut'+EnameByIdId).checked;

		   //子功能单行B 选择 后,父功能B为 选择, A为 非.对应子功能行的A为 非
		   if(oldstu1){
			   ems[0].checked=true;
			   document.getElementsByName('ishidden'+EnameByNameId+'[]')[0].checked=false;
			   $DE('ishidden'+EnameByIdId).checked=false;
		   }else{
				 //子功能单行B 非   后,对应行的C为非
				$DE('isputred'+EnameByIdId).checked=false;
		   }
	
		}else if(Ename=="isputred")
		{

			 //子功能单行C 选择 后,父功能C为 选择, A为 非.对应子功能行的A为 非,B为选择
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
          <td align="left"><div style="color:red"><img src='../images/ico/help.gif' /> 修改此页内容有风险，请小心操作！</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> 每行的<strong>是否隐藏</strong>勾选后,其后的<strong>是否快捷方式,是否加红</strong>,则会自动取消勾选</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> 每行的<strong>是否快捷方式</strong>取消勾选后,其后的<strong>是否加红</strong>,则会自动取消勾选</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> "父功能"的<strong>是否隐藏</strong>勾选后,其包含的所有"子功能"的<strong>是否快捷方式,是否加红</strong>,则会自动勾选</div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> 功能地址,<span style="color:red">背景红色</span>代表实际文件不存在,需要删除          </div>
            <div style="color:#333333"><img src='../images/ico/help.gif' /> 功能地址,<span style="color:#FF0">背景黄色</span>代表此文件是跳转功能,不能直接在此页显示,需要删除)
            <div style="color:#333333"><img src='../images/ico/help.gif' /> 子功能如果是"文档信息"中的子栏目,则系统中显示的名称为栏目名称
            </div>
            </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-bottom:8px">
  <tr >
    <td  height="28"  width="150"  background='../images/tbg.gif'><div class="toolbox"> <a href="sys_function_add.php" >添加顶级功能</a> </div></td>
  </tr>
</table>
<!--用于单条更新 .JS来赋值-->
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
    <td   height="35"  background="../images/tbg.gif" ><strong>显示名称</strong></td>
    <td background="../images/tbg.gif"><strong>排序</strong></td>
    <td background="../images/tbg.gif"><strong>是否隐藏</strong></td>
    <td background="../images/tbg.gif"><strong>是否快捷方式</strong></td>
    <td background="../images/tbg.gif"><strong>是否加红</strong></td>
    <td background="../images/tbg.gif"><strong>备注</strong></td>
    <td  background="../images/tbg.gif"><strong>操作</strong></td>
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
 
    //输出父功能
    $parentStr=  "<tr  bgcolor=\"#ffffff\"  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
      <td   style='padding-left:5px'>
	  <img style='cursor:pointer' id='img{$parentId}' onClick=\"showHideImg('info{$parentId}',{$parentId},'img{$parentId}');\" src='../images/explode.gif' width='11' height='11'>
					 <!--parentId  用于批量更新时获取ishidden isshartcut isputred的父记录ID,批量更新时通过此ID获取INPUT的状态--> 
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
		   $parentStr.= $parentIshidden==' checked'? ' √ ' : ' × ';
		  $parentStr.=  " <input name='ishidden{$parentId}[]'  style=\"display:none\"  type='checkbox' class='np' id='ishidden{$parentId}'  value='ishidden{$parentId}'   {$parentIshidden}  onClick='dir_Sel(\"ishidden\",{$parentId},{$parentId})' >";
	   }
	   
		
		
		$parentStr.="</td>
      <td align='center'><input name='isshartcut{$parentId}[]' type='checkbox' class='np' id='isshartcut{$parentId}'  value='isshartcut{$parentId}' {$parentIsshartcut}   onClick='dir_Sel(\"isshartcut\",{$parentId},{$parentId})' ></td>
      <td align='center'><input name='isputred{$parentId}[]' type='checkbox' class='np' id='isputred{$parentId}' value='isputred{$parentId}'  {$parentIsputred}  onClick='dir_Sel(\"isputred\",{$parentId},{$parentId})' ></td>
      <td align='center'><input type='text' id='Remark{$parentId}'  name='Remark{$parentId}' value='{$parentRemark}' class='abt' /></td>
      <td align='center'><a href='javascript:updateItem($parentId);'>更新</a> 
			   
			 <a href=\"sys_function_add.php?topid={$parentId}&parentTitle={$parentTitle}\">添加子功能</a> ";

		//如果没有子功能，并且不是系统功能，显示删除
		
	   if(count($menu)==1&&$parentIsbasefuc==0)
	   {
		   $parentStr.=  " <a href='javascript:isdel(\"?dopost=del&id=\",{$parentId});'>删除</a>";
	   }
	  
	  
	$parentStr.= "</td>
    </tr>";
	
	
	echo $parentStr;
	
	
	//输出子功能
    $childStr= "<tr bgcolor='#FFFFFF' ><td  colspan='7'    id='info{$parentId}' style='padding:10px;display:none'>";


     if(count($menu)>1) 
	 {
			$childStr.= "  <table   width='98%'   border='0' cellspacing='1' cellpadding='0' align='center' style='background:#cfcfcf;'>
				<tr bgcolor='#cfcfcf'  height='35' align='center'>
				  <td background='../images/tbg.gif'><strong>分组名称</strong></td>
				  <td  background='../images/tbg.gif'><strong>显示名称</strong></td>
				  <td background='../images/tbg.gif'><strong>组内排序</strong></td>
				  <td background='../images/tbg.gif'><strong>功能地址</strong></td>
				  <td background='../images/tbg.gif'><strong>是否隐藏</strong></td>
				  <td background='../images/tbg.gif'><strong>是否快捷</strong></td>
				  <td background='../images/tbg.gif'><strong>是否加红</strong></td>
				  <td background='../images/tbg.gif'><strong>备注</strong></td>
				  <td background='../images/tbg.gif'><strong>操作</strong></td>
				</tr>";
				//将子功能菜单连接，按分组存入数组中
			for($childi=1;$childi<count($menu);$childi++)
			{
					$childMenu=explode(',',$menu[$childi]);  //获取子功能数组
					$childId=$childMenu[0];
					$childUrladd=$childMenu[1];
					$childGroup=$childMenu[2]==""?'默认功能':$childMenu[2];
					$childTitle=$childMenu[3];
					$childDis=$childMenu[4];
					$childIshidden=$childMenu[5]==1? ' checked' : '';
					$childIsshartcut=$childMenu[6]==1? ' checked' : '';
					$childIsputred=$childMenu[7]==1? ' checked' : '';
					$childRemark=$childMenu[8];
					$childIsbasefuc=$childMenu[9];
		
					$childStr .= "\n<tr bgcolor='#FFFFFF'  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n
					 <!--parentId  用于批量更新时获取ishidden isshartcut isputred的父记录ID,批量更新时通过此ID获取INPUT的状态--> 
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
						$bgcolor=" bgcolor=\"#FF0000\"";  //如果实际文件不存在 则背景显示红色
					}else
					{//如果实际文件存在,则判断是否为跳转数据
							
					//dump($childUrladd);
					    
						//???141130 此处有问题 如果 系统功能界面goods_edit.php这种跳转页面,没有设置为跳转页面,则显示数组索引找不到
						//BUG故障重现时 又重现不了错误 ???
						
						
						
						 //判断文件是否跳转数据,
						$filenameArray=explode('/',$childUrladd);
						$filename=ClearUrlAddParameter($filenameArray[1]); //得到不包含目录的文件地址，并清除地址中包含的参数（？后的内容清除）
						
						require_once("../baseconfig/sys_baseconfg.class.php");
						$fun = new sys_baseconfg();
						$oneBaseConfigs = $fun->getOneBaseConfig($filename);  //供栏目选择
						$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
						
						if(count($oneBaseConfigsArray)>3)$isjeep=$oneBaseConfigsArray[3];
						if($isjeep==1)$bgcolor=" bgcolor=\"#FFFF00\"";  //如果是跳转文件,则显示黄色背景
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
						  $childStr.= $childIshidden==' checked'? ' √ ' : ' × ';

						  $childStr .= "<input style=\"display:none\" name='ishidden".$parentId."[]' type='checkbox' class='np' id='ishidden".$childId."' value='ishidden".$childId."'  onClick='file_Sel(\"ishidden\",".$parentId.",".$childId.")'  ".$childIshidden." ></td>\r\n";
					 }
					
					
					
					
					
					
					
					 $childStr .= " <td align='center'><input name='isshartcut".$parentId."[]' type='checkbox' class='np' id='isshartcut".$childId."'  value='isshartcut".$childId."'  onClick='file_Sel(\"isshartcut\",".$parentId.",".$childId.")' ".$childIsshartcut."  ></td>\r\n";
					
					 $childStr .= " <td align='center'><input name='isputred".$parentId."[]' type='checkbox' class='np' id='isputred".$childId."'  value='isputred".$childId."'   onClick='file_Sel(\"isputred\",".$parentId.",".$childId.")' ".$childIsputred."  ></td>\r\n";
					  
					  
					  
					  
					  
					 $childStr .= "  <td align='center'><input type='text' id='Remark".$childId."'  name='Remark".$childId."' value='".$childRemark."' class='abt' /></td>";
					 
					 $childStr .= "  <td align='center'> <a href='javascript:updateItem($childId);'>更新</a> ";
					  //如果不是系统功能，则可删除 
					 if($childIsbasefuc==0)
					 {
						 $childStr.= " <a href='javascript:isdel(\"?dopost=del&id=\",{$childId});'>删除</a>";
					 }
		
					 $childStr .= "</td></tr>  ";
			}
			
			
			$childStr.="      </table>";
    }else
	{
			$childStr.="<div align=\"center\"><strong>无子功能</strong></div>";
		
		}
   
   
   
    $childStr.="  </td>
    </tr>";
	//$childs[$parentMenuTitle]=$retuStr_temp;  //子功能数组  HTM页面调用 
	echo $childStr;
}

?>
  <tr bgcolor="#cfcfcf" height="35" align="center">
    <td colspan="12" background="../images/tbg.gif" >
      <input  type="hidden"  name="dopost" value='batupdate' class='abt' />
      <input name="imageField" type="submit" value="全部更新" class='np coolbg' /></td>
  </tr>
  </table>
</form>
</body>
</html>
