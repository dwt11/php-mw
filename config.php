<?php
/**
 * ����Ŀ¼�����ļ�
 *
 * @version        $Id: config.php 1 14:31 2010��7��12��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
define('DEDEPATH', str_replace("\\", '/', dirname(__FILE__) ) );//����ϵͳ��Ŀ¼Ϊ��ǰĿ¼ 
require_once(DEDEPATH.'/include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/role.func.php');

header('Cache-Control:private');
$dsql->safeCheck = FALSE;
$dsql->SetLongLink();

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = $s_scriptName = '';
//$isUrlOpen = @ini_get('allow_url_fopen');//141008�ദ��ֵ�˱���  ��ֻ��customfields11111.func.php��ʹ����
$dedeNowurl = GetCurUrl();

$dedeNowurls = explode('?', $dedeNowurl);


//��ʾ��150128��
if($dedeNowurl!="/main.php"&&$dedeNowurl!="/index_menu.php"&&$dedeNowurl!="/index_body.php"){
//�˶β���Ҫʹ�û���,�û�ע���,��ξͺ���������
//

		$obj = new COM("PHPdll.dwt11");//����VBд��DLL��PHPdll�ǹ�������test������
		$output=$obj->getCode(); // Call the "sum()" ����  150305�Ż�
		//echo $output;
		$reg_code=$obj->getRegCode($output); // ���ע����
		
		global $dsql;
		//��ȡ���ݿ��е�ע����
		$sql="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='1001'";
		$dsql->SetQuery($sql);
		$dsql->Execute();
        $row = $dsql->GetObject();
        if($reg_code!=$row->value)
        {//���δע��
			 
			  //��ȡϵͳ��ʼ����ʱ��
			  $sql1="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='2001'";
			  $dsql->SetQuery($sql1);
			  $dsql->Execute(1);
			  $row1 = $dsql->GetObject(1);
			  $startdate_sys=$row1->value;//150304�޸ı�������,��Ȼ�Ļ�,��ϵͳ�г�ͻ 
			 
			  //��ȡϵͳ���д���
			  $sql2="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='2000'";
			  $dsql->SetQuery($sql2);
			  $dsql->Execute(2);
			  $row2 = $dsql->GetObject(2);
			  $runnumb=$row2->value;
			 
              $daynumb=(time()-$startdate_sys)/86400;
			  
			  //���������������30��,������(��¼)��������300�� ����ʾ�û�δע��
			  if($daynumb>30||$runnumb>300)echo PutStr();

			  
			  //dump($daynumb."  ".$runnumb);
        }


}




$s_scriptName = $dedeNowurls[0];  ////    Ĭ��ֻȡ���������ĵ�ַ ����Ȩ���ж�   

//�����ַ�д��в��� ���Ҳ�������cid ���жϵ�ַ��Ϊ����CID��,�����ĵ�\�򵥼�¼\�豸��������з��๦�ܵĵط� Ȩ���ж�
//150111�Ż�,ԭʹ�ù��ܵ������ж�,�޸�Ϊֱ����CID�ж�, 
if(count($dedeNowurls)>1&&strpos( $dedeNowurls[1] , "cid" ) !== false)
{
		$s_scriptName = $dedeNowurl;
		$s_scriptNames = explode('&', $s_scriptName);   //ȥ���� & ��Ĳ���
		$s_scriptName = $s_scriptNames[0];  ////      
}
//$s_scriptName = $dedeNowurl;

//$cfg_remote_site = empty($cfg_remote_site)? 'N' : $cfg_remote_site;
//echo $s_scriptName;
//�����û���¼״̬
$cuserLogin = new userLogin();
//dump($cuserLogin->getUserId());
if($cuserLogin->getUserId()==-1)
{
	//ShowMsg("�û���¼��ϢʧЧ,�����µ�¼!",""); ����������  �� header������
    
	
	//���ֱ�Ӵ���վ��ҳ ����ʾ�û� �����û���������
	//����Ǵ򿪵�������ҳ ��Ҫ��ʾ�û� ���� �û����������¼ 
	if($dedeNowurl=="/"||$dedeNowurl=="/main.php")
	{
		$jumpurl="$cfg_install_path/login.php?gotopage=".urlencode($dedeNowurl);
	}else
	{
		$jumpurl="$cfg_install_path/login.php?msg=nologin&gotopage=".urlencode($dedeNowurl);
		}
	header("location:$jumpurl");
    exit();
}



//����Ȩ���ж�
//��ȡ��ǰ��ҳ��ĵ�ַ,�������Ŀ¼�µ�,���ж��Ƿ���в���Ȩ��
$s_scriptNames = explode('/', $s_scriptName);
if(count($s_scriptNames)>2)
{
	  $filename = $s_scriptNames[2];//��ǰ�������ļ���
	  $funDirName = $s_scriptNames[1];//��ǰ�������ļ���
	  
	  global $funAllName;
	  $funAllName=$funDirName."/".$filename;
	   // dump($s_scriptNames);//sys/sys_data.done.php   //140927���ҳ�������ݿ⻹ԭ��ҳ��  �򲻼��Ȩ��  ��Ϊ���Ȩ���Ǵ����ݿ��ȡ�ģ�����ԭ���ݿ�ʱ��������ݿ�  ����û��Ȩ��
	  // dump($funAllName);
	   //??����Ҫ���� ����ǹ���Ա�ˣ��Ų���� ������
	  if($filename!=""&&$filename!="sys_data.done.php")Check_webRole($funAllName);



	  //�����ݿ��ȡ��ǰ����ҳ�ı���
	  
	  //���� XXX.do.php xxx.class.php��ҳ��
	  //dump($funAllName);
	  $doClassFiles = explode('.', $funAllName);
	  if(count($doClassFiles)<3)
	  {
		  $sysFunInfo = $dsql->getone("select title from #@__sys_function where urladd='$funAllName'");
		  if($sysFunInfo=="")
		  {
			  
					$filenameArray=explode('/',$funAllName);
					$filename=$filenameArray[1];
					require_once("baseconfig/sys_baseconfg.class.php");
					$fun = new sys_baseconfg();
					$oneBaseConfigs = $fun->getOneBaseConfig($filename);  //����Ŀѡ��
					if($oneBaseConfigs!="")
					{
						$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
						$sysFunTitle=$oneBaseConfigsArray[2];
					}else
					{
						$sysFunTitle="��תҳ���δ���ñ���"; 
					}
		   }else
		   {
			  $sysFunTitle = $sysFunInfo['title'];
		   }
	  }
}




//��¼ϵͳ������־
if($cfg_dede_log=='Y')
{
    //$s_nologfile = '_main|_list';
    $s_needlogfile = 'sys_|file_';
    $s_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    $s_query = isset($dedeNowurls[1]) ? $dedeNowurls[1] : '';
    $s_scriptNames = explode('/', $s_scriptName);
    $s_scriptNames = $s_scriptNames[count($s_scriptNames)-1];
    $s_userip = GetIP();
    //if( $s_method=='POST' || (!preg_match("#".$s_nologfile."#i", $s_scriptNames) && $s_query!='') || preg_match("#".$s_needlogfile."#i",$s_scriptNames) )
    //{
    
	    $inquery = "INSERT INTO `#@__sys_log`(adminid,filename,method,query,cip,dtime)
             VALUES ('".$cuserLogin->getUserId()."','{$s_scriptNames}','{$s_method}','".addslashes($s_query)."','{$s_userip}','".time()."');";
	//dump($inquery);
       
	    $dsql->ExecuteNoneQuery($inquery);
   // }
}


















function PutStr()
{
	
	  $bootomRand=dotrand(0,545);
	  $str="<style type='text/css'>
	  * {
		  margin: 0;
		  padding: 0;
		  list-style-type: none;
	  }
	  a, img {
		  border: 0;
	  }
	  #mintbar {
		  filter: alpha(opacity=90);
		  -moz-opacity:0.9;  
		  -khtml-opacity: 0.3;  
		  opacity: 0.9;  
		  position: absolute;
		  z-index: 2147483647;
		  background: url('../images/top_bg.jpg') repeat-x 0px 3px;
		  font-size: 14px;
		  font-family: Arial, Helvetica, Sans-serif;
		  color: #FFF;
		  padding: 0;
		  bottom: ".$bootomRand."px;/*����Ҫ0-545���λ��*/
		  width: 100%;
		  text-align: center;
		  height: 40px;
	  }
	  #mintbar div {
		  position: relative;
		  margin: 0 auto;
		  padding-top: 10px;
		  
		  height: 30px;
	  }
	  #mintbar div h2 {
		  font-size: 16px;
		  color:ffffff
	  }
	  </style>
	  <div id='mintbar'>
		<div>
		  <h2 align='center'><img src='../images/tips.gif'> ע������ʾ�򽫲���ʾ,����ϵ�绰    ��ȡע���� </h2>
		</div>
	  </div>";
		  
		  
	  return $str;	
}









// ��ջ���tplcacheĿ¼
function ClearCache()
{
    $tplCache = DEDEDATA.'/tplcache/';
    $fileArray = glob($tplCache."*.*");
    if (count($fileArray) > 1)
    {
        foreach ($fileArray as $key => $value)
        {
           // dump($value);
			if (file_exists($value)) unlink($value);
            else continue;
        }
        return TRUE;
    }
    return FALSE;
}


/**
 *  ����ģ���ļ�  �����������,һ��ԭDEDE��EDIT ADDҳ���� ,���ڸ�Ϊֱ����PHPҳ������ 140821
 *
 * @access    public
 * @param     string  $filename  �ļ�����
 * @param     bool  $isabs  �Ƿ�Ϊ����Ŀ¼
 * @return    string
*/ 
function DedeInclude($filename, $isabs=FALSE)
{
    return $isabs ? $filename : DEDEPATH.'/'.$filename;
}

helper('cache');
