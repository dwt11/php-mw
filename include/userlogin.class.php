<?php   if(!defined('DEDEINC')) exit('Request Error!');

session_start();








/**
 * ��¼��
 *
 * @package          userLogin
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class userLogin
{
    var $userName = '';  //��¼��
    var $userPwd = '';   //����
    var $userID = '';    //��¼ID
    var $userEmpID = ''; //Ա��ID
    var $userType = '';  //�û�Ȩ��ֵ
    var $keepuserNameTag = 'dede_admin_name';
    var $keepUserIDTag = 'dede_admin_id';
    var $keepUserEmpIDTag = 'dede_admin_empid';
    var $keepUserTypeTag = 'dede_admin_type';

    //php5���캯��
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
     *  �����û��Ƿ���ȷ
     *
     * @access    public
     * @param     string    $userName  �û���
     * @param     string    $userpwd  ����
     * @return    string
     */
    function checkUser($userName, $userpwd)
    {
        
		$this->sysInfoToConfig();//д��ϵͳ������Ϣ
		
		global $dsql;

        //ֻ�����û�����������0-9,a-z,A-Z,'@','_','.','-'��Щ�ַ�
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
     *  �����û��ĻỰ״̬
     *
     * @access    public
     * @return    int    �ɹ����� 1 ��ʧ�ܷ��� -1
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
     *  �����û��ĻỰ״̬
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
     *  ����û���Ȩ��ֵ
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
     *  ��ȡ�û�Ȩ��ֵ
     *
     * @access    public
     * @return    int
     
    function getUserRank()
    {
        return $this->getUserType();
    }*/

    /**
     *  ����û���ID
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
     *  ����û���Ա��ID
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
     *  ����û��ĵ�¼��
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
	
	
	
	
	//ϵͳ������Ϣ�����ݿⲢ�ж�150128
	function sysInfoToConfig()
	{
		$obj = new COM("PHPdll.dwt11");//����VBд��DLL��PHPdll�ǹ�������test������
		$new_computer_code=$obj->getCode(); // ��û�����
		
		global $dsql;
		//��ȡ���ݿⱣ��Ļ�����
		$sql="SELECT value FROM `#@__sys_sysconfig`  WHERE aid='1000'";
		$dsql->SetQuery($sql);
		$dsql->Execute();
        $row = $dsql->GetObject();
        if($new_computer_code!=$row->value)
        {//�����ȡ�Ļ����������ݿⱣ�治һ��,��������ݿ�Ļ�����Ϊ���µ�,���趨ϵͳ�Ŀ�ʼ����Ϊ��ǰ����
            $inquery = "UPDATE `#@__sys_sysconfig` SET value='$new_computer_code' WHERE aid='1000'";
            $dsql->ExecuteNoneQuery($inquery);
            //�˴���������,������ݿ���û��ʱ���0�Ļ�,����������������ô����??????150129
			$inquery = "UPDATE `#@__sys_sysconfig` SET value='".time()."' WHERE aid='2001'";
            $dsql->ExecuteNoneQuery($inquery);
        }
		
		//����ϵͳ���д���
		$inquery = "UPDATE `#@__sys_sysconfig` SET value=value+1 WHERE aid='2000'";
		$dsql->ExecuteNoneQuery($inquery);
		
	}

  }
