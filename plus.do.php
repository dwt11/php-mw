<?php  
require_once("config.php");

/*
���в������ݵ���չҳ  ����ǰ��ȡ�����û�����

*/


if(empty($dopost))
{
    ShowMsg('�Բ�����ûָ�����в�����','-1');
    exit();
}
$id = isset($id) ? preg_replace("#[^0-9]#", '', $id) : '';
$cid = empty($cid) ? 0 : intval($cid);




/*--------------------------
//�༭�ĵ�
function editArchives(){ }
---------------------------*/
if($dopost=='editArchives')
{
    $query = "SELECT arc.typeid as cid,arc.userid as userid FROM `dede_archives_arctiny` arc WHERE arc.id='$id' ";
    $row = $dsql->GetOne($query);
    $cid = $row['cid'];
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="archives/archives_edit.php?cid=$cid&aid=$id";
    header("location:{$gurl}");
    exit();
}





/*--------------------------
//ɾ�� �ĵ�
function editArchives(){ }
---------------------------*/
if($dopost=='delArchives')
{
    $query = "SELECT arc.typeid as cid,arc.userid as userid FROM `dede_archives_arctiny` arc WHERE arc.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
    $cid = $row['cid'];
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="archives/archives_del.php?cid=$cid&dopost=delArchives&aid=$id";
    header("location:{$gurl}");
    exit();
}



/*-----------------------------------------------------------------------------------------���Ƿָ���--------------------------*/


















/*--------------------------
//�༭�豸
function editdevice(){ }
---------------------------*/
if($dopost=='editDevice')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //���� session������userlogin.class.php���жϵ�ǰ�豸 �Ƿ�ǰ��¼���û���ӵ� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_edit.php?cid=$cid&did=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� �豸
function editdevice(){ }
---------------------------*/
if($dopost=='delDevice')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //���� session������userlogin.class.php���жϵ�ǰ�豸 �Ƿ�ǰ��¼���û���ӵ� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_del.php?cid=$cid&dopost=deldevice&did=$id";
    header("location:{$gurl}");
    exit();
}








/*--------------------------
//����豸���޼�¼
function editdevice(){ }
---------------------------*/
if($dopost=='addDeviceFixLog')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
     $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //���� session������userlogin.class.php���жϵ�ǰ�豸 �Ƿ�ǰ��¼���û���ӵ� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_addfixlog.php?cid=$cid&did=$id";
    header("location:{$gurl}");
    exit();
}



