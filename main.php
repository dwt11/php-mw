<?php
/**
 * �����̨��ҳ
 *
 * @version        $Id: index.php 1 11:06 2010��7��13��Z tianya $
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
    <div class="top_logo"> <img src="images/top_logo.gif" width="220" height="37" alt="��ӭʹ��" title="��ӭʹ��" /> </div>
    <div class="top_link">
      <ul>
        <li class="welcome"><span id="k"> </span> </li>
        <li class="welcome"><strong> 
		<?php 
		//�˴�����̫��,���̫���Ļ�,�ֱ���С��ʱ��,�ῴ������һ��
		//echo GetEmpDepAllNameByUserId($cuserLogin->getUserId(),$cuserLogin->getUserType())." ".GetEmpNameByUserId($cuserLogin->getUserId())." (".$cuserLogin->getUserName().")";
		echo GetEmpNameByUserId($cuserLogin->getUserId())." (".$cuserLogin->getUserName().")";
		?>
         </strong> </li>
        <li> <a href="#" id="togglemenu">���ز˵�</a></li>
        <?php if(file_exists(dirname(__FILE__).'/archives'))echo "<li><a href='/'  target='_top'>��̨��ҳ</a></li>";  //1130������ĵ������         ?>
        <li><a href="index_body.php"  target="main">������ҳ</a></li>
        <li><a href="changePwd.php" target="main">�����޸�</a></li>
        <li><a href="exit.php" target="_top">�˳�</a></li>
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
$jsUrls="";   //δ��SCRIPT���ӵ�ַ
require_once("include/schedule.class.php");
$sc = new schedule();
$totalNumb=$sc->totalNumb;
$jsUrls=$sc->urlsjs;   //δ��SCRIPT���ӵ�ַ




//dump($arcNoViewdArray["url"]);
//if($cuserLogin->getUserType()<10&&$totalNumb>0)
if($totalNumb>0)
{//����ǹ���Ա ����δ�����ݴ���0 ���δ������
?>
<script>
    $(document).ready(function(){
        //����
        strbody='<marquee  scrollamount=2 onmouseover=stop()  onmouseout=start() direction=\'up\'><div style=\'font-size:14px;line-height:24px;\'>';
    <?php
	    echo "title='����".$totalNumb."�����칤��';\r\n";
		echo $jsUrls;
    ?>
        strbody+='</div></marquee>';
    
    
    
    
        autoclosetime=50000;  //�Զ��ر�ʱ�� 0���Զ��ر� ���뵥λ
        $.messager.anim('slide', 3000);//slide������Ϣ  ��������  Ĭ�����
        //$.messager.anim('fade', 3000);//fadeIn������Ϣ  ����ʾ
        //$.messager.anim('show', 5000);//show������Ϣ  б�ŵ���
        $.messager.lays(300, 200);  //��ʾ���С
        $.messager.show(title, strbody,autoclosetime);    
    });
    </script>
<?php }?>
<script language=javascript>
                    function times(){
                    var d=new initArray("������","����һ","���ڶ�","������","������","������","������"); 
                          
                                  var enabled = 0; today = new Date();
                  var day; var date;
                  if(today.getDay()==0) day = "������"
                  if(today.getDay()==1) day = "����һ"
                  if(today.getDay()==2) day = "���ڶ�"
                  if(today.getDay()==3) day = "������"
                  if(today.getDay()==4) day = "������"
                  if(today.getDay()==5) day = "������"
                  if(today.getDay()==6) day = "������"
                   var today=new Date();
                        hour=today.getHours();
                        minute=today.getMinutes();
                        second=today.getSeconds();
                       k.innerHTML="" +  today.getUTCFullYear() + "��"+  number_length((today.getMonth() + 1 ),2) + "��" + number_length(today.getDate(),2) + "�� &nbsp;"+number_length(hour,2)+":"+number_length(minute,2)+":"+number_length(second,2)+"&nbsp;&nbsp;&nbsp;"+day
                     setTimeout("times()",800);
                  }
                  
                  //���ֳ��Ȳ���
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