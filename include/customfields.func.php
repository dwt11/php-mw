<?php   if(!defined('DEDEINC')) exit('dedecms');
/**
 * 系统核心函数存放文件
 * @version        $Id: customfields.func.php 2 20:50 2010年7月7日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  获得一个附加表单(发布时用)
 *
 * @access    public
 * @param     object  $ctag  标签
 * @return    string
 */
 
 
 
  global $formitem_temp;  //只在此页使用 ，添加\编辑\详细信息显示页 的HTML格式 
  $formitem_temp =  "<tr> 
        <td width=\"10%\" class=\"bline\" height='24' align=\"right\">&nbsp;~name~：</td>
        <td class=\"bline\">~form~</td>
       </tr>
   ";
 
 /**
 *  获得表单(添加时用)
 *
 * @access    public
 * @param     object  $ctag  标签
 * @param     string  $stepname  数据字典名称  141229增加

 * @return    string
 */

function GetFormItem($ctag,$stepname='')
{
    global $dsql;
    global $formitem_temp;
    $fieldname = $ctag->GetName();
 	if($stepname=="") $stepname =$fieldname;   //如果数据字典名称不为空,则字段的名称就是数据字典的名称  ,在DEVICe的扩展字段里使用141229
    $fieldType =     $ctag->GetAtt('type');
    $formitem=$formitem_temp;
    $innertext = trim($ctag->GetInnerText());
    if($innertext!='')
    {
        $formitem = $innertext;
    }
    
    if($fieldType=='select')
    {
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));
        $myformItem = "<select name='$fieldname' style='width:150px'>";
        foreach($items as $v)
        {
            $v = trim($v);
            if($v!='') {
                $myformItem.= "<option value='$v'>$v</option>\r\n";
            }
        }
        $myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }
	
	
    else if($fieldType=='depselect')
    {
		require_once(DEDEPATH."/emp/dep.inc.options.php");
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));
		
		$depOptions = GetDepOptionList();
		$myformItem .= "<select name='depid' id='depid'  >\r\n";
		$myformItem .= "<option value='0'>请选择部门...</option>\r\n";
		$myformItem .= $depOptions;
		$myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }
	
	//150305增加 员工选择
    else if($fieldType=='empselect')
    {
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));


		  $EmpOptions = GetEmpOptionList();
          $myformItem .=  "<div style='width:280px'><span style='color:#999; float:right'>支持编号\汉字\拼音首字母搜索</span><select name='empid' id='empid'  m='search' >\r\n";
          $myformItem .=  "<option value='0'>请选择员工...</option>\r\n";
          $myformItem .=  $EmpOptions;
          $myformItem .=  "</select> \r\n
						  <!--//select界面选择框-->
						  <script type=\"text/javascript\" src=\"../js/jquery/jquery.selectseach.min.js\"></script>
						  <script>
						  function getmydata(){
							  alert($('#sssss').val());
						  }
						  $(document).ready(function(){
							 $('select').selectseach(); 
						  }); 
						  
						  </script>
						  </div>";
		
        $innertext = $myformItem;
    }
	
	
    else if($fieldType=='stepselect')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,'', $fieldname, $seltitle='','select');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ctag->GetAtt("type")=='stepradio')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,'', $fieldname, $seltitle='','radio');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($fieldType=='stepcheckbox')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,'', $fieldname, $seltitle='','checkbox');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
	
	
	
    else if($fieldType=='radio')
    {
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));
        $i = 0;
        foreach($items as $v)
        {
            $v = trim($v);
            if($v!='')
            {
                $myformItem .= ($i==0 ? "<input type='radio' name='$fieldname' class='np' value='$v' checked>$v\r\n" : "<input type='radio' name='$fieldname' class='np' value='$v'>$v\r\n");
                $i++;
            }
        }
        $innertext = $myformItem;
    }
    else if($fieldType=='checkbox')
    {
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));
        foreach($items as $v)
        {
            $v = trim($v);
            if($v!='')
            {
				$myformItem .= "<input type='checkbox' name='{$fieldname}[]' class='np' value='$v'>$v\r\n";
                
            }
        }
        $innertext = $myformItem;
    }
    else if($fieldType=='htmltext')
    {
        $dfvalue = ($ctag->GetAtt('default')!='' ? $ctag->GetAtt('default') : '');
        $dfvalue = str_replace('{{', '<', $dfvalue);
        $dfvalue = str_replace('}}', '>', $dfvalue);

         $innertext = GetEditor("body",""); 
    }
    else if($fieldType=="multitext")
    {
        $innertext = "<textarea name='$fieldname' id='$fieldname' style='width:30%;height:80px'></textarea>\r\n";
    }
	
	//随后 是否日期类型和时间类型分开待看  150305
    else if($fieldType=="datetime")
    {
        //$nowtime = GetDateTimeMk(time());
		$nowtime = GetDateMk(time());
        //$innertext = "<input type=\"text\" name=\"$fieldname\" size=\"23\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd H:m:s'})\"/>";
		        $innertext = "<input type=\"text\" name=\"$fieldname\" size=\"12\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})\"/>";

    }
    else if($fieldType=='img'||$fieldType=='imgfile')
    {
       $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='浏览...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($fieldType=='media')
    {
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='浏览...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($fieldType=='addon')
    {
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='浏览...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
    else if($fieldType=='int'||$fieldType=='float')
    {
        $dfvalue = ($ctag->GetAtt('default')!='' ? $ctag->GetAtt('default') : '0');
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:100px'  class='intxt' value='$dfvalue' /> (填写数值)\r\n";
    }
    else
    {
        $dfvalue = ($ctag->GetAtt('default')!='' ? $ctag->GetAtt('default') : '');
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:250px'  class='intxt' value='$dfvalue' />\r\n";
    }
    $formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
    $formitem = str_replace("~form~",$innertext,$formitem);
    return $formitem;
}










/**
 *  处理不同类型的数据
 *  保存表单内容时使用  将扩展内容里的值 转换为合适的值
 * @access    public
 * @param     string  $dvalue  默认值
 * @param     string  $dtype  默认类型
 * @param     int  $aid  文档ID
 * @param     string  $job  操作类型
 * @param     string  $addvar  值
 * @param     string  $fieldname  变量类型
 * @return    string
 */
function GetFieldValue($dvalue, $dtype, $aid=0, $job='add', $addvar='', $fieldname='')
{

//dump($dvalue);
//dump($dtype);
//dump($aid);

    global $cfg_basedir, $cfg_install_path;

    if($dtype=='int')
    {
        if($dvalue=='')
        {
            return 0;
        }
        return GetAlabNum($dvalue);
    }
    else if($dtype=='stepselect')
    {
        $dvalue = trim(preg_replace("#[^0-9\.]#", "", $dvalue));
        return $dvalue;
    }
    else if($dtype=='float')
    {
        if($dvalue=='')
        {
            return 0;
        }
        return GetAlabNum($dvalue);
    }
    else if($dtype=='datetime')
    {
        if($dvalue=='')
        {
            return 0;
        }
        return GetMkTime($dvalue);
    }
    else if($dtype=='checkbox')
    {
        $okvalue = '';
        if(is_array($dvalue))
        {
            $okvalue = join(',',$dvalue);
        }
        return $okvalue;
    }
    else if($dtype=='stepcheckbox')//141120增加 数据字典的checkbox保存值时 获取多先的值
    {
        $okvalue = '';
        if(is_array($dvalue))
        {
            $okvalue = join(',',$dvalue);
        }
        return $okvalue;
    }
    else if($dtype=="htmltext")
    {
        return $dvalue;
    }
    else if($dtype=="multitext")
    {
        return $dvalue;
    }
    else if($dtype=='img' || $dtype=='imgfile')
    {
        $iurl = stripslashes($dvalue);
        if(trim($iurl)=='')
        {
            return '';
        }
        $iurl = trim(str_replace($GLOBALS['cfg_basehost'],"",$iurl));
        $imgurl = "{dede:img text='' width='' height=''} ".$iurl." {/dede:img}";
        if(preg_match("/^http:\/\//i", $iurl) && $GLOBALS['cfg_isUrlOpen'])
        {
            //远程图片
            $reimgs = '';
            if($GLOBALS['cfg_isUrlOpen'])
            {
                $reimgs = GetRemoteImage($iurl,$adminid);
                if(is_array($reimgs))
                {
                    if($dtype=='imgfile')
                    {
                        $imgurl = $reimgs[1];
                    }
                    else
                    {
                        $imgurl = "{dede:img text='' width='".$reimgs[1]."' height='".$reimgs[2]."'} ".$reimgs[0]." {/dede:img}";
                    }
                }
            }
            else
            {
                if($dtype=='imgfile')
                {
                    $imgurl = $iurl;
                }
                else
                {
                    $imgurl = "{dede:img text='' width='' height=''} ".$iurl." {/dede:img}";
                }
            }
        }
        else if($iurl != '')
        {
            //站内图片
            $imgfile = $cfg_basedir.$iurl;
            if(is_file($imgfile))
            {
                $info = '';
                $imginfos = GetImageSize($imgfile,$info);
                if($dtype=="imgfile")
                {
                    $imgurl = $iurl;
                }
                else
                {
                    $imgurl = "{dede:img text='' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}";
                }
            }
        }
        return addslashes($imgurl);
    }
    else
    {
        return $dvalue;
    }
}

/**
 *  获得带值的表单(编辑时用)
 *
 * @access    public
 * @param     object  $ctag  标签
 * @param     mixed  $fvalue  变量值
 * @param     string  $stepname  数据字典名称  原为$fieldname 141129修改 ($fieldname  这个是否有用待查,因为在功能里又获取了一次  上面的功能也有的  随后再处理141229  在getListitemValue中已经用作它的用)

 * @return    string
 */
function GetFormItemValue($ctag, $fvalue,  $stepname='')
{
   global $formitem_temp;
//dump($ctag);
    global $cfg_basedir,$dsql;
    $fieldname = $ctag->GetName();
	if($stepname=="") $stepname =$fieldname;   //如果数据字典名称不为空,则字段的名称就是数据字典的名称  ,在DEVICe的扩展字段里使用141229
    $formitem=$formitem_temp;
    $innertext = trim($ctag->GetInnerText());

	if($innertext!='')
    {
        $formitem = $innertext;
    }
    	//dump($formitem."---");
    $ftype = $ctag->GetAtt('type');
    $myformItem = '';
    if(preg_match("/select|radio|checkbox/i", $ftype))
    {
        $items = explode(',',$ctag->GetAtt('default'));
    }
    if($ftype=='select')
    {
        $myformItem = "<select name='$fieldname' style='width:150px'>";
        if(is_array($items))
        {
            foreach($items as $v)
            {
                $v = trim($v);
                if($v=='')
                {
                    continue;
                }
                $myformItem.= ($fvalue==$v ? "<option value='$v' selected>$v</option>\r\n" : "<option value='$v'>$v</option>\r\n");
            }
        }
        $myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }
    else if($ftype=='depselect')
    {
		require_once(DEDEPATH."/emp/dep.inc.options.php");
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));
		
		$depOptions = GetDepOptionList($fvalue);
		$myformItem .= "<select name='depid' id='depid'  >\r\n";
		$myformItem .= "<option value='0'>请选择部门...</option>\r\n";
		$myformItem .= $depOptions;
		$myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }

	//150305增加 员工选择
    else if($ftype=='empselect')
    {
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));


		  $EmpOptions = GetEmpOptionList($fvalue);
          $myformItem .=  "<div style='width:280px'><span style='color:#999; float:right'>支持编号\汉字\拼音首字母搜索</span><select name='empid' id='empid'  m='search' >\r\n";
          $myformItem .=  "<option value='0'>请选择员工...</option>\r\n";
          $myformItem .=  $EmpOptions;
          $myformItem .=  "</select> \r\n
						  <!--//select界面选择框-->
						  <script type=\"text/javascript\" src=\"../js/jquery/jquery.selectseach.min.js\"></script>
						  <script>
						  function getmydata(){
							  alert($('#sssss').val());
						  }
						  $(document).ready(function(){
							 $('select').selectseach(); 
						  }); 
						  
						  </script>
						  </div>";
		
        $innertext = $myformItem;
    }
	


    else if($ftype=='stepselect')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,$fvalue, $fieldname, $seltitle='','select');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ftype=='stepradio')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,$fvalue, $fieldname, $seltitle='','radio');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ftype=='stepcheckbox')
    {

			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$myformItem=GetEnumsForm($stepname,$fvalue, $fieldname, $seltitle='','checkbox');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ftype=='radio')
    {
        if(is_array($items))
        {
            foreach($items as $v)
            {
                $v = trim($v);
                if($v=='') continue;
                $myformItem.= ($fvalue==$v ? "<input type='radio' name='$fieldname' class='np' value='$v' checked='checked' />$v\r\n" : "<input type='radio' name='$fieldname' class='np' value='$v' />$v\r\n");
            }
        }
        $innertext = $myformItem;
    }

    //checkbox
    else if($ftype=='checkbox')
    {
        $myformItem = '';
        $fvalues = explode(',',$fvalue);
        if(is_array($items))
        {
            foreach($items as $v)
            {
                $v = trim($v);
                if($v=='')
                {
                    continue;
                }
                if(in_array($v,$fvalues))
                {
                    $myformItem .= "<input type='checkbox' name='{$fieldname}[]' class='np' value='$v' checked='checked' />$v\r\n";
                }
                else
                {
                    $myformItem .= "<input type='checkbox' name='{$fieldname}[]' class='np' value='$v' />$v\r\n";
                }
            }
        }
        $innertext = $myformItem;
    }

    else if($ftype=="htmltext")
    {
       $myformItem = GetEditor("body","$fvalue"); 
        $innertext = $myformItem;
    }
    else if($ftype=="multitext")
    {
        $innertext = "<textarea name='$fieldname' id='$fieldname' style='width:30%;height:80px'>$fvalue</textarea>\r\n";
    }
	//随后 是否日期类型和时间类型分开待看  150305
    else if($ftype=="datetime")
    {
       // $nowtime = GetDateTimeMk($fvalue);
       // $innertext = "<input type=\"text\" name=\"$fieldname\" size=\"23\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd H:m:s'})\"/>";
        $nowtime = GetDateMk($fvalue);
        $innertext = "<input type=\"text\" name=\"$fieldname\" size=\"12\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})\"/>";
        
		
    }
    else if($ftype=="img")
    {
        $ndtp = new DedeTagParse();
        $ndtp->LoadSource($fvalue);
        if(!is_array($ndtp->CTags))
        {
            $ndtp->Clear();
            $fvalue =  "";
        }
        else
        {
            $ntag = $ndtp->GetTag("img");
            $fvalue = trim($ntag->GetInnerText());
        }
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="imgfile")
    {
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="media")
    {
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="addon")
    {
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' value='$fvalue' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="int"||$ftype=="float")
    {
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:100px'  class='intxt' value='$fvalue' /> (填写数值)\r\n";
    }
    else
    {
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:250px'  class='intxt' value='$fvalue' />\r\n";
    }
	//dump($formitem);
    $formitem = str_replace('~name~',$ctag->GetAtt('itemname'),$formitem);
    $formitem = str_replace('~form~',$innertext,$formitem);
	
    return $formitem;
}








