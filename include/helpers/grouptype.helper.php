<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * Ȩ��С����
 *
 * @version        $Id: grouptype.helper.php 1 16:49 20141009Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */




 


/**
 *  ���� ���Ȩ���� id ��ȡ Ȩ���������
 *
 * @param     string  $tid  ��ĿID
 * @return    string
 */
if ( ! function_exists('GetUserTypeNames'))
{
    function GetUserTypeNames($trank)
    {
		global $groupRanks;
        //dump($groupRanks);
        if(!is_array($groupRanks))
        {
      // dump(is_array($groupRanks));
            GetGroupRanks();   
        }
        //dump($trank);
        $rankNames="";
		$usertypes = explode(',', $trank);
		//   dump($usertypes); 
		//$ns = explode(',',$n);
		foreach($usertypes as $usertype)
		{
		   //if(isset($groupRanks[$usertype])) $rankNames.=$usertype." ".$groupRanks[$usertype]."&nbsp;&nbsp;&nbsp;&nbsp;";
		   if(isset($groupRanks[$usertype])) $rankNames.=$groupRanks[$usertype]."  ";
		   //dump($usertype); 
		}
	
		//dump( $rankNames);
		if($rankNames!="")return $rankNames;
		else return "���κ�Ȩ��";
    }
}





//��ȡ����Ȩ��������
function GetGroupRanks()
{
    global $groupRanks,$dsql;
	$dsql->SetQuery("SELECT rank,typename FROM `#@__sys_admintype` ");
	$dsql->Execute();
	while($row = $dsql->GetObject())
	{
		$groupRanks[$row->rank] = $row->typename;
	}
	    //$row->typename = base64_encode($row->typename);
}




