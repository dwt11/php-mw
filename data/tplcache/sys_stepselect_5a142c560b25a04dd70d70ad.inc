<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<style>
li {
	float: left;
	padding-right: 8px;
	line-height: 24px;
}
.abt {
	width: 90%;
	border: 1px #ffffff solid
}
#edsta {
	position: absolute;
	top: 73px;
	left: 111px;
	width: 278px;
	height: 199px;
	background-color: #F9FCEF;
	border: 1px solid #dedede;
	display: none;
	padding: 3px;
}
#edsta div {
	margin: 5px;
}
</style>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script src="../js/dialog.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
var loadhtml = "<center><img src='../images/loadinglit.gif' style='padding:30px' /></center>";


//单条更新子类目
function updateItem(aid)
{
	var upenumf = document.getElementById('upenumf');
   upenumf.ename.value = $DE('ename'+aid).value;
   upenumf.evalue.value = $DE('evalue'+aid).value;
   upenumf.disorder.value = $DE('disorder'+aid).value;
   upenumf.aid.value = aid;
   upenumf.submit();
}



//获取当前的主类别id
function GetSelType()
{
  var selvalue = $DE('egroup1').options[$DE('egroup1').selectedIndex].value;
  return selvalue;
}





//编辑单个主类别
function EditType()
{
   var id = GetSelType();
   if(id==0) {
      alert("必须选择一个类别！");
      return false;
   }
   AlertMsg(event,'修改类别组','sys_stepselect.php?action=edit&id='+id);
}


//浏览单个 主类别 
function ViewType()
{
   var id = GetSelType();
   if(id==0) {
      alert("必须选择一个类别！");
      return false;
   }
   AlertMsg(event,'预览类别组','sys_stepselect.php?action=view&id='+id);
}


//删除单个主类别
function DelType()
{
  if(window.confirm("你确实要删除这个类别组吗？")==false) return false;
  var id = GetSelType();
  if(id==0) {
      alert("必须选择一个类别！");
      return false;
  }
  location.href='sys_stepselect.php?action=del&id='+id;
}

//选择组别后跳转页面(选择顶级)
function ChangePage(sobj)
{
    var ntxt = sobj.options[sobj.selectedIndex].text;
    if(sobj.options[sobj.selectedIndex].value==0)
    {
        location.href='sys_stepselect.php';
    }
    else
    {
        var ns = ntxt.split('|');
        location.href='sys_stepselect.php?egroup='+ns[0];
    }
}

//删除checkbox多选的子内容
function DelSel()
{
    if(window.confirm("你确实要删除这些吗？")) document.form1.submit();
}



//选择子内容后 跳转
function ChangePage2(sobj)
{
    var nv = sobj.options[sobj.selectedIndex].value;
    if(sobj.options[sobj.selectedIndex].value==0)
    {
        location.href='sys_stepselect.php?egroup=<?php echo $egroup; ?>';
    }
    else
    {
        location.href='sys_stepselect.php?egroup=<?php echo $egroup; ?>&reevalue='+nv;
    }
}

//-->
</SCRIPT>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<div id='edsta'>
  <center>
    <img src='../images/loadinglit.gif' />
  </center>
</div>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
  <tr>
    <td height="28"  background="../images/tbg.gif" ><div class="toolbox"><a href='sys_stepselect.php?action=upallcache'>更新所有缓存</a> <a onclick="AlertMsg(event,'添加类别组','sys_stepselect.php?action=addnew');" href="javascript:;">添加类别组</a> </div></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
  <tr>
    <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="85"><strong>请选择组别：</strong></td>
          <td width="264"><select name="egroup1" id="egroup1" style="width:90%;" onChange="ChangePage(this)">
              <option value='0'>--所有组--</option>
              <?php
            $selgroup = '';
            foreach($etypes as $arr)
            {
                $stylecolor = "";
                if($arr['issystem']==1) $stylecolor = " style='color:#999999' ";
                if($egroup==$arr['egroup']) {
                    $selgroup = $arr['itemname'];
                    echo "<option value='{$arr['id']}' $stylecolor selected='1'>{$arr['egroup']}|{$arr['itemname']}</option>\r\n";
                }
                else {
                    echo "<option value='{$arr['id']}' $stylecolor>{$arr['egroup']}|{$arr['itemname']}</option>\r\n";
                }
            }
        ?>
            </select></td>
          <td width="350"><a onclick="EditType()" href="javascript:;">修改</a> <a onclick="DelType()" href="javascript:;">删除</a> <a onclick="ViewType()" href="javascript:;">预览</a></td>
        </tr>
        <tr>
          <td colspan='3' height='24' style='color:#333333'><img src='../images/ico/help.gif' /> 灰色字的为系统内置，您是不能对它进行删除修改操作的，但可以添加或修改它的元素。</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