/**
 *  获得扩展字段的值(管理列表页使用)
 *
 * @access    public
 * @param     object  $ctag  标签
 * @param     mixed  $fvalue  变量值
 * @param     string  $stepname  数据字典名称   在device的扩展功能里,因为扩展表里的字段名称是固定的,所以使用数据字典的值时,数据字典的名称保存在特定的值(stepname)里(原DEDE中字段名称就是数据字典名称),所以这里使用$fieldname 来获取devive扩展表里的数据字典值

$isrow=false  是否行显示  默认是false 就是列显示  用于列表页显示;  true的话行显示,用于详细信息页,每个扩展内容以行显示
 * @return    string
 
 
 */
function GetListItemValue($ctag, $fvalue,  $stepname='',$isrow=false)
{
//dump($ctag);
  global $formitem_temp;  //只在此页使用 ，添加\编辑\详细信息显示页 的HTML格式 
    

     
	$listitem_temp =  "<td  align=\"left\">~value~</td>";//列表格式 就是列显示  用于列表页显示;    150116增加靠左显示  商品中表内容多的列显示
    if($isrow)$listitem_temp ="<tr> 
        <td width=\"10%\" class=\"bline\" height='24' align=\"right\">&nbsp;~name~：</td>
        <td class=\"bline\">~value~</td>
       </tr>";  //行显示,用于详细信息页,每个扩展内容以行显示
	
	global $cfg_basedir,$dsql;
    $fieldname = $ctag->GetName();  
	if($stepname=="") $stepname =$fieldname;   //如果数据字典名称不为空,则字段的名称就是数据字典的名称  ,在DEVICe的扩展字段里使用141229
	
    $listitem=$listitem_temp;
    $innertext = trim($ctag->GetInnerText());   //如果tag模板有值  则使用tag的模板,这个怎么设定 随后再找141229

	if($innertext!='')
    {
        $listitem = $innertext;
    }
    	//dump($listitem."---");
    $ftype = $ctag->GetAtt('type');
    $mylistitem = '';
    if(preg_match("/select|radio|checkbox/i", $ftype))
    {
        $items = explode(',',$ctag->GetAtt('default'));
    }
    
	//如果是 select radio checkbox 则直接输出数据库的值
	if($ftype=='select'||$ftype=='radio'||$ftype=='checkbox')
    {
    
        $mylistitem .= $fvalue;
        $innertext = $mylistitem;
    }

	//部门类型
	else if($ftype=='depselect')
    {
    
        $mylistitem = GetDepsNameByDepId($fvalue);
        $innertext = $mylistitem;
    }
	//员工类型
	else if($ftype=='empselect')
    {
    
        $mylistitem = GetEmpNameById($fvalue);
        $innertext = $mylistitem;
    }
    else if($ftype=='stepselect'||$ftype=='stepradio'||$ftype=='stepcheckbox')
    {
            //dump($fieldname);
			require_once DEDEINC.'/enums.func.php';  //获取联动枚举表单

			$mylistitem=GetEnumsValue($stepname,$fvalue);

		$listitem = str_replace('~name~',$ctag->GetAtt('itemname'),$listitem);
        $listitem = str_replace('~value~', $mylistitem, $listitem);
        return $listitem;
    }
	//随后 是否日期类型和时间类型分开待看  150305

    else if($ftype=="datetime")
    {
        //$innertext = GetDateTimeMk($fvalue);
        $innertext = GetDateMk($fvalue);
    }
    else 
    {
        $innertext = $fvalue;
    }
	
	//以下这些暂时没用 后期看列表中是否需要这些功能项
/*    else if($ftype=="htmltext")
    {
        //现在的功能是列表显示  如果后期需要显示的时候要转为纯文本 并截取一定的字数
		//$mylistitem = GetEditor("body","$fvalue"); 
        //$innertext = $mylistitem;
    }
    else if($ftype=="multitext")
    {
        //$innertext = "<textarea name='$fieldname' id='$fieldname' style='width:90%;height:80px'>$fvalue</textarea>\r\n";
    }
    else if($ftype=="img")
    {
       $ndtp = new DedeTagParse();
        $ndtp->LoadSource($fvalue);
        if(!is_array($ndtp->CTags))
        {
            $ndtp->Clear();
            $fvalue =  "";
        }
        else
        {
            $ntag = $ndtp->GetTag("img");
            $fvalue = trim($ntag->GetInnerText());
        }
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
   }
    else if($ftype=="imgfile")
    {
       // $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="media")
    {
        //$innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="addon")
    {
        //$innertext = "<input type='text' name='$fieldname' id='$fieldname' value='$fvalue' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='浏览...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
*/	

//dump($listitem);
    $listitem = str_replace('~name~',$ctag->GetAtt('itemname'),$listitem);
    $listitem = str_replace('~value~',$innertext,$listitem);
	
    return $listitem;
}