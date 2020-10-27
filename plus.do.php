<?php  
require_once("config.php");

/*
具有部门数据的扩展页  访问前获取部门用户数据

*/


if(empty($dopost))
{
    ShowMsg('对不起，你没指定运行参数！','-1');
    exit();
}
$id = isset($id) ? preg_replace("#[^0-9]#", '', $id) : '';
$cid = empty($cid) ? 0 : intval($cid);




/*--------------------------
//编辑文档
function editArchives(){ }
---------------------------*/
if($dopost=='editArchives')
{
    $query = "SELECT arc.typeid as cid,arc.userid as userid FROM `dede_archives_arctiny` arc WHERE arc.id='$id' ";
    $row = $dsql->GetOne($query);
    $cid = $row['cid'];
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="archives/archives_edit.php?cid=$cid&aid=$id";
    header("location:{$gurl}");
    exit();
}





/*--------------------------
//删除 文档
function editArchives(){ }
---------------------------*/
if($dopost=='delArchives')
{
    $query = "SELECT arc.typeid as cid,arc.userid as userid FROM `dede_archives_arctiny` arc WHERE arc.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
    $cid = $row['cid'];
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="archives/archives_del.php?cid=$cid&dopost=delArchives&aid=$id";
    header("location:{$gurl}");
    exit();
}



/*-----------------------------------------------------------------------------------------我是分隔线--------------------------*/


















/*--------------------------
//编辑设备
function editdevice(){ }
---------------------------*/
if($dopost=='editDevice')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //存入 session用于在userlogin.class.php中判断当前设备 是否当前登录的用户添加的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_edit.php?cid=$cid&did=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 设备
function editdevice(){ }
---------------------------*/
if($dopost=='delDevice')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //存入 session用于在userlogin.class.php中判断当前设备 是否当前登录的用户添加的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_del.php?cid=$cid&dopost=deldevice&did=$id";
    header("location:{$gurl}");
    exit();
}








/*--------------------------
//添加设备检修记录
function editdevice(){ }
---------------------------*/
if($dopost=='addDeviceFixLog')
{
    $query = "SELECT dev.typeid as cid,dev.depid as depid   FROM `dede_device_tiny` dev WHERE dev.id='$id' ";
     $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //存入 session用于在userlogin.class.php中判断当前设备 是否当前登录的用户添加的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_addfixlog.php?cid=$cid&did=$id";
    header("location:{$gurl}");
    exit();
}



