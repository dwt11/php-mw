<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');


$url=$_SESSION["url"];//�Ӹ�ҳ���ȡ��ҳ�����
if(!isset($_SESSION["inlNextUrlNumb"]))$_SESSION["inlNextUrlNumb"]=0; //���û�е�ǰҳ�� ��ǰҳ��ֵΪ0
if($_SESSION["inlNextUrlNumb"]>=count($url))$_SESSION["inlNextUrlNumb"]=0;   //�����ǰҳ��ֵ���� ��ҳ�����ɵ�URL��������ֵ ����0
//dump( " ".$_SESSION["inlNextUrlNumb"]." ".$url[$_SESSION["inlNextUrlNumb"]]);

$urls=$url[$_SESSION["inlNextUrlNumb"]];
$pagesParameter=explode('|', $urls);
//��ʽ deptopid������ID|pageSize��ҳ��С|pageno��ǰҳ����(����޷�ҳ��Ϊ1)

$deptopid=$pagesParameter[0];
$pageSize=$pagesParameter[1];
$pageno=$pagesParameter[2];
$totalresult=$pagesParameter[3];  //��¼���� ����޴����� �����ҳ�Ļ�,��תҳ���� һֱ��ʾ��һҳ����
//��ʽ deptopid������ID|pageSize��ҳ��С|pageno��ǰҳ����(����޷�ҳ��Ϊ1)|$rowNumb�ܼ�¼��
$_SESSION["inlNextUrlNumb"]=$_SESSION["inlNextUrlNumb"]+1;


	

$date =  date("Y-m", time()) ;   //Ĭ����ʾ��ǰ�µ�����

$class = isset($class) ? $class : "";   


$row = $dsql->GetOne("SELECT dep_name FROM `#@__emp_dep` WHERE dep_id='$deptopid'");
$title=str_replace("-","��",$date)."�� ".$row['dep_name']." ����Ա���׶� ".strtoupper($class)." ����";

//��ȡ��ǰ�����ŵ������Ӳ��� �ַ���
$childStr=GetDepChildArray($deptopid); 


$wheresql="";
if($class!="")$wheresql=" and 	inl.integral_class ='$class' ";
$sql = "SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 ��ǰ�����Ĳ�ѯ��� ����������Ĳ�ѯʹ��,��ѯ��ǰ���źϼ���������
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3�����1
		FROM
			(SELECT @rownumb := 0) rownumb, #2��ȡ�����������,ʹ�ô˾佫����Ź�0
			(#1��������,���ϲ�ѯ��ȡ���е�Ա���Ļ��ֺϼ�(where���ɼ��·�����),�Ժϼƺ�Ļ�������
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '$date' $wheresql
				WHERE
					emp.emp_isdel = 0  
				
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in ($childStr) order by emp_dep";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = $pageSize;
$dlist->SetParameter("deptopid",$deptopid);      //��ǰ������ID


$tplfile = "trundle.do.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL

$dlist->Display();                  //��ʾ


//��ȡ Ա������ʷ��ֵ
function getOldEmpFz($empid,$class="")
{

			global $dsql;
	
	    $wheresql="";
	    if($class!="")$wheresql=" and integral_class='$class' ";
		$questr1="SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  integral_empid='".$empid."' $wheresql ";
		
		//echo $questr1;
		$rowarc1 = $dsql->GetOne($questr1);
		if(!is_array($rowarc1))
		{
		  $str="0";
		}
		else
		{
		
			$str=$rowarc1['totalfz'];
		
		
		}
	
		
		return (double)($str);


}


	

//PS���û�мӲ�������Ȩ��  ��Ϊ������ڹ���ҳ��Ĳ�ѯ,��ѯ��ͬʱ�Ѿ����˲�������Ȩ��
//���ص�ǰ��ѡ���Ĳ���  �������¼����ŵ���ID���б���ѯ��ز����°����ļ�¼ʱʹ��
function GetDepChildArray($selid)
{
    global $DepArray, $dsql;

    $DepArray="";
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








?>