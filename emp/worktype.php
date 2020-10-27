<?php
/**
 * 工种管理
 *
 * @version        $Id: worktype.php 1 14:31 2010年7月12日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("worktypeunit.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<link href="../css/base.css" rel="stylesheet" type="text/css">
<script src="../js/dedeajax2.js"></script>
<script language="javascript" src="../js/main.js"></script>
<script language="javascript">
function LoadSuns(ctid,tid)
{
    
	if($DE(ctid).innerHTML.length < 10){
      $DE('img'+tid).src = '../images/contract.gif';
	  var myajax = new DedeAjax($DE(ctid));
	  myajax.SendGet('worktype.do.php?dopost=GetSunLists&cid='+tid);
  }
  else{ 
  showHideImg(ctid,tid,'img'+tid); 
  }
}
</script>
<style>
.coolbg2 {
	border: 1px solid #000000;
	background-color: #F2F5E9;
	height: 18px
}
.coolbt2 {
	border-left: 2px solid #EFEFEF;
	border-top: 2px solid #EFEFEF;
	border-right: 2px solid #ACACAC;
	border-bottom: 2px solid #ACACAC;
	background-color: #F7FCDA
}
.nbline {
	border-bottom: 1px solid #d6d6d6;
	background-color: #FFFFFF;
}
.bline2 {
	border-bottom: 1px solid #d6d6d6;
	background-color: #F9FCEF;
}
</style>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8' >
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
  <tr>
    <td height="35" background="../images/tbg.gif"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong><?php echo $sysFunTitle?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>

<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#cfcfcf" align="center">
  <tr>
    <td height="28" background='../images/tbg.gif' style="padding-left:10px;">
      <div class="toolbox"> 
      
      <?php 
	  if(Test_webRole("emp/worktype_add.php")) echo "<a href=\"worktype_add.php\" >添加</a>";
	  
	  
	  if(!isset($exallct)) { ?>
      <a href='worktype.php?exallct=all'>展开全部</a>
      <?php }else{ ?>
      <a href='worktype.php'>普通模式</a>
      <?php } ?>
</div>
      </td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;margin-top:5px" >
  <form name='form1' method='post' action=''>
    <tr>
      <td height="120" bgcolor="#FFFFFF" valign="top"><?php
$tu = new WorktypeUnit();
$tu->ListAllWorktype();
?>
        <br/></td>
    </tr>
  </form>
</table>
</body>
</html>