/*--------------------------
//编辑设备检修记录
function editdevice(){ }
---------------------------*/
if($dopost=='editDeviceFixLog')
{
	$query = "SELECT  dev.typeid as cid,dev.depid as depid
	 FROM dede_device_fix_log   fl
	 left join dede_device dev on dev.id=fl.did  
	 where fl.id=$id";
     $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //存入 session用于在userlogin.class.php中判断当前设备 是否当前登录的用户添加的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
    $cid = $row['cid'];
    $gurl="device/device_editfixlog.php?cid=$cid&id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 设备检修记录,使用设备的部门数据判断权限
function editdevice(){ }
---------------------------*/
if($dopost=='delDeviceFixLog')
{
	$query = "SELECT  dev.typeid as cid,dev.depid as depid
	 FROM dede_device_fix_log   fl
	 left join dede_device dev on dev.id=fl.did  
	 where fl.id=$id";
    $row = $dsql->GetOne($query);
	$depid=$row['depid'];  //存入 session用于在userlogin.class.php中判断当前设备 是否当前登录的用户添加的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$depid;
     $cid = $row['cid'];
   $gurl="device/device_delfixlog.php?cid=$cid&dopost=deldevice&id=$id";
    header("location:{$gurl}");
    exit();
}

/*-----------------------------------------------------------------------------------------我是分隔线--------------------------*/

















/*--------------------------
//编辑
function edit(){ }
---------------------------*/
if($dopost=='editDailylog')
{
    $query = "SELECT userid FROM `#@__other_dailylog`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	//dump($userid);
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
	$gurl="other/dailylog_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 
function del(){ }
---------------------------*/
if($dopost=='delDailylog')
{
    $query = "SELECT userid FROM `#@__other_dailylog`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
     $gurl="other/dailylog_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*-----------------------------------------------------------------------------------------我是分隔线--------------------------*/










/*--------------------------
//编辑
function edit(){ }
---------------------------*/
if($dopost=='editWorkbug')
{
	
	
	//编辑 判断发布部门
    $query = "SELECT senddepid  FROM `#@__other_workbug`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$senddepid=$row['senddepid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$senddepid;
	$gurl="other/workbug_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//整改
function edit(){ }
---------------------------*/
if($dopost=='repairWorkbug')
{
	
	
	//整改 判断缺陷所属部门
    $query = "SELECT workbugdepid  FROM `#@__other_workbug`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$workbugdepid=$row['workbugdepid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$workbugdepid;
	$gurl="other/workbug_repair.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 
function del(){ }
---------------------------*/
if($dopost=='delWorkbug')
{
 	//编辑 判断发布部门
   $query = "SELECT senddepid FROM `#@__other_workbug` WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$senddepid=$row['senddepid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_depid_'.$GLOBALS['cuserLogin']->getUserId()]=$senddepid;
    $gurl="other/workbug_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}
		











/*--------------------------
//编辑文档
function editSimplelist(){ }
---------------------------*/
if($dopost=='editSimplelist')
{
    $query = "SELECT sim.typeid as cid,sim.userid as userid  FROM `dede_simplelist` sim          WHERE sim.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="simplelist/simplelist_edit.php?cid=$cid&sid=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 文档
function editSimplelist(){ }
---------------------------*/
if($dopost=='delSimplelist')
{
    $query = "SELECT sim.typeid as cid,sim.userid as userid  FROM `dede_simplelist` sim          WHERE sim.id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前文档 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="simplelist/simplelist_del.php?cid=$cid&sid=$id&dopost=delSimplelist";
    header("location:{$gurl}");
    exit();
}







/*------------------------------------------------------------------------------------商品管理150114这里的可能有问题,未验证,权限判断都没有做-----我是分隔线--------------------------*/
/*--------------------------
//编辑商品
function editgoods(){ }
---------------------------*/
if($dopost=='editGoods')
{
    $query = "SELECT userid FROM `dede_goods`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="goods/goods_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 商品
function editgoods(){ }
---------------------------*/
if($dopost=='delGoods')
{
    $query = "SELECT userid  FROM `dede_goods`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="goods/goods_del.php?id=$id&dopost=delGoods";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 商品 日志记录
function editgoods(){ }
---------------------------*/
if($dopost=='delGoodsLog')
{
    $query = "SELECT userid  FROM `dede_goods_log`   WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $cid = $row['cid'];
    $gurl="goods/goods_del.php?id=$id&dopost=delGoodsLog";
    header("location:{$gurl}");
    exit();
}

/*--------------------------
//删除 订单
function editArchives(){ }
---------------------------*/
if($dopost=='delSales')
{
    $query = "SELECT  userid FROM `dede_sales`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="sales/sales_del.php?id=$id&dopost=delSales";
    header("location:{$gurl}");
    exit();
}



/*--------------------------
//删除 订单的商品
function editArchives(){ }
---------------------------*/
if($dopost=='delSalesGoods')
{
    $query = "SELECT  userid FROM `dede_sales`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
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
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="finance/otherpay_del.php?id=$id";
    header("location:{$gurl}");
    exit();
	
	
	
}




/*--------------------------
//删除 
function (){ }
---------------------------*/
if($dopost=='delWorklog')
{
    $query = "SELECT  userid FROM `dede_other_worklog`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="other/worklog_del.php?id=$id";
    header("location:{$gurl}");
    exit();
}
/*--------------------------
//删除 
function (){ }
---------------------------*/
if($dopost=='delClient')
{
    $query = "SELECT  userid FROM `dede_people_client`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/client_del.php?id=$id&dopost=delClient";
    header("location:{$gurl}");
    exit();
}
/*--------------------------
//删除 
function (){ }
---------------------------*/
if($dopost=='delClientlog')
{
    $query = "SELECT  userid FROM `dede_people_client_log`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/client_del.php?id=$id&dopost=delClientlog";
    header("location:{$gurl}");
    exit();
}




/*--------------------------
//删除 
function (){ }
---------------------------*/
if($dopost=='delSupplier')
{
    $query = "SELECT  userid FROM `dede_people_supplier`  WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="people/supplier_del.php?id=$id&dopost=del";
    header("location:{$gurl}");
    exit();
}




/*--------------------------
//编辑采购
function edit(){ }
---------------------------*/
if($dopost=='editPurchase')
{
    $query = "SELECT userid
           FROM `dede_purchase` 
          WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限(在userlogin.class.php中获取完后就注销掉)
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl="purchase/purchase_edit.php?id=$id";
    header("location:{$gurl}");
    exit();
}


/*--------------------------
//删除 采购
function editgoods(){ }
---------------------------*/
if($dopost=='delPurchase')
{
    $query = "SELECT userid
           FROM `dede_purchase` 
          WHERE id='$id' ";
    $row = $dsql->GetOne($query);
	//dump($row);
	$userid=$row['userid'];  //存入 session用于在userlogin.class.php中判断当前商品 是否当前登录的用户发布的 如果是则具有编辑权限
	$_SESSION['session_userid_'.$GLOBALS['cuserLogin']->getUserId()]=$userid;
    $gurl='purchase/purchase_del.php?id=$id';
    header("location:{$gurl}");
    exit();
}
