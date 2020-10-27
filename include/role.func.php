<?php   if(!defined('DEDEINC')) exit('Request Error!');


/**
 *  ��Ȩ�޼��󷵻ز����Ի���
 *
 * @access    public
 * @param     string  $n  ��������
 * @param     string  $userid  �û�ID,�����ĵ�������, �༭ ��ɾ�� ���ܴ���Щֵ,�����жϵ�ǰ�ļ�¼�Ƿ�ǰ��¼���û�������,����ǵ�ǰ��¼�û������� ��ɹ���
 * @return    string
 */
function Check_webRole($n)
{
    
	//dump($n);
    if(!Test_webRole($n))
    {
        ShowMsg("�Բ�����û��Ȩ��ִ�д˲�����<br/><br/><a href='javascript:history.go(-1);'>����˷�����һҳ&gt;&gt;</a>",'javascript:;');
        exit();
    }
}





/**
 *  �����û��Ƿ���Ȩʹ��ĳ����,���������һ����ֵ����
 *  Check_webRole����ֻ�Ƕ�����ֵ��һ���������
 *
 * @access    public
 * @param     string  $n  ��������
 * @param     string  $userid  �û�ID,�����ĵ�������, �༭ ��ɾ�� ���ܴ���Щֵ,�����жϵ�ǰ�ļ�¼�Ƿ�ǰ��¼���û�������,����ǵ�ǰ��¼�û������� ��ɹ���
 * @return    mix  ��������򷵻�TRUE
 */
