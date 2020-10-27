<?php
/**
 * ϵͳ����
 *
 * @version        $Id: sys_info.php 1 22:28 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

if(empty($dopost)) $dopost = "";

$configfile = DEDEDATA.'/config.cache.inc.php';

//�������ú���
function ReWriteConfig()
{
    global $dsql,$configfile;
    if(!is_writeable($configfile))
    {
        echo "�����ļ�'{$configfile}'��֧��д�룬�޷��޸�ϵͳ���ò�����";
        exit();
    }
    $fp = fopen($configfile,'w');
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
    $dsql->SetQuery("SELECT `varname`,`type`,`value`,`groupid` FROM `#@__sys_sysconfig` where aid<1000 ORDER BY aid ASC ");//150128���aid�ж�  ����ע���������Ϣд�뻺�� �ļ�
    $dsql->Execute();
    while($row = $dsql->GetArray())
    {
        if($row['type']=='number')
        {
            if($row['value']=='') $row['value'] = 0;
            fwrite($fp,"\${$row['varname']} = ".$row['value'].";\r\n");
        }
        else
        {
            fwrite($fp,"\${$row['varname']} = '".str_replace("'",'',$row['value'])."';\r\n");
        }
    }
    fwrite($fp,"?".">");
    fclose($fp);
}

//�������õĸĶ�
if($dopost=="save")
{
    foreach($_POST as $k=>$v)
    {
        if(preg_match("#^edit___#", $k))
        {
            $v = cn_substrR(${$k}, 1024);
        }
        else
        {
            continue;
        }
        $k = preg_replace("#^edit___#", "", $k);
        $dsql->ExecuteNoneQuery("UPDATE `#@__sys_sysconfig` SET `value`='$v' WHERE varname='$k' ");
    }
    ReWriteConfig();
    ShowMsg("�ɹ�����վ�����ã�", "sys_info.php");
    exit();
}
//����±���
else if($dopost=='add')
{
    if($vartype=='bool' && ($nvarvalue!='Y' && $nvarvalue!='N'))
    {
        ShowMsg("��������ֵ����Ϊ'Y'��'N'!","-1");
        exit();
    }
    if(trim($nvarname)=='' || preg_match("#[^a-z_]#i", $nvarname) )
    {
        ShowMsg("����������Ϊ�ղ��ұ���Ϊ[a-z_]���!","-1");
        exit();
    }
    $row = $dsql->GetOne("SELECT varname FROM `#@__sys_sysconfig` WHERE varname LIKE '$nvarname' ");
    if(is_array($row))
    {
        ShowMsg("�ñ��������Ѿ�����!","-1");
        exit();
    }
    $row = $dsql->GetOne("SELECT aid FROM `#@__sys_sysconfig` ORDER BY aid DESC ");
    $aid = $row['aid'] + 1;
    $inquery = "INSERT INTO `#@__sys_sysconfig`(`aid`,`varname`,`info`,`value`,`type`,`groupid`)
    VALUES ('$aid','$nvarname','$varmsg','$nvarvalue','$vartype','$vargroup')";
    $rs = $dsql->ExecuteNoneQuery($inquery);
    if(!$rs)
    {
        ShowMsg("��������ʧ�ܣ������зǷ��ַ���", "sys_info.php?gp=$vargroup");
        exit();
    }
    if(!is_writeable($configfile))
    {
        ShowMsg("�ɹ���������������� $configfile �޷�д�룬��˲��ܸ��������ļ���","sys_info.php?gp=$vargroup");
        exit();
    }else
    {
        ReWriteConfig();
        ShowMsg("�ɹ�������������������ļ���","sys_info.php?gp=$vargroup");
        exit();
    }
}
// ��������
else if ($dopost=='search')
{
    $keywords = isset($keywords)? strip_tags($keywords) : '';
    $i = 1;
    $configstr = <<<EOT
 <table width="100%" cellspacing="1" cellpadding="1" border="0" bgcolor="#cfcfcf" id="tdSearch" style="">
  <tbody>
   <tr height="25" bgcolor="#fbfce2" align="center">
    <td width="300">����˵��</td>
    <td>����ֵ</td>
    <td width="220">������</td>
   </tr>
EOT;
    echo $configstr;
    if ($keywords)
    {

        $dsql->SetQuery("SELECT * FROM `#@__sys_sysconfig` WHERE info LIKE '%$keywords%' or  varname LIKE '%$keywords%' order by aid asc");
        $dsql->Execute();
       
        while ($row = $dsql->GetArray()) {
            $bgcolor = ($i++%2==0)? "#F9FCEF" : "#ffffff";
            $row['info'] = preg_replace("#{$keywords}#", '<font color="red">'.$keywords.'</font>', $row['info']);
?>
<tr align="center" height="25" bgcolor="<?php echo $bgcolor?>">
  <td width="300"><?php echo $row['info']; ?>��</td>
  <td align="left" style="padding:3px;"><?php
    if($row['type']=='bool')
    {
        $c1='';
        $c2 = '';
        $row['value']=='Y' ? $c1=" checked" : $c2=" checked";
        echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='Y'$c1>�� ";
        echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='N'$c2>�� ";
    }else if($row['type']=='bstring')
    {
        echo "<textarea name='edit___{$row['varname']}' row='4' id='edit___{$row['varname']}' class='textarea_info' style='width:98%;height:50px'>".htmlspecialchars($row['value'])."</textarea>";
    }else if($row['type']=='number')
    {
        echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value='{$row['value']}' style='width:30%'>";
    }else
    {
        echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value=\"".htmlspecialchars($row['value'])."\" style='width:80%'>";
    }
    ?></td>
  <td><?php echo $row['varname']?></td>
</tr>
<?php
}
?>
</table>
<?php
        exit;
    }
    if ($i == 1)
    {
        echo '      <tr align="center" bgcolor="#F9FCEF" height="25">
           <td colspan="3">û���ҵ�����������</td>
          </tr></table>';
    }
    exit;
} else if ($dopost=='make_encode')
{
    $chars='abcdefghigklmnopqrstuvwxwyABCDEFGHIGKLMNOPQRSTUVWXWY0123456789';
    $hash='';
    $length = rand(28,32);
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    echo $hash;
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script language="javascript">
var searchconfig = false;
function ShowConfig(em,allgr)
{
	if(searchconfig) location.reload();
	for(var i=1;i<=allgr;i++)
	{
		if(i==em) $DE('td'+i).style.display = ($Nav()=='IE' ? 'block' : 'table');
		else $DE('td'+i).style.display = 'none';
	}
	$DE('addvar').style.display = 'none';
}


function backSearch()
{
	location.reload();
}
function getSearch()
{
	var searchKeywords = $DE('keywds').value;
	var myajax = new DedeAjax($DE('_search'));
	myajax.SendGet('sys_info.php?dopost=search&keywords='+searchKeywords)
	$DE('_searchback').innerHTML = '<input name="searchbackBtn" type="button" value="����" id="searchbackBtn" onclick="backSearch()"/>'
	$DE('_mainsearch').innerHTML = '';
	searchconfig = true;
}
function resetCookieEncode()
{//������������cookie������
  jQuery.get("sys_info.php?dopost=make_encode", function(data){
    jQuery("#edit___cfg_cookie_encode").val(data);
  });
}
</script>
<link href="../css/base.css" rel="stylesheet" type="text/css">
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="center"><strong><?php echo $sysFunTitle?></strong></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif" align="left"><div style="color:red"><img src='../images/ico/help.gif' /> �޸Ĵ�ҳ�����з��գ���С�Ĳ�����</div></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
  <tr>
    <td height="24" bgcolor="#ffffff" align="center"><?php
$ds[0]="1,ϵͳ����";
$ds[1]="2,��������";
$totalGroup = count($ds);
$i = 0;
foreach($ds as $dl)
{
	$dl = trim($dl);
	if(empty($dl)) continue;
	$dls = explode(',',$dl);
	$i++;
	if($i>1) echo " | <a href='javascript:ShowConfig($i,$totalGroup)'>{$dls[1]}</a> ";
	else{
		echo " <a href='javascript:ShowConfig($i,$totalGroup)'>{$dls[1]}</a> ";
	}
}
?></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px" bgcolor="#D6D6D6" align="center">
  <tr>
    <td height="28" align="right" background="../images/tbg.gif" style="border:1px solid #cfcfcf;border-bottom:none;">&nbsp;&nbsp;&nbsp;����������
      <input type="text" name="keywds" id="keywds" />
      <input name="searchBtn" type="button" value="����" id="searchBtn" onClick="getSearch()"/>
      &nbsp;<span id="_searchback"></span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" width="100%"><form action="sys_info.php" method="post" name="form1">
        <input type="hidden" name="dopost" value="save">
        <div id="_search"></div>
        <div id="_mainsearch">
          <?php
$n = 0;
if(!isset($gp)) $gp = 1;
foreach($ds as $dl)
{
	$dl = trim($dl);
	if(empty($dl)) continue;
	$dls = explode(',',$dl);
	$n++;
?>
          <table width="100%" style='<?php if($n!=$gp) echo "display:none"; ?>' id="td<?php echo $n?>" border="0" cellspacing="1" cellpadding="1" bgcolor="#cfcfcf">
            <tr align="center" bgcolor="#FBFCE2" height="25">
              <td width="300">����˵��</td>
              <td>����ֵ</td>
              <td width="220">������</td>
            </tr>
            <?php
$dsql->SetQuery("Select * From `#@__sys_sysconfig` where groupid='{$dls[0]}' and aid<'2000' order by aid asc");//150128���aid�ж�  ����ʾ������Ϣ
$dsql->Execute();
$i = 1;
while($row = $dsql->GetArray())
{
	if($i%2==0)
	{
		$bgcolor = "#F9FCEF";
	}
	else
	{
		$bgcolor = "#ffffff";
	}
	$i++;
?>
            <tr align="center" height="25" bgcolor="<?php echo $bgcolor?>">
              <td width="300"><?php echo $row['info']; ?>�� </td>
              <td align="left" style="padding:3px;"><?php
if($row['type']=='bool')
{
	$c1='';
	$c2 = '';
	$row['value']=='Y' ? $c1=" checked" : $c2=" checked";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='Y'$c1>�� ";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='N'$c2>�� ";
}else if($row['type']=='bstring')
{
	echo "<textarea name='edit___{$row['varname']}' row='4' id='edit___{$row['varname']}' class='textarea_info' style='width:98%;height:50px'>".htmlspecialchars($row['value'])."</textarea>";
}else if($row['type']=='number')
{
	echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value='{$row['value']}' style='width:30%'>";
}else
{
	$addstr='';
	if ($row['varname']=='cfg_cookie_encode') {
	  $addstr=' <a href="javascript:resetCookieEncode();" style="color:blue">[��������]</a>';
	}
	echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value=\"".htmlspecialchars($row['value'])."\" style='width:80%'>{$addstr}";
}
?></td>
              <td><?php echo $row['varname']?></td>
            </tr>
            <?php
}

?>
          </table>
          <?php
}
?>
        </div>
        <table width="100%" border="0" cellspacing="1" cellpadding="1"  style="border:1px solid #cfcfcf;border-top:none;">
          <tr bgcolor="#F9FCEF">
            <td height="50" colspan="3"><table width="98%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="11%">&nbsp;</td>
                  <td width="11%"><input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" border="0" class="np"></td>
                  <td width="78%"><img src="../images/button_reset.gif" width="60" height="22" style="cursor:pointer" onClick="document.form1.reset()"></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
