<?php
/**
 * ����SELECT OPTIONSѡ���-�ⲿ����
 *
 * @version        $Id: inc_catalog_options.php 1 10:32 2010��7��21��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  ��ȡ��Ȩ�޲�ѯ��ѡ���б�
 *
 * @access    public
 * @param     string  $selid  ѡ��ID
 * @return    string
 */
function GetDepOptionList($selid=0)
{
    global $OptionDepArrayList;    //����OPTION�����
	global $dsql;
	global $DepArray;    //�����Ѿ���ѯ���Ĳ���ID

	$wheresql="";
    //��ǰѡ�еĲ���
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $OptionDepArrayList .= "<option value='".$row['dep_id']."' selected='selected'>".$row['dep_name']."</option>\r\n";
    }
   global $funAllName;
//   echo $funAllName;
   $wheresql  .= getDepRole($funAllName,"dep_id");    //���ؿ��Թ���Ĳ���ID�� ��ѯ���
 //����Ȩ�޲�����Ĳ����п���,��û���Ӳ��ŵ�Ȩ�޵�,�������������Ĳ��Ų�ѯ����,Ҫ��� ��ѯ��������ID�Ƿ��ڲ���Ȩ����
 //���ص�Ȩ�޲�ѯ���,����������еĿ��Բ�ѯ��ID,�����ڻ�ȡ�ӷ���ʱ Ҫ����Ƿ��Ѿ���ѯ����ID
 
 
    global $DepRole;
 	$DepRole=getDepRole($funAllName);  //��þ���Ȩ�޵�ID,���û��Ȩ��������

    //dump ($wheresql);
    
    if($wheresql==""){$wheresql=" and dep_topid=0";}  
	$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
		
        //����Ѿ���ѯ���Ĳ���ID,����Ѿ���ѯ��,������		
		$DepArrays = explode(',', rtrim($DepArray,","));
        if(in_array($row->dep_id,$DepArrays ))
        {
            //dump($row->dep_id);
            continue;
        }

        
		
		
		$sonCats = '';
        LogicGetDepOptionArray($row->dep_id, '��', $dsql, $sonCats);
		$OptionDepArrayList .= "<option value='".$row->dep_id."' class='option1'>".$row->dep_name."</option>\r\n";
		$OptionDepArrayList .= $sonCats;
		$DepArray .= $row->dep_id.",";

       
    }
	//dump($DepArray);
    return $OptionDepArrayList;
}








/**

150130���

��ζintegral_query.htm ���ֲ�ѯҳ��ʹ��
HC �豸���޼�¼���� ����������ʹ��
 *  ��ȡ����Ȩ�޲�ѯ��ѡ���б�
 *
 * @access    public
 * @param     string  $selid  ѡ��ID
 * @return    string
 */
function GetDepOptionList_norole($selid=0)
{
    global $OptionDepArrayList;    //����OPTION�����
	global $dsql;
	global $DepArray;    //�����Ѿ���ѯ���Ĳ���ID

	$wheresql="";
    //��ǰѡ�еĲ���
    if($selid > 0)
    {
        $row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $OptionDepArrayList .= "<option value='".$row['dep_id']."' selected='selected'>".$row['dep_name']."</option>\r\n";
    }

    //dump ($wheresql);
    
    if($wheresql==""){$wheresql=" and dep_topid=0";}  
	$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
		
        //����Ѿ���ѯ���Ĳ���ID,����Ѿ���ѯ��,������		
		$DepArrays = explode(',', rtrim($DepArray,","));
        if(in_array($row->dep_id,$DepArrays ))
        {
            //dump($row->dep_id);
            continue;
        }

        
		
		
		$sonCats = '';
        LogicGetDepOptionArray($row->dep_id, '��', $dsql, $sonCats);
		$OptionDepArrayList .= "<option value='".$row->dep_id."' class='option1'>".$row->dep_name."</option>\r\n";
		$OptionDepArrayList .= $sonCats;
		$DepArray .= $row->dep_id.",";

       
    }
	//dump($DepArray);
    return $OptionDepArrayList;
}



function LogicGetDepOptionArray($id,$step,&$dsql, &$sonCats)
{
    global $OptionDepArrayList;    //����OPTION�����
	global $DepArray;    //�����Ѿ���ѯ���Ĳ���ID
	global $DepRole;    //�����Ѿ���ѯ���Ĳ���ID
    $dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$id."'  order by dep_id asc");
    $dsql->Execute($id);
    while($row=$dsql->GetObject($id))
    {
        	
		if($DepRole!="")
		{
			$DepRoleArrays = explode(',', $DepRole);
			if(!in_array($row->dep_id,$DepRoleArrays ))
			{
				//dump($row->dep_id);
				continue;
			}
		}

        $sonCats .= "<option value='".$row->dep_id."' class='option3'><span style='color:#666666'>$step</span>".$row->dep_name."</option>\r\n";
        LogicGetDepOptionArray($row->dep_id,$step.'��',$dsql, $sonCats);
		$DepArray .= $row->dep_id.",";
    }
	
	
}




























//PS���û�мӲ�������Ȩ��  ��Ϊ������ڹ���ҳ��Ĳ�ѯ,��ѯ��ͬʱ�Ѿ����˲�������Ȩ��
//���ص�ǰ��ѡ���Ĳ���  �������¼����ŵ���ID���б���ѯ��ز����°����ļ�¼ʱʹ��
function GetDepChildArray($selid=0)
{
    global $DepArray, $dsql;


    //��ǰѡ�еĲ���
    if($selid > 0)
    {
        //$row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
        $DepArray .= $selid.",";
        LogicGetDepArray($selid,$dsql);
    }

	//echo $OptionDepArrayList;
    return rtrim($DepArray, ",");
}
function LogicGetDepArray($selid,&$dsql)
{
    global $DepArray;
    $dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$selid."'  order by dep_id asc");
    $dsql->Execute($selid);
    while($row=$dsql->GetObject($selid))
    {
        $DepArray .= $row->dep_id.",";
        LogicGetDepArray($row->dep_id,$dsql);
    }
	
	
}
