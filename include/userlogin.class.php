<?php   if(!defined('DEDEINC')) exit('Request Error!');

session_start();








/**
 * 登录类
 *
 * @package          userLogin
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class userLogin
{
    var $userName = '';  //登录名
    var $userPwd = '';   //密码
    var $userID = '';    //登录ID
    var $userEmpID = ''; //员工ID
    var $userType = '';  //用户权限值
    var $keepuserNameTag = 'dede_admin_name';
    var $keepUserIDTag = 'dede_admin_id';
    var $keepUserEmpIDTag = 'dede_admin_empid';
    var $keepUserTypeTag = 'dede_admin_type';

    //php5构造函数
    function __construct()
    {

        if(isset($_SESSION[$this->keepUserIDTag]))
        {
            $this->userName = $_SESSION[$this->keepuserNameTag];
            $this->userID = $_SESSION[$this->keepUserIDTag];
            $this->userEmpID = $_SESSION[$this->keepUserEmpIDTag];
            $this->userType = $_SESSION[$this->keepUserTypeTag];
        }

    }


    /**
     *  检验用户是否正确
     *
     * @access    public
     * @param     string    $userName  用户名
     * @param     string    $userpwd  密码
     * @return    string
     */
    function checkUser($userName, $userpwd)
    {
        
		$this->sysInfoToConfig();//写入系统运行信息
		
		global $dsql;

        //只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
        //$this->userName = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $userName);
		$this->userName =  $userName;
        $this->userPwd = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $userpwd);
        $pwd = substr(md5($this->userPwd), 5, 20);
        
		$sql="SELECT admin.* FROM `#@__sys_admin` admin  WHERE admin.userName LIKE '".$this->userName."' LIMIT 0,1";
		$dsql->SetQuery($sql);
		//dump($sql);
		$dsql->Execute();
        $row = $dsql->GetObject();
        if(!isset($row->pwd))
        {
            return -1;
        }
        else if($pwd!=$row->pwd)
        {
            return -2;
        }
        else
        {
            $loginip = GetIP();
            $this->userID = $row->id;
            $this->userEmpID = $row->empid;
            $this->userType = $row->usertype;
            $this->userName = $row->userName;
            $inquery = "UPDATE `#@__sys_admin` SET loginip='$loginip',logintime='".time()."',loginnumb=loginnumb+1 WHERE id='".$row->id."'";
            $dsql->ExecuteNoneQuery($inquery);
			//dump();
            return 1;
        }
    }

    /**
     *  保持用户的会话状态
     *
     * @access    public
     * @return    int    成功返回 1 ，失败返回 -1
     */
    function keepUser()
    {
        
//dump($this->userID);
		//if($this->userID != '' && $this->userType != '')
		if($this->userID != '' )
        {

            @session_register($this->keepUserIDTag);
            $_SESSION[$this->keepUserIDTag] = $this->userID;

            @session_register($this->keepUserEmpIDTag);
            $_SESSION[$this->keepUserEmpIDTag] = $this->userEmpID;


            @session_register($this->keepUserTypeTag);
            $_SESSION[$this->keepUserTypeTag] = $this->userType;

            @session_register($this->keepuserNameTag);
            $_SESSION[$this->keepuserNameTag] = $this->userName;


            PutCookie('DedeUserID', $this->userID, 3600 * 24, '/');
            PutCookie('DedeLoginTime', time(), 3600 * 24, '/');
            
            
            return 1;
        }
        else
        {
            return -1;
        }
    }
    

    //
    /**
     *  结束用户的会话状态
     *
     * @access    public
     * @return    void
     */
    function exitUser()
    {
        //ClearMyAddon();
        @session_unregister($this->keepUserEmpIDTag);
        @session_unregister($this->keepUserIDTag);
        @session_unregister($this->keepUserTypeTag);
        @session_unregister($this->keepuserNameTag);
        DropCookie('DedeUserID');
        DropCookie('DedeLoginTime');
        $_SESSION = array();
    }

    

    /**
     *  获得用户的权限值
     *
     * @access    public
     * @return    int
     */
    function getUserType()
    {
		
        if($this->userType != '')
        {
            return $this->userType;
        }
        else
        {
            return -1;
        }
    }

    /**
     *  获取用户权限值
     *
     * @access    public
     * @return    int
     
    function getUserRank()
    {
        return $this->getUserType();
    }*/

    /**
     *  获得用户的ID
     *
     * @access    public
     * @return    int
     */
    function getUserId()
    {
	    if($this->userID != '')
        {
            return $this->userID;
        }
        else
        {
            return -1;
        }
    }

    /**
     *  获得用户的员工ID
     *
     * @access    public
     * @return    int
     */
    function getUserEmpID()
    {
        if($this->userEmpID != '')
        {
            return $this->userEmpID;
        }
        else
        {
            return -1;
        }
    }

    /**
     *  获得用户的登录名
     *
     * @access    public
     * @return    string
     */
    function getuserName()
    {
        if($this->userName != '')
        {
            return $this->userName;
        }
        else
        {
            return -1;
        }
    }
	
	
	
	
	//系统运行信息到数据库并判断150128
	function sysInfoToConfig()
	{
		$obj = new COM("PHPdll.dwt11");//调用VB写的DLL，PHPdll是工程名，test是类名
		$new_computer_code=$obj->getCode(); // 获得机器码
		
		global $dsql;
		//获取数据库保存的机器码
		$sql="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='1000'";
		$dsql->SetQuery($sql);
		$dsql->Execute();
        $row = $dsql->GetObject();
        if($new_computer_code!=$row->value)
        {//如果获取的机器码与数据库保存不一致,则更新数据库的机器码为最新的,并设定系统的开始日期为当前日期
            $inquery = "UPDATE `#@__sys_sysconfig` SET value='$new_computer_code' WHERE aid='1000'";
            $dsql->ExecuteNoneQuery($inquery);
            //此处存在问题,如果数据库中没有时间或0的话,不会更新随后再想怎么处理??????150129
			$inquery = "UPDATE `#@__sys_sysconfig` SET value='".time()."' WHERE aid='2001'";
            $dsql->ExecuteNoneQuery($inquery);
        }
		
		//更新系统运行次数
		$inquery = "UPDATE `#@__sys_sysconfig` SET value=value+1 WHERE aid='2000'";
		$dsql->ExecuteNoneQuery($inquery);
		
	}

  }
