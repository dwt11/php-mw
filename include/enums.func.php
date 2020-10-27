<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * �����˵���
 *
 * @version        $Id: enums.func.php 2 13:19 2011-3-24 tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

// �������ڻ����ļ���д�뻺��
if(!file_exists(DEDEDATA.'/enums/system.php')) WriteEnumsCache();

/**
 *  ����ö�ٻ���
 *
 * @access    public
 * @param     string  $egroup  ������
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
        $tenum = false; //����������ʶ
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
    return '�ɹ���������ö�ٻ��棡';
}

/**
 *  ��ȡ�������������ݵĸ���������
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
 *  ��ȡö�ٵ�select��
 *
 * @access    public
 * @param     string  $egroup  ������
 * @param     string  $evalue  ������ֵ
 * @param     string  $formid  ��ID
 * @param     string  $seltitle  ѡ�����
 * @param     string  $display  ��ʾ��ʽ,Ĭ��radio,����ѡΪselect
 * @param     string  $width  radio,checkbox������ȼ��  Ĭ��120��,�������-1 ���޼��  ����
 * @return    string  �ɹ��󷵻�һ��ö�ٱ�
 */
function GetEnumsForm($egroup, $evalue='', $formid='', $seltitle='',$display='radio',$width=120)
{
	
	//�ж��ֵ����Ƿ�༶��
	//�༶�����ݿ��ȡ ���ɶ�����ʽ
	//???���δ��,�����������豸�������õ�,��������û������,
	//�Ժ��õ�ʱ������141224
	
	
	
	//dump($evalue);
    $forms="";
	$prefix="";  //??���û���� 141011
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
				if($width>0)$forms .="<div style='float: left;width:{$width}px;'>";  //�Ⱦ�����
				if($width==-1)$forms .="<div >";  //����
				if($v==$evalue)   
				{
					 $forms .="\t<input name='$formid' id='$formid' type='radio'  value='$v'   checked='checked'/><strong>$prefix$n</strong>\r\n";  //141207���ӼӴ���ʾ
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
				$checked="";  //�Ƿ�ѡ�� 141209��
				$name=Html2Text($prefix.$n); //�����Ƿ�Ӵ�
				if($width>0)$forms .="<div style='float: left;width:{$width}px;'>";  //�Ⱦ�����
				if($width==-1)$forms .="<div >";  //����
				//dump($v."----".$evalue);
				if(strlen($name)>15)$name="<span title='".$name."'>".cn_substrR($name,15)."</span>";//141225��� ��ֹ���ֹ��� 
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
		    //150123�Ż� ɾ���к��\r\n  ��Ϊ�ڲɹ���ƷʱҪ��̬��� �ɹ���λ, ���ֵҪ��JAVASCRIPT��
			$forms = "<select name='$formid' id='$formid' class='enumselect'>";
			$forms .= "\t<option value='' selected='selected'>ѡ��{$seltitle}</option>";   //ԭvalue='0'  ��Ϊgoods_log�е�logflag 0Ϊ����ֵ 1ע�� 2����  �˴�������0   141128�޸�
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
 *  ��ȡһ������
 *
 * @access    public
 * @param     string    $egroup   ������
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
 *  ��ȡ���ݵ�JS����(��������)
 *
 * @access    public
 * @param     string    $egroup   ������
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
        // JS�н�3����Ŀ��ŵ��ڶ���key��ȥ
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
 *  д������JS����
 *
 * @access    public
 * @param     string    $egroup   ������
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
 *  ��ȡö�ٵ�ֵ
 *
 * @access    public
 * @param     string    $egroup   ������
 * @param     string    $evalue   ����ֵ
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












//��ȡ�����б�(�ֵ��б�ҳ����ʾ/�ֵ��б�ҳ��Ԥ��/��ȡ��ʱ�ж�,��������Ƕ༶��,��������)
//$egroup,  ������
//$selevalue ѡ�е�ֵ
function getOptionsList($egroup,$selevalue="")
{
    global $OptionArrayList;    //����OPTION�����
	global $dsql;

	$wheresql="";
    //��ǰѡ�еĲ���
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
        LogicGetOptionArray($egroup,$row->evalue, '��', $dsql, $sonCats);
		$OptionArrayList .= "<option value='".$row->evalue."' class='option1'>".$row->ename."</option>\r\n";
		$OptionArrayList .= $sonCats;

       
    }
	//dump($OptionArrayList);
    return $OptionArrayList;
}

function LogicGetOptionArray($egroup,$evalue,$step,&$dsql, &$sonCats)
{
    global $OptionArrayList;    //����OPTION�����
    $dsql->SetQuery("Select * From `#@__sys_enum` where egroup='$egroup' and  reevalue='".$evalue."'    ORDER BY disorder ASC");
    $dsql->Execute($egroup.$evalue);
    while($row=$dsql->GetObject($egroup.$evalue))
    {
        	

        $sonCats .= "<option value='".$row->evalue."' class='option3'>$step".$row->ename."</option>\r\n";
        LogicGetOptionArray($egroup,$row->evalue,$step.'��',$dsql, $sonCats);
    }
	
	
}
