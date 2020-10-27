<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 联动菜单类
 *
 * @version        $Id: enums.func.php 2 13:19 2011-3-24 tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

// 弱不存在缓存文件则写入缓存
if(!file_exists(DEDEDATA.'/enums/system.php')) WriteEnumsCache();

/**
 *  更新枚举缓存
 *
 * @access    public
 * @param     string  $egroup  联动组
 * @return    string
 */
function WriteEnumsCache($egroup='')
{
    global $dsql;
    $egroups = array();
    if($egroup=='') {
        $dsql->SetQuery("SELECT egroup FROM `#@__sys_enum` GROUP BY egroup ");
    }
    else {
        $dsql->SetQuery("SELECT egroup FROM `#@__sys_enum` WHERE egroup='$egroup' GROUP BY egroup ");
    }
    $dsql->Execute('enum');
    while($nrow = $dsql->GetArray('enum')) {
        $egroups[] = $nrow['egroup'];
    }
    foreach($egroups as $egroup)
    {
        $cachefile = DEDEDATA.'/enums/'.$egroup.'.php';
        $fp = fopen($cachefile,'w');
        fwrite($fp,'<'."?php\r\nglobal \$em_{$egroup}s;\r\n\$em_{$egroup}s = array();\r\n");
        $dsql->SetQuery("SELECT ename,evalue,issign FROM `#@__sys_enum` WHERE egroup='$egroup' ORDER BY disorder ASC, evalue ASC ");
        $dsql->Execute('enum');
        $issign = -1;
        $tenum = false; //三级联动标识
        while($nrow = $dsql->GetArray('enum'))
        {
            fwrite($fp,"\$em_{$egroup}s['{$nrow['evalue']}'] = '{$nrow['ename']}';\r\n");
            if($issign==-1) $issign = $nrow['issign'];
            if($nrow['issign']==2) $tenum = true;
        }
        if ($tenum) $dsql->ExecuteNoneQuery("UPDATE `#@__stepselect` SET `issign`=2 WHERE egroup='$egroup'; ");
        fwrite($fp,'?'.'>');
        fclose($fp);
		
		//dump($issign);
        //if(empty($issign)) WriteEnumsJs($egroup);
    }
    return '成功更新所有枚举缓存！';
}

/**
 *  获取联动表单两级数据的父类与子类
 *
 * @access    public
 * @param     string  $v
 * @return    array
 */
function GetEnumsTypes($v)
{
    $rearr['top'] = $rearr['son'] = 0;
    if($v==0) return $rearr;
    if($v%500==0) {
        $rearr['top'] = $v;
    }
    else {
        $rearr['son'] = $v;
        $rearr['top'] = $v - ($v%500);
    }
    return $rearr;
}

/**
 *  获取枚举的select表单
 *
 * @access    public
 * @param     string  $egroup  组名称
 * @param     string  $evalue  子内容值
 * @param     string  $formid  表单ID
 * @param     string  $seltitle  选择标题
 * @param     string  $display  显示方式,默认radio,可以选为select
 * @param     string  $width  radio,checkbox的输出等间距  默认120宽,如果传入-1 则无间距  竖排
 * @return    string  成功后返回一个枚举表单
 */
