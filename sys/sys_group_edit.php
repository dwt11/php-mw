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
if(empty($adminRole))$adminRole="";

if(empty($dopost)) $dopost = "";
if($dopost=='save')
{
 
 
   
    if($rank==10)
    {
        ShowMsg('��������Ա��Ȩ�޲��������!', 'sys_group.php');
        exit();
    }


	//dump($adminWebRole);exit;
        $All_webRole = $All_depRole =  "";      //ҳ��Ȩ��
	
	
	
	if($adminRole!=""){
		$All_webRole = $All_depRole =  "admin_AllowAll";      //ҳ��Ȩ��
	}else
	{



			$checkBoxArrary=array();
	
			//���빦����
			require_once("sys_function.class.php");
			$fun = new sys_function();
			$fucArray=$fun->getSysFunArray();
			//�в������ݵ�CHECKBOX
			//1��ҳ��ѡ�е�checkbox���Ϊһ������
			//�����ŵ���Ϊ����,ѭ����ȡѡ�е�checkbox
			foreach ($fucArray as $key=>$menu)
			{
				  for($i2=0; $i2<=$allDepNumb-1; $i2++)
				  {
					  $checkBoxName="dep".$i2.$key;   //ͨ��ҳ��input hidden���ݹ����Ĳ��Ÿ���,������CHECKBOx������,Ȼ����PHP����ȡѡ�е�CHECKBOX��ֵ
					  if(empty($$checkBoxName))$$checkBoxName="";
					//dump($$checkBoxName);
					  if(is_array($$checkBoxName))
					  {
						  
						  foreach($$checkBoxName as $checkBoxValues)
						  {
							  $value = explode(',',$checkBoxValues);
							  if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$value[1],"depRole"=>$value[0]));   //��ȡ��ֵ�� �����µ�����
						  }
					  }
				  }
			}
			
			//�޲������ݵ� �ļ�����ѹ������
			foreach ($fucArray as $key=>$menu)
			{
					$checkBoxName="dep".$key;   //ͨ��ҳ��input hidden���ݹ����Ĳ��Ÿ���,������CHECKBOx������,Ȼ����PHP����ȡѡ�е�CHECKBOX��ֵ
					if(empty($$checkBoxName))$$checkBoxName="";
				  //dump($$checkBoxName);
					if(is_array($$checkBoxName))
					{
						
						foreach($$checkBoxName as $checkBoxValues)
						{
							$value = explode(',',$checkBoxValues);
							if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$checkBoxValues,"depRole"=>"0"));   //��ȡ��ֵ�� �����µ�����
						}
					}
				
			}


//dump($checkBoxArrary);
			$group->getSaveValue($checkBoxArrary);   //��ȡ�ַ���
			$All_webRole=$group->save_webRole;
			$All_depRole=$group->save_depRole;
	}






	
	
//dump($onlyfile);
//dump($All_webRole);
//dump($All_depRole);
    $dsql->ExecuteNoneQuery("UPDATE `#@__sys_admintype` SET typename='$groupname',web_role='$All_webRole',department_role='$All_depRole',Remark='$Remark' WHERE CONCAT(`rank`)='$rank'");
    ShowMsg('�ɹ������û����Ȩ��!', 'sys_group.php');
    exit();
}



$groupWebRanks = Array();
$groupSet = $dsql->GetOne("SELECT * FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='{$rank}' ");
$groupWebRanks = explode('|', $groupSet['web_role']);
$groupDepRanks = explode('|', $groupSet['department_role']);
//dump($groupWebRanks);
//dump($groupDepRanks);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
<script src="../js/jquery.min.js"></script>
<script src="../js/dedeajax2.js"></script>
<script src="../js/main.js"></script>
<script src="../js/sys_group.js"></script>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
</head>

<body background='../images/allbg.gif' leftmargin='8' topmargin='8' onload="ShowHide('roleTable');">
<center>
  <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
    <tr>
      <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><div style="color:red"><img src='../images/ico/help.gif' /> �޸Ĵ�ҳ�����з��գ���С�Ĳ�����</div>
              <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>��һ��</strong> Ϊ�û����Է��ʵ�ҳ��Ȩ�ޣ�ÿ���<strong>����</strong>ѡ�к�����<strong>��ӡ�ɾ�����༭</strong>����չ���ܣ��ſ��Ը����趨��ʾ</div>
              
              
 <?php
 if(file_exists(DEDEPATH.'/emp'))
{
	?>
 <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>��һ��</strong> Ϊ�û����Է��ʵĲ���Ȩ��</div>
 <?php }?>
 
              
              </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <form name='form1' action='sys_group_edit.php' method='post' >
    <input type='hidden' name='dopost' value='save'>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b><?php echo $sysFunTitle?></b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td  width="10%" class="bline" align="right">�����ƣ�</td>
              <td ><input name="groupname" type="text" id="groupname" value="<?php echo $groupSet['typename']?>"></td>
            </tr>
            <tr>
            <td  class="bline" align="right">����ֵ��</td>
              <td  class="bline"><input name="rank" type="hidden" id="rank" value="<?php echo $groupSet['rank']?>">
                <?php echo $groupSet['rank']?></td>
            </tr>
            <tr>
            <td    align="right">��ע��</td>
              <td  ><textarea name="Remark" rows="5" id="Remark" style="width:15%;height:50px"><?php echo $groupSet['Remark']?></textarea></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center" style="margin-top:10px">
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b>Ȩ��ѡ��</b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="center">
        
        <table width="98%"  border="0" cellspacing="1" cellpadding="1" style="margin-top:10px" bgcolor="#D6D6D6">
            <tr>
              <td height='25'  bgcolor='#FBFCE2' align="left">
               &nbsp;<strong>�ر�Ȩ��(����������Աʹ��)</strong>
               <br> 
          <input name='adminRole' type='checkbox' class='np'  value='admin_AllowAll'   <?php echo $group->CRank("admin_AllowAll","admin_AllowAll",$groupWebRanks,$groupDepRanks)?>  onclick="ShowHide('roleTable')">
          ���Խ����������(ѡ������,�û��齫���й���Ա��Ȩ��) </td>
      </tr>
    </table>
         
          <?php 
                  $group->getRoleTable($groupWebRanks,$groupDepRanks);   //ֱ�����
             ?>
             
             </td>
      </tr>
      <tr  bgcolor="#F9FCEF">
        <td height="45" align="left" style="padding-left:50px">
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
          <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" class="np" border="0" style="cursor:pointer">
          <img src="../images/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:pointer"></td>
      </tr>
    </table>
  </form>
  	<?php 
$t2 = ExecTime();
//echo $t2-$t1;

?>

  
</center>
</body>
</html>