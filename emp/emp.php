<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	


if(empty($dopost)) $dopost = '';

if($dopost=='bb')
{
	
	$dsql->ExecuteNoneQuery("update `#@__emp` set emp_bb='".$bb."' where emp_id='$aid';");
	ShowMsg("���³ɹ���",$ENV_GOBACK_URL);
	exit();
}


if($dopost=='bx')
{
	
	$dsql->ExecuteNoneQuery("update `#@__emp` set emp_bx='".$bx."' where emp_id='$aid';");
	ShowMsg("���³ɹ���",$ENV_GOBACK_URL);
	exit();
}

$wheresql=" where emp_isdel=0 "; //Ĭ����� ����ʾ ɾ���˵�Ա��
//$title="Ա������"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And (emp_code = '$keyword'"; //���
	  $wheresql  .= " or emp_realname LIKE '%$keyword%')";  //����
	 // $wheresql  .= " or crm.aid  LIKE '%$keyword%'";  //CRM�����������
	 // $wheresql  .= " or emp_sfz  LIKE '%$keyword%'";  //���
	//  $wheresql  .= " or emp_phone  LIKE '%$keyword%' ";    //���ϱ��
      
	 
}
$emp_dep = isset($emp_dep) ? $emp_dep : "";   
if($emp_dep!=0)
{
	   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and   emp_dep in (".$emp_depids.") ";    //���ϱ��
}


$wheresql  .= getDepRole($funAllName,"emp_dep");    //���ؿ��Թ���Ĳ���ID�� ��ѯ���



$neworderby = isset($neworderby) ? $neworderby : "";   

//Ĭ��DESC����
$neworderby =  " order by emp_code desc ";


 

$sql = "Select *  From `#@__emp`  $wheresql $neworderby  ";

//dump($funAllName);
//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;
/*$dlist->SetParameter("mid",$mid);
	$dlist->SetParameter("search_type",$search_type);
	$dlist->SetParameter("startdate",$startdate);
	$dlist->SetParameter("enddate",$enddate);



if(isset($sta))
{
	$dlist->SetParameter("sta",$sta);
}*/
$emp_ste = isset($emp_ste) ? $emp_ste : "";   


$dlist->SetParameter("emp_dep",$emp_dep);  //Ա��״̬����
$dlist->SetParameter("emp_ste",$emp_ste);  //Ա��״̬����
$dlist->SetParameter("keyword",$keyword);      //�ؼ���


$tplfile = "emp.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ

//dump(getDepRole());




//��ʾ�����Ĳ������� 
function GetGz($id)
{
			global $dsql;
	
		$questr1="SELECT worktype_name FROM `#@__emp_worktype` where worktype_id='".$id."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="�޹��ּ�¼";
		}
		else
		{
		
			$str=$rowarc1['worktype_name'];
		
		
		}
	

return $str;

}


//��ʾ��¼�û��� 
function GetUserName($id)
{
		global $dsql;
		$questr1="SELECT userName FROM `#@__sys_admin` where empid='".$id."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="��";
		}
		else
		{
		
			$str=$rowarc1['userName'];
		
		
		}
	

return $str;

}






?>