<?php
/**
 * ϵͳȨ����༭
 *
 * @version        $Id: sys_group_edit.php 1 22:28 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_group.class.php");
$t1 = ExecTime();
$group = new sys_group();

if(empty($dopost)) $dopost = "";



//��õ�ǰȨ�������Ϣ
$groupSet = $dsql->GetOne("SELECT * FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='{$rank}' ");
$groupWebRanks = explode('|', $groupSet['web_role']);
$groupDepRanks = explode('|', $groupSet['department_role']);
//dump($groupWebRanks);
//dump($groupDepRanks);
$empUserNames="";
//��õ�ǰȨ�����������ĵ�¼����Ա������   ȫ��ƥ�� ����ģ������
$query = "SELECT userName,empid FROM `dede_sys_admin` WHERE FIND_IN_SET('$rank',usertype)>0";	    //echo $query."<br>";//exit;
$db->SetQuery($query);
$db->Execute(0);
//echo $query."<br>";//exit;
while($row1=$db->GetObject(0))
{
   
   $empUserNames.=GetEmpNameById($row1->empid)."(".$row1->userName.") ";
}
			
if($empUserNames=="")$empUserNames="��";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
</head>

<body background='../images/allbg.gif' leftmargin='8' topmargin='8' >
<center>
  <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
    <tr>
      <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><div style="color:#333333"><img src='../images/ico/help.gif' /> ��ע:�� Ϊ����Ȩ�޵Ĺ���</div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
    <tr>
      <td height="35" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b><?php echo $sysFunTitle?></b></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF" align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td  width="10%" class="bline" align="right">�����ƣ�</td>
            <td class="bline"><?php echo $groupSet['typename']?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">����ֵ��</td>
            <td class="bline"><?php echo $groupSet['rank']?></td>
          </tr>
          <tr>
            <td   class="bline" align="right">��ע��</td>
            <td class="bline"><?php echo $groupSet['Remark']?></td>
          </tr>
         <tr>
            <td  height=35 align="right">������Ա��</td>
            <td  ><?php echo $empUserNames?></td>
          </tr>

        </table></td>
    </tr>
  </table>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center" style="margin-top:10px">
       <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b>Ȩ����Ϣ</b></td>
      </tr>
 <?php
if($groupSet['web_role']=="admin_AllowAll"&&$groupSet['department_role']=="admin_AllowAll")
{

?>
   <tr>
      <td height='35'  bgcolor='#F9FAF3'  align='center'><strong>�û�����й���Ա��Ȩ�� ���Խ���������� </strong></td>
    </tr>
  </table>
  <?php }else{?>
              <tr>
              <td height='30'  bgcolor='#FFFFFF' align="left">
    
          <?php 
                  $group->getRoleTable($groupWebRanks,$groupDepRanks,true);   //ֱ�����
             ?>
             
             </td>
      </tr>
   
  <?php }?>
    </table>

  	<?php 
$t2 = ExecTime();
//echo $t2-$t1;

?>

</body>
</html>