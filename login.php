<?php
/**
 * ��̨��½
 *
 * @version        $Id: login.php 1 8:48 2010��7��13��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
if(empty($dopost)) $dopost = '';

$msg="";

//��¼���
if($dopost=='login')
{
    
        $cuserLogin = new userLogin();
        if(!empty($userName) && !empty($pwd))
        {
            $res = $cuserLogin->checkUser($userName,$pwd);

            //success
            if($res==1)
            {
                $cuserLogin->keepUser();
               if(!empty($gotopage))
                {
                    ShowMsg('�ɹ���¼��������ת��',$gotopage);
					if(file_exists('archives'))setcookie('NOT_ARC_VIEWD_URL',"", time()+3600, '/');   //������ǰ̨����ĵ�ַ Ҫע����

                    exit();
                }
                else
                {
                    ShowMsg('�ɹ���¼������ת����������ҳ��',"main.php");
                    exit();
                }
            }

            //error
            else if($res==-1)
            {
				ShowMsg('����û���������!',-1,0,1000);
				exit;
            }
            else
            {
                ShowMsg('����������!',-1,0,1000);
				exit;
            }
        }

        //password empty
        else
        {
            ShowMsg('�û�������û��д����!',-1,0,1000);
			exit;
        }
}


//����û�δ��¼ ����ʾ
if($msg=="nologin")
{
	$redmsg = '<div class=\'tips\'>�������û����������¼</div>';
}else
{
	$redmsg = '';
	}



//��ȡϵͳ���û��ĸ���,�����������5�����input���û�����,С��5�Ļ�,ֱ������select���û�ѡ��
$dsql = $GLOBALS['dsql'];
$usernumb=0;
$sql=" SELECT count(id) as dd   FROM #@__sys_admin";
$userrow = $dsql->GetOne($sql);
if(is_array($userrow))
{
	$usernumb=$userrow['dd'];
}
$userNameFrom="<input type='text' name='userName'/>";
if($usernumb<1)
{
       $optionarr="";
	    $dsql->SetQuery("SELECT userName  FROM `#@__sys_admin` order by logintime desc");
        $dsql->Execute();
        while($row = $dsql->GetArray())
        {
		   $optionarr.="<option value='".$row['userName']."'>".$row['userName']."</option>\r\n";
        }
	
	
	$userNameFrom="<select name='userName' style='width:135px'>\r\n".$optionarr."</select>\r\n";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $cfg_softname." ".$cfg_version; ?></title>
<link href="css/base.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />


</head>

<body>
<div id="login-box">
   <div class="login-top"></div>
   <?php echo $redmsg; ?>
   <div class="login-main">
    <form name="form1" method="post" action="login.php">
      <input type="hidden" name="gotopage" value="<?php if(!empty($gotopage)) echo $gotopage;?>" />
      <input type="hidden" name="dopost" value="login" />
      <dl>
	   <dt>�û�����</dt>
	   <dd>
	   <?php echo $userNameFrom;?>
       </dd>
	   <dt>��&nbsp;&nbsp;�룺</dt>
	   <dd><input type="password" class="alltxt" name="pwd"/></dd>
		<dt>&nbsp;</dt>
		<dd><button type="submit" name="sm1" class="login-btn" onclick="this.form.submit();">�� ¼</button></dd>
	 </dl>
	</form>
   </div>
   <div class="login-power"><strong>���ֹ���:<a href="integral/trundle_maina.php?class=a">A</a> <a href="integral/trundle_maina.php?class=b">B</a> <a href="integral/trundle_maina.php?class=c">C</a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
</div>
<script src="../js/ie6bye.js"></script>
</body>
</html>
