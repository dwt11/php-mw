<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$checkdate=$checkdate;  //check ��������Ҫ������·� 
getconfig(); ///�õ�ȫ�ֿ��ڹ���

if(empty($dopost))$dopost="";

////dump ($checkdate);



if($dopost=='check')
{
	
	$querys=array(); //�������鲢���

	$get_check_data="Select *  From `#@__checkin`   where kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' order by kq_hw_emptime desc";
	$dsql->Execute('c', $get_check_data);
    while($row = $dsql->GetArray('c'))
    {

		  $kq_zt=0;
          $kqzt_temp=returncheck($row['kq_hw_emptime'],$row['kq_hw_empcode']);
        //  //dump($kqzt_temp);
		  if($kqzt_temp=="<font color='#009900'>����</font>")$kq_zt=100;
          if($kqzt_temp=="<font color='#66CCFF'>һ���ٵ�</font>")$kq_zt=1;
          if($kqzt_temp=="<font color='#FF9900'>�����ٵ�</font>")$kq_zt=2;
          if($kqzt_temp=="<font color='#FF0000'>�����ٵ�</font>")$kq_zt=3;
          if($kqzt_temp=="<font color='#66CCFF'>һ������</font>")$kq_zt=11;
          if($kqzt_temp=="<font color='#FF9900'>��������</font>")$kq_zt=12;
          if($kqzt_temp=="<font color='#FF0000'>��������</font>")$kq_zt=13;
		  if($kqzt_temp=="����������")$kq_zt=1000;
		  if($kqzt_temp=="��������")$kq_zt=2000;
// 100Ϊ���� ��1һ���ٵ� 2�����ٵ� 3�����ٵ�  11һ������ 12�������� 13��������  21 �������� 22����һ��

			  $querys[] = " UPDATE `dede_checkin` SET `kq_zt`='".$kq_zt."' WHERE (`kq_id`='".$row['kq_id']."') ";
		
    }

    $_SESSION["querysArray"]="";  //ע��SESSION
    $_SESSION["querysArray"]=$querys;   //ʹ��session������Ҫ����Ŀ�������
    //����ǰ��ռ���
	$_SESSION["truenumb"]="0"; //�������
	$_SESSION["falsenumb"]="0"; //�������

	//dump($querys);		  
	 ShowMsg("���ڻ�ȡ".$checkdate ."�������","c_check_1.php?dopost=check_1&checkdate=$checkdate","","",1);
    exit();
	
}


//��ҳ��������
if($dopost=='check_1')
{
	//$t1 = ExecTime();
	
	
	$truenumb=$_SESSION["truenumb"]; //����Ѿ���������� 
	$falsenumb=$_SESSION["falsenumb"]; //��õ����������� 


	$querys=$_SESSION["querysArray"];   //��ȡ����
	//��ҳ���������
	$pageSize=50;    //ÿҳ����
	if(!isset($pageNo))$pageNo=1; //��ǰҳ��
	if(!isset($totalResult))$totalResult=count($querys);//Ҫ���������
    $totalPage = ceil($totalResult / $pageSize);//��ҳ��
    $iStart=($pageNo-1) * $pageSize;
    $iEnd=$pageNo*$pageSize;
	if($iEnd>$totalResult)$iEnd=$totalResult;
	
	   // dump($iStart."--".$iEnd."--".$totalResult);
	
    for($i1=$iStart; $i1<$iEnd; $i1++)
    {
	   // dump($i1."--".$querys[$i1]);
					 // dump($querys[$i1]."--".$i1);
				if(!$dsql->ExecuteNoneQuery($querys[$i1]))
				  {
					  $falsenumb++;
				  }else{
					  $truenumb++;
				 }
	//dump($truenumb."--".$falsenumb);
	}
	 
    
   if($totalPage>$pageNo)
   {//��ҳ����
        $toPage=$pageNo+1;
	   ShowMsg("�������".$checkdate."��".$pageNo."ҳ����,��".$totalPage."ҳ��","c_check_1.php?dopost=check_1&checkdate=$checkdate&pageNo=$toPage&totalResult=$totalResult","","",1);
   }else
   {
	  ShowMsg("���ڼ�¼����·�: ".$checkdate .",�ɹ�  ".$truenumb." ��,ʧ�� ".$falsenumb." ����","c_check.php");
	}

exit();
}












$wheresql=" where 1=1 "; //Ĭ����� ����ʾ�Ӽ�¼
$sql = "Select *  From `#@__checkin`   where kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' order by kq_hw_emptime  desc";

////dump($sql);
$dlist = new DataListCP();

//�趨ÿҳ��ʾ��¼����Ĭ��25����
$dlist->pageSize = 30;


