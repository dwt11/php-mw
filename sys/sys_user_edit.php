<?php
/**
 * �༭ϵͳ����Ա
 *
 * @version        $Id: sys_user_edit.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

require_once("sys_group.class.php");
$group = new sys_group();


if(empty($dopost)) $dopost='';

//��ȡ�û���Ϣ
$randcode = mt_rand(10000,99999);
$safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
$row = $dsql->GetOne("SELECT * FROM `#@__sys_admin` WHERE id='$id'");
$rowusertypes = explode(',', $row['usertype']);//����Ա������,��¼�û������û����ж��    141222�޸�ԭ��������ύ��ͻ 
$rowusertype_sing=$row['usertype'];      ////������Ա������,��¼�û������û���Ϊ����


if(!file_exists('../emp'))
{//���û��Ա������,��ֱ�ӻ�ȡȨ�� ���޸�
	//��ȡ�û�Ȩ��
	$groupWebRanks = Array();
	$groupSet = $dsql->GetOne("SELECT * FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$rowusertype_sing."' ");
	$groupWebRanks = explode('|', $groupSet['web_role']);
	$groupDepRanks = explode('|', $groupSet['department_role']);
}





if($dopost=='saveedit')
{
    $pwd = trim($pwd);
    if($pwd!='' && preg_match("#[^0-9a-zA-Z_@!\.-]#", $pwd))
    {
        ShowMsg('���벻�Ϸ�����ʹ��[0-9a-zA-Z_@!.-]�ڵ��ַ���', '-1', 0, 3000);
        exit();
    }
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    if($safecodeok != $safecode)
    {
        ShowMsg("����д��ȷ�İ�ȫ��֤����", "sys_user_edit.php?id={$id}&dopost=edit");
        exit();
    }
    $pwdm = '';
    if($pwd != '')
    {
        $pwdm = ",pwd='".md5($pwd)."'";
        $pwd = ",pwd='".substr(md5($pwd), 5, 20)."'";
    }

	//��ȡ�û���Ϣ
	$randcode = mt_rand(10000,99999);
	$safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
	//$typeOptions = '';
	if(file_exists('../emp'))
	{
		//�����Ա��������,����������
////	//ɾ���˶�,141127���ü����,����ӵ�ҳ��,ֻ��ѡ��û��¼����Ա��,ѡ�����е�¼����Ա����
//		$row = $dsql->GetOne("SELECT empid FROM `#@__sys_admin` WHERE id='$id'");
//		//����޸���ƥ���Ա������,���ѯ�Ƿ��Ѿ�ƥ����
//		if($row['empid']!=$empid){
//			//dump($row['empid']);
//			//dump($row['empid']$empid)
//			$questr="SELECT COUNT(*) AS dd FROM `#@__sys_admin` where  empid =".$empid;
//			//dump($questr);
//			$rowarc = $dsql->GetOne($questr);
//			if($rowarc['dd']>0)    {
//				ShowMsg("��Ա������ƥ��ĵ�¼�˻���","-1");
//				exit(); 
//			}
//		}
	    //dump($usertypes);
		if(isset($usertypes)){
			$usertype = join(',', $usertypes);
		}else
		{
		   $usertype="";
		   // ShowMsg('��ѡ���û��飡','-1');
		   // exit();
		}


		if($id!=3){
			$query = "UPDATE `#@__sys_admin` SET usertype='$usertype',empid='$empid' $pwd WHERE id='$id'";
		}else{
			$query = "UPDATE `#@__sys_admin` SET empid='$empid' $pwd WHERE id='$id'";
		}



	}else
	{   //���û��Ա������Ȩ��
							  //�޸��û�Ȩ�޵����ݱ�
						  //if(empty($onlyfile))$onlyfile="";
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
					
					
					
					
					
					
						
								$dsql->ExecuteNoneQuery("UPDATE `#@__sys_admintype` SET web_role='$All_webRole',department_role='$All_depRole' WHERE CONCAT(`rank`)='$rowusertype_sing'");
							
		
		







			$query = "UPDATE `#@__sys_admin` SET empid='$empid' $pwd WHERE id='$id'";
		
		}
	

    //dump($query);
	$dsql->ExecuteNoneQuery($query);
    ShowMsg("�ɹ�����һ���ʻ���",$ENV_GOBACK_URL);
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
<script src="../js/main.js"></script>
<script src="../js/dialog.js"></script>
<script src="../js/sys_group.js"></script>
<script language='javascript'>
	
	
   function checkSubmit()
  {
     if(document.form1.userName.value==""){
	     alert("�û���¼������Ϊ�գ�");
	     document.form1.userName.focus();
	     return false;
     }
<?php
if(file_exists('../emp'))
{//�����Ա��������,����������
//��Ա������Ļ�,��ϵͳ�û����� ��¼��ʹ��Ӣ�� ��ϳɹ���ϵͳ
//,��Ա������Ļ�,����ֱ��ʹ�����ĵ�¼�� ,�� ���������
	
	?>
	  //var NowNum = document.getElementById(userName).value.length;
     if(document.form1.userName.value.length<4){
	     alert("�û���¼������С����λ");
	     document.form1.userName.focus();
	     return false;
     }
<?php }?>
	 
	
     if(document.form1.pwd.value==""){
	     alert("�û����벻��Ϊ�գ�");
	     document.form1.pwd.focus();
	     return false;
     }
     if(document.form1.pwd.value.length<6){
	     alert("�û����벻��С����λ��");
	     document.form1.pwd.focus();
	     return false;
     }
     return true;
 }
</script>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8' onload="ShowHide('roleTable');">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><?php echo $sysFunTitle?></b></td>
  </tr>
  <tr>
  <td  align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1" action="sys_user_edit.php" method="post">
	<input type="hidden" name="dopost" value="saveedit" />
	<input type="hidden" name="id" value="<?php echo $row['id']?>" />
    <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
          <tr> 
            <td width="10%" class="bline" align="right">�û���¼����</td>
            <td class="bline"><?php echo $row['userName']?></td>
          </tr>
        
          <tr> 
            <td  class="bline" align="right">�û����룺</td>
            <td class="bline">
            	<input name="pwd" type="text" id="pwd" size="16" style="width:200px" /> &nbsp;���������޸ģ�ֻ����'0-9a-zA-Z.@_-!'���ڷ�Χ���ַ���
            </td>
          </tr>
      <?php
if(file_exists('../emp'))
{//�����Ա��������,����������
	
	?>
          <tr> 
            <td  class="bline" align="right">�û��飺</td>
            <td  class="bline">
			  <select name='usertypes[]' style='width:200px'  size='10'  multiple="true">
			  	<?php
			  	$dsql->SetQuery("Select * from #@__sys_admintype order by rank asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		echo "<option value='".$myrow->rank."' ".(in_array($myrow->rank, $rowusertypes) ? ' selected' : '').">".$myrow->typename."</option>\r\n";
			  	}
			  	?>
			  </select>
                               (�� �����ϵ� Ctrl �� ���Խ��ж�ѡ ��¼��adminȨ�޲����޸�)
         </td>
          </tr>
          <tr> 
            <td  class="bline" align="right">Ա��������</td>
            <td  class="bline">
			  <select name='empid' style='width:200px'>
			                <option value='0'<?php if($row['empid']==0) echo " selected='1'"?>>��</option>
	<?php
				//���������û������Ա��
			  	$dsql->SetQuery("Select emp_id,emp_realname from #@__emp emp 
				                 where  emp_isdel=0 and 
								 ((select count(1) as num from #@__sys_admin admin where admin.empid = emp.emp_id) = 0 or emp_id='".$row['empid']."') order by convert(emp_realname using gbk) asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		if($row['empid']==$myrow->emp_id) echo "<option value='".$myrow->emp_id."' selected='1'>".$myrow->emp_realname."</option>\r\n";
			  		else echo "<option value='".$myrow->emp_id."'>".$myrow->emp_realname."</option>\r\n";
			  	}
			  	?>
			  </select>
         </td>
          </tr>
      <?php }else
{
	echo "<input type=\"hidden\" name=\"empid\">";
	//echo "<input type=\"hidden\" name=\"usertypes[]\" id=\"usertypes[]\">";
	}?>
           <tr> 
            <td  class="bline" align="right">��ȫ��֤����</td>
            <td  class="bline">
            	<input name="safecode" type="text" id="safecode" size="16" style="width:200px" />
            	<input name="randcode" type="hidden" value="<?php echo $randcode; ?>" />
            	 &nbsp;
          (���Ʊ����룺 <font color='red'><?php echo $safecode;  ?></font>) </td>
      </tr>
      <?php
if(!file_exists('../emp'))
{//���û��Ա��������,����������
	
	?>
      <tr  bgcolor="#F9FCEF">
        <td colspan="2" align="center"><strong>Ȩ��ѡ��</strong></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="bline">
      
        <?php 
                  $group->getRoleTable($groupWebRanks,$groupDepRanks);   //ֱ�����
             ?>
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
      </td>
  </tr>
  <?php }?>
          <tr  bgcolor="#F9FCEF">
            <td height="45"></td>
            <td>
            	<input type="submit" name="Submit" value=" �� �� " class="coolbg np" />
            </td>
          </tr>
        </table>
      </form>
	  </td>
</tr>
</table>
</body>
</html>