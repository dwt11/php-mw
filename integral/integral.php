<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEPATH."/emp/dep.inc.options.php");	


$emp_dep = isset($emp_dep) ? $emp_dep : "";   
$totalhj=0;

$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$title="���ֹ���"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";   
if($keyword!="")
{
  
	  $wheresql  .= " And integral_empid in (select emp_id from dede_emp where emp_realname LIKE '%$keyword%' or emp_code = '$keyword') ";    //���ϱ��
      
	 
}

$date = isset($date) ? $date : "";   
if($date!="")
{
  
	  $wheresql  .= " and    date_format(integral_date, '%Y-%m') = '$date' ";    //���ϱ��
      
	 
}


$integral_class = isset($integral_class) ? $integral_class : "";   
if($integral_class!="")
{
  
	  $wheresql  .= " and  integral_class = '$integral_class' ";    //���ϱ��
      
	 
}

if($emp_dep!=0)
{
   $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);
	  $wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depids.")) ";    //���ϱ��
 
	  //$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep=$emp_dep) ";    //���ϱ��
      
	 
}



//����Ȩ������
$emp_depidRoles= getDepRole($funAllName,"");
if($emp_depidRoles!="")$wheresql  .= " and  integral_empid in (select emp_id from dede_emp where emp_dep in (".$emp_depidRoles.")) ";    //���ϱ��




$neworderway = 'desc';
$orderby = isset($orderby) ? $orderby : "";   

//Ĭ��DESC����110716
if($orderby!="")
{
	$neworderby =" order by ". $orderby ." " ;
}else
{
	$neworderby =  " order by integral_date desc,integral_id desc ";
	$neworderway = "";
}


 

$sql = "Select *  From `#@__integral`  $wheresql $neworderby $neworderway ";

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


$dlist->SetParameter("keyword",$keyword);      //�ؼ���
$dlist->SetParameter("date",$date);      //�ؼ���
$dlist->SetParameter("integral_class",$integral_class);      //�����ֶ�
$dlist->SetParameter("emp_dep",$emp_dep);      //�����ֶ�


$tplfile = "integral.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ






	

//��ȡ�������� 
function getgz($gzid)
{

			global $dsql;
	
		$questr1="SELECT gz_name,gz_ms FROM `#@__integral_guizhe` where gz_id='".$gzid."'";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="�޼�¼";
		}
		else
		{
		
			$str=$rowarc1['gz_name'].",".$rowarc1['gz_ms'];
		
		
		}
	    if($gzid==0)$str="���Կ�����������";
	    if($gzid==-1)$str="������ֵ,�ֶ�����";

return $str;


}


	








?>