<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$inputdate=$inputdate;  //input ��������Ҫ������·� 
////dump ($inputdate);

if(empty($dopost))$dopost="";


//����ʱ�Ƚ����ݴ�������,Ȼ���ٷ����������ݿ�
//���ֱ�ӷ�ҳ�������ݿ�Ļ�,��ΪҪ�Ƚϵ��������,���������ݳ���
if($dopost=='input')
{
		  
	 ShowMsg("���ڻ�ȡ".$inputdate ."��������","c_input_1.php?dopost=input_1&inputdate=$inputdate","","",1);
 exit();
}



//����ʱ�Ƚ����ݴ�������,Ȼ���ٷ����������ݿ�
//���ֱ�ӷ�ҳ�������ݿ�Ļ�,��ΪҪ�Ƚϵ��������,���������ݳ���
if($dopost=='input_1')
{
$t1 = ExecTime();

	$querys=array(); //�������鲢���
	//global $querys;  
	$get_no_input_data="SELECT
	c.CardID,
	c.EmployeeID,
	c.CardTime,
	c.DevID,
	e.EmployeeCode,
	e.EmployeeName,
	d.DevName,
	d.IPAddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID 
ORDER BY c.CardTime
";
//����ֱ�ӻ�ȡ��ǰ�µ�ȫ������  ����ѯ�Ѿ�����������ˣ����� not IN̫�� not exits��ѯ��������   left joinȻ��not null ���ݶ���̫��
	// dump($get_no_input_data);
    $dsql->Execute('c', $get_no_input_data);
    while($row = $dsql->GetArray('c'))
    {
          //$kq_empid= $row['EmployeeID'];//���Ҫ����Ա���������ѯmw�ж�Ӧ��Ա��ID,��ʱ����,��ֻ��Ա������Ƿ������
		  $kq_hw_CARDID= $row['CardID'] ;
		  $kq_hw_emptime= $row['CardTime'] ;
		  $kq_hw_devname= $row['DevName'] ;
		  $kq_hw_devip= $row['IPAddress'] ;
		  //$kq_hw_empid= $row['EmployeeID'] ;
		  $kq_hw_empname= $row['EmployeeName'] ;
		  $kq_hw_empcode= $row['EmployeeCode'] ;
		  $kq_markdate= date("Y-m-d", time()) ;
		  
		  //$querys[] = " INSERT  ignore  INTO `dede_checkin` (kq_empid,kq_hw_CARDID,kq_hw_emptime,kq_hw_devname,kq_hw_devip,kq_hw_empid,kq_hw_empname,kq_hw_empcode,kq_markdate,kq_integralid,kq_salaryid,kq_czy,kq_zt)
							//	VALUES (null, '".$kq_hw_CARDID."', '".$kq_hw_emptime."', '".$kq_hw_devname."', '".$kq_hw_devip."', null, '".$kq_hw_empname."', '".$kq_hw_empcode."','".$kq_markdate."', 0,0,".$cuserLogin->getUserID().",0);";
		 //���ﲻ��INSERT  ignore  INTO  ֱ��ʹ��MYSQLִ������  ���Է��سɹ��������ݿⲻ�ظ�������  ������Զ�����  ��Ϊ���ݱ� ��kq_hw_CARDID,kq_hw_emptime��kq_hw_devip�����˲������ظ�
		 $querys[] = " INSERT  INTO `dede_checkin` (kq_empid,kq_hw_CARDID,kq_hw_emptime,kq_hw_devname,kq_hw_devip,kq_hw_empid,kq_hw_empname,kq_hw_empcode,kq_markdate,kq_integralid,kq_salaryid,kq_czy,kq_zt)
								VALUES (null, '".$kq_hw_CARDID."', '".$kq_hw_emptime."', '".$kq_hw_devname."', '".$kq_hw_devip."', null, '".$kq_hw_empname."', '".$kq_hw_empcode."','".$kq_markdate."', 0,0,".$cuserLogin->getUserID().",0);";
    }
    $_SESSION["querysArray"]="";  //ע��SESSION
    $_SESSION["querysArray"]=$querys;   //ʹ��session������Ҫ����Ŀ�������
    //����ǰ��ռ���
	$_SESSION["truenumb"]="0"; //�������
	$_SESSION["falsenumb"]="0"; //�������
// $t2 = ExecTime();
//echo $t2-$t1;

	//dump($querys);		  
	ShowMsg("��ʼ����".$inputdate ."��������","c_input_1.php?dopost=input_2&inputdate=$inputdate","","",1);
 exit();
 
}


