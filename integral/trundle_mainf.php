<?php
require_once("../config.php");

setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");


$_SESSION["inlNextUrlNumb"]=0;  //��ҳ��������
$_SESSION["url"]="";             //URL��ַ�������

$class = isset($class) ? $class : "f";   


//��Ϊ���ֹ�����ʾ����ҳ��,���ڻ�ȡ���ֹ�����ʾ��URL��ַ����
//1\�Ȼ�ȡ���ж������ź����������Ӳ��ŵ�ID,
$query = " SELECT * FROM `#@__emp_dep`  WHERE dep_topid=0 ORDER BY dep_id ASC ";
$dsql->SetQuery($query);
$dsql->Execute(0);
while($row = $dsql->GetObject(0))
{
    $dep_id[]=$row->dep_id;
	$childStr[]=GetDepChildArray($row->dep_id);
}






$pageSize=50;    //�����ҳ��Ҳ���ô�ֵ  ����ͳһÿҳ��ʾ������


foreach($childStr as $k=>$str)
{
//2��ѯԱ����,����ǰ����ID��������Ա�������г�
	$totalPage=1;
	$sql = "SELECT count(*) as rownumb 	FROM dede_emp emp where emp_isdel=0 and emp_dep in ($str) ";
	$row = $dsql->GetOne($sql);
	$rowNumb=$row["rownumb"];
	//dump($rowNumb);
    
	
	//dump($dep_id[$k]);
	
	
	//����ܼ�¼������0 �������ӵ�ַ
	if($rowNumb>0)
	{
		//����õ��ļ�¼������ÿҳ��ҳ�ļ�¼��  �����ӵ�ַ���Ϸ�ҳ
		//����ֻ�е�һҳ
		if($rowNumb>$pageSize)
		{
			$totalPage=ceil($rowNumb/$pageSize);
			for($ii=1;$ii<=$totalPage;$ii++)
			{
				//������ҳ��Ҫ�õĲ���,����session
	//��ʽ deptopid������ID|pageSize��ҳ��С|pageno��ǰҳ����(����޷�ҳ��Ϊ1)|$rowNumb�ܼ�¼��
				$url[]=$dep_id[$k]."|".$pageSize."|".$ii."|".$rowNumb;
			}
		}else
		{
				$url[]=$dep_id[$k]."|".$pageSize."||";
			
		}
		
	}
	//dump($totalPage);
}

//dump($url);
			

$_SESSION["url"]=$url;



 


	

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




<script language="JavaScript"> 
function myrefresh() 
{
   parent.main.location.reload();

} 
setInterval("myrefresh()",10000); //ָ��1000=1��ˢ��һ�� 
</script> 

<!--This is IE DTD patch , Don't delete this line.-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title><?php echo $sysFunTitle?></title>
</head>
<body  >
    <iframe id="main" width="100%" height="98%" name="main" frameborder="0" src="trundle.do.php?class=<?php echo $class;?>"></iframe>
</body>
</html>

<?php
exit();

?>