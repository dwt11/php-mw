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


//������������Ŀ
function updateItem(aid)
{
	var upenumf = document.getElementById('upenumf');
   upenumf.ename.value = $DE('ename'+aid).value;
   upenumf.evalue.value = $DE('evalue'+aid).value;
   upenumf.disorder.value = $DE('disorder'+aid).value;
   upenumf.aid.value = aid;
   upenumf.submit();
}



//��ȡ��ǰ�������id
function GetSelType()
{
  var selvalue = $DE('egroup1').options[$DE('egroup1').selectedIndex].value;
  return selvalue;
}





//�༭���������
function EditType()
{
   var id = GetSelType();
   if(id==0) {
      alert("����ѡ��һ�����");
      return false;
   }
   AlertMsg(event,'�޸������','sys_stepselect.php?action=edit&id='+id);
}


//������� ����� 
function ViewType()
{
   var id = GetSelType();
   if(id==0) {
      alert("����ѡ��һ�����");
      return false;
   }
   AlertMsg(event,'Ԥ�������','sys_stepselect.php?action=view&id='+id);
}


//ɾ�����������
function DelType()
{
  if(window.confirm("��ȷʵҪɾ������������")==false) return false;
  var id = GetSelType();
  if(id==0) {
      alert("����ѡ��һ�����");
      return false;
  }
  location.href='sys_stepselect.php?action=del&id='+id;
}

//ѡ��������תҳ��(ѡ�񶥼�)
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

//ɾ��checkbox��ѡ��������
function DelSel()
{
    if(window.confirm("��ȷʵҪɾ����Щ��")) document.form1.submit();
}



//ѡ�������ݺ� ��ת
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
    <td height="28"  background="../images/tbg.gif" ><div class="toolbox"><a href='sys_stepselect.php?action=upallcache'>�������л���</a> <a onclick="AlertMsg(event,'���������','sys_stepselect.php?action=addnew');" href="javascript:;">���������</a> </div></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" style="margin-bottom:6px">
  <tr>
    <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="85"><strong>��ѡ�����</strong></td>
          <td width="264"><select name="egroup1" id="egroup1" style="width:90%;" onChange="ChangePage(this)">
              <option value='0'>--������--</option>
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
          <td width="350"><a onclick="EditType()" href="javascript:;">�޸�</a> <a onclick="DelType()" href="javascript:;">ɾ��</a> <a onclick="ViewType()" href="javascript:;">Ԥ��</a></td>
        </tr>
        <tr>
          <td colspan='3' height='24' style='color:#333333'><img src='../images/ico/help.gif' /> ��ɫ�ֵ�Ϊϵͳ���ã����ǲ��ܶ�������ɾ���޸Ĳ����ģ����������ӻ��޸�����Ԫ�ء�</td>
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
    <td height="28" background="../images/tbg.gif" colspan="8"><div style="float:left"> &nbsp; <b>�����ݹ���</b> </div></td>
  </tr>
 <form action='sys_stepselect.php' method='post'> <tr bgcolor="#ffffff" height='48'>
    <td>
    
        <INPUT TYPE="hidden" NAME="action" value="addenum_save" />
        <INPUT TYPE="hidden" NAME="issign" value="<?php echo $arr['issign']; ?>" />
        <INPUT TYPE="hidden" NAME="egroup" value="<?php echo $arr['egroup']; ?>" />
        <div style='float:left;'> <b>&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;�ƣ�</b> <?php echo $selgroup; ?> <b>&nbsp;�ϼ����ݣ�</b>
          <select name='reevalue'  onChange="ChangePage2(this)">
            <option value='0'><?php echo $selgroup; ?>(����)...</option>
            <?php echo $options; ?>
          </select>
        </div>    
    &nbsp;</td>
  </tr>
  <tr bgcolor="#ffffff" height='48'>
    <td>
        
        <div style='float:left;'> <b>&nbsp;���������ƣ�</b>
          <INPUT TYPE="text" NAME="ename" class="iptxt" style='width:350px' />
        </div>
        <div style='float:left;padding-left:6px'>
          <INPUT TYPE="submit" name='sb2' value="��������" class="np coolbg"/>
        </div>
        <div style='clear:both;color:#333333;line-height:24px;'> &nbsp;<img src='../images/ico/help.gif' /> �ð�Ƕ���","�ֿ�����һ�����Ӷ�������ݡ� </div>
      </td>
  </tr></form>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="../images/tbg.gif" colspan="8"><div style="float:left"> <b>�������б�</b> </div>
      <div style="float:right"></div></td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td>ѡ��</td>
    <td>���</td>
    <td >���</td>
    <td >��������</td>
    <td>����������(���ڱ�����ʾ)</td>
    <td>������ֵ<br>
      (�������ݱ�����,�޸Ĵ�ֵ��,�������ڶ�Ӧ�Ĺ�����,�����ֵ�������ʾ����,������޸�)</td>
    <td>��������</td>
    <td >����</td>
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
        <a href='javascript:updateItem(<?php echo $fields['id']; ?>);'>[����]</a> <a href='javascript:isdel("sys_stepselect.php?action=delenum&id=",<?php echo $fields['id']; ?>);'>[ɾ��]</a>
        <?php
         }
         else
         {
               echo "<a href='sys_stepselect.php?egroup={$fields['egroup']}'><u>".$egroups[$fields['egroup']]."</u></a>";
         }
        ?></td>
    </tr>
    
    <?php 
    //��ȡ������
    LogicListAllSun($fields['egroup'],$fields['evalue'], "-");
    
}
}?>
  </form>
  <tr height="24">
    <td colspan="8" bgcolor="#ffffff">&nbsp; <a href="javascript:selAll('ids[]')" id="selAllBut" class="coolbg">ȫѡ</a> &nbsp; <a href='javascript:DelSel();' class='np coolbg'>ɾ����ѡ</a></td>
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
    <td height="28" background="../images/tbg.gif" colspan="7"><div style="float:left"> &nbsp;��<a href='sys_stepselect.php'><b><u>���б�</u></b></a> </div>
      <div style="float:right"></div></td>
  </tr>
  <tr align="center" bgcolor="#FBFCE2" height="24">
    <td >���</td>
    <td >�������ļ���</td>
    <td >Ӣ������<br>
      (���ڳ����ȡȡ������Ψһ)</td>
    <td >��ʾ����<br>
      (���ڱ�����ʾ)</td>
    <td >ϵͳ����</td>
    <td >��ע</td>
    <td>����</td>
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
    <td> ���� </td>
    <td><strong><?php echo $fields['egroup']; ?></strong></td>
    <td align="left"><a href='sys_stepselect.php?egroup=<?php echo $fields['egroup']; ?>'><u><?php echo $fields['itemname']; ?></u></a></td>
    <td> <?php echo $fields['issystem']==1 ? '��' : '��'; ?> </td>
    <td align="left"><?php echo $fields['description']; ?></td>
    <td><a href='sys_stepselect.php?action=upallcache&egroup=<?php echo $fields['egroup']; ?>'>[���»���]</a> <a href='sys_stepselect.php?egroup=<?php echo $fields['egroup']; ?>'>[�鿴������]</a></td>
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