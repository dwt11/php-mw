<?php   if(!defined('DEDEINC')) exit('Request Error!');


/**
 *  对权限检测后返回操作对话框
 *
 * @access    public
 * @param     string  $n  功能名称
 * @param     string  $userid  用户ID,用在文档管理中, 编辑 和删除 功能传入些值,用于判断当前的记录是否当前登录的用户发布的,如果是当前登录用户发布的 则可管理
 * @return    string
 */
function Check_webRole($n)
{
    
	//dump($n);
    if(!Test_webRole($n))
    {
        ShowMsg("对不起，你没有权限执行此操作！<br/><br/><a href='javascript:history.go(-1);'>点击此返回上一页&gt;&gt;</a>",'javascript:;');
        exit();
    }
}





/**
 *  检验用户是否有权使用某功能,这个函数是一个回值函数
 *  Check_webRole函数只是对他回值的一个处理过程
 *
 * @access    public
 * @param     string  $n  功能名称
 * @param     string  $userid  用户ID,用在文档管理中, 编辑 和删除 功能传入些值,用于判断当前的记录是否当前登录的用户发布的,如果是当前登录用户发布的 则可管理
 * @return    mix  如果具有则返回TRUE
 */
function Test_webRole($n)
{
	//dump($n);
	global $dsql;
    $rs_Web = false;
	$web_role="";


	//1、如果是 XXX.do.php xxx.class.php的页面 直接返回TRUE(这些页面不参与权限判断)
	$doClassFiles = explode('.', $n);
	if(count($doClassFiles)>2)
	{
		if($doClassFiles[2]!="")return TRUE;
	}
	
	
	
	
    //2用户有属于多个权限组的话,则合并输出页面权限值
	//??这个后期是否要优化   因为每次点击 都要来这里判断,是否直接从缓存读取
	//dump($GLOBALS['cuserLogin']->getUserType());
	$usertypes = explode(',', $GLOBALS['cuserLogin']->getUserType());
	foreach($usertypes as $usertype)
	{
		  //直接从数据 库获取 权限内容
		  $sql="SELECT web_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$usertype."'";
		  $groupSet = $dsql->GetOne($sql);
		  if(is_array($groupSet))$web_role .= $groupSet['web_role']."|";
	}

	//2.1如果是管理员 则返回TRUE
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


	



//-----------2.2权限判断
		//如果包含CID,则获取所有上级的地址
//       
//			$n_Array=explode('cid',$n);  //分隔地址 用于获取文件名称
//			dump($n_Array);
//			$dirName=$urladdArray[0];//获得文件夹名称
		if(strpos( $n , "cid=" ) !== false)
		{
			$urladdArray=explode('/',$n);  //分隔地址 用于获取文件名称
			$dirName=$urladdArray[0];//获得文件夹名称
			// dump($n);
			if(UrlAddFileExists(DEDEPATH."/".$dirName."/catalog.inc.class.php"))   //
			{//如果文件存在 则获取他的上级ID
				  $n=preg_replace("#\?userid=[0-9]*#", '',$n);   //清除掉USERID
				  $n=preg_replace("#\?depid=[0-9]*#", '',$n);   //清除掉depid
				  $star=strpos( $n , "cid=" )+4;
				  $lenth=strlen($n)-$star;
				  $cid=substr($n,$star,$lenth);
	  
	  
				  global $parentUrlArray;
				  $parentUrlArray="";//所有当前N地址的上级地址
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
						  $parentUrlArray[]= preg_replace("#cid=[0-9]*#", 'cid='.$nowcid,$n);   //替换掉网址中的CID
					  }
				  }
			}
		}
		
		
	
		//先判断自己是否有权限
		if(in_array($n,$web_roles))
		{
			return TRUE; 
		}
		
		//如果自己没有权限,然后就判断上级是否有权限
		//这一项  archives 里用
	
	
	    //150111优化,以上这些是判断直接显示 包含页面有:所有list  扩展页面不包含部门和用户数据的 
		//上述判断完后,判断包含用户和部门数据的扩展页面的权限



		//判断是否包含部门数据 ,并且是扩展功能(edit和DEL页面)
		//原始用的这个,优化速度 时取消,使用直接判断地址的
