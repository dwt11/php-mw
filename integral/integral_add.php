<?php
/**
 * 添加
 *
 * @version        $Id: spec_add.php 1 16:22 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");


if(empty($integral_empids_display ))$integral_empids_display ="";  //选中的员工ID


if(empty($dopost)) {
	
		if(empty($integral_class ))$integral_class ="";
		$gzOptions="";
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
		if($integral_class!=""){
		  // 如查选择了
			  global $dsql;
				   $gzOptions.="<option value='-1'>".strtoupper($integral_class)."分其他分值</option>";
			  $query="SELECT * FROM `#@__integral_guizhe` where gz_class='".$integral_class."' order by gz_id desc";
			  //dump($query);
			  $dsql->Execute('c', $query);
			  while($row = $dsql->GetArray('c'))
			  {
				$isaors="&nbsp;&nbsp;";
				if($row['gz_aors']=="add")$isaors="加";
				if($row['gz_aors']=="sub")$isaors="减";
				
			 
				   $gzOptions.="<option value='".$row['gz_id']."'>".$isaors." ".$row['gz_fz']."  ".$row['gz_name']."</option>";
			  }
			}
	$dopost = '';
}

/*------------------------
function getEmpMap_checbox() {  }
-------------------------
用于多选人员 积分中使用 输出checbox*/
else if($dopost=='getEmpMap_checkbox')
{
		require_once('../emp/emp.inc.class.checkbox.php');
		AjaxHead();
		//输出AJAX可移动窗体
		$divname = 'getEmpMap_checkbox';
		$tus = new empMapCheckbox();
	?>
<form name='quicksel' action='javascript:;' method='get'>
    <div class='quicksel'>
    <?php $tus->empAllCheckbox(); ?>
  </div>
  <div align='center' class='quickselfoot'><img src="../images/button_ok.gif" onClick="getSelCat('<?php echo $targetid; ?>','<?php echo $targetid_display; ?>');" width="60" height="22" class="np" border="0" style="cursor:pointer" />&nbsp;&nbsp;<img src="../images/button_back.gif" onclick='CloseMsg();' width="60" height="22" border="0"  style="cursor:pointer" /></div>
</form>
<?php
	//AJAX窗体结束
	exit();
}




/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
	$integral_empid=trim($integral_empid);
	$integral_empids=trim($integral_empids);
	$integral_date=trim($integral_date);
	$integral_gzid=trim($integral_gzid);
	$integral_class=trim($integral_class);
	
	$questr="SELECT * FROM `dede_integral_guizhe` where gz_id =".$integral_gzid;
					//dump($questr);
	$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
    {
		$integral_fz=$rowarc['gz_fz'];
		$integral_aors=$rowarc['gz_aors'];
		if($rowarc['gz_aors']=="sub")$integral_fz="-".$rowarc['gz_fz'];

	}
	
	
	//其他分值
	if($integral_gzid==-1)$integral_fz=$integral_qtfz;  //如果选“其他”  则保存手动输入值，用于初始积分
	$integral_bz=trim($integral_bz);
	$integral_markdate=date("Y-m-d", time());
		
    //如果是多选的员工
	if($integral_empids!="")
      {
		$empids = explode(',', $integral_empids);
        if(is_array($empids))
        {
            foreach($empids as $v)
            {
                if($v=='') continue;
               	$query = "
				 INSERT INTO `dede_integral` (`integral_empid`, `integral_date`, `integral_gzid`, `integral_class`, `integral_aors`, `integral_fz`, `integral_bz`, `integral_markdate`, `integral_czy`)
				  VALUES ('".$v."', '".$integral_date."', '".$integral_gzid."', '".$integral_class."', '".$integral_aors."', '".$integral_fz."', '".$integral_bz."', '".$integral_markdate."',".$cuserLogin->getUserID().")";
				
			 //dump($query);
			   
			   
				 if(!$dsql->ExecuteNoneQuery($query))
				{
					ShowMsg("添加数据时出错，请检查原因！", "-1");
					exit();
				}
   
            }
        }
	  }else
	  
	  {
				$query = "
				 INSERT INTO `dede_integral` (`integral_empid`, `integral_date`, `integral_gzid`, `integral_class`, `integral_aors`, `integral_fz`, `integral_bz`, `integral_markdate`, `integral_czy`)
				  VALUES ('".$integral_empid."', '".$integral_date."', '".$integral_gzid."', '".$integral_class."', '".$integral_aors."', '".$integral_fz."', '".$integral_bz."', '".$integral_markdate."',".$cuserLogin->getUserID().")";
				
			 // dump($query);
			   
			   
				 if(!$dsql->ExecuteNoneQuery($query))
				{
					ShowMsg("添加数据时出错，请检查原因！", "-1");
					exit();
				}
   
	  }
   
   
   ShowMsg("成功添加积分记录！","integral.php");
   exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script type="text/javascript" src="../include/My97DatePicker/WdatePicker.js"></script>
