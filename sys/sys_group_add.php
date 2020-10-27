<?php
/**
 * ϵͳȨ�������
 *
 * @version        $Id: sys_group_add.php 1 22:28 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");
require_once("sys_group.class.php");
$group = new sys_group();
if(empty($adminRole))$adminRole="";

if(!empty($dopost)&&$dopost=="save")
{
	//if(empty($onlyfile))$onlyfile="";
    $row = $dsql->GetOne("SELECT * FROM #@__sys_admintype WHERE rank='".$rank."'");
    if(is_array($row))
    {
        ShowMsg('�������������ļ���ֵ�Ѵ��ڣ��������ظ�!', '-1');
        exit();
    }
    if($rank > 10)
    {
        ShowMsg('�鼶��ֵ���ܴ���10�� ����һ��Ȩ�����þ���Ч!', '-1');
        exit();
    }
    
	//dump($adminWebRole);exit;
    $All_webRole = $All_depRole =  "";      //ҳ��Ȩ��
	$AllWeb_Role = '';      //ҳ��Ȩ��
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






	
	
//dump($All_webRole);
//dump($All_depRole);
    $query="INSERT INTO #@__sys_admintype(rank,typename,web_role,department_role,Remark) VALUES ('$rank','$groupname',  '$All_webRole', '$All_depRole','$Remark');";
	
	// dump($query);
	 $dsql->ExecuteNoneQuery($query);
    ShowMsg("�ɹ�����һ���µ��û���!", "sys_group.php");
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
<script src="../js/sys_group.js"></script>
<link href='/css/base.css' rel='stylesheet' type='text/css'>
</head>
<body background='../images/allbg.gif' leftmargin='8' topmargin='8'>
<center>
  <table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center" style="margin-bottom:5px">
    <tr>
      <td height="30" bgcolor="#ffffff" style="padding:6px;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><div style="color:red"><img src='../images/ico/help.gif' /> �޸Ĵ�ҳ�����з��գ���С�Ĳ�����</div>
              <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>��һ��</strong> Ϊ�û����Է��ʵ�ҳ�湦�ܣ�ÿ���<strong>����</strong>ѡ�к�����<strong>��ӡ�ɾ�����༭</strong>����չ���ܣ��ſ��Ը����趨��ʾ</div>
              <?php
 if(file_exists(DEDEPATH.'/emp'))
{
	?>
              <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>��һ��</strong> Ϊ�û����Է��ʵĲ���Ȩ��</div>
              <div style="color:#333333"><img src='../images/ico/help.gif' /> <strong>-</strong> �������޲�������,��ֱ��ѡ�����µ�ѡ���</div>
              <?php }?></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <form name='form1' action='sys_group_add.php' method='post'  onSubmit="return checkSubmit();">
    <input type='hidden' name='dopost' value='save'>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b><?php echo $sysFunTitle?></b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="left"><table width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td  width="10%" class="bline" align="right">�����ƣ�</td>
              <td class="bline"><input name="groupname" type="text" id="groupname" ></td>
            </tr>
            <tr>
              <td  class="bline" align="right">����ֵ��</td>
              <td class="bline"><input name="rank" type="text" id="rank" size="6">
                �����֣�ϵͳ��ռ�õļ���ֵ��
                <?php
          	
          	$dsql->SetQuery("Select rank From #@__sys_admintype");
          	$dsql->Execute();
          	while($row = $dsql->GetObject()) echo '<font color=red>'.$row->rank.'</font>��';
          	?>
                ������ֵ����С��10�����������10����Ȩ�����ý���Ч(��������Ա)�����10���鲻����ȫ�������Ҫ������ʹ��С���� </td>
            </tr>
            <tr>
              <td  align="right">��ע��</td>
              <td ><textarea name="Remark" rows="5" id="Remark" style="width:15%;height:50px"></textarea></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center" style="margin-top:10px" >
      <tr>
        <td height="30" background="../images/tbg.gif" align="left" style="padding-left:10px;"><b>Ȩ��ѡ��</b></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF" align="left"><table width="98%"  border="0" cellspacing="1" cellpadding="1" style="margin:10px" bgcolor="#D6D6D6">
            <tr>
              <td height='25'  bgcolor='#FBFCE2' align="left">&nbsp;<strong>�ر�Ȩ��(����������Աʹ��)</strong> <br>
                <input name='adminRole' type='checkbox' class='np'  value='admin_AllowAll'  onclick="ShowHide('roleTable')"   >
                ���Խ����������(ѡ������,�û��齫���й���Ա��Ȩ��) </td>
            </tr>
          </table>
          <?php 
                  $group->getRoleTable();   //ֱ�����
             ?></td>
      </tr>
      <tr  bgcolor="#F9FCEF">
        <td height="45" align="left" style="padding-left:50px">
        
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
          <input name="imageField" type="image" src="../images/button_ok.gif" width="60" height="22" class="np" border="0" style="cursor:pointer">
          <img src="../images/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:pointer"></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>