if(!empty($egroup))
{
    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_stepselect` WHERE egroup='{$egroup}' ");

    $options=getOptionsList($egroup,$reevalue);
    //dump()
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" style='margin-bottom:8px;'>
  <tr>
    <td height="28" background="../images/tbg.gif" colspan="8"><div style="float:left"> &nbsp; <b>子内容管理</b> </div></td>
  </tr>
 <form action='sys_stepselect.php' method='post'> <tr bgcolor="#ffffff" height='48'>
    <td>
    
        <INPUT TYPE="hidden" NAME="action" value="addenum_save" />
        <INPUT TYPE="hidden" NAME="issign" value="<?php echo $arr['issign']; ?>" />
        <INPUT TYPE="hidden" NAME="egroup" value="<?php echo $arr['egroup']; ?>" />
        <div style='float:left;'> <b>&nbsp;组&nbsp;&nbsp;名&nbsp;&nbsp;称：</b> <?php echo $selgroup; ?> <b>&nbsp;上级内容：</b>
          <select name='reevalue'  onChange="ChangePage2(this)">
            <option value='0'><?php echo $selgroup; ?>(顶级)...</option>
            <?php echo $options; ?>
          </select>
        </div>    
    &nbsp;</td>
  </tr>
  <tr bgcolor="#ffffff" height='48'>
    <td>
        
        <div style='float:left;'> <b>&nbsp;子内容名称：</b>
          <INPUT TYPE="text" NAME="ename" class="iptxt" style='width:350px' />
        </div>
        <div style='float:left;padding-left:6px'>
          <INPUT TYPE="submit" name='sb2' value="批量添加" class="np coolbg"/>
        </div>
        <div style='clear:both;color:#333333;line-height:24px;'> &nbsp;<img src='../images/ico/help.gif' /> 用半角逗号","分开可以一次添加多个子内容。 </div>
      </td>
  </tr></form>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="../images/tbg.gif" colspan="8"><div style="float:left"> <b>子内容列表</b> </div>
      <div style="float:right"></div></td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td>选择</td>
    <td>编号</td>
    <td >组别</td>
    <td >所属组名</td>
    <td>子内容名称(用于表单显示)</td>
    <td>子内容值<br>
      (用于数据表保存,修改此值后,会引起在对应的功能中,数据字典名称显示错误,请谨慎修改)</td>
    <td>组内排序</td>
    <td >操作</td>
  </tr>
  <form action='sys_stepselect.php' name='upenumf' method='post' id="upenumf">
    <input type='hidden' name='action' value='upenum' />
    <INPUT TYPE="hidden" NAME="aid" value="" />
    <input type='hidden' name='ename' value='' />
    <input type='hidden' name='evalue' value='' />
    <input type='hidden' name='disorder' value='' />
  </form>
  <form name='form1' action='sys_stepselect.php' method='post'>
    <input type='hidden' name='action' value='delenumAllSel' />
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
 
 
 
    <tr align="center" bgcolor="#FFFFFF" height="24" onMouseMove="javascript:this.bgColor='#FCFDEE';" 
        onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td><input type='checkbox' name='ids[]' value='<?php echo $fields['id']; ?>' class='np' /></td>
      <td><?php echo $fields['id']; ?></td>
      <td><?php echo getSunNumb($fields['egroup'],$fields['evalue']);?></td>
      <td><?php echo $fields['egroup']; ?></td>
      <td>
	  <input type='text' id='ename<?php echo $fields['id']; ?>' value='<?php echo $fields['ename']; ?>' class='abt' /></td>
      <td><input type='text' id='evalue<?php echo $fields['id']; ?>' value='<?php echo $fields['evalue']; ?>' class='abt' /></td>
      <td><input type='text' id='disorder<?php echo $fields['id']; ?>' value='<?php echo $fields['disorder']; ?>' class='abt' /></td>
      <td><?php
                if(!empty($egroup))
        {
        ?>
        <a href='javascript:updateItem(<?php echo $fields['id']; ?>);'>[更新]</a> <a href='javascript:isdel("sys_stepselect.php?action=delenum&id=",<?php echo $fields['id']; ?>);'>[删除]</a>
        <?php
         }
         else
         {
               echo "<a href='sys_stepselect.php?egroup={$fields['egroup']}'><u>".$egroups[$fields['egroup']]."</u></a>";
         }
        ?></td>
    </tr>
    
    <?php 
    //获取子内容
    LogicListAllSun($fields['egroup'],$fields['evalue'], "-");
    
}
}?>
  </form>
  <tr height="24">
    <td colspan="8" bgcolor="#ffffff">&nbsp; <a href="javascript:selAll('ids[]')" id="selAllBut" class="coolbg">全选</a> &nbsp; <a href='javascript:DelSel();' class='np coolbg'>删除所选</a></td>
  </tr>
  <tr >
    <td height="28" colspan="8"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
<?php
}
else
{
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="../images/tbg.gif" colspan="7"><div style="float:left"> &nbsp;·<a href='sys_stepselect.php'><b><u>组列表</u></b></a> </div>
      <div style="float:right"></div></td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td >编号</td>
    <td >所包含的级数</td>
    <td >英文组名<br>
      (用于程序读取取，必须唯一)</td>
    <td >显示组名<br>
      (用于表单显示)</td>
    <td >系统内置</td>
    <td >备注</td>
    <td>操作</td>
  </tr>
  <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
  <tr align="center" bgcolor="#FFFFFF" height="28" onMouseMove="javascript:this.bgColor='#FCFDEE';"  onMouseOut="javascript:this.bgColor='#FFFFFF';">
    <td> <?php echo $fields['id']; ?> </td>
    <td> 级数 </td>
    <td><strong><?php echo $fields['egroup']; ?></strong></td>
    <td align="left"><a href='sys_stepselect.php?egroup=<?php echo $fields['egroup']; ?>'><u><?php echo $fields['itemname']; ?></u></a></td>
    <td> <?php echo $fields['issystem']==1 ? '是' : '否'; ?> </td>
    <td align="left"><?php echo $fields['description']; ?></td>
    <td><a href='sys_stepselect.php?action=upallcache&egroup=<?php echo $fields['egroup']; ?>'>[更新缓存]</a> <a href='sys_stepselect.php?egroup=<?php echo $fields['egroup']; ?>'>[查看子内容]</a></td>
  </tr>
  <?php
}
}?>
  <tr >
    <td height="28" colspan="7"  background='../images/tbg.gif' align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
<?php
}
?>
</body>
</html>