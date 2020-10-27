<?php
/**
 * 后台登陆
 *
 * @version        $Id: login.php 1 8:48 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__).'/include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
if(empty($dopost)) $dopost = '';

$msg="";

//登录检测
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
                    ShowMsg('成功登录，正在跳转！',$gotopage);
					if(file_exists('archives'))setcookie('NOT_ARC_VIEWD_URL',"", time()+3600, '/');   //这里是前台保存的地址 要注销掉

                    exit();
                }
                else
                {
                    ShowMsg('成功登录，正在转向管理管理主页！',"main.php");
                    exit();
                }
            }

            //error
            else if($res==-1)
            {
				ShowMsg('你的用户名不存在!',-1,0,1000);
				exit;
            }
            else
            {
                ShowMsg('你的密码错误!',-1,0,1000);
				exit;
            }
        }

        //password empty
        else
        {
            ShowMsg('用户和密码没填写完整!',-1,0,1000);
			exit;
        }
}


//如果用户未登录 则提示
if($msg=="nologin")
{
	$redmsg = '<div class=\'tips\'>请输入用户名和密码登录</div>';
}else
{
	$redmsg = '';
	}



//获取系统中用户的个数,如果个数大于5则输出input供用户输入,小于5的话,直接下拉select供用户选择
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
	   <dt>用户名：</dt>
	   <dd>
	   <?php echo $userNameFrom;?>
       </dd>
	   <dt>密&nbsp;&nbsp;码：</dt>
	   <dd><input type="password" class="alltxt" name="pwd"/></dd>
		<dt>&nbsp;</dt>
		<dd><button type="submit" name="sm1" class="login-btn" onclick="this.form.submit();">登 录</button></dd>
	 </dl>
	</form>
   </div>
   <div class="login-power"><strong>积分滚动:<a href="integral/trundle_maina.php?class=a">A</a> <a href="integral/trundle_maina.php?class=b">B</a> <a href="integral/trundle_maina.php?class=c">C</a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
</div>
<script src="../js/ie6bye.js"></script>
</body>
</html>
