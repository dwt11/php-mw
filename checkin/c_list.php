<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEPATH."/emp/dep.inc.options.php");	
if(empty($dopost))$dopost="";
$emp_dep = isset($emp_dep) ? $emp_dep : "";   
if($dopost=='clear')
{
	//140915 kq_integralid=0 and kq_salaryid=0  ��SQL�е�������û����,��Ϊ��ӹ��ʺͻ���ʱδ�����������ֶ� һֱ��0
	//$dsql->ExecuteNoneQuery("DELETE from `#@__checkin` where kq_integralid=0 and kq_salaryid=0;");
	$dsql->ExecuteNoneQuery("DELETE from `#@__checkin`");
	ShowMsg("���ȫ�����ڼ�¼�ɹ���","c_list.php");
	exit();
}

if($dopost=='clearDate')
{
	//140915 kq_integralid=0 and kq_salaryid=0  ��SQL�е�������û����,��Ϊ��ӹ��ʺͻ���ʱδ�����������ֶ� һֱ��0
	$query="DELETE from `#@__checkin` where kq_integralid=0 and kq_salaryid=0 and   date_format(kq_hw_emptime, '%Y-%m') = '$clearDate' ;";
	//dump($query);
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("���".$clearDate."�Ŀ��ڼ�¼�ɹ���","c_list.php");
	exit();
}

if($dopost=='update')
{
	
	$dsql->ExecuteNoneQuery("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	//	dump("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	ShowMsg("���³ɹ���","c_list.php");
	exit();
}


if($dopost=='updates')
{
    
    if($qstr=='')
    {
        ShowMsg('������Ч��',$ENV_GOBACK_URL);
        exit();
    }
	//dump($qstr);
    $qstrs = explode('`',$qstr);
    $i = 0;
    foreach($qstrs as $aid)
    {
		//dump("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
	   $dsql->ExecuteNoneQuery("update `#@__checkin` set kq_zt='".$kq_zt."' where kq_id='$aid';");
    }
	ShowMsg("���³ɹ���","c_list.php");
	exit();
}



$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$title="���ڼ�¼����"; //ҳ����ʾ�ı���




$keyword = isset($keyword) ? $keyword : "";
//$keyword_temp=str_replace("0","",$keyword);������ݱ�洢��Ա��������ַ���,����Ҫ�Ѷ����0�����������Ա�����????150130
//	  or kq_hw_empcode='$keyword'
if($keyword!="")
{
  
	  $wheresql  .= " And (kq_hw_empname LIKE '%$keyword%'
	  ) ";    //���ϱ��
      
	 
}

$date = isset($date) ? $date : "";   
if($date!="")
{
  
	  $wheresql  .= " and    date_format(kq_hw_emptime, '%Y-%m-%d') = '$date' ";    //���ϱ��
      
	 
}



//$neworderway = ($orderway == 'asc' ? 'asc' : 'desc');
//$orderby = isset($orderby) ? $orderby : "";   
//
////Ĭ��DESC����110716
//if($orderby!="")
//{
//	$neworderby =" order by ". $orderby ." " ;
//}else
//{
//	$neworderby =  " order by kq_hw_emptime desc ";
//	$neworderway = "";
//}
//

 if($emp_dep!=0)
{
 $emp_depids= GetDepChildArray($emp_dep);
 //dump($emp_depids);

	  $wheresql  .= " and  kq_hw_empcode in (select emp_code from dede_emp where emp_isdel=0 and emp_dep in (".$emp_depids.")) ";    //���ϱ��
      
	 
}



$sql = "Select *  From `#@__checkin`  $wheresql order by kq_hw_emptime desc ";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;
$dlist->SetParameter("emp_dep",$emp_dep);
$dlist->SetParameter("date",$date);


$dlist->SetParameter("keyword",$keyword);      //�ؼ���


$tplfile = "c_list.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ



// 
function getste($kq_zt)
{
		  if($kq_zt==0)$kqzt_temp="δ���";
		  if($kq_zt==1000)$kqzt_temp="<strong>����������</strong>";
		  if($kq_zt==2000)$kqzt_temp="<strong>��������</strong>";
		  if($kq_zt==100)$kqzt_temp="<strong><font color='#009900'>����</font></strong>";
          if($kq_zt==1)$kqzt_temp="<strong><font color='#66CCFF'>һ���ٵ�</font></strong>";
          if($kq_zt==2)$kqzt_temp="<strong><font color='#FF9900'>�����ٵ�</font></strong>";
          if($kq_zt==3)$kqzt_temp="<strong><font color='#FF0000'>�����ٵ�</font></strong>";
          if($kq_zt==11)$kqzt_temp="<strong><font color='#66CCFF'>һ������</font></strong>";
          if($kq_zt==12)$kqzt_temp="<strong><font color='#FF9900'>��������</font></strong>";
          if($kq_zt==13)$kqzt_temp="<strong><font color='#FF0000'>��������</font></strong>";
	      if($kq_zt==21)$kqzt_temp="<strong><font color='#66CCFF'>��������</font></strong>";
          if($kq_zt==22)$kqzt_temp="<strong><font color='#FF9900'>����һ��</font></strong>";


return $kqzt_temp;

}

//��ȡԱ���İ��
function getbb($kq_hw_empcode)
{
	
			global $dsql;
		//150527�޸�   ���� isdel���ж� ,ԭ��û�� ��ɾ��Ա������ �����ͬ�ı��Ա�� ��ѯ���ڻ����
		$questr1="SELECT emp_bb FROM `#@__emp` where emp_code='".$kq_hw_empcode."' and emp_isdel=0";

		 	
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="�޼�¼";
		}
		else
		{
		
			$str=$rowarc1['emp_bb'];
		
		
		}
	

return $str;
}







?>