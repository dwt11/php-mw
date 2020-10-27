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
//
//require_once(DEDEINC."/customfields.func.php");
//require_once(DEDEPATH."/inc/inc_archives_functions.php");
getconfig();
if(empty($dopost)) {
	
		require_once(DEDEPATH."/emp/emp.inc.options.php");	

	
	
		$salary_kq="";
		$salary_kqsm="";

		if($selectempid>0){
			// 如查选择了员工 则查询他的考勤 
				global $dsql;
				
				$questr1="SELECT emp_code FROM `#@__emp` where emp_id='".$selectempid."'";
				$rowarc1 = $dsql->GetOne($questr1);
				if(!is_array($rowarc1))
				{
						$salary_kq=0;
						$salary_kqsm="未查询到考勤记录";
				}
				else
				{
			 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
//dump($ejcd);
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=1 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					  ////dump($row);
					   $salary_kq = $row['dd']*$yjcd;  //一级迟到每次10元
					  if($row['dd']>0) $salary_kqsm="一级迟到".$row['dd']."次 ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=2 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$ejcd;  //一级迟到每次10元
					   if($row['dd']>0)  $salary_kqsm.="二级迟到".$row['dd']."次 ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=3 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$sjcd;  //一级迟到每次10元
					   if($row['dd']>0)  $salary_kqsm.="三级迟到".$row['dd']."次 ";
	
	
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=11 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$yjzt;  //一级迟到每次10元
					  if($row['dd']>0)   $salary_kqsm="一级早退".$row['dd']."次 ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=12 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$ejzt;  //一级迟到每次10元
					  if($row['dd']>0)   $salary_kqsm.="二级早退".$row['dd']."次 ";
	
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=13 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$sjzt;  //一级迟到每次10元
					   if($row['dd']>0)  $salary_kqsm.="三级早退".$row['dd']."次 ";
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=21 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$kgbt;  //一级迟到每次10元
					   if($row['dd']>0)  $salary_kqsm.="旷工半天".$row['dd']."次 ";
	
					  $row = $dsql->GetOne("Select count(*) as dd  From `dede_checkin`  where kq_hw_empcode=".$rowarc1['emp_code']." and  kq_zt=22 and  date_format(kq_hw_emptime, '%Y-%m-%d') = '$date'");
					   $salary_kq += $row['dd']*$kgyt;  //一级迟到每次10元
					   if($row['dd']>0)  $salary_kqsm.="旷工一天".$row['dd']."次 ";
	
	
	
						if($salary_kqsm=="")  $salary_kqsm="未查询到违规考勤记录 ";
				
				}
			
			
			}
	$dopost = '';
}