function GetEnumsForm($egroup, $evalue='', $formid='', $seltitle='',$display='radio',$width=120)
{
	
	//判断字典组是否多级的
	//多级从数据库读取 并可多种形式
	//???这段未做,本来是做到设备管理里用的,但看来是没有用了,
	//以后用的时候再做141224
	
	
	
	//dump($evalue);
    $forms="";
	$prefix="";  //??这个没有用 141011
	$cachefile = DEDEDATA.'/enums/'.$egroup.'.php';
    include($cachefile);
    if($formid=='')
    {
        $formid = $egroup;
    }
    if($display=='radio')
	{
		
			foreach(${'em_'.$egroup.'s'} as $v=>$n)
			{
				if($width>0)$forms .="<div style='float: left;width:{$width}px;'>";  //等距排列
				if($width==-1)$forms .="<div >";  //竖排
				if($v==$evalue)   
				{
					 $forms .="\t<input name='$formid' id='$formid' type='radio'  value='$v'   checked='checked'/><strong>$prefix$n</strong>\r\n";  //141207增加加粗显示
				//dump($v."----".$evalue);
				}
				else
				{
					$forms .= "\t<input name='$formid' id='$formid' type='radio'  value='$v'  />$prefix$n\r\n";
				}
					$forms .= "\t</div>\r\n";
			}
	
	}
    if($display=='checkbox')
	{
		
			foreach(${'em_'.$egroup.'s'} as $v=>$n)
			{
				$checked="";  //是否选中 141209加
				$name=Html2Text($prefix.$n); //名称是否加粗
				if($width>0)$forms .="<div style='float: left;width:{$width}px;'>";  //等距排列
				if($width==-1)$forms .="<div >";  //竖排
				//dump($v."----".$evalue);
				if(strlen($name)>15)$name="<span title='".$name."'>".cn_substrR($name,15)."</span>";//141225添加 防止文字过长 
				foreach(explode(",",$evalue) as $e)
				{
					if($v==$e)
					{
						$checked=" checked='checked' ";
						$name="<strong>$name</strong>";
					}
				}
				$forms .= "\t<input name='".$formid."[]' id='$formid' type='checkbox'  value='$v' $checked />$name\r\n";
				
				$forms .= "\t</div>\r\n";
			}
			
	     
	}
    if($display=='select')
	{
		    //150123优化 删除行后的\r\n  因为在采购商品时要动态添加 采购单位, 这个值要到JAVASCRIPT中
			$forms = "<select name='$formid' id='$formid' class='enumselect'>";
			$forms .= "\t<option value='' selected='selected'>选择{$seltitle}</option>";   //原value='0'  因为goods_log中的logflag 0为正常值 1注意 2待办  此处不能用0   141128修改
			foreach(${'em_'.$egroup.'s'} as $v=>$n)
			{
				
				if($v==$evalue)
				{
					$forms .= "\t<option value='$v' selected='selected'>$prefix$n</option>";
				}
				else
				{
					$forms .= "\t<option value='$v'>$prefix$n</option>";
				}
			}
			$forms .= "</select>";
	
	}
    return $forms;
}

/**
 *  获取一级数据
 *
 * @access    public
 * @param     string    $egroup   联动组
 * @return    array
 */
/*function getTopData($egroup)
{
    $data = array();
    $cachefile = DEDEDATA.'/enums/'.$egroup.'.php';
    include($cachefile);
    foreach(${'em_'.$egroup.'s'} as $k=>$v)
    {
        if($k >= 500 && $k%500 == 0) {
            $data[$k] = $v;
        }
    }
    return $data;
}
*/

/**
 *  获取数据的JS代码(二级联动)
 *
 * @access    public
 * @param     string    $egroup   联动组
 * @return    string
 */
/*function GetEnumsJs($egroup)
{
    global ${'em_'.$egroup.'s'};
    include_once(DEDEDATA.'/enums/'.$egroup.'.php');
    $jsCode = "<!--\r\n";
    $jsCode .= "em_{$egroup}s=new Array();\r\n";
    foreach(${'em_'.$egroup.'s'} as $k => $v)
    {
        // JS中将3级类目存放到第二个key中去
        if (preg_match("#([0-9]{1,})\.([0-9]{1,})#", $k, $matchs))
        {
            $valKey = $matchs[1] + $matchs[2] / 1000;
            $jsCode .= "em_{$egroup}s[{$valKey}]='$v';\r\n";
        } else { 
            $jsCode .= "em_{$egroup}s[$k]='$v';\r\n";
        }
    }
    $jsCode .= "-->";
    return $jsCode;
}

*
 *  写入联动JS代码
 *
 * @access    public
 * @param     string    $egroup   联动组
 * @return    string
 */