$dlist->SetParameter("checkdate",$checkdate);  //Ա��״̬����


$tplfile = "c_check_1.htm";



//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ






//�õ�������
function Get_all_check($checkdate)
{
			global $dsql;
	
        $sql="select count(*) as dd from  `#@__checkin`   where kq_zt=0 and  date_format(kq_hw_emptime, '%Y-%m') = '$checkdate'";
	//	//dump($sql);
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $all_check_numb=0;
		}
		else
		{
		
			$all_check_numb=$rowarc1['dd'];
		
		
		}
		
return $all_check_numb;

}


//�õ�����������
function Get_yes_check($checkdate)
{
			global $dsql;
	
        $sql="select count(*) as dd from dede_checkin  WHERE kq_zt=0 and  date_format(kq_hw_emptime, '%Y-%m') = '$checkdate' AND (
	


		
		(
					date_format(kq_hw_emptime, '%H') >=7
					AND date_format(kq_hw_emptime, '%H')<8
				)
				
		or 
				
					(
						date_format(kq_hw_emptime, '%H') >= 18
						AND date_format(kq_hw_emptime, '%H') <= 20
					)
		
			)";
				////dump($sql);

		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $yes_check_numb=0;
		}
		else
		{
		
			$yes_check_numb=$rowarc1['dd'];
		
		
		}
		
return $yes_check_numb;

}



//�õ�Υ������  ��������� �Ȳ�Ū��
function Get_no_check($checkdate)
{
			global $dsql;

 $sql="select count(*) as dd from dede_checkin  WHERE  kq_zt=0 and date_format(kq_hw_emptime, '%Y-%m') = '$checkdate'
 AND (
	


(
			(date_format(kq_hw_emptime, '%H') >=8 )
			AND (date_format(kq_hw_emptime, '%H')<12 )
		)
		
or 
		
			(
				date_format(kq_hw_emptime, '%H') >= 12
				AND date_format(kq_hw_emptime, '%H') < 18
			)

	)";
			////dump($sql);
				//echo 
		$rowarc1 = $dsql->GetOne($sql);
		if(!is_array($rowarc1))
		{
		  $no_check_numb=0;
		}
		else
		{
		
			$no_check_numb=$rowarc1['dd'];
		
		
		}
		
return $no_check_numb;

}



//��ȡ���ڹ���  ȫ��
function getconfig()
 {  
 
 			global $dsql;

 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$djorxj;
	  $yjcd=0;//һ���ٵ�</td>
          $ejcd=0;//�����ٵ�</td>
		  $sjcd=0;//�����ٵ�</td>
          
		  $yjzt=0;//һ������</td>
		 $ejzt=0;//��������</td>
         $sjzt=0;//��������</td>

  $arcQuery = "SELECT *  from #@__checkin_config  WHERE id='1' ";
  // //dump($arcQuery);
	$arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ��Ϣ����!","-1");
        exit();
    }else{
		  
		  
		  $yjcd=$arcRow['yjcd'];//һ���ٵ�</td>
          $ejcd=$arcRow['ejcd'];//�����ٵ�</td>
		  $sjcd=$arcRow['sjcd'];//�����ٵ�</td>
          
		  $yjzt=$arcRow['yjzt'];//һ������</td>
		 $ejzt=$arcRow['ejzt'];//��������</td>
         $sjzt=$arcRow['sjzt'];//��������</td>
         $djorxj=$arcRow['djorxj'];

		
		}
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

