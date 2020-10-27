<?php
/**
 * ���ϵͳ����Ա
 *
 * @version        $Id: sys_user_add.php 1 16:22 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

require_once("sys_group.class.php");
$group = new sys_group();


if(empty($dopost)) $dopost='';

if($dopost=='saveadd')
{
	if(file_exists('../emp'))
	{//�����Ա��������,����������
	//��Ա������Ļ�,��ϵͳ�û����� ��¼��ʹ��Ӣ�� ��ϳɹ���ϵͳ
	//,��Ա������Ļ�,����ֱ��ʹ�����ĵ�¼�� ,�� ���������
		
		if(preg_match("#[^0-9a-zA-Z_@!\.-]#", $userName))
		{
			ShowMsg('�û������Ϸ���<br />��ʹ��[0-9a-zA-Z_@!.-]�ڵ��ַ���', '-1', 0, 3000);
			exit();
		}
	}
	
	
	if(preg_match("#[^0-9a-zA-Z_@!\.-]#", $pwd) )
	{
		ShowMsg('���벻�Ϸ���<br />��ʹ��[0-9a-zA-Z_@!.-]�ڵ��ַ���', '-1', 0, 3000);
		exit();
	}
	
	
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    if($safecode != $safecodeok )
    {
        ShowMsg('����д��ȫ��֤����', '-1', 0, 3000);
        exit();
    }
    $mpwd = md5($pwd);
    $pwd = substr(md5($pwd), 5, 20);

    $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__sys_admin` WHERE userName LIKE '$userName' ");
    if($row['dd']>0)
    {
        ShowMsg('�û���¼���Ѵ��ڣ�','-1');
        exit();
    }
	
	if(file_exists('../emp'))
	{//�����Ա��������,����������
//	//ɾ���˶�,141127���ü����,����ӵ�ҳ��,ֻ��ѡ��û��¼����Ա��,ѡ�����е�¼����Ա����
//		$questr="SELECT COUNT(*) AS dd FROM `#@__emp` where emp_isdel=0 and emp_id =".$empid;
//		dump($questr);
//		$rowarc = $dsql->GetOne($questr);
//		if($rowarc['dd']>0)    {
//			ShowMsg("��Ա������ƥ��ĵ�¼�˻���","-1");
//			exit(); 
//		}
	
		if(isset($usertypes)){
			$usertype = join(',', $usertypes);
		}else
		{
		   $usertype="";
		   // ShowMsg('��ѡ���û��飡','-1');
		   // exit();
			}
	}else
	{
							  //����û�Ȩ�޵����ݱ�
						  //if(empty($onlyfile))$onlyfile="";
								$row = $dsql->GetOne("SELECT rank FROM #@__sys_admintype where rank!=10 order by rank desc");
								if(is_array($row))
								{
									$rank=$row['rank']+0.001;//�õ��µ�Ȩ����ID
								}else
								{
									$rank=0.001;//�õ��µ�Ȩ����ID
								}
								




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
							
							
							
							
							
							
								
								
								$query="INSERT INTO #@__sys_admintype(rank,typename,web_role,department_role,Remark) VALUES ('$rank','$userName',  '$All_webRole', '$All_depRole','ϵͳ�û����');";
								 $dsql->ExecuteNoneQuery($query);
								 
								 
									
		
				$usertype=$rank;      //�û���Ȩ��ID,�����û����ݱ�		
		}

    
    //��̨����Ա
    $inquery = "INSERT INTO `#@__sys_admin`(usertype,userName,pwd,empid)
                                                    VALUES('$usertype','$userName','$pwd','$empid'); ";
    //dump($inquery);
	$rs = $dsql->ExecuteNoneQuery($inquery);


   ShowMsg('�ɹ����һ���û���', 'sys_user.php');
   exit();
}
$randcode = mt_rand(10000, 99999);
$safecode = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
//$typeOptions = '';



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=">
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
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="30" background="../images/tbg.gif" bgcolor="#E7E7E7" style="padding-left:20px;"><b><?php echo $sysFunTitle?></b></td>
  </tr>
  <tr>
    <td  align="center" valign="top" bgcolor="#FFFFFF"><form name="form1" action="sys_user_add.php" onSubmit="return checkSubmit();" method="post">
      <input type="hidden" name="dopost" value="saveadd" />
      <table width="100%" border="0"  cellspacing="0" cellpadding="0" style="text-align:left;background:#ffffff;">
      <tr>
        <td  width="10%" class="bline" align="right">�û���¼����</td>
        <td  class="bline" ><input name="userName" type="text" id="userName" size="16" style="width:200px" />
          ��ֻ����'0-9'��'a-z'��'A-Z'��'.'��'@'��'_'��'-'��'!'���ڷ�Χ���ַ���</td>
      </tr>
      <tr>
        <td  width="10%" class="bline" align="right">�û����룺</td>
        <td  class="bline" ><input name="pwd" type="text" id="pwd" size="16" style="width:200px" />
          ��ֻ����'0-9'��'a-z'��'A-Z'��'.'��'@'��'_'��'-'��'!'���ڷ�Χ���ַ���</td>
      </tr>
      <?php
if(file_exists('../emp'))
{//�����Ա��������,����������
	
	?>
      <tr>
        <td  class="bline" align="right">�û��飺</td>
        <td  class="bline" ><select name='usertypes[]' style='width:200px' size='10'  multiple="true">
            <?php
			  	echo "<option value=''>��</option>\r\n";
			  	$dsql->SetQuery("Select * from `#@__sys_admintype` order by rank asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		echo "<option value='".$myrow->rank."'>".$myrow->rank." ".$myrow->typename."</option>\r\n";
			  	}
			  	?>
          </select>
          (�� �����ϵ� Ctrl �� ���Խ��ж�ѡ) </td>
      </tr>
      <tr>
        <td  class="bline" align="right">Ա��������</td>
        <td  class="bline" ><select name='empid' style='width:200px'>
            <option value='0' >��</option>
            <?php
				//���������û������Ա��
			  	$dsql->SetQuery("Select emp_id,emp_realname from #@__emp emp where  emp_isdel=0 and (select count(1) as num from #@__sys_admin admin where admin.empid = emp.emp_id) = 0 order by convert(emp_realname using gbk) asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		 echo "<option value='".$myrow->emp_id."'>".$myrow->emp_realname."</option>\r\n";
			  	}
			  	?>
          </select></td>
      </tr>
      <?php }else
{
	echo "<input type=\"hidden\" name=\"empid\">";
	//echo "<input type=\"hidden\" name=\"usertypes[]\" id=\"usertypes[]\">";
	}?>
      <tr>
        <td  class="bline" align="right">��ȫ��֤����</td>
        <td  class="bline" ><input name="safecode" type="text" id="safecode" size="16" style="width:200px" />
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
                  $group->getRoleTable();   //ֱ�����
             ?>
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
      </td>
  </tr>
  <?php }?>
  <tr  bgcolor="#F9FCEF">
    <td height="45"></td>
    <td ><input type="submit" name="Submit" value=" ��  �� " class="coolbg np" /></td>
  </tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>