//��ҳ��������
if($dopost=='input_2')
{
	$t1 = ExecTime();
$t1 = ExecTime();
	
	$truenumb=$_SESSION["truenumb"]; //����Ѿ���������� 
	$falsenumb=$_SESSION["falsenumb"]; //��õ����������� 


	$querys=$_SESSION["querysArray"];   //��ȡ����
	//��ҳ���������
	$pageSize=5000;    //ÿҳ����
	if(!isset($pageNo))$pageNo=1; //��ǰҳ��
	if(!isset($totalResult))$totalResult=count($querys);//Ҫ���������
    $totalPage = ceil($totalResult / $pageSize);//��ҳ��
    $iStart=($pageNo-1) * $pageSize;
    $iEnd=$pageNo*$pageSize;
	if($iEnd>$totalResult)$iEnd=$totalResult;
	
	   // dump($iStart."--".$iEnd."--".$totalResult);



	$lnk = mysql_connect('localhost', 'root', 'xiaoxiao') or die ('Not connected : ' . mysql_error());
	mysql_select_db('mw', $lnk) or die ('Can\'t use bl_db : ' . 
	mysql_error());
	mysql_query("set names 'gbk'");
    //mysql_query("SET AUTOCOMMIT=0");//����Ϊ1���Զ��ύ  0���Զ��ύ
	
	mysql_query("begin");
    for($i1=$iStart; $i1<($iEnd); $i1++)
    {
		if(!mysql_query($querys[$i1]))
				  {
					  $falsenumb++;
				  }else{
					  $truenumb++;
				 }

	}
	 
	mysql_query('COMMIT'); //ִ������
    //echo "�ɹ�  ".$truenumb." ��,ʧ�� ".$falsenumb." ��<br>";
 $t2 = ExecTime();
//echo $t2-$t1;
   if($totalPage>$pageNo)
   {//��ҳ����
        $toPage=$pageNo+1;
	   ShowMsg("���ڵ���".$inputdate."��".$pageNo."ҳ����,��".$totalPage."ҳ�� ִ��ʱ�䣺".number_format($t2-$t1,1)."�� ","c_input_1.php?dopost=input_2&inputdate=$inputdate&pageNo=$toPage&totalResult=$totalResult","","",1);
   }else
   {
	  ShowMsg("���ڼ�¼�����·�: ".$inputdate .",�ɹ�����  ".$truenumb." ��","c_input.php","",10000,"");
	}

exit();
}




//��ȡ��¼��
Get_numb($inputdate);




//�õ�ѡ����·ݵ� �������ݿ���ļ�¼
$sql = "SELECT
	c.Cardid,
	c.employeeid,
	c.cardtime,
	c.devid,
	e.employeecode,
	e.employeename,
	d.devname,
	d.ipaddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID";

//dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;


$dlist->SetParameter("inputdate",$inputdate);  //Ա��״̬����


$tplfile = "c_input_1.htm";

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ




function Get_numb($inputdate)
{

//�õ���ǰ�µ�������
		//
		global $dsql,$allResult;
		$sql="SELECT
	 count(*) as dd
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '$inputdate'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID";
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $allResult=0;
		}
		else
		{
		
			$allResult=$rowarc1['dd'];
		
		
		}
		



         //��ȡ�Ѿ������
			global $yes_input_numb;
        //$sql="select count(*) as dd from hwatt.kqz_card hw , mw.dede_checkin dz WHERE hw.CardID = dz.kq_hw_CARDID and hw.CardTime=dz.kq_hw_emptime  AND date_format(hw.CardTime, '%Y-%m') = '$inputdate'";
		$sql="SELECT
	count(*) AS dd
FROM
	dede_checkin
WHERE
	kq_hw_CARDID IN (
		SELECT
			c.Cardid
		FROM
			hwatt.kqz_card AS c,
			hwatt.kqz_employee AS e,
			hwatt.kqz_devinfo AS d
		WHERE
			date_format(CardTime, '%Y-%m') = '$inputdate'
		AND c.EmployeeID = e.EmployeeID
		AND c.DevID = d.DevID
	)";
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $yes_input_numb=0;
		}
		else
		{
		
			$yes_input_numb=$rowarc1['dd'];
		
		
		}
		




			global $no_input_numb;  //δ�����
			
       
		
			$no_input_numb=$allResult-$yes_input_numb;
}
		
		
		












?>