function Test_webRole($n)
{
	//dump($n);
	global $dsql;
    $rs_Web = false;
	$web_role="";


	//1������� XXX.do.php xxx.class.php��ҳ�� ֱ�ӷ���TRUE(��Щҳ�治����Ȩ���ж�)
	$doClassFiles = explode('.', $n);
	if(count($doClassFiles)>2)
	{
		if($doClassFiles[2]!="")return TRUE;
	}
	
	
	
	
    //2�û������ڶ��Ȩ����Ļ�,��ϲ����ҳ��Ȩ��ֵ
	//??��������Ƿ�Ҫ�Ż�   ��Ϊÿ�ε�� ��Ҫ�������ж�,�Ƿ�ֱ�Ӵӻ����ȡ
	//dump($GLOBALS['cuserLogin']->getUserType());
	$usertypes = explode(',', $GLOBALS['cuserLogin']->getUserType());
	foreach($usertypes as $usertype)
	{
		  //ֱ�Ӵ����� ���ȡ Ȩ������
		  $sql="SELECT web_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$usertype."'";
		  $groupSet = $dsql->GetOne($sql);
		  if(is_array($groupSet))$web_role .= $groupSet['web_role']."|";
	}

	//2.1����ǹ���Ա �򷵻�TRUE
	if(preg_match('/admin_AllowAll/i',$web_role))
    {
        return TRUE;
    }
    if($n=='')
    {
        return TRUE;
    }

	$web_role = rtrim($web_role,"|");
	$web_roles = explode('|', $web_role);


	



//-----------2.2Ȩ���ж�
		//�������CID,���ȡ�����ϼ��ĵ�ַ
//       
//			$n_Array=explode('cid',$n);  //�ָ���ַ ���ڻ�ȡ�ļ�����
//			dump($n_Array);
//			$dirName=$urladdArray[0];//����ļ�������
		if(strpos( $n , "cid=" ) !== false)
		{
			$urladdArray=explode('/',$n);  //�ָ���ַ ���ڻ�ȡ�ļ�����
			$dirName=$urladdArray[0];//����ļ�������
			// dump($n);
			if(UrlAddFileExists(DEDEPATH."/".$dirName."/catalog.inc.class.php"))   //
			{//����ļ����� ���ȡ�����ϼ�ID
				  $n=preg_replace("#\?userid=[0-9]*#", '',$n);   //�����USERID
				  $n=preg_replace("#\?depid=[0-9]*#", '',$n);   //�����depid
				  $star=strpos( $n , "cid=" )+4;
				  $lenth=strlen($n)-$star;
				  $cid=substr($n,$star,$lenth);
	  
	  
				  global $parentUrlArray;
				  $parentUrlArray="";//���е�ǰN��ַ���ϼ���ַ
				  $reidArray="";
							  
				  require_once(DEDEPATH."/".$dirName."/catalog.inc.class.php");
				  $classname=$dirName."CatalogInc";
				  $newClassName=$dirName."ClI";
				  $$newClassName = new $classname();
				  $reidArray=$$newClassName->GetAllParentUrlToRole($cid);  
				  //dump($reidArray);
	  
				  if(is_array($reidArray))
				  {
					  for($reidi=0;$reidi<count($reidArray);$reidi++)
					  {
						  $nowcid=$reidArray[$reidi];
						  $parentUrlArray[]= preg_replace("#cid=[0-9]*#", 'cid='.$nowcid,$n);   //�滻����ַ�е�CID
					  }
				  }
			}
		}
		
		
	
		//���ж��Լ��Ƿ���Ȩ��
		if(in_array($n,$web_roles))
		{
			return TRUE; 
		}
		
		//����Լ�û��Ȩ��,Ȼ����ж��ϼ��Ƿ���Ȩ��
		//��һ��  archives ����
	
	
	    //150111�Ż�,������Щ���ж�ֱ����ʾ ����ҳ����:����list  ��չҳ�治�������ź��û����ݵ� 
		//�����ж����,�жϰ����û��Ͳ������ݵ���չҳ���Ȩ��



		//�ж��Ƿ������������ ,��������չ����(edit��DELҳ��)
		//ԭʼ�õ����,�Ż��ٶ� ʱȡ��,ʹ��ֱ���жϵ�ַ��
//		require_once(DEDEPATH."/sys/sys_group.class.php");
//		$fun = new sys_group();
//		$isdep=$fun->isDepRoleToTestRole($n);   //�Ƿ������������,��������չ����(edit��DELҳ��)
		
		
		//$isdepeditdel=(strpos($n , "_edit" )!== false||strpos($n , "_del" )!== false)&&strpos( $n , "userid" ) !== false;    141207ԭΪ�˾��Ϊ�¾�,����û�û����Ȩ���趨��ѡ���ŵı༭Ȩ��,���Լ�����������,��ʾ�༭��ť,���������ʾ��Ȩ��
		//_repair��ȱ�ݹ��������ҳ��
		//$isdepeditdel=(strpos($n , "_edit" )!== false||strpos($n , "_del" )!== false||strpos($n , "_repair" )!== false);//???141215�˾�Ҫ�Ż� �������»������ж��Ƿ���չ����(�����е���ҳ������»���,�������һ��)
		$isdepeditdel=(strpos($n , "_" )!== false);//150112�Ż� �����»������ж��Ƿ���չ����
		if($isdepeditdel)
		{
			 //dump(check_dep_plus($n));
			 if(check_dep_plus($n)) return true;
			
		}else if(!$rs_Web&&isset($parentUrlArray)&&is_array($parentUrlArray))
		{
			  foreach($parentUrlArray as $parentUrl)
			  {
				  if(in_array($parentUrl,$web_roles))
				  {
			//dump($parentUrl);
					  return TRUE; 
				  }
			  }
		 }
		






    return $rs_Web;
}