/*------------------------
function getCatMap() {  }
-------------------------
用于单选人员-输出radio 工资中使用*/
else if($dopost=='getEmpMap_radio')
{
		require_once('../emp/emp.inc.class.radio.php');
		AjaxHead();
		//输出AJAX可移动窗体
		$divname = 'getEmpMap_radio';
		$tus = new empMapRadio();
	?>
<form name='quicksel' action='javascript:;' method='get'>
  <div class='quicksel'>
    <?php $tus->empAllRadio(); ?>
  </div>
  <div align='center' class='quickselfoot'><img src="../images/button_ok.gif" onClick="getSelCat('<?php echo $targetid; ?>','<?php echo $targetid_display; ?>');" width="60" height="22" class="np" border="0" style="cursor:pointer" />&nbsp;&nbsp;<img src="../images/button_back.gif" onclick='CloseMsg();' width="60" height="22" border="0"  style="cursor:pointer" /></div>
</form>
<?php
	//AJAX窗体结束
	exit();
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
    
	
	
	
	$salary_empid=trim($salary_empid); 
	$salary_empids=trim($salary_empids); 


/*此段已经没有用了,改为可多选员工150111
    //如果是快速选择器选择的员工
	if($salary_empids!="")
      {
	$salary_empid=$salary_empids; 

	  }
	$salary_yf=trim($salary_yf); 
*/	
	
/*此段已经没有用了,改为按天 添加  并可添加多条150111
	$questr="SELECT salary_empid FROM `dede_salary` where salary_hy='".$salary_yf."' and salary_empid =".$salary_empid;
			////dump($questr);
			$rowarc = $dsql->GetOne($questr);
	if(is_array($rowarc))
    {
		ShowMsg("所选月份已经存在此员工的工资！","-1");
		exit(); 
	}
*/		
    
	$salary_jb=(double)trim($salary_jb); 
	$salary_jbsm=trim($salary_jbsm); 
	$salary_jj=(double)trim($salary_jj); 
	$salary_jjsm=trim($salary_jjsm); 
	$salary_hs=(double)trim($salary_hs); 
	$salary_hssm=trim($salary_hssm); 
	$salary_kq=(double)trim($salary_kq); 
	$salary_kqsm=trim($salary_kqsm); 
	$salary_qtsub=(double)trim($salary_qtsub); 
	$salary_qtsubsm=trim($salary_qtsubsm); 
	$salary_qtadd=(double)trim($salary_qtadd); 
	$salary_qtaddsm=trim($salary_qtaddsm); 
	$salary_markdate= date("Y-m-d", time());; 
	$salary_yfmoney=$salary_jb+$salary_jj-$salary_hs-$salary_kq-$salary_qtsub+$salary_qtadd;


    setcookie("SALARY_YF_COOK",$salary_yf,time()+3600*12,"/");   //150122客户每次添加工资时,不是当天的日期,所以这里将日期保存,然后下次添加时读取COOKIE(保存12个小时)

    //如果是多选的员工
	if($salary_empids!="")
      {
		$empids = explode(',', $salary_empids);
        if(is_array($empids))
        {
            foreach($empids as $v)
            {
                if($v=='') continue;
				
				  $query = "
				   INSERT INTO `dede_salary` (salary_empid,salary_yf,salary_jb,salary_jbsm,salary_jj,salary_jjsm,salary_hs,salary_hssm,salary_kq,salary_kqsm,salary_qtsub,salary_qtsubsm,salary_qtadd,salary_qtaddsm,salary_czy,salary_markdate,salary_lqdate,salary_lqname,salary_yfmoney,salary_sf)
									VALUES (".$v.", '".$salary_yf."', '".$salary_jb."', '".$salary_jbsm."', '".$salary_jj."', '".$salary_jjsm."', '".$salary_hs."', '".$salary_hssm."','".$salary_kq."', '".$salary_kqsm."', '".$salary_qtsub."', '".$salary_qtsubsm."', '".$salary_qtadd."', '".$salary_qtaddsm."', ".$cuserLogin->getUserID().", '".$salary_markdate."', null,null, '".$salary_yfmoney."',null);
				  ";
			   
			   
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
			 INSERT INTO `dede_salary` (salary_empid,salary_yf,salary_jb,salary_jbsm,salary_jj,salary_jjsm,salary_hs,salary_hssm,salary_kq,salary_kqsm,salary_qtsub,salary_qtsubsm,salary_qtadd,salary_qtaddsm,salary_czy,salary_markdate,salary_lqdate,salary_lqname,salary_yfmoney,salary_sf)
							  VALUES (".$salary_empid.", '".$salary_yf."', '".$salary_jb."', '".$salary_jbsm."', '".$salary_jj."', '".$salary_jjsm."', '".$salary_hs."', '".$salary_hssm."','".$salary_kq."', '".$salary_kqsm."', '".$salary_qtsub."', '".$salary_qtsubsm."', '".$salary_qtadd."', '".$salary_qtaddsm."', ".$cuserLogin->getUserID().", '".$salary_markdate."', null,null, '".$salary_yfmoney."',null);
			";
			 if(!$dsql->ExecuteNoneQuery($query))
			{
				ShowMsg("添加数据时出错，请检查原因！", "-1");
				exit();
			}
	  }
	
	
	
	
	
   
    ShowMsg("成功添加员工工资！",$ENV_GOBACK_URL);
    exit();
}

//获取考勤扣款规则  全局
function getconfig()
 {  
 
 			global $dsql;

 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$kgbt,$kgyt;
	  $yjcd=0;//一级迟到</td>
          $ejcd=0;//二级迟到</td>
		  $sjcd=0;//三级迟到</td>
          
		  $yjzt=0;//一级早退</td>
		 $ejzt=0;//二级早退</td>
         $sjzt=0;//三级早退</td>

  $arcQuery = "SELECT *  from #@__salary_config  WHERE id='1' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("读取信息出错!","-1");
        exit();
    }else{
		  
		  
		  $yjcd=$arcRow['yjcd'];//一级迟到</td>
          $ejcd=$arcRow['ejcd'];//二级迟到</td>
		  $sjcd=$arcRow['sjcd'];//三级迟到</td>
          
		  $yjzt=$arcRow['yjzt'];//一级早退</td>
		 $ejzt=$arcRow['ejzt'];//二级早退</td>
         $sjzt=$arcRow['sjzt'];//三级早退</td>

         $kgbt=$arcRow['kgbt'];//三级早退</td>
         $kgyt=$arcRow['kgyt'];//三级早退</td>
	//dump($ejcd);	
		}
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
<script src="../js/main.js"></script>
<script language="javascript">
function checkSubmit()
{
	 //哪果未选择员工
	if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100)&&document.form1.salary_empids.value=="")
	
	//单选150111注销改为多选
	//if((document.form1.salary_empid.value==0||document.form1.salary_empid.value==-100))
	{
		alert('请选择员工！');
		return false;
	}
	 
     return true;
}