/*--------------------------
//�༭�豸���޼�¼
function editdevice(){ }
---------------------------*/
if($dopost=='editDeviceFixLog')
{
	$query = "SELECT  dev.typeid as cid,dev.depid as depid
	 FROM dede_device_fix_log   fl
	 left join dede_device dev on dev.id=fl.did  
	 where fl.id=$id";
     $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //���� session������userlogin.class.php���жϵ�ǰ�豸 �Ƿ�ǰ��¼���û���ӵ� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_editfixlog.php?cid=$cid&id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� �豸���޼�¼,ʹ���豸�Ĳ��������ж�Ȩ��
function editdevice(){ }
---------------------------*/
if($dopost=='delDeviceFixLog')
{
	$query = "SELECT  dev.typeid as cid,dev.depid as depid
	 FROM dede_device_fix_log   fl
	 left join dede_device dev on dev.id=fl.did  
	 where fl.id=$id";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //���� session������userlogin.class.php���жϵ�ǰ�豸 �Ƿ�ǰ��¼���û���ӵ� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
     $cid = $row['cid'];
   $gurl="device/device_delfixlog.php?cid=$cid&dopost=deldevice&id=$id";
    header("location:{$gurl}");
    exit();
}

/*-----------------------------------------------------------------------------------------���Ƿָ���--------------------------*/

















/*--------------------------
//�༭
function edit(){ }
---------------------------*/
if($dopost=='editDailylog')
{
    $query = "SELECT userid FROM `#@__other_dailylog`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	//dump($userid);
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
	$gurl="other/dailylog_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� 
function del(){ }
---------------------------*/
if($dopost=='delDailylog')
{
    $query = "SELECT userid FROM `#@__other_dailylog`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
     $gurl="other/dailylog_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*-----------------------------------------------------------------------------------------���Ƿָ���--------------------------*/










/*--------------------------
//�༭
function edit(){ }
---------------------------*/
if($dopost=='editWorkbug')
{
	
	
	//�༭ �жϷ�������
    $query = "SELECT senddepid  FROM `#@__other_workbug`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$senddepid=$row['senddepid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$senddepid;
	$gurl="other/workbug_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//����
function edit(){ }
---------------------------*/
if($dopost=='repairWorkbug')
{
	
	
	//���� �ж�ȱ����������
    $query = "SELECT workbugdepid  FROM `#@__other_workbug`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$workbugdepid=$row['workbugdepid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$workbugdepid;
	$gurl="other/workbug_repair.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� 
function del(){ }
---------------------------*/
if($dopost=='delWorkbug')
{
 	//�༭ �жϷ�������
   $query = "SELECT senddepid FROM `#@__other_workbug` WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$senddepid=$row['senddepid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$senddepid;
    $gurl="other/workbug_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}
		











/*--------------------------
//�༭�ĵ�
function editSimplelist(){ }
---------------------------*/
if($dopost=='editSimplelist')
{
    $query = "SELECT sim.typeid as cid,sim.userid as userid  FROM `dede_simplelist` sim          WHERE sim.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="simplelist/simplelist_edit.php?cid=$cid&sid=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� �ĵ�
function editSimplelist(){ }
---------------------------*/
if($dopost=='delSimplelist')
{
    $query = "SELECT sim.typeid as cid,sim.userid as userid  FROM `dede_simplelist` sim          WHERE sim.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ�ĵ� �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="simplelist/simplelist_del.php?cid=$cid&sid=$id&dopost=delSimplelist";
    header("location:{$gurl}");
    exit();
}







/*------------------------------------------------------------------------------------��Ʒ����150114����Ŀ���������,δ��֤,Ȩ���ж϶�û����-----���Ƿָ���--------------------------*/
/*--------------------------
//�༭��Ʒ
function editgoods(){ }
---------------------------*/
if($dopost=='editGoods')
{
    $query = "SELECT userid FROM `dede_goods`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="goods/goods_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� ��Ʒ
function editgoods(){ }
---------------------------*/
if($dopost=='delGoods')
{
    $query = "SELECT userid  FROM `dede_goods`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="goods/goods_del.php?id=$id&dopost=delGoods";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� ��Ʒ ��־��¼
function editgoods(){ }
---------------------------*/
if($dopost=='delGoodsLog')
{
    $query = "SELECT userid  FROM `dede_goods_log`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="goods/goods_del.php?id=$id&dopost=delGoodsLog";
    header("location:{$gurl}");
    exit();
}

/*--------------------------
//ɾ�� ����
function editArchives(){ }
---------------------------*/
if($dopost=='delSales')
{
    $query = "SELECT  userid FROM `dede_sales`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="sales/sales_del.php?id=$id&dopost=delSales";
    header("location:{$gurl}");
    exit();
}



/*--------------------------
//ɾ�� ��������Ʒ
function editArchives(){ }
---------------------------*/
if($dopost=='delSalesGoods')
{
    $query = "SELECT  userid FROM `dede_sales`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="sales/salesgoods_del.php?id=$id&dopost=delSalesGoods";
    header("location:{$gurl}");
    exit();
}


if($dopost=='delOtherpay')
{
    $query = "SELECT  userid FROM `dede_finance_otherpay`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="finance/otherpay_del.php?id=$id";
    header("location:{$gurl}");
    exit();
	
	
	
}




/*--------------------------
//ɾ�� 
function (){ }
---------------------------*/
if($dopost=='delWorklog')
{
    $query = "SELECT  userid FROM `dede_other_worklog`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="other/worklog_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}
/*--------------------------
//ɾ�� 
function (){ }
---------------------------*/
if($dopost=='delClient')
{
    $query = "SELECT  userid FROM `dede_people_client`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/client_del.php?id=$id&dopost=delClient";
    header("location:{$gurl}");
    exit();
}
/*--------------------------
//ɾ�� 
function (){ }
---------------------------*/
if($dopost=='delClientlog')
{
    $query = "SELECT  userid FROM `dede_people_client_log`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/client_del.php?id=$id&dopost=delClientlog";
    header("location:{$gurl}");
    exit();
}




/*--------------------------
//ɾ�� 
function (){ }
---------------------------*/
if($dopost=='delSupplier')
{
    $query = "SELECT  userid FROM `dede_people_supplier`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/supplier_del.php?id=$id&dopost=del";
    header("location:{$gurl}");
    exit();
}




/*--------------------------
//�༭�ɹ�
function edit(){ }
---------------------------*/
if($dopost=='editPurchase')
{
    $query = "SELECT userid
           FROM `dede_purchase` 
          WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��(��userlogin.class.php�л�ȡ����ע����)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="purchase/purchase_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//ɾ�� �ɹ�
function editgoods(){ }
---------------------------*/
if($dopost=='delPurchase')
{
    $query = "SELECT userid
           FROM `dede_purchase` 
          WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //���� session������userlogin.class.php���жϵ�ǰ��Ʒ �Ƿ�ǰ��¼���û������� ���������б༭Ȩ��
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl='purchase/purchase_del.php?id=$id';
    header("location:{$gurl}");
    exit();
}