function check_dep_plus($n)
{
		//$isdepeditdel= false;
					//dump($n);
		//���������������,�������ж�
				$userid="";//�õ���������,����ǹ�����־ �� �ĵ����ҳ��,ʹ��USERID����ȡ����ID
				$depid="";//�õ���������,�����Ա�������ҳ��,ֱ�ӱ����в���ID��
				
				
				//������б�ҳ�洫������userid
				
				if(strpos( $n , "userid" ) !== false)
				{//������� userid
					$star=strpos( $n , "userid=" )+7;
					$lenth=strlen($n)-$star;
					$userid=substr($n,$star,$lenth);
				}else//141206ԭ��û�����else �Ƿֿ���,��1205ע����unset ���� �б�ҳ�洫������userid��sessionҪ�����else������
				{
					
					  //$userid=3809;
					  //�����xxx.do.PHPҳ��,�û�����༭��DEL��,��SESSION��������
					 // dump($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]);
					  if(isset($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]))
					  {
						  $userid=$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()];	
						  //unset($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]);   //141205�޸� ����༭ʱ��DOҳ�潫���ݵ�userid������ֵ,Ȼ��ע�� ֱ���û��´�do��ʱ���µ�ֵ,���ע���Ļ�,�û����Լ����������ݵ�༭��,�ٵ㱣��Ļ�,��ʾ����
					  }
					
					
				}
				
				//dump($userid);
				if($userid!="")
				{
					  $userids_role=$GLOBALS['cuserLogin']->getUserId();//Ĭ���Լ��ĵ�¼id ���й����Լ���Ȩ��
					  
					  //����������е�ǰҳ��͵�ǰ��¼�û���Ȩ��,��ӻ����ȡ �������ݿ��ȡ 141206�Ż�
					  if(!isset($_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()]))
					  {					  
						  $deps_role = getDepRole($n);     //�Ӳ���Ȩ���л�ȡ �ɹ���Ĳ���ID��
						  
						  //$deps_role="1,15,2,10,3,16,4,11,5,17,6,18,7,19,8,20,9,14";
						  if($deps_role!="")
						  {
							  $userids_role=$userids_role.",".GetDepAllUserId($deps_role);//�ɹ�����û�+��ǰ��¼�û�
							  $_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()]=$userids_role;  //����ÿ�����ӵ�Ȩ��
						  }
					  }else
					  {
						  
						  $userids_role= $_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()];
					  }
					// dump($n);
					// dump($userids_role);
					  
/*					  
					     //���ӻ���Ĵ���
					     $deps_role = getDepRole($n);     //�Ӳ���Ȩ���л�ȡ �ɹ���Ĳ���ID��
						  if($deps_role!="")
						  {
							  $userids_role=GetDepAllUserId($deps_role).",".$GLOBALS['cuserLogin']->getUserId();//�ɹ�����û�+��ǰ��¼�û�
						  }
*/					  
						if($userids_role!="")
						{
							  $userid_roleArray=explode(",",$userids_role);
							  if(in_array($userid,$userid_roleArray))return TRUE; 
						}
				}
				
				
				
			
			
				
               //������б�ҳ�洫������depid
			   //ȱ�ݼ�¼��ҳ��ֱ�Ӱ���depid ���ж�Ȩ��
			   //141215����
				if(strpos( $n , "depid" ) !== false)
				{//������� userid
					$star=strpos( $n , "depid=" )+6;
					$lenth=strlen($n)-$star;
					$depid=substr($n,$star,$lenth);
				}else
				{
					//�����plus.do.PHPҳ��,�û�����༭��DEL��,��SESSION��������
					if(isset($_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]))
					{
						$depid=$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()];	
					
					}
				}
				if($depid!="")
				{
						 //���ӻ���Ĵ���
						 $deps_role = getDepRole($n);     //�Ӳ���Ȩ���л�ȡ �ɹ���Ĳ���ID��
						  if($deps_role!="")
						  {
							  $deps_roleArray=explode(",",$deps_role);
							  if(in_array($depid,$deps_roleArray))return TRUE; 
						  }
					
				}
				
				


 //   dump($n."��ַ");



		
		
}











/**
 *  ���ɵ�ǰ��¼�û��� ����ID��ѯSQL
 *
 * @access    public
 * @param     string  $funAllName  ��ǰ�򿪵��ļ�
 * @param     string  $FieldName  ���ɵĲ�ѯ�����ֶ�����(���Ϊ����ֻ����Զ��ŷָ���depid,��Ϊ�������sql)
 * @return    string
 */