function ChangePage2(sobj)
{
    var nv = document.form1.salary_empid.value;
	var date=document.form1.salary_yf.value;
    var nv_display = document.form1.salary_empids_display.value;
   // var empids = document.form1.integral_empids.value;
    if(nv_display=="")
    {
		if(nv!=-100)
		{
			//location.href='salary_add.php?selectempid='+nv+'&salary_empids='+empids+'&date='+date;
			//location.href='salary_add.php?selectempid='+nv+'&date='+date;
			location.href='salary_add.php?selectempid='+nv+'&date='+date;
		}
		else
		{
			alert('请选择员工,你当前选择的是部门！');
		}
	}
}
/*此段无用
function ChangePage2_d(sobj)
{
    var nvs = document.form1.salary_empids.value;
    var nvs_display = document.form1.salary_empids_display.value;
	if(nvs!=null)nv=nvs;
	var date=document.form1.salary_yf.value;
   // var empids = document.form1.integral_empids.value;
    if(nv!=-100)
    {
        //location.href='salary_add.php?selectempid='+nv+'&salary_empids='+empids+'&date='+date;
		location.href='salary_add.php?selectempid='+nv+'&selectempid_display='+nv_display+'&date='+date;
    }
}
*/






/*/单选150111注销改为多选用于在弹出框单选人员后将值给到input
//targetId保存到数据库
//targetId_display页面友好显示
function getSelCat(targetId,targetId_display)
{
	var selBox = document.quicksel.selempid;
	var targetObj = $DE(targetId);
	var selvalue = '';
	var seldisplay = '';

	for(var i=0; i< selBox.length; i++)
	{
			if(selBox[i].checked) {
				seldisplay =  selBox[i].nextSibling.nodeValue;
				selvalue =  selBox[i].value;
				 break;
			}
	}
	if(selvalue=='')
	{
		alert('你没有选中任何项目！');
		return ;
	}else	if(targetObj)
	{
	   	var date=document.form1.salary_yf.value;
		// var empids = document.form1.integral_empids.value;
		location.href='salary_add.php?selectempid='+selvalue+'&selectempid_display='+seldisplay+'&date='+date;
	 }
}
*/




//用于多选人员1450111添加*/

