<?php   if(!defined('DEDEINC')) exit('dedecms');
/**
 * ϵͳ���ĺ�������ļ�
 * @version        $Id: customfields.func.php 2 20:50 2010��7��7��Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
/**
 *  ���һ�����ӱ�(����ʱ��)
 *
 * @access    public
 * @param     object  $ctag  ��ǩ
 * @return    string
 */
 
 
 
  global $formitem_temp;  //ֻ�ڴ�ҳʹ�� �����\�༭\��ϸ��Ϣ��ʾҳ ��HTML��ʽ 
  $formitem_temp =  "<tr> 
        <td width=\"10%\" class=\"bline\" height='24' align=\"right\">&nbsp;~name~��</td>
        <td class=\"bline\">~form~</td>
       </tr>
   ";
 
 /**
 *  ��ñ�(���ʱ��)
 *
 * @access    public
 * @param     object  $ctag  ��ǩ
 * @param     string  $stepname  �����ֵ�����  141229����

 * @return    string
 */

function GetFormItem($ctag,$stepname='')
{
    global $dsql;
    global $formitem_temp;
    $fieldname = $ctag->GetName();
 	if($stepname=="") $stepname =$fieldname;   //��������ֵ����Ʋ�Ϊ��,���ֶε����ƾ��������ֵ������  ,��DEVICe����չ�ֶ���ʹ��141229
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
		$myformItem .= "<option value='0'>��ѡ����...</option>\r\n";
		$myformItem .= $depOptions;
		$myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }
	
	//150305���� Ա��ѡ��
    else if($fieldType=='empselect')
    {
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));


		  $EmpOptions = GetEmpOptionList();
          $myformItem .=  "<div style='width:280px'><span style='color:#999; float:right'>֧�ֱ��\����\ƴ������ĸ����</span><select name='empid' id='empid'  m='search' >\r\n";
          $myformItem .=  "<option value='0'>��ѡ��Ա��...</option>\r\n";
          $myformItem .=  $EmpOptions;
          $myformItem .=  "</select> \r\n
						  <!--//select����ѡ���-->
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

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

			$myformItem=GetEnumsForm($stepname,'', $fieldname, $seltitle='','select');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ctag->GetAtt("type")=='stepradio')
    {

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

			$myformItem=GetEnumsForm($stepname,'', $fieldname, $seltitle='','radio');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($fieldType=='stepcheckbox')
    {

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

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
	
	//��� �Ƿ��������ͺ�ʱ�����ͷֿ�����  150305
    else if($fieldType=="datetime")
    {
        //$nowtime = GetDateTimeMk(time());
		$nowtime = GetDateMk(time());
        //$innertext = "<input type=\"text\" name=\"$fieldname\" size=\"23\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd H:m:s'})\"/>";
		        $innertext = "<input type=\"text\" name=\"$fieldname\" size=\"12\" value=\"$nowtime\" readonly=\"readonly\" class=\"Wdate\"  onfocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})\"/>";

    }
    else if($fieldType=='img'||$fieldType=='imgfile')
    {
       $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($fieldType=='media')
    {
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='���...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($fieldType=='addon')
    {
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300px' class='text' /> <input name='".$fieldname."_bt' type='button' class='inputbut' value='���...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
    else if($fieldType=='int'||$fieldType=='float')
    {
        $dfvalue = ($ctag->GetAtt('default')!='' ? $ctag->GetAtt('default') : '0');
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:100px'  class='intxt' value='$dfvalue' /> (��д��ֵ)\r\n";
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
 *  ����ͬ���͵�����
 *  ���������ʱʹ��  ����չ�������ֵ ת��Ϊ���ʵ�ֵ
 * @access    public
 * @param     string  $dvalue  Ĭ��ֵ
 * @param     string  $dtype  Ĭ������
 * @param     int  $aid  �ĵ�ID
 * @param     string  $job  ��������
 * @param     string  $addvar  ֵ
 * @param     string  $fieldname  ��������
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
    else if($dtype=='stepcheckbox')//141120���� �����ֵ��checkbox����ֵʱ ��ȡ���ȵ�ֵ
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
            //Զ��ͼƬ
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
            //վ��ͼƬ
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
 *  ��ô�ֵ�ı�(�༭ʱ��)
 *
 * @access    public
 * @param     object  $ctag  ��ǩ
 * @param     mixed  $fvalue  ����ֵ
 * @param     string  $stepname  �����ֵ�����  ԭΪ$fieldname 141129�޸� ($fieldname  ����Ƿ����ô���,��Ϊ�ڹ������ֻ�ȡ��һ��  ����Ĺ���Ҳ�е�  ����ٴ���141229  ��getListitemValue���Ѿ�����������)

 * @return    string
 */
function GetFormItemValue($ctag, $fvalue,  $stepname='')
{
   global $formitem_temp;
//dump($ctag);
    global $cfg_basedir,$dsql;
    $fieldname = $ctag->GetName();
	if($stepname=="") $stepname =$fieldname;   //��������ֵ����Ʋ�Ϊ��,���ֶε����ƾ��������ֵ������  ,��DEVICe����չ�ֶ���ʹ��141229
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
		$myformItem .= "<option value='0'>��ѡ����...</option>\r\n";
		$myformItem .= $depOptions;
		$myformItem .= "</select>\r\n";
        $innertext = $myformItem;
    }

	//150305���� Ա��ѡ��
    else if($ftype=='empselect')
    {
		require_once(DEDEPATH."/emp/emp.inc.options.php");	
			
        $myformItem = '';
        $items = explode(',',$ctag->GetAtt("default"));


		  $EmpOptions = GetEmpOptionList($fvalue);
          $myformItem .=  "<div style='width:280px'><span style='color:#999; float:right'>֧�ֱ��\����\ƴ������ĸ����</span><select name='empid' id='empid'  m='search' >\r\n";
          $myformItem .=  "<option value='0'>��ѡ��Ա��...</option>\r\n";
          $myformItem .=  $EmpOptions;
          $myformItem .=  "</select> \r\n
						  <!--//select����ѡ���-->
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

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

			$myformItem=GetEnumsForm($stepname,$fvalue, $fieldname, $seltitle='','select');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ftype=='stepradio')
    {

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

			$myformItem=GetEnumsForm($stepname,$fvalue, $fieldname, $seltitle='','radio');

        $formitem = str_replace('~name~', $ctag->GetAtt('itemname'), $formitem);
        $formitem = str_replace('~form~', $myformItem, $formitem);
        return $formitem;
    }
    else if($ftype=='stepcheckbox')
    {

			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

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
	//��� �Ƿ��������ͺ�ʱ�����ͷֿ�����  150305
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
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="imgfile")
    {
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="media")
    {
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="addon")
    {
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' value='$fvalue' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="int"||$ftype=="float")
    {
        $innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:100px'  class='intxt' value='$fvalue' /> (��д��ֵ)\r\n";
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
 *  �����չ�ֶε�ֵ(�����б�ҳʹ��)
 *
 * @access    public
 * @param     object  $ctag  ��ǩ
 * @param     mixed  $fvalue  ����ֵ
 * @param     string  $stepname  �����ֵ�����   ��device����չ������,��Ϊ��չ������ֶ������ǹ̶���,����ʹ�������ֵ��ֵʱ,�����ֵ�����Ʊ������ض���ֵ(stepname)��(ԭDEDE���ֶ����ƾ��������ֵ�����),��������ʹ��$fieldname ����ȡdevive��չ����������ֵ�ֵ

$isrow=false  �Ƿ�����ʾ  Ĭ����false ��������ʾ  �����б�ҳ��ʾ;  true�Ļ�����ʾ,������ϸ��Ϣҳ,ÿ����չ����������ʾ
 * @return    string
 
 
 */
function GetListItemValue($ctag, $fvalue,  $stepname='',$isrow=false)
{
//dump($ctag);
  global $formitem_temp;  //ֻ�ڴ�ҳʹ�� �����\�༭\��ϸ��Ϣ��ʾҳ ��HTML��ʽ 
    

     
	$listitem_temp =  "<td  align=\"left\">~value~</td>";//�б��ʽ ��������ʾ  �����б�ҳ��ʾ;    150116���ӿ�����ʾ  ��Ʒ�б����ݶ������ʾ
    if($isrow)$listitem_temp ="<tr> 
        <td width=\"10%\" class=\"bline\" height='24' align=\"right\">&nbsp;~name~��</td>
        <td class=\"bline\">~value~</td>
       </tr>";  //����ʾ,������ϸ��Ϣҳ,ÿ����չ����������ʾ
	
	global $cfg_basedir,$dsql;
    $fieldname = $ctag->GetName();  
	if($stepname=="") $stepname =$fieldname;   //��������ֵ����Ʋ�Ϊ��,���ֶε����ƾ��������ֵ������  ,��DEVICe����չ�ֶ���ʹ��141229
	
    $listitem=$listitem_temp;
    $innertext = trim($ctag->GetInnerText());   //���tagģ����ֵ  ��ʹ��tag��ģ��,�����ô�趨 �������141229

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
    
	//����� select radio checkbox ��ֱ��������ݿ��ֵ
	if($ftype=='select'||$ftype=='radio'||$ftype=='checkbox')
    {
    
        $mylistitem .= $fvalue;
        $innertext = $mylistitem;
    }

	//��������
	else if($ftype=='depselect')
    {
    
        $mylistitem = GetDepsNameByDepId($fvalue);
        $innertext = $mylistitem;
    }
	//Ա������
	else if($ftype=='empselect')
    {
    
        $mylistitem = GetEmpNameById($fvalue);
        $innertext = $mylistitem;
    }
    else if($ftype=='stepselect'||$ftype=='stepradio'||$ftype=='stepcheckbox')
    {
            //dump($fieldname);
			require_once DEDEINC.'/enums.func.php';  //��ȡ����ö�ٱ�

			$mylistitem=GetEnumsValue($stepname,$fvalue);

		$listitem = str_replace('~name~',$ctag->GetAtt('itemname'),$listitem);
        $listitem = str_replace('~value~', $mylistitem, $listitem);
        return $listitem;
    }
	//��� �Ƿ��������ͺ�ʱ�����ͷֿ�����  150305

    else if($ftype=="datetime")
    {
        //$innertext = GetDateTimeMk($fvalue);
        $innertext = GetDateMk($fvalue);
    }
    else 
    {
        $innertext = $fvalue;
    }
	
	//������Щ��ʱû�� ���ڿ��б����Ƿ���Ҫ��Щ������
/*    else if($ftype=="htmltext")
    {
        //���ڵĹ������б���ʾ  ���������Ҫ��ʾ��ʱ��ҪתΪ���ı� ����ȡһ��������
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
        $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
   }
    else if($ftype=="imgfile")
    {
       // $innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\" />\r\n";
    }
    else if($ftype=="media")
    {
        //$innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectMedia('form1.$fieldname')\" />\r\n";
    }
    else if($ftype=="addon")
    {
        //$innertext = "<input type='text' name='$fieldname' id='$fieldname' value='$fvalue' style='width:300px'  class='text' /> <input name='".$fieldname."_bt' class='inputbut' type='button' value='���...' onClick=\"SelectSoft('form1.$fieldname')\" />\r\n";
    }
*/	

//dump($listitem);
    $listitem = str_replace('~name~',$ctag->GetAtt('itemname'),$listitem);
    $listitem = str_replace('~value~',$innertext,$listitem);
	
    return $listitem;
}