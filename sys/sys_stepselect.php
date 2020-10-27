<?php
/**
 * ����ѡ�����
 *
 * @version        $Id: sys_stepselect.php 2 13:23 2011-3-24 tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once("../config.php");

require_once(DEDEINC."/datalistcp.class.php");
require_once(DEDEINC.'/enums.func.php');
/*-----------------
ǰ̨��ͼ
function __show() { }
------------------*/
$ENV_GOBACK_URL = (isset($ENV_GOBACK_URL) ? $ENV_GOBACK_URL : 'sys_stepselect.php');
if(empty($action))
{
    setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
    if(!isset($egroup)) $egroup = '';
    if(!isset($reevalue)) $reevalue ='';
    $etypes = array();
    $egroups = array();
    $dsql->Execute('me','SELECT * FROM `#@__sys_stepselect` ORDER BY id DESC');
    while($arr = $dsql->GetArray())
    {
        $etypes[] = $arr;
        $egroups[$arr['egroup']] = $arr['itemname'];
    }

    if($egroup!='')
    {
        $orderby = 'ORDER BY disorder ASC, evalue ASC';
        if(!empty($reevalue))
        {
            //��ѯ������
           // $egroupsql = " WHERE egroup LIKE '$egroup' AND reevalue='$reevalue' or (evalue='$reevalue' and egroup='$egroup')";
		    $egroupsql = " WHERE egroup LIKE '$egroup' AND reevalue='$reevalue' ";
        }
        else
        {
			//ֻ��ȡ��������,Ȼ�󵽽������ڵ��ù��� �ݹ��ȡ �¼�����
            $egroupsql = " WHERE egroup LIKE '$egroup' and (reevalue='0' or isnull(reevalue) or reevalue='') ";
        }
        $sql = "SELECT * FROM `#@__sys_enum` $egroupsql $orderby";
    } else {
        $egroupsql = '';
        $sql = "SELECT * FROM `#@__sys_stepselect` ORDER BY id DESC";
    }
    //echo $sql;exit;
    $dlist = new DataListCP();
    $dlist->SetParameter('egroup',$egroup);
    $dlist->SetParameter('reevalue',$reevalue);
    $dlist->SetTemplet("sys_stepselect.htm");
    $dlist->SetSource($sql);
    $dlist->display();
    exit();
}
else if($action=='edit' || $action=='addnew' || $action=='addenum' || $action=='view')
{
    AjaxHead();
    include('sys_stepselect_showajax.htm');
    exit();
}
/*-----------------
ɾ�����������
function __del() { }
------------------*/
else if($action=='del')
{
    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_stepselect` WHERE id='$id' ");
    if(!is_array($arr))
    {
        ShowMsg("�޷���ȡ��Ϣ�����������������", "sys_stepselect.php?".ExecTime());
        exit();
    }
    if($arr['issystem']==1)
    {
        ShowMsg("ϵͳ���õ��鲻��ɾ����", "sys_stepselect.php?".ExecTime());
        exit();
    }
    $dsql->ExecuteNoneQuery("DELETE FROM `#@__sys_stepselect` WHERE id='$id'; ");
    $dsql->ExecuteNoneQuery("DELETE FROM `#@__sys_enum` WHERE egroup='{$arr['egroup']}'; ");
    ShowMsg("�ɹ�ɾ��һ���飡", "sys_stepselect.php?".ExecTime());
    exit();
}
else if($action=='delenumAllSel')
{
    if(isset($ids) && is_array($ids))
    {
        $id = join(',', $ids);

        $groups = array();
        $dsql->Execute('me', "SELECT egroup FROM `#@__sys_enum` WHERE id IN($id) GROUP BY egroup");
        while($row = $dsql->GetArray('me'))
        {
            $groups[] = $row['egroup'];
        }

        $dsql->ExecuteNoneQuery("DELETE FROM `#@__sys_enum` WHERE id IN($id); ");

        //���»���
        foreach($groups as $egropu) 
        {
            WriteEnumsCache($egroup);
        }

        ShowMsg("�ɹ�ɾ��ѡ�е������ݣ�", $ENV_GOBACK_URL);
    }
    else
    {
        ShowMsg("��ûѡ���κ����ݣ�", "-1");
    }
    exit();
}
else if($action=='delenum')
{
    $row = $dsql->GetOne("SELECT egroup FROM `#@__sys_enum` WHERE id = '$id' ");
    $dsql->ExecuteNoneQuery("DELETE FROM `#@__sys_enum` WHERE id='{$id}'; ");
    WriteEnumsCache($row['egroup']);
    ShowMsg("�ɹ�ɾ��һ�������ݣ�", $ENV_GOBACK_URL);
    exit();
}
/*-----------------
�������޸�
function __edit_save() { }
------------------*/
else if($action=='edit_save')
{
    if(preg_match("#[^0-9a-z_-]#i", $egroup))
    {
        ShowMsg("�����Ʋ�����ȫ���ַ���������ţ�","-1");
        exit();
    }
    $dsql->ExecuteNoneQuery("UPDATE `#@__sys_stepselect` SET `itemname`='$itemname',`egroup`='$egroup',`description`='$description' WHERE id='$id'; ");
    ShowMsg("�ɹ��޸�һ�����࣡", "sys_stepselect.php?".ExecTime());
    exit();
}
/*-----------------
��������
function __addnew_save() { }
------------------*/
else if($action=='addnew_save')
{
    if(preg_match("#[^0-9a-z_-]#i", $egroup))
    {
        ShowMsg("�����Ʋ�����ȫ���ַ���������ţ�", "-1");
        exit();
    }
    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_stepselect` WHERE itemname LIKE '$itemname' OR egroup LIKE '$egroup' ");
    if(is_array($arr))
    {
        ShowMsg("��ָ����������ƻ��������Ѿ����ڣ�����ʹ�ã�","sys_stepselect.php");
        exit();
    }
    $dsql->ExecuteNoneQuery("INSERT INTO `#@__sys_stepselect`(`itemname`,`egroup`,`issign`,`issystem`,`description`) VALUES('$itemname','$egroup','0','0','$description'); ");
    WriteEnumsCache($egroup);
    ShowMsg("�ɹ����һ���飡","sys_stepselect.php?egroup=$egroup");
    exit();
}
/*���������
---------------------*/
else if($action=='addenum_save')
{
    if(empty($ename) ) 
    {
         Showmsg("���������Ʋ���Ϊ�գ�","-1");
         exit();
    }
    
    
    if($reevalue!="")//����ϼ�ֵ��Ϊ��,����������Ӷ������µ�������
    {
        $enames = explode(',', $ename);
        foreach($enames as $ename)
        {
           
		    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_enum` WHERE  egroup='$egroup'  and ename = '$ename' ");
			if(is_array($arr))
			{
				ShowMsg("����д�������������Ѿ����ڣ�����ʹ�ã�",$ENV_GOBACK_URL);
				exit();
			}

		   
		    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_enum` WHERE egroup='$egroup' ORDER BY id DESC ");
                   // echo $sql;exit;
			if(!is_array($arr)){
			$disorder = $evalue =  1 ;
			}
			else 
			{
			$disorder = $arr['disorder'] + 1 ;
			//$evalue = $arr['evalue'] + 1 ;
			}
                
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__sys_enum`(`ename`,`evalue`,`reevalue`,`egroup`,`disorder`,`issign`) 
                                    VALUES('$ename','$disorder','$reevalue','$egroup','$disorder','$issign'); "); 
        }
    
    }else
    {//���һ��������
        $enames = explode(',', $ename);
        foreach($enames as $ename)
        {
           
		    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_enum` WHERE  egroup='$egroup'  and ename = '$ename' ");
			if(is_array($arr))
			{
				ShowMsg("����д�������������Ѿ����ڣ�����ʹ�ã�",$ENV_GOBACK_URL);
				exit();
			}

		   
		    $arr = $dsql->GetOne("SELECT * FROM `#@__sys_enum` WHERE egroup='$egroup'  ORDER BY id DESC ");
                   // echo $sql;exit;
			if(!is_array($arr)){
			$disorder = $evalue =  1 ;
			}
			else 
			{
			$disorder = $arr['disorder'] + 1 ;
			//$evalue = $arr['evalue'] + 1 ;
			}
                
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__sys_enum`(`ename`,`evalue`,`egroup`,`disorder`,`issign`) 
                                    VALUES('$ename','$disorder','$egroup','$disorder','$issign'); "); 
        }
	}
        WriteEnumsCache($egroup);                                                          
        ShowMsg("�ɹ���������ݣ�".$dsql->GetError(), $ENV_GOBACK_URL);
        exit();
}
/*-----------------
�޸����������ƺ�����
function __upenum() { }
------------------*/
else if($action=='upenum')
{
    $ename = trim(str_replace("-", '', $ename));
    $row = $dsql->GetOne("SELECT egroup FROM `#@__sys_enum` WHERE id = '$aid'");   ///141223�޸� ��ȡ ������ 1\�����ж�������ֵ�Ƿ��ظ� 2\���������ݵ�JS
    $row1 = $dsql->GetOne("SELECT * FROM `#@__sys_enum` WHERE egroup = '".$row['egroup']."' and evalue='$evalue' and id!=$aid ");//�ж�������ֵ�Ƿ��ظ�
	if(is_array($row1))
	{
		ShowMsg("������ֵ�ظ�,���飡", '-1');
	}else{
    
		$dsql->ExecuteNoneQuery("UPDATE `#@__sys_enum` SET `ename`='$ename',`evalue`='$evalue',`disorder`='$disorder' WHERE id='$aid'; ");
		ShowMsg("�ɹ��޸�һ�������ݣ�", $ENV_GOBACK_URL);
		WriteEnumsCache($row['egroup']);
	}
	exit();
}
/*-----------------
����ö�ٻ���
function __upallcache() { }
------------------*/
else if($action=='upallcache')
{
    if(!isset($egroup)) $egroup = '';
    WriteEnumsCache($egroup);
    ShowMsg("�ɸ��»��棡", $ENV_GOBACK_URL);
    exit();
}



    /**
     *  ���һ�����µĵݹ����
     *
     * @access    public
     * @param      $egroup   ��������  
     * @param      $evalue   ����ֵ  
     * @param     string  $step  �㼶��־
     * @return    void
     */
    function LogicListAllSun($egroup,$evalue, $step)
    {
        $fevalue = $evalue;
		global $dsql;
        $dsql->SetQuery("SELECT * FROM `dede_sys_enum` WHERE reevalue='$fevalue' and egroup='$egroup' order by disorder");
        $dsql->Execute($fevalue);
        if($dsql->GetTotalRow($fevalue)>0)
        {
            while($row = $dsql->GetObject($fevalue))
            {
                //$egroup = $row->egroup;
                $ename = $step.$row->ename;
                $reevalue = $row->reevalue;
                $evalue = $row->evalue;
                $disorder = $row->disorder;
                $id = $row->id;
                

				echo "<tr align='center' bgcolor='#FFFFFF' height='24' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" 
					onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
				  <td><input type='checkbox' name='ids[]' value='{dede:field.id /}' class='np' /></td>
				  <td>$id</td>
				  <td>";
				  echo getSunNumb($egroup,$evalue);
				  echo "</td>
				  <td>$egroup</td>
				  <td>
				  
				  <input type='text' id='ename{$id}' value='$ename' class='abt' /></td>
				  <td><input type='text' id='evalue{$id}' value='$evalue' class='abt' /></td>
				  <td><input type='text' id='disorder{$id}' value='$disorder' class='abt' /></td>
				  <td>";
				  if(!empty($egroup))
					{
				   
				  echo "   <a href='javascript:updateItem({$id});'>[����]</a> <a href='javascript:isdel(\"sys_stepselect.php?action=delenum&id=\",{$id});'>[ɾ��]</a>";
				   
					 }
					 else
					 {
						   echo "<a href='sys_stepselect.php?egroup={$egroup}'><u>".$egroup."</u></a>";
					 }
				  echo "</td>
				</tr>";





                LogicListAllSun($egroup,$evalue,$step.$step);
            }
        }
    }


















    /**
     *  ��õ�ǰ���ݵ� ���ڼ���
	 evalue Ϊ��Ϊ��һ��
	 
     *
     * @access    public
     * @param      $egroup   ��������  
     * @param      $evalue   ����ֵ  
     * @param     string  $step  �㼶��־
     * @return    void
     */
    function getSunNumb($egroup,$evalue)
    {
        $fevalue = $evalue;
		global $dsql;
        global $i;    
       $dsql->SetQuery("SELECT * FROM `dede_sys_enum` WHERE evalue='$fevalue' and egroup='$egroup' order by disorder");
        //dump("SELECT * FROM `dede_sys_enum` WHERE evalue='$fevalue' and egroup='$egroup' order by disorder");
		
		$i=1;
		$dsql->Execute();
        if($dsql->GetTotalRow()>0)
        {
            while($rownumb = $dsql->GetObject())
            {
                $reevalue = $rownumb->reevalue;
				if(empty($reevalue)||$reevalue==""||$reevalue=="0")
				{
					//dump($i);
					return "<strong>1</strong>��";
				}else
				{
					//$i++;
					//dump($i);
					getLogicSunNumb($egroup,$reevalue,$i);
				    return $i."��";
				}
            }
        }
    }
	
	
    function getLogicSunNumb($egroup,$evalue,$i)
    {
        $fevalue = $evalue;
		global $dsql;
         global $i;    
       $dsql->SetQuery("SELECT * FROM `dede_sys_enum` WHERE evalue='$fevalue' and egroup='$egroup' order by disorder");
		
		$dsql->Execute($fevalue.$i.$i);
        if($dsql->GetTotalRow($fevalue.$i.$i)>0)
        {
            while($rownumbl = $dsql->GetObject($fevalue.$i.$i))
            {
                $reevaluel = $rownumbl->reevalue;
				
					$i++;
					//dump($i);
					getLogicSunNumb($egroup,$reevaluel,$i);
            }
        }
    }
































