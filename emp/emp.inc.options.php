<?php
/**
 * Ա��ѡ���
 *
 * @version        $Id: inc_catalog_options.php 1 10:32 2010��7��21��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  ��ȡѡ���б�
 *
 * @access    public
 * @param     string  $selid  ѡ��ID
 * @return    string
 
 
 
 
 
 */
 
 
function GetEmpOptionList($selid=0)
{
    global  $dsql;


    
	
    $wheresql="";//150130���
	$OptionEmpArrayList="";
	
        //��ǰѡ�е�Ա��
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp` WHERE emp_id='$selid'");
        $OptionEmpArrayList .= "<option value='".$row['emp_id']."' selected='selected'>".GetIntAddZero($row['emp_code'])."-".$row['emp_realname']."</option>\r\n";
    }

//����Ȩ����������
	global $funAllName;
    $wheresql  .= getDepRole($funAllName,"emp_dep");    //���ؿ��Թ���Ĳ���ID�� ��ѯ���
    if($wheresql==""){$wheresql=" ";}  

	$query = " SELECT * FROM `#@__emp`  WHERE emp_isdel=0 $wheresql ORDER BY convert(emp_realname using gbk) ASC ";
	//dump($query);
    $dsql->SetQuery($query);
    $dsql->Execute();//150130ɾ��$DEPID
    while($row1=$dsql->GetObject())
    {
            $OptionEmpArrayList .= "<option value='".$row1->emp_id."' >--".GetIntAddZero($row1->emp_code)." ".$row1->emp_realname."</option>\r\n";
	}

   
   
   
    return $OptionEmpArrayList;
}