//���ؿ��ڽ��
//$kq_hw_emptime,ԭʼ����ʱ��
//$kq_hw_empcode //����Ա����� ���жϿ��ڰ��
function returncheck($kq_hw_emptime,$kq_hw_empcode)
{
	
	 			global  $yjcd,$ejcd,$sjcd,$yjzt,$ejzt,$sjzt,$djorxj;

	//dump($kq_hw_emptime);
	
	$restr="<font color='#009900'>����</font>";
	
	 //ԭʼ���ڼ�¼ʱ�� ��ʱ��õ�int
    $timeold_int=strtotime(date("H:i:s",strtotime($kq_hw_emptime)));
        
        
        $kqbb=getbb($kq_hw_empcode) ;
	
	
	
	
		if($kqbb=="���װ�"){
									   //�ֱ��ж��Ƿ�����8 12 14 18�������  �����������ڽ��  ��������� ����ʾ������
									 //echo date("H",strtotime($fields['kq_hw_emptime']));
									 //�ж� 8��Ŀ���
									  if(date("H",strtotime($kq_hw_emptime))==8 ||(date("H",strtotime($kq_hw_emptime))>=7  && date("H",strtotime($kq_hw_emptime))<9 )){
								   
									  
											//8���INT
											 $time8_int=strtotime("08:00:00");
											//����ʱ��int��8��int�����õ�  ��ֵ����
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($timeold_int-$time8_int)/60; 
											
											//������ж�
										//       echo $timecheck_minute;
											if( $timecheck_minute>$yjcd &&  $timecheck_minute<=$ejcd) $restr= "<font color='#66CCFF'>һ���ٵ�</font>";
											if( $timecheck_minute>$ejcd &&  $timecheck_minute<=$sjcd) $restr= "<font color='#FF9900'>�����ٵ�</font>";
											if( $timecheck_minute>$sjcd) $restr= "<font color='#FF0000'>�����ٵ�</font>";
									 //  echo "��";
									   
									  
									  }
									  
									  
									 //�ж� 12��Ŀ���
									 else if(date("H",strtotime($kq_hw_emptime))==12 ||(date("H",strtotime($kq_hw_emptime))>=11 && date("H",strtotime($kq_hw_emptime))<13 )){
									 
									  
											//8���INT
											 $time8_int=strtotime("12:00:00");
											//����ʱ��int��8��int�����õ�  ��ֵ����
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($time8_int-$timeold_int)/60; 
											
											//������ж�
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjzt &&  $timecheck_minute<=$ejzt) $restr= "<font color='#66CCFF'>һ������</font>";
											if( $timecheck_minute>$ejzt &&  $timecheck_minute<$sjzt) $restr= "<font color='#FF9900'>��������</font>";
											if( $timecheck_minute>$sjzt ) $restr= "<font color='#FF0000'>��������</font>";
									   
								   //   echo "ʮ��";
									  }
									  
									  
									 //�ж� 14��Ŀ���
									 
									 else if(date("H",strtotime($kq_hw_emptime))==14 ||(date("H",strtotime($kq_hw_emptime))>=13 && date("H",strtotime($kq_hw_emptime))<16 )){
									 
									  
											//8���INT
											 $time8_int=strtotime("14:00:00");
									 if($djorxj=="�ļ�"){ $time8_int=strtotime("15:00:00");}
if($djorxj=="���＾"){ $time8_int=strtotime("14:30:00");}
											//����ʱ��int��8��int�����õ�  ��ֵ����
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($timeold_int-$time8_int)/60; 
											
											//������ж�
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjcd &&  $timecheck_minute<=$ejcd) $restr= "<font color='#66CCFF'>һ���ٵ�</font>";
											if( $timecheck_minute>$ejcd &&  $timecheck_minute<=$sjcd) $restr= "<font color='#FF9900'>�����ٵ�</font>";
											if( $timecheck_minute>$sjcd) $restr= "<font color='#FF0000'>�����ٵ�</font>";
									  // echo "ʮ��";
									  
									  }
									  
									  
									  
									  
									  
									  
									 //�ж� 18��Ŀ���
									 else if(date("H",strtotime($kq_hw_emptime))==18 ||( date("H",strtotime($kq_hw_emptime))>=17 && date("H",strtotime($kq_hw_emptime))<20 )){
									 
									  
											//8���INT
											 $time8_int=strtotime("18:00:00");
									 if($djorxj=="�ļ�"){ $time8_int=strtotime("19:00:00");}
if($djorxj=="���＾"){ $time8_int=strtotime("18:30:00");}
											//����ʱ��int��8��int�����õ�  ��ֵ����
											//$timecheck_int=$timeold_int-$time8_int; 
											$timecheck_minute=($time8_int-$timeold_int)/60; 
											
											//������ж�
												//echo $timecheck_minute;
										
											if( $timecheck_minute>$yjzt &&  $timecheck_minute<=$ejzt) $restr= "<font color='#66CCFF'>һ������</font>";
											if( $timecheck_minute>$ejzt &&  $timecheck_minute<$sjzt) $restr= "<font color='#FF9900'>��������</font>";
											if( $timecheck_minute>$sjzt ) $restr= "<font color='#FF0000'>��������</font>";
										   // if( $timecheck_minute>120) $restr= "<font color='#FFFF00'>��������</font>";
									  //      echo "ff";
									  //echo "ʮ��";
									  }
									  
									  else
									  {
										  $restr= "����������";
										  }
									  
									  //echo "����ʱ��INT:".$timeold_int."<br>����ʱ���ʽ".$timeold_date."<br>8��INT".$time8_int."<br>�����ķ���int".$timecheck_int."<br>�����ķ�����".$timecheck_minute;
        
      
		}
		
		
		
		if($kqbb=="����"){
								
										  $restr= "��������";
										 
      
		}
	        return $restr;

	
	
	
	}



?>