//		require_once(DEDEPATH."/sys/sys_group.class.php");
//		$fun = new sys_group();
//		$isdep=$fun->isDepRoleToTestRole($n);   //是否包含部门数据,并且是扩展功能(edit和DEL页面)
		
		
		//$isdepeditdel=(strpos($n , "_edit" )!== false||strpos($n , "_del" )!== false)&&strpos( $n , "userid" ) !== false;    141207原为此句改为下句,如果用户没有在权限设定里选择部门的编辑权限,但自己发布的内容,显示编辑按钮,但点击后提示无权限
		//_repair是缺陷管理的整改页面
		//$isdepeditdel=(strpos($n , "_edit" )!== false||strpos($n , "_del" )!== false||strpos($n , "_repair" )!== false);//???141215此句要优化 随后根据下划线来判断是否扩展功能(现在有的主页面包含下划线,随后整合一下)
		$isdepeditdel=(strpos($n , "_" )!== false);//150112优化 根据下划线来判断是否扩展功能
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
		//如果包含部门数据,则这样判断
				$userid="";//得到部门数据,这个是工作日志 或 文档类的页面,使用USERID来获取部门ID
				$depid="";//得到部门数据,这个是员工管理等页面,直接保存有部门ID的
				
				
				//这个是列表页面传过来的userid
				
				if(strpos( $n , "userid" ) !== false)
				{//如果包含 userid
					$star=strpos( $n , "userid=" )+7;
					$lenth=strlen($n)-$star;
					$userid=substr($n,$star,$lenth);
				}else//141206原来没有这个else 是分开的,但1205注销了unset 所以 列表页面传过来的userid和session要加这个else来区别
				{
					
					  //$userid=3809;
					  //这个是xxx.do.PHP页面,用户点击编辑或DEL后,从SESSION付过来的
					 // dump($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]);
					  if(isset($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]))
					  {
						  $userid=$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()];	
						  //unset($_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]);   //141205修改 点击编辑时到DO页面将数据的userid赋给此值,然后不注销 直接用户下次do的时候赋新的值,如果注销的话,用户在自己发布的数据点编辑后,再点保存的话,提示错误
					  }
					
					
				}
				
				//dump($userid);
				if($userid!="")
				{
					  $userids_role=$GLOBALS['cuserLogin']->getUserId();//默认自己的登录id 具有管理自己的权限
					  
					  //如果缓存中有当前页面和当前登录用户的权限,则从缓存读取 不从数据库读取 141206优化
					  if(!isset($_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()]))
					  {					  
						  $deps_role = getDepRole($n);     //从部门权限中获取 可管理的部门ID，
						  
						  //$deps_role="1,15,2,10,3,16,4,11,5,17,6,18,7,19,8,20,9,14";
						  if($deps_role!="")
						  {
							  $userids_role=$userids_role.",".GetDepAllUserId($deps_role);//可管理的用户+当前登录用户
							  $_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()]=$userids_role;  //缓存每个连接的权限
						  }
					  }else
					  {
						  
						  $userids_role= $_SESSION['session_'.$n.'_'.$GLOBALS['cuserLogin']->getUserId()];
					  }
					// dump($n);
					// dump($userids_role);
					  
/*					  
					     //不加缓存的代码
					     $deps_role = getDepRole($n);     //从部门权限中获取 可管理的部门ID，
						  if($deps_role!="")
						  {
							  $userids_role=GetDepAllUserId($deps_role).",".$GLOBALS['cuserLogin']->getUserId();//可管理的用户+当前登录用户
						  }
*/					  
						if($userids_role!="")
						{
							  $userid_roleArray=explode(",",$userids_role);
							  if(in_array($userid,$userid_roleArray))return TRUE; 
						}
				}
				
				
				
			
			
				
               //这个是列表页面传过来的depid
			   //缺陷记录等页面直接包含depid 来判断权限
			   //141215增加
				if(strpos( $n , "depid" ) !== false)
				{//如果包含 userid
					$star=strpos( $n , "depid=" )+6;
					$lenth=strlen($n)-$star;
					$depid=substr($n,$star,$lenth);
				}else
				{
					//这个是plus.do.PHP页面,用户点击编辑或DEL后,从SESSION付过来的
					if(isset($_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]))
					{
						$depid=$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()];	
					
					}
				}
				if($depid!="")
				{
						 //不加缓存的代码
						 $deps_role = getDepRole($n);     //从部门权限中获取 可管理的部门ID，
						  if($deps_role!="")
						  {
							  $deps_roleArray=explode(",",$deps_role);
							  if(in_array($depid,$deps_roleArray))return TRUE; 
						  }
					
				}
				
				


 //   dump($n."地址");



		
		
}











