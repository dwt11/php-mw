<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 权限小助手
 *
 * @version        $Id: grouptype.helper.php 1 16:49 20141009Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */




 


/**
 *  根据 多个权限组 id 获取 权限组的名称
 *
 * @param     string  $tid  栏目ID
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
		else return "无任何权限";
    }
}





//获取所有权限组数据
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