<script language='javascript' src="../js/dialog.js"></script>
<script language='javascript' src="../js/main.js"></script>
<script language="javascript">
function checkSubmit()
{
  
	 
	 //哪果未选择员工
	if((document.form1.integral_empid.value==0||document.form1.integral_empid.value==-100)&&document.form1.integral_empids.value=="")
	{
		alert('请选择员工！');
		return false;
	}
	 
	if(document.form1.integral_class.value=="")
	{
		alert('请选择积分类型！');
		return false;
	}
	 
     return true;
}


function ChangePage2()
{
    var nv = document.form1.integral_class.value;
    var empid = document.form1.integral_empid.value;
    var empids = document.form1.integral_empids.value;
    var empids_display = document.form1.integral_empids_display.value;
	var date=document.form1.integral_date.value;
  
        location.href='integral_add.php?integral_class='+nv+'&integral_empid='+empid+'&integral_empids='+empids+'&integral_empids_display='+empids_display+'&integral_date='+date;
    
}


//用于积分多选人员*/

//targetId保存到数据库
//targetId_display页面友好显示
function getSelCat(targetId,targetId_display)
{
	var selBox = document.quicksel.selempid;
	//var selBox = document.getElementById("selempid");
	var targetObj = $DE(targetId);
	var targetdisplayObj = $DE(targetId_display);
	var selvalue = '';
	var seldisplay = '';

	var j = 0;
	for(var i=0; i< selBox.length; i++)
	{
			if(selBox[i].checked) {
				j++;
				//if(j==10) break;//最多选择十个
				selvalue += (selvalue=='' ? selBox[i].value : ','+selBox[i].value);
				seldisplay += (seldisplay=='' ? selBox[i].nextSibling.nodeValue : ','+selBox[i].nextSibling.nodeValue);
			}
	}



	if(selvalue=='')
	{
		alert('你没有选中任何项目！');
		return ;
	}else if(targetObj) 
	{
		targetObj.value = selvalue;
		targetdisplayObj.value = seldisplay;
	
	}

	
	CloseMsg();

	
}

</script>

<!--//select界面选择框 自定义搜索功能150111添加-->
<script type="text/javascript" src="../js/jquery/jquery.selectseach.min.js"></script>
<script>
function getmydata(){
	alert($('#sssss').val());
}
$(document).ready(function(){
   $('select').selectseach(); 
}); 

</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><strong><?php echo $sysFunTitle?></strong></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
        <form name="form1" action="integral_add.php" method="post"    onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
          <tr>
            <td    width="10%" class="bline" align="right">&nbsp;<b>员工单选</b>：</td>
            <td  class="bline"><table>
                <tr>
                  <td width="200px"><?php
          if(empty($integral_empid))$integral_empid="";
		  
		  $EmpOptions = GetEmpOptionList($integral_empid);
          echo "<div style='width:300px'><span style='color:#999; float:right'>支持编号\汉字\拼音首字母搜索</span><select name='integral_empid' id='integral_empid'  m='search' >\r\n";
          echo "<option value='0'>请选择员工...</option>\r\n";
          echo $EmpOptions;
          echo "</select></div>";
			?></td>
                  <td>&nbsp;&nbsp;<b>员工多选</b>：<input type='hidden' name='integral_empids' id='integral_empids' value='<?php echo $integral_empids;?>'    style='width:200px;'  >
                    <input type='text' name='integral_empids_display' id='integral_empids_display' value='<?php echo $integral_empids_display;?>'    style='width:200px;'  onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_checkbox&targetid=integral_empids&targetid_display=integral_empids_display&rnd='+Math.random(),690,500)"   readonly="readonly" >
                    <a onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_checkbox&targetid=integral_empids&targetid_display=integral_empids_display&rnd='+Math.random(),690,500);" href="javascript:;"> <img src='../images/ico/search.gif' style='cursor:pointer;'  alt='选择人员' title='选择人员' /></a></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>积分日期</b>：</td>
            <td  class="bline"><?php
                  
          if(empty($integral_date))$integral_date="";
				  
				  if($integral_date==""){
                  
                    $nowtime =date("Y-m-d", time());
                    }
                    else
                    
                    {
                    $nowtime =$integral_date;
                    }
                    
                    
                          ?>
              <input type="text" name="integral_date" size="14" value="<?php echo $nowtime;?>" readonly class="Wdate"    onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>积分类型</b>：</td>
            <td  class="bline"><select name="integral_class" onChange='ChangePage2()'>
                <option value="">请选择</option>
                
               <?php for($i=65;$i<74;$i++)
			   { 
				   echo "<option value=".strtolower(chr($i))."";
				   if($integral_class== strtolower(chr($i)) )echo " selected='selected'";
				   echo ">".strtoupper(chr($i))."积分</option>";
			   
			   }?>
                
                </select></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>积分项目</b>：</td>
            <td  class="bline"><?php
          echo "<select name='integral_gzid' id='integral_gzid'   >\r\n";
          echo "<option value='0'>请选择规则...</option>\r\n";
          echo $gzOptions;
          echo "</select>";
			?></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>其他分值</b>：</td>
            <td  class="bline"><input type="text" name="integral_qtfz" size="30"   />
              积分项目选中“其他分值”才起作用 </td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>备注</b>：</td>
            <td  class="bline"><input type="text" name="integral_bz" size="30"   /></td>
          </tr>
          <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td ><input type="submit" name="Submit" value=" 保  存 " class="coolbg np" /></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