/**
 *  生成当前登录用户的 部门ID查询SQL
 *
 * @access    public
 * @param     string  $funAllName  当前打开的文件
 * @param     string  $FieldName  生成的查询语句的字段名称(如果为空则只输出以逗号分隔的depid,不为空则输出sql)
 * @return    string
 */
function getDepRole($funAllName,$FieldName="")
{
	global $dsql;
	
	$funAllName=	preg_replace("#\?userid=[0-9]*|\&userid=[0-9]*|\?depid=[0-9]*|\&depid=[0-9]*#", '',$funAllName);   //清除掉USERID或usertype用于获取部门数据
	//dump($funAllName);

	$return_str="";
    $dep_role_str="";
	$usertypes = explode(',', $GLOBALS['cuserLogin']->getUserType());    //用户有属于多个权限组的话,则分别存入数组中


	$depRoleArrary=array();
	$webRoleArrary=array();
    foreach($usertypes as $usertype)
    {
		  //直接从数据 库获取 权限内容
		  $sql="SELECT web_role,department_role FROM `#@__sys_admintype` WHERE CONCAT(`rank`)='".$usertype."'";
		  $groupSet = $dsql->GetOne($sql);
		  array_push($depRoleArrary,$groupSet['department_role']);
		  array_push($webRoleArrary,$groupSet['web_role']);
	}
   // dump($webRoleArrary);
   //dump($depRoleArrary);
    //循环多个权限组的内容
    foreach($depRoleArrary as $dep_role)
    {
		//如果是管理员 则返回TRUE
		  if(preg_match('/admin_AllowAll/i',$dep_role))
		  {
			  return "";
		  }
	}



//无继承权限的,如员工管理,直接获取当前功能页面对应的部门权限的数据
	  foreach($webRoleArrary as $key =>$web_role)
	  {
			$web_roles = explode('|', $web_role);
			$funFileNameKey = array_search($funAllName, $web_roles);  //得到索引KEY
			if($funFileNameKey!==false)     //当用 === 或 !== 进行比较时则不进行类型转换，因为此时类型和数值都要比对(因为key值有可能是0,如果用!=比较的话0也是false)
			{
				$dep_roles = explode('|', $depRoleArrary[$key]);
		   //dump($depRoleArrary[$key]);
				$dep_role_str.=$dep_roles[$funFileNameKey].",";
			}
	  }


	
	//如果有CID,则循环所有CID的上级部门
	//如果上级栏目有,管理权限,则代表当前栏目也有管理权限
	//这一步是为了--当添加的功能包含子栏目,但子栏目的webrole不在权限表中,而菜单列出了子栏目的地址,当用户点击子栏目地址后,这里要循环判断一下
	global $parentUrlArray;
	if(is_array($parentUrlArray))
	{
		
		//dump($webRoleArrary );
				foreach($parentUrlArray as $parentUrl)
				{
					foreach($webRoleArrary as $key =>$web_role)
					{
						  $web_roles = explode('|', $web_role);
						  $funFileNameKey = array_search($parentUrl, $web_roles);  //得到索引KEY
						  if($funFileNameKey!==false)     //当用 === 或 !== 进行比较时则不进行类型转换，因为此时类型和数值都要比对(因为key值有可能是0,如果用!=比较的话0也是false)
						  {
							  $dep_roles = explode('|', $depRoleArrary[$key]);
						 //dump($depRoleArrary[$key]);
							  $dep_role_str.=$dep_roles[$funFileNameKey].",";
						  }
					}
				}
	}







		$dep_role_str=rtrim($dep_role_str,",");//删除右侧多余的逗号
		$dep_role_str=implode(",",array_unique(explode(",",$dep_role_str)));//删除重复的值

//dump($dep_role_str."部门");
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






























