//targetId保存到数据库
//targetId_display页面友好显示
function getSelCat(targetId,targetId_display)
{
	var selBox = document.quicksel.selempid;
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

<!--//select界面选择框 自定义搜索功能-->
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
        <form name="form1" action="salary_add.php" method="post"    onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="save" />
          <tr>
            <td    width="10%" class="bline" align="right">&nbsp;<b>员工单选</b>：</td>
            <td  class="bline"><table>
                <tr>
                  <td width="200px"><span id='typeidct'>
                    <?php
          $EmpOptions = GetEmpOptionList($selectempid);
          echo "<div style='width:300px'><span style='color:#999; float:right'>支持编号\汉字\拼音首字母搜索</span><select name='salary_empid' id='salary_empid'  onChange='ChangePage2()'  m='search'>\r\n";
          echo "<option value='0'>请选择员工...</option>\r\n";
          echo $EmpOptions;
          echo "</select></div>";
			?>
                    </span></td>
                  <td><input type='hidden' name='salary_empids' id='salary_empids' value='<?php echo $selectempid;?>'  >
                    
                    <!-- 单选员工

             <input type='text' name='salary_empids_display' id='salary_empids' value='<?php echo $selectempid_display;?>'    style='width:100px;'  onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_radio&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500)"   readonly="readonly" >
                     <a onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_radio&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500);" href="javascript:;">
--> 
                    &nbsp;&nbsp;<b>员工多选</b>：
                    <input type='text' name='salary_empids_display' id='salary_empids_display' value='<?php echo $selectempid_display;?>'    style='width:200px;'  onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_checkbox&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500)"   readonly="readonly" >
                    <a onClick="AlertMsg(event,'选择员工','?dopost=getEmpMap_checkbox&targetid=salary_empids&targetid_display=salary_empids_display&rnd='+Math.random(),690,500);" href="javascript:;"> <img src='../images/ico/search.gif' style='cursor:pointer;'  alt='选择人员' title='选择人员' /></a> <span style="color:#999">如果多选员工,则自动考勤扣款功能失效</span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>日期</b>：</td>
            <td  class="bline"><?php
				  if($date==""){
                  
				       //如果cook保存有上一次添加的日期  则使用上一次的
					   //否则使用服务器的当前日期
                       if($SALARY_YF_COOK=="")
					   {
						     $nowtime =date("Y-m-d", time());
					   }else
					   {
						     $nowtime =$SALARY_YF_COOK;
					   }
                    }
                    else
                    
                    {
                    $nowtime =$date;
                    }
                    
                   
                          ?>
              <input type="text" name="salary_yf" size="14" value="<?php echo $nowtime;?>" readonly class="Wdate"  onChange='ChangePage2(this)'  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-{%d-5}'})"/></td>
            
            <!--  <input type="text" name="salary_yf" size="14" value="<?php echo $nowtime;?>" readonly="readonly" class="Wdate"    onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})"/>
   --> 
            
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>基本工资</b>：</td>
            <td  class="bline"><input type="text" name="salary_jb" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
              <input type="text" name="salary_jbsm" size="30"   /></td>
          </tr>
          
          <!--  <tr>
            <td    class="bline" align="right">&nbsp;<b>资金</b>：</td>
            <td  class="bline">
              <input type="text" name="salary_jj" size="10"   />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
                            <input type="text" name="salary_jjsm" size="30"   />

              </td>
          </tr>



              <tr>
            <td   class="bline" align="right">&nbsp;<b>伙食费</b>：</td>
            <td  class="bline">
              <input type="text" name="salary_hsf" size="10"   />
              
              
              
              
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
                            <input type="text" name="salary_hsfsm" size="30"   />

              </td>
          </tr>


-->
          <tr>
            <td   class="bline" align="right">&nbsp;<b>考勤</b>：</td>
            <td  class="bline"><input type="text" name="salary_kq" size="10"  value="<?php echo $salary_kq?>"  />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
              <input type="text" name="salary_kqsm" size="30"  value="<?php echo $salary_kqsm?>"   /></td>
          </tr>
          <tr>
            <td    class="bline" align="right">&nbsp;<b>其他添加</b>：</td>
            <td  class="bline"><input type="text" name="salary_qtadd" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
              <input type="text" name="salary_qtaddsm" size="30"   /></td>
          </tr>
          <tr>
            <td   class="bline" align="right">&nbsp;<b>其他减少</b>：</td>
            <td  class="bline"><input type="text" name="salary_qtsub" size="10"   />
              &nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;<b>说明</b>：
              <input type="text" name="salary_qtsubsm" size="30"   /></td>
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