/*function WriteEnumsJs($egroup)
{
    $jsfile = DEDEDATA.'/enums/'.$egroup.'.js';
    $fp = fopen($jsfile, 'w');
   	dump($egroup);
 fwrite($fp, GetEnumsJs($egroup));
    fclose($fp);
}
*/

/**
 *  获取枚举的值
 *
 * @access    public
 * @param     string    $egroup   联动组
 * @param     string    $evalue   联动值
 * @return    string
 */
function GetEnumsValue($egroup, $evalue=0)
{
    include_once(DEDEDATA.'/enums/'.$egroup.'.php');
    global ${'em_'.$egroup.'s'};
    //dump($egroup);
    //dump($evalue);

    //dump(${'em_'.$egroup.'s'});
	$rtustr="";
	$evalue=trim($evalue);
	if($evalue!="")
	{
		$evalueArray=explode(',',$evalue);
		if(is_array($evalueArray))
		{
			foreach($evalueArray as $evalue)
			{
				if(isset(${'em_'.$egroup.'s'}[$evalue]))
				{
					$rtustr.= ${'em_'.$egroup.'s'}[$evalue]." ";
				}
			}
			
		}else{
				if(isset(${'em_'.$egroup.'s'}[$evalue]))
				{
					$rtustr= ${'em_'.$egroup.'s'}[$evalue];
				}
			
			}
		
		
		
	}
	
	return trim($rtustr," ");
}












//获取下拉列表(字典列表页面显示/字典列表页面预览/获取表单时判断,如果分组是多级的,则调用这个)
//$egroup,  组名称
//$selevalue 选中的值
function getOptionsList($egroup,$selevalue="")
{
    global $OptionArrayList;    //返回OPTION的语句
	global $dsql;

	$wheresql="";
    //当前选中的部门
    if($selevalue!="")
    {
        $row = $dsql->GetOne("SELECT evalue,ename FROM `#@__sys_enum` WHERE egroup='$egroup' and evalue='$selevalue'");
    //dump ("SELECT evalue,ename FROM `#@__sys_enum` WHERE egroup='$egroup' and evalue='$selevalue'");
        $OptionArrayList .= "<option value='".$row['evalue']."' selected='selected'>".$row['ename']."</option>\r\n";
    }
 
 

 
    if($wheresql==""){$wheresql="  WHERE egroup LIKE '$egroup' and (reevalue='0' or isnull(reevalue) or reevalue='') ";}  
	$query = " SELECT * FROM `#@__sys_enum`  $wheresql  ORDER BY disorder ASC ";
    $dsql->SetQuery($query);
    $dsql->Execute();

    while($row=$dsql->GetObject())
    {
		

        
		
		
		$sonCats = '';
        LogicGetOptionArray($egroup,$row->evalue, '─', $dsql, $sonCats);
		$OptionArrayList .= "<option value='".$row->evalue."' class='option1'>".$row->ename."</option>\r\n";
		$OptionArrayList .= $sonCats;

       
    }
	//dump($OptionArrayList);
    return $OptionArrayList;
}

function LogicGetOptionArray($egroup,$evalue,$step,&$dsql, &$sonCats)
{
    global $OptionArrayList;    //返回OPTION的语句
    $dsql->SetQuery("Select * From `#@__sys_enum` where egroup='$egroup' and  reevalue='".$evalue."'    ORDER BY disorder ASC");
    $dsql->Execute($egroup.$evalue);
    while($row=$dsql->GetObject($egroup.$evalue))
    {
        	

        $sonCats .= "<option value='".$row->evalue."' class='option3'>$step".$row->ename."</option>\r\n";
        LogicGetOptionArray($egroup,$row->evalue,$step.'─',$dsql, $sonCats);
    }
	
	
}