function getDepRole($funAllName,$FieldName="")
{
	global $dsql;
	
	$funAllName=	preg_replace("#\?userid=[0-9]*|\&userid=[0-9]*|\?depid=[0-9]*|\&depid=[0-9]*#", '',$funAllName);   //�����USERID��usertype���ڻ�ȡ��������
	//dump($funAllName);

	$return_str="";
    $dep_role_str="";
	$usertypes = explode(',', $GLOBALS['cuserLogin']->getUserType());    //�û������ڶ��Ȩ����Ļ�,��ֱ����������


	$depRoleArrary=array();
	$webRoleArrary=array();
    foreach($usertypes as $usertype)
    {
		  //ֱ�Ӵ����� ���ȡ Ȩ������
		  $sql="SELECT web_role,department_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$usertype."'";
		  $groupSet = $dsql->GetOne($sql);
		  array_push($depRoleArrary,$groupSet['department_role']);
		  array_push($webRoleArrary,$groupSet['web_role']);
	}
   // dump($webRoleArrary);
   //dump($depRoleArrary);
    //ѭ�����Ȩ���������
    foreach($depRoleArrary as $dep_role)
    {
		//����ǹ���Ա �򷵻�TRUE
		  if(preg_match('/admin_AllowAll/i',$dep_role))
		  {
			  return "";
		  }
	}



//�޼̳�Ȩ�޵�,��Ա������,ֱ�ӻ�ȡ��ǰ����ҳ���Ӧ�Ĳ���Ȩ�޵�����
	  foreach($webRoleArrary as $key =>$web_role)
	  {
			$web_roles = explode('|', $web_role);
			$funFileNameKey = array_search($funAllName, $web_roles);  //�õ�����KEY
			if($funFileNameKey!==false)     //���� === �� !== ���бȽ�ʱ�򲻽�������ת������Ϊ��ʱ���ͺ���ֵ��Ҫ�ȶ�(��Ϊkeyֵ�п�����0,�����!=�ȽϵĻ�0Ҳ��false)
			{
				$dep_roles = explode('|', $depRoleArrary[$key]);
		   //dump($depRoleArrary[$key]);
				$dep_role_str.=$dep_roles[$funFileNameKey].",";
			}
	  }


	
	//�����CID,��ѭ������CID���ϼ�����
	//����ϼ���Ŀ��,����Ȩ��,�����ǰ��ĿҲ�й���Ȩ��
	//��һ����Ϊ��--����ӵĹ��ܰ�������Ŀ,������Ŀ��webrole����Ȩ�ޱ���,���˵��г�������Ŀ�ĵ�ַ,���û��������Ŀ��ַ��,����Ҫѭ���ж�һ��
	global $parentUrlArray;
	if(is_array($parentUrlArray))
	{
		
		//dump($webRoleArrary );
				foreach($parentUrlArray as $parentUrl)
				{
					foreach($webRoleArrary as $key =>$web_role)
					{
						  $web_roles = explode('|', $web_role);
						  $funFileNameKey = array_search($parentUrl, $web_roles);  //�õ�����KEY
						  if($funFileNameKey!==false)     //���� === �� !== ���бȽ�ʱ�򲻽�������ת������Ϊ��ʱ���ͺ���ֵ��Ҫ�ȶ�(��Ϊkeyֵ�п�����0,�����!=�ȽϵĻ�0Ҳ��false)
						  {
							  $dep_roles = explode('|', $depRoleArrary[$key]);
						 //dump($depRoleArrary[$key]);
							  $dep_role_str.=$dep_roles[$funFileNameKey].",";
						  }
					}
				}
	}







		$dep_role_str=rtrim($dep_role_str,",");//ɾ���Ҳ����Ķ���
		$dep_role_str=implode(",",array_unique(explode(",",$dep_role_str)));//ɾ���ظ���ֵ

//dump($dep_role_str."����");
	if ($dep_role_str!="")
	{
		if($FieldName!="")
		{
			$return_str=" and ".$FieldName." in (".$dep_role_str.") ";
		}else
		{
			$return_str=$dep_role_str;
		}
		
	}
	return $return_str;
}






























































