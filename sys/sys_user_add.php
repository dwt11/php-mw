<?php
/**
 * 添加系统管理员
 *
 * @version        $Id: sys_user_add.php 1 16:22 2010年7月20日Z tianya $
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
	{//如果有员工管理功能,才输出下面的
	//有员工管理的话,则系统用户管理 登录名使用英文 如合成管理系统
	//,无员工管理的话,可以直接使用中文登录名 ,如 进销存管理
		
		if(preg_match("#[^0-9a-zA-Z_@!\.-]#", $userName))
		{
			ShowMsg('用户名不合法，<br />请使用[0-9a-zA-Z_@!.-]内的字符！', '-1', 0, 3000);
			exit();
		}
	}
	
	
	if(preg_match("#[^0-9a-zA-Z_@!\.-]#", $pwd) )
	{
		ShowMsg('密码不合法，<br />请使用[0-9a-zA-Z_@!.-]内的字符！', '-1', 0, 3000);
		exit();
	}
	
	
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    if($safecode != $safecodeok )
    {
        ShowMsg('请填写安全验证串！', '-1', 0, 3000);
        exit();
    }
    $mpwd = md5($pwd);
    $pwd = substr(md5($pwd), 5, 20);

    $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__sys_admin` WHERE userName LIKE '$userName' ");
    if($row['dd']>0)
    {
        ShowMsg('用户登录名已存在！','-1');
        exit();
    }
	
	if(file_exists('../emp'))
	{//如果有员工管理功能,才输出下面的
//	//删除此段,141127不用检测了,在添加的页面,只能选择没登录名的员工,选不了有登录名的员工了
//		$questr="SELECT COUNT(*) AS dd FROM `#@__emp` where emp_isdel=0 and emp_id =".$empid;
//		dump($questr);
//		$rowarc = $dsql->GetOne($questr);
//		if($rowarc['dd']>0)    {
//			ShowMsg("此员工已有匹配的登录账户！","-1");
//			exit(); 
//		}
	
		if(isset($usertypes)){
			$usertype = join(',', $usertypes);
		}else
		{
		   $usertype="";
		   // ShowMsg('请选择用户组！','-1');
		   // exit();
			}
	}else
	{
							  //添加用户权限到数据表
						  //if(empty($onlyfile))$onlyfile="";
								$row = $dsql->GetOne("SELECT rank FROM #@__sys_admintype where rank!=10 order by rank desc");
								if(is_array($row))
								{
									$rank=$row['rank']+0.001;//得到新的权限组ID
								}else
								{
									$rank=0.001;//得到新的权限组ID
								}
								




										$checkBoxArrary=array();
										//引入功能类
										require_once("sys_function.class.php");
										$fun = new sys_function();
										$fucArray=$fun->getSysFunArray();
										//有部门数据的CHECKBOX
										//1将页面选中的checkbox组合为一个数组
										//按部门的行为数组,循环获取选中的checkbox
										foreach ($fucArray as $key=>$menu)
										{
											  for($i2=0; $i2<=$allDepNumb-1; $i2++)
											  {
												  $checkBoxName="dep".$i2.$key;   //通过页面input hidden传递过来的部门个数,来定义CHECKBOx的名字,然后用PHP来获取选中的CHECKBOX的值
												  if(empty($$checkBoxName))$$checkBoxName="";
												//dump($$checkBoxName);
												  if(is_array($$checkBoxName))
												  {
													  
													  foreach($$checkBoxName as $checkBoxValues)
													  {
														  $value = explode(',',$checkBoxValues);
														  if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$value[1],"depRole"=>$value[0]));   //获取到值后 存入新的数组
													  }
												  }
											  }
										}
										
										//无部门数据的 文件名称压入数组
										foreach ($fucArray as $key=>$menu)
										{
												$checkBoxName="dep".$key;   //通过页面input hidden传递过来的部门个数,来定义CHECKBOx的名字,然后用PHP来获取选中的CHECKBOX的值
												if(empty($$checkBoxName))$$checkBoxName="";
											  //dump($$checkBoxName);
												if(is_array($$checkBoxName))
												{
													
													foreach($$checkBoxName as $checkBoxValues)
													{
														$value = explode(',',$checkBoxValues);
														if($checkBoxValues!="")array_push($checkBoxArrary, array("webRole"=>$checkBoxValues,"depRole"=>"0"));   //获取到值后 存入新的数组
													}
												}
											
										}
										
							
							
							
							//dump($checkBoxArrary);
										$group->getSaveValue($checkBoxArrary);   //获取字符串
										$All_webRole=$group->save_webRole;
										$All_depRole=$group->save_depRole;
							
							
							
							
							
							
								
								
								$query="INSERT INTO #@__sys_admintype(rank,typename,web_role,department_role,Remark) VALUES ('$rank','$userName',  '$All_webRole', '$All_depRole','系统用户添加');";
								 $dsql->ExecuteNoneQuery($query);
								 
								 
									
		
				$usertype=$rank;      //用户的权限ID,存入用户数据表		
		}

    
    //后台管理员
    $inquery = "INSERT INTO `#@__sys_admin`(usertype,userName,pwd,empid)
                                                    VALUES('$usertype','$userName','$pwd','$empid'); ";
    //dump($inquery);
	$rs = $dsql->ExecuteNoneQuery($inquery);


   ShowMsg('成功添加一个用户！', 'sys_user.php');
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
	     alert("用户登录名不能为空！");
	     document.form1.userName.focus();
	     return false;
     }
<?php
if(file_exists('../emp'))
{//如果有员工管理功能,才输出下面的
//有员工管理的话,则系统用户管理 登录名使用英文 如合成管理系统
//,无员工管理的话,可以直接使用中文登录名 ,如 进销存管理
	
	?>
	  //var NowNum = document.getElementById(userName).value.length;
     if(document.form1.userName.value.length<4){
	     alert("用户登录名不能小于四位");
	     document.form1.userName.focus();
	     return false;
     }
<?php }?>
	 
	
     if(document.form1.pwd.value==""){
	     alert("用户密码不能为空！");
	     document.form1.pwd.focus();
	     return false;
     }
     if(document.form1.pwd.value.length<6){
	     alert("用户密码不能小于六位！");
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
        <td  width="10%" class="bline" align="right">用户登录名：</td>
        <td  class="bline" ><input name="userName" type="text" id="userName" size="16" style="width:200px" />
          （只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
      </tr>
      <tr>
        <td  width="10%" class="bline" align="right">用户密码：</td>
        <td  class="bline" ><input name="pwd" type="text" id="pwd" size="16" style="width:200px" />
          （只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
      </tr>
      <?php
if(file_exists('../emp'))
{//如果有员工管理功能,才输出下面的
	
	?>
      <tr>
        <td  class="bline" align="right">用户组：</td>
        <td  class="bline" ><select name='usertypes[]' style='width:200px' size='10'  multiple="true">
            <?php
			  	echo "<option value=''>无</option>\r\n";
			  	$dsql->SetQuery("Select * from `#@__sys_admintype` order by rank asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		echo "<option value='".$myrow->rank."'>".$myrow->rank." ".$myrow->typename."</option>\r\n";
			  	}
			  	?>
          </select>
          (按 键盘上的 Ctrl 键 可以进行多选) </td>
      </tr>
      <tr>
        <td  class="bline" align="right">员工姓名：</td>
        <td  class="bline" ><select name='empid' style='width:200px'>
            <option value='0' >无</option>
            <?php
				//搜索不在用户表里的员工
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
        <td  class="bline" align="right">安全验证串：</td>
        <td  class="bline" ><input name="safecode" type="text" id="safecode" size="16" style="width:200px" />
          <input name="randcode" type="hidden" value="<?php echo $randcode; ?>" />
          &nbsp;
          (复制本代码： <font color='red'><?php echo $safecode;  ?></font>) </td>
      </tr>
      <?php
if(!file_exists('../emp'))
{//如果没有员工管理功能,才输出下面的
	
	?>
      <tr  bgcolor="#F9FCEF">
        <td colspan="2" align="center"><strong>权限选择</strong></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="bline">
      
        <?php 
                  $group->getRoleTable();   //直接输出
             ?>
        <input type='hidden' name='allDepNumb' value='<?php echo $group->allDepNumb;?>'>
      </td>
  </tr>
  <?php }?>
  <tr  bgcolor="#F9FCEF">
    <td height="45"></td>
    <td ><input type="submit" name="Submit" value=" 保  存 " class="coolbg np" /></td>
  </tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>