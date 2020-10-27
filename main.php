<?php
/**
 * 管理后台首页
 *
 * @version        $Id: index.php 1 11:06 2010年7月13日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("config.php");
require_once(DEDEINC.'/dedetag.class.php');
$t1 = ExecTime();



?>

<!--This is IE DTD patch , Don't delete this line.-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $cfg_softname." ".$cfg_version; ?></title>
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="js/jquery/jquery.messager.js"></script>
<script src="js/frame.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
var $ = jQuery;
function JumpFrame(url1, url2){
	$('#menufra').get(0).src = url1;
	$('#main').get(0).src = url2;
}
</script>
</head>
<body class="showmenu"  onload="times()">
<div class="pagemask"></div>
<iframe class="iframemask"></iframe>
<div class="head">
  <div class="top">
    <div class="top_logo"> <img src="images/top_logo.gif" width="220" height="37" alt="欢迎使用" title="欢迎使用" /> </div>
    <div class="top_link">
      <ul>
        <li class="welcome"><span id="k"> </span> </li>
        <li class="welcome"><strong> 
		<?php 
		//此处不能太长,如果太长的话,分辨率小的时候,会看不到这一行
		//echo GetEmpDepAllNameByUserId($cuserLogin->getUserId(),$cuserLogin->getUserType())." ".GetEmpNameByUserId($cuserLogin->getUserId())." (".$cuserLogin->getUserName().")";
		echo GetEmpNameByUserId($cuserLogin->getUserId())." (".$cuserLogin->getUserName().")";
		?>
         </strong> </li>
        <li> <a href="#" id="togglemenu">隐藏菜单</a></li>
        <?php if(file_exists(dirname(__FILE__).'/archives'))echo "<li><a href='/'  target='_top'>首台首页</a></li>";  //1130如果有文档则输出         ?>
        <li><a href="index_body.php"  target="main">管理首页</a></li>
        <li><a href="changePwd.php" target="main">密码修改</a></li>
        <li><a href="exit.php" target="_top">退出</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="left">
  <div class="menu" id="menu">
    <iframe src="index_menu.php" id="menufra" name="menu" frameborder="0"></iframe>
  </div>
</div>
<div class="right">
  <div class="main">
    <iframe id="main" name="main" frameborder="0" src="index_body.php"></iframe>
  </div>
</div>
<script src="../js/ie6bye.js"></script>
</body>
</html>
<?php

$totalNumb=0;
$jsUrls="";   //未读SCRIPT连接地址
require_once("include/schedule.class.php");
$sc = new schedule();
$totalNumb=$sc->totalNumb;
$jsUrls=$sc->urlsjs;   //未读SCRIPT连接地址




//dump($arcNoViewdArray["url"]);
//if($cuserLogin->getUserType()<10&&$totalNumb>0)
if($totalNumb>0)
{//如果非管理员 并且未读内容大于0 输出未读内容
?>
<script>
    $(document).ready(function(){
        //内容
        strbody='<marquee  scrollamount=2 onmouseover=stop()  onmouseout=start() direction=\'up\'><div style=\'font-size:14px;line-height:24px;\'>';
    <?php
	    echo "title='你有".$totalNumb."条待办工作';\r\n";
		echo $jsUrls;
    ?>
        strbody+='</div></marquee>';
    
    
    
    
        autoclosetime=50000;  //自动关闭时间 0不自动关闭 毫秒单位
        $.messager.anim('slide', 3000);//slide动画消息  从下往上  默认这个
        //$.messager.anim('fade', 3000);//fadeIn动画消息  逐渐显示
        //$.messager.anim('show', 5000);//show动画消息  斜着弹出
        $.messager.lays(300, 200);  //提示框大小
        $.messager.show(title, strbody,autoclosetime);    
    });
    </script>
<?php }?>
<script language=javascript>
                    function times(){
                    var d=new initArray("星期日","星期一","星期二","星期三","星期四","星期五","星期六"); 
                          
                                  var enabled = 0; today = new Date();
                  var day; var date;
                  if(today.getDay()==0) day = "星期日"
                  if(today.getDay()==1) day = "星期一"
                  if(today.getDay()==2) day = "星期二"
                  if(today.getDay()==3) day = "星期三"
                  if(today.getDay()==4) day = "星期四"
                  if(today.getDay()==5) day = "星期五"
                  if(today.getDay()==6) day = "星期六"
                   var today=new Date();
                        hour=today.getHours();
                        minute=today.getMinutes();
                        second=today.getSeconds();
                       k.innerHTML="" +  today.getUTCFullYear() + "年"+  number_length((today.getMonth() + 1 ),2) + "月" + number_length(today.getDate(),2) + "日 &nbsp;"+number_length(hour,2)+":"+number_length(minute,2)+":"+number_length(second,2)+"&nbsp;&nbsp;&nbsp;"+day
                     setTimeout("times()",800);
                  }
                  
                  //数字长度补充
                  function number_length(N, L)
                  {
                      N = N + '';
                      M_len = L - N.length;
                  
                      for (i = 0; i < M_len; i++)
                      {
                          N = "0" + N;
                      }
                      return N;
                  }
                  function initArray(){
                  this.length=initArray.arguments.length
                  for(var i=0;i<this.length;i++)
                  this[i+1]=initArray.arguments[i]  }
                  </script>
<?php
$t2 = ExecTime();
//echo $t2-$t1;

exit();

?>