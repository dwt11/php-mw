<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * ���ܹ���
 *
 * @version        $Id: depunit.class.php 1 15:21 2010��7��5��Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * ϵͳ���ܹ���   
 *
 * @package          DepUnit
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class sys_group
{
    var $dsql;
    var $funFileName;  //
    var $fileTitle;  //    ������ ���������չ���ܵı���
    var $depName;
	var $depId;
	var $allFileNumb;   //ȫ���ӹ��ܵ��ܸ���
	var $childFileNumbArray;  //��ʽ$childFileNumbArray[$key]   $key�������ܴ����ݿ��ж�ȡ����ID //�����ܰ������ӹ��ܵĸ���=���ݿ����ӹ��ܸ���+sys_function_date.PHP�ж�ȡ�����ӹ��ܵĸ��ӹ���(�½�-�༭-ɾ��)
	var $childFilePlusNumbArray;  //��ʽ$childFilePlusNumbArray[$key]   $key���ӹ��ܴ����ݿ��ж�ȡ����ID //=�ӹ��ܰ�������չ����(�½�-�༭-ɾ��)�ĸ���+����ĸ���
	var $allDepNumb;   //ȫ�����ŵ��ܸ���
	var $save_webRole; //�����ȡ�����û�ѡ���Ȩ��
	var $save_depRole;//�����ȡ�����û�ѡ���Ȩ��



    var $funArray;    //������ ���������ഴ��ʱ ��ֵ,��������ѭ������  �����ѭ��  ������ÿ�����������
    //php5���캯��
    function __construct()
    {
		$this->dsql = $GLOBALS['dsql'];
        $this->depName = array();
        $this->depId = array();
        $this->funFileName = array();
        $this->fileTitle = array();
        $this->childFileNumbArray = array();
        $this->childFilePlusNumbArray = array();
        $this->allFileNumb = 0;
        $this->allDepNumb = 0;
        $this->save_webRole = "";
        $this->save_depRole = "";
		
		require_once(DEDEDATA."/sys_function_data.php");
			
		//���빦����
		require_once("sys_function.class.php");
		$fun = new sys_function();
		$this->fucArray=$fun->getSysFunArray();
			
	    $this->getFileArray();   //��ȡ�ӹ���������� ����������
	   $this->getAllDepArray();   //��ȡ������Ϣ ����������
	   $this->getDepNumb();   //��ȡ��������
    }


    function sys_function()
    {
        $this->__construct();
    }

    //������
    function Close()
    {
    }




	//���
	function getRoleTable($groupWebRanks="",$groupDepRanks="",$isView=false)
	{
            
			$disp="";
            if(!$isView&&$groupWebRanks!=""&&!in_array("admin_AllowAll",$groupWebRanks))$disp= "style='display:none'";//����ǹ���Ա�����ʾ,ҳ�����ʱ�Զ�����;���ǹ���Ա�������,ҳ�����ʱ�Զ���ʾ,��ΪshowHideȡ���Ƿ� 
            echo "       <table  id='roleTable' width='98%'  border='0' cellspacing='1' cellpadding='1' $disp >\r\n";
            
			
			foreach ($this->fucArray as $key=>$menu)
			{
				 //$retuStr="";
				echo "<tr>\r\n
					  <td>\r\n
					  <table border='0' cellspacing='1'  cellpadding='1' style='margin:10px' bgcolor='#D6D6D6' align='left'>\r\n
				  <tr  align='center' bgcolor='#FBFCE2'>\r\n";
				$this->getDirs($key,$menu);   //ֱ����� ����������
				echo "</tr>\r\n";
				  
	  
	  
				//�����������:ҳ��Ĺ�������
				//��һ�� ���ݿ��еĹ�������(�˵���ʾ)
				//�ڶ��� ���ܵĸ��ӹ��� ���ļ��ж�ȡ (�½� �༭ ɾ����)
				$this->getFiles($key,$menu);   //ֱ�����
	  
	  

				echo "<tr  align='center' bgcolor='#ffffff'  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">";
				//���һ��checkbox:������ȫѡ
				$this->getCheckbox($key,$menu,$groupWebRanks,$groupDepRanks,$isView);   //ֱ�����
				echo "</tr>";
	  
				//������в��ŵ���:����
				//��һ�в�������,�ڶ���CHECKBOX������ȫѡ 
				$this->getDeps($key,$menu,$groupWebRanks,$groupDepRanks,$isView);   //ֱ�����
	  
	  
	  
				echo "</table>\r\n
				             </td>\r\n
            </tr>\r\n";
			}
			
			echo "</table>\r\n";
	}




  

	//�����һ�� �����ܴ���
	//$key   �����ܵ����ݿ�ID
	//$menu  �����ܵ�����
	function getDirs($key,$menu)
	{


            //if(file_exists(DEDEPATH.'/emp'))
			//echo "        <td rowspan=\"4\"  colspan=\"2\" ><!--��һ�к͵�һ�е����Ͻǿհ�--></td>";   //�����Ա���Ͳ��ŵ���ع���,����������һ��
					  //���û�в���,��������� ȫѡcheckbox
				if($this->allDepNumb==0)
				{
					echo "        <td rowspan=\"3\" width='30'><!--��һ�к͵�һ�е����Ͻǿհ�--></td>";   //�����Ա���Ͳ��ŵ���ع���,����������һ��
				}else
				{
					echo "        <td rowspan=\"4\"  colspan=\"2\" ><!--��һ�к͵�һ�е����Ͻǿհ�--></td>";   //�����Ա���Ͳ��ŵ���ع���,����������һ��	
				}
				
				
				
				
			//dump($this->fucArray);
				
				
				//����ӹ��ܼ�¼������0����������� 
				if($this->childFileNumbArray[$key]>0)
				{
					$parentMenu=explode(',',$menu[0]);  
					//$parentId=$parentMenu[0];
					$parentTitle=$parentMenu[3];
					
					$childNumb=count($menu)-1;
					$this->allFileNumb+=$childNumb;
					//dump($childNumb);
					//dump($this->childFileNumbArray[$key]."-----0--------");
					//�������������
					echo     "<td colspan=\"".$this->childFileNumbArray[$key]."\"><strong>$parentTitle</strong></td>\r\n";
				}



	}
	

          //�����������:ҳ��Ĺ�������
	//$key   �����ܵ����ݿ�ID
	//$menu  �����ܵ�����
	function getFiles($key,$menu)
	{       
		  //�ڶ��� ���ݿ��е��ӹ�������(�˵���ʾ)
			echo "      <tr  align=\"center\" bgcolor=\"#FBFCE2\">\r\n";
			for($childi=1;$childi<count($menu);$childi++)
			{
				$childMenu=explode(',',$menu[$childi]);  
				$childId=$childMenu[0];
				$childTitle=$childMenu[3];
				//dump($this->childFilePlusNumbArray);
				$plusi=0;
				//if($this->childFileNumbArray[$childId]!=NULL)
				$plusi=$this->childFilePlusNumbArray[$childId];
				$colspan="";
				if($plusi>1)
				{
					$td_row= "colspan=\"".$plusi."\"";
				}else
				{
					$td_row= " rowspan=\"2\"  ";
				}
				echo "<td $td_row  nowrap style='min-width:60px'>".$childTitle."</td>\r\n";
			}
			echo "</tr>\r\n";

			echo "      <tr  align=\"center\" bgcolor=\"#FBFCE2\">\r\n";
		  
		  
		  
		  //������ �ӹ��ܵĸ��ӹ��� ���ļ��ж�ȡ (�½� �༭ ɾ����)
			if(array_key_exists($key,$this->fileTitle))
			{
				for($i1=0; $i1<=count($this->fileTitle[$key])-1; $i1++)
				{
					echo "<td  valign=\"top\" align=\"center\" nowrap; style='min-width:60px'>".$this->fileTitle[$key][$i1]."</td>\r\n";
				}
				echo "</tr>";
			}
			
		  
	}

    //��������� checkbox :������ȫѡ
	//$key   �����ܵ����ݿ�ID
	//$menu  �����ܵ�����
	//$groupWebRanks=""    �༭��鿴ʱ���������û���ҳ��Ȩ��ֵ
	//,$groupDepRanks="",  �༭��鿴ʱ���������û��Ĳ���Ȩ��ֵ
	//$isView=false        false���checkbox   TRUE��������,�鿴Ȩ��ҳ����
	function getCheckbox($key,$menu,$groupWebRanks="",$groupDepRanks="",$isView=false)
	{

		  //���û�в���,��������� ȫѡcheckbox
		  if($this->allDepNumb==0)
		  {
			  echo "<td align=\"center\"  height='30' >";
				  if(!$isView)echo "<input name=\"dep".$key."[]\" type='checkbox' class='np' value=\"\"  onClick='row_Sel(\"$key\")'   >";   //û�в�������ʱ�� ��ȫѡ
			  echo "</td >";
		  }
		  for($i1=0; $i1<=count($this->funFileName[$key])-1; $i1++)
          {
              echo "<td align=\"center\"  height='30' >";
			  if($this->isDepDate($this->funFileName[$key][$i1]))  //����˹��ܰ�����������������ŵ����� �������0 ����JS�ж� �е�CHECKBOX��ȫѡ
			  {
				  if(!$isView)echo "<input  type='checkbox' class='np' id='file_".$i1.$key."'  value=\"\"  onClick='col_Sel(\"".$i1.$key."\",\"".$this->allDepNumb."\")'  >";
			  }else
			  {
				   //��������ص�
//				   if(!$isView)echo "<input name=\"onlyfile[]\"  type=\"checkbox\" class='np'  id='file_".$i1."_-100'  value=\"".$this->funFileName[$key][$i1]."\"";
//				   if(!$isView&&($groupWebRanks!=""||$groupDepRanks!=""))echo $this->CRank(0,$this->funFileName[$key][$i1],$groupWebRanks,$groupDepRanks,$isView);  //�Ƿ�ѡ��
//				   //if(!$isView)echo " style=\"display:none\"> ";
//				   if(!$isView)echo " > ";
				  
				   //����˹��� �������������� ������������checkbox ���ڱ���ҳ��ֱ�ӻ�ȡ ֻ�ļ����ܵ�����
					if(!$isView)echo "<input name=\"dep".$key."[]\" type='checkbox' class='np' id='file_".$i1."_-100' value=\"".$this->funFileName[$key][$i1]."\" ";
					if($groupWebRanks!=""||$groupDepRanks!="")echo $this->CRank(0,$this->funFileName[$key][$i1],$groupWebRanks,$groupDepRanks,$isView);
					if(!$isView)echo ">";
				  
				  
			  }
			  //echo "";
			  echo "</td>\r\n";
          }
	}


		  //������в��ŵ���:����
		  //��һ�в�������,�ڶ���CHECKBOX������ȫѡ 
          //$groupWebRanks="",$groupDepRanks="" �༭�Ͳ鿴ʱʹ�õ�  ���ݿ��б�����û���Ȩ�� ������
		  //isview �Ƿ�鿴ҳ��  Ϊ1�Ļ� �����checkbox
	function getDeps($key,$menu,$groupWebRanks="",$groupDepRanks="",$isView=false)
	{
				//dump($this->allDepNumb);
				//dump($fun->depName);
		  
		  
		  if($this->allDepNumb>0)
		  { 
				for($i2=0; $i2<$this->allDepNumb; $i2++)
				{
					
					$colspan="";
					if($isView)$colspan=" colspan='2'";//�����Ȩ�޲鿴�򽫴�������Ϊ2
					echo "<tr align=\"left\" bgcolor=\"#FFFFFF\" height=\"26\"  onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"> 
							   <td style='white-space:nowrap;padding-left:5px'  bgcolor=\"#FBFCE2\" $colspan>".$this->depName[$i2]."</td>";
							   
					if(!$isView)echo "<td align=\"center\" bgcolor=\"#FBFCE2\"><input name=\"dep".$i2.$key."[]\" type='checkbox' class='np' value=\"\"  onClick='row_Sel(\"".$i2.$key."\")'   ></td>\r\n";
					
					//���checkbox
					for($i3=0; $i3<=count($this->funFileName[$key])-1; $i3++)
					  {
						  //ҳ���ļ����� ���ڴ������ݿ� $funFileName[$i3]
						  //����ID,���ڴ������ݿ�$depId[$i2]
						  
						  
						  //CHECKBOX  ��ȫѡ��getElementsByName  ��dep[]����
						  //CHECKBOX  ��ȫѡ��getElementById  ��file[]����
						  // �ж� �Ƿ�ѡ�� ".CWebRank($row->dir)."
						  echo "<td nowrap  align=\"center\">";
						  
						  if($this->isDepDate($this->funFileName[$key][$i3]))  //����˹��ܰ����������ݲ����checkbox �������"-"
						  {
							  if(!$isView)echo "<input name=\"dep".$i2.$key."[]\" type='checkbox' class='np' id='file_".$i3.$key."_".$i2."' value=\"".$this->depId[$i2].",".$this->funFileName[$key][$i3]."\" ";
							  if($groupWebRanks!=""||$groupDepRanks!="")echo $this->CRank($this->depId[$i2],$this->funFileName[$key][$i3],$groupWebRanks,$groupDepRanks,$isView);
							  if(!$isView)echo ">";
						  }else
						  {
							  echo "-";
							  }
						  echo "</td>\r\n";
					  }
					echo "</tr>";
				  }
		  }

	}















































		//����Ƿ��Ѿ��д�Ȩ��
		//$depId  ����ID
		//$funFileName ҳ���ļ�����
		//$groupWebRanks,$groupDepRanks������б����ֵ
		/*
		˵��:
		web_role��������Ϊ:
		
		emp/emp.php|emp/emp_add.php|salary/salary.php|sys/sys_user_add.php|emp/dep.php|emp/dep_add.php|emp/worktype.php|emp/worktype_add.php|emp/dep_del.php|emp/dep_edit.php|emp/emp_do.php|emp/emp_edit.php|emp/worktype_del.php|emp/worktype_do.php|emp/worktype_edit.php|emp/emp_del.php|checkin/c_input.php|checkin/c_check.php|checkin/c_list.php|checkin/c_config.php|checkin/c_check_1.php|checkin/c_input_1.php|integral/integral.php|integral/integral_add.php|integral/integral_input.php|integral/integral_checkinConfig.php|integral/integral_guizhe.php|integral/integral_guizhe_add.php|integral/trundle.php|integral/integral_query.php|integral/integral_do.php|integral/integral_guizhe_edit.php|integral/integral_input_1.php|integral/integral_del.php|salary/salary_add.php|salary/salary_day.php|salary/salary_t.php|salary/salary_config.php|salary/salary_do.php|salary/salary_edit.php|salary/salary_del.php|sys/sys_info.php|sys/sys_stepselect.php|sys/log.php|sys/sys_function.php|sys/sys_cache_up.php|sys/sys_data.php|sys/sys_data_revert.php|sys/sys_group.php|sys/sys_group_add.php|sys/sys_user.php|sys/log_del.php|sys/sys_user_edit.php|sys/sys_data.done.php|sys/sys_group_edit.php|sys/sys_group_del.php|sys/sys_user_del.php
		
		
		
		
		
		
		dep_role��������Ϊ:
		
		1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28|26,28
		
		
		������|Ϊ�ָ���   web��dep�Ƕ�Ӧ�ĸ���
		
		���Ȩ��ʱ,��������ǰҳ������filename��web_role����|�ָ��������е�����key
		Ȼ���ȡ dep_role��|�ָ�������KEYΪfilenameKEY��ֵ,�����ֵ��","�ָ�Ϊ����,Ȼ�����depId�Ƿ��ڴ�������,������򷵻�checked
		*/

		function CRank($depId,$funFileName,$groupWebRanks,$groupDepRanks,$isView=false)
		{
			$return_str="";
			//dump($funFileName);
			//dump($groupWebRanks);
			$funFileNameKey = array_search($funFileName, $groupWebRanks);
				if($funFileNameKey!==false)     //���� === �� !== ���бȽ�ʱ�򲻽�������ת������Ϊ��ʱ���ͺ���ֵ��Ҫ�ȶ�(��Ϊkeyֵ�п�����0,�����!=�ȽϵĻ�0Ҳ��false)
				{
					if($depId==0)//�����������Ϊ0���ʾ ��������������  ֱ������ж�  
					{
							  $return_str=" checked";
							  if($isView)$return_str=" ��";	
					}else
					{
						  if(in_array($depId,explode(',',$groupDepRanks[$funFileNameKey])))
						  {
							  $return_str=" checked";
							  if($isView)$return_str=" ��";	
						  }
					}
				}

			return  $return_str;
		}











//��ȡ�û�ѡ�е� ����Ȩ�޺Ͳ���Ȩ�� �ַ��� ���ڱ��浽���ݿ�
    function getSaveValue($checkBoxArrary)
	{
			 //2�� ҳ���ļ�������ͬ������,��Ӧ�Ĳ���ID�ϲ�
			  $tmpArray = array();
			  foreach ($checkBoxArrary as $row) {
				  $key = $row['webRole'];
				  if (array_key_exists($key, $tmpArray)) {
					  $tmpArray[$key]['depRole'] = $tmpArray[$key]['depRole']  . ',' . $row['depRole'];
				  } else {
					  $tmpArray[$key] = $row;
				  }
			  }
			  
			  //dump($tmpArray);
	/*		  array(2) {
						["emp/emp.php"] => array(2) {
						  ["webRole"] => string(11) "emp/emp.php"
						  ["depRole"] => string(89) "1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51"
						}
						["emp/emp_add.php"] => array(2) {
						  ["webRole"] => string(15) "emp/emp_add.php"
						  ["depRole"] => string(89) "1,9,23,24,27,52,10,25,26,31,32,11,28,29,30,2,12,13,14,15,16,17,18,19,20,22,3,5,6,35,49,51"
						}
					  }
	*/
	
	
				$All_Role=""; 
				 $All_webRole ="";
				 $All_depRole ="";
			  //3���ϲ�������� ���Ϊ�ַ���
			  foreach ($tmpArray as $row) {
				 $All_Role.=$row["webRole"]."|".$row["depRole"]." ";
				 $All_webRole .=$row["webRole"]."|";
				 $All_depRole .=$row["depRole"]."|";
			  }
			  
	
	
	
	
			  $this->save_webRole = rtrim($All_webRole,"|");
			  $this->save_depRole = rtrim($All_depRole,"|");

		
		}


    
    //�Ƿ������������ ��������TRUE ������FALSE
	//	$dirFileName  ���ܵ��ļ����� ��Ҫ�ָ���/��ʹ��
	function isDepDate($dirFileName)
	{
		$dirFileName=ClearUrlAddParameter($dirFileName);   //�����ַ��Ĳ���
		$dirFileNames=explode('/',$dirFileName);
		//dump($dirFileName);
		//dump(is_array($dirFileNames));
		if(count($dirFileNames)>1)
		{
			$dirName=$dirFileNames[0];
			$fileName=ClearUrlAddParameter($dirFileNames[1]);   //������ļ����Ӻ���Ĳ���
		
		
			
					//���ı��ļ����ж�
				$row=$GLOBALS['baseConfigFunArray'][$dirName];
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //���ﲻ��!==��  ���!==�����ҳ��ַ�����0λ,���Ǿ��ǲ�Ҫ��0λ��
					 if ( strpos( $row[$funi] , $fileName ) >0 )   
					 {
						  $oneBaseConfigs= $row[$funi];	
						  if($oneBaseConfigs!="")
						  {
							  $oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
							  $isdep=$oneBaseConfigsArray[4];
							if($isdep==1)
							{
							  return true;
							}else{
								return false;
							}
						  }
					 }
				}
						
	
		}
		
		
	
	}
	
	
	
    //�ж��Ƿ������������,������EDIT��DELҳ��(ϵͳ�����������������,�б�ҳ�����ҳ�ֱ����Լ���ҳ��ʹ��SQL����б���ԵĲ�������.�༭ҳ��ɾ��ҳ��TestRole���ж�)
	// ��������TRUE ������FALSE
	//	$dirFileName  ���ܵ��ļ����� ��Ҫ�ָ���/��ʹ��
	function isDepRoleToTestRole($dirFileName)
	{
		$dirFileName=ClearUrlAddParameter($dirFileName);   //�����ַ��Ĳ���
		$dirFileNames=explode('/',$dirFileName);
		$iseditdel=strpos($dirFileName , "_edit" )!== false||strpos($dirFileName , "_del" )!== false;
		if(count($dirFileNames)>1&&$iseditdel)
		{
		//dump($dirFileName);
			$dirName=$dirFileNames[0];
			$fileName=ClearUrlAddParameter($dirFileNames[1]);   //������ļ����Ӻ���Ĳ���
		
		
		
					//���ı��ļ����ж�
				$row=$GLOBALS['baseConfigFunArray'][$dirName];
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //���ﲻ��!==��  ���!==�����ҳ��ַ�����0λ,���Ǿ��ǲ�Ҫ��0λ��
					 if ( strpos( $row[$funi] , $fileName ) >0 )   
					 {
					  $oneBaseConfigs= $row[$funi];	
						if($oneBaseConfigs!="")
						{
							$oneBaseConfigsArray=explode(',', $oneBaseConfigs);  
							$isdep=$oneBaseConfigsArray[4];    //�Ƿ������������
							
						  if($isdep==1)
						  {
							return true;
						  }else{
							return false;
						  }
						}
					 }
				}
		}
		
		
	
	}
	
	
	




	
//-------------------------------------����ֻ�ڱ�ҳ���ڵ���  �ⲿ������ --------------------------------------------------



//��ȡ�ӹ���,����������
//$dir ����������
//$diri �����ܼǼ���
	function getFileArray()
	{
		
		
		    //�Ȼ�ȡ���ݿ��еĹ���,Ȼ��������ݿ�Ĺ���,��ȡ�ı��ļ������չ����
			foreach ($this->fucArray as $parentIdKey=>$menu)
			{
				$this->childFileNumbArray[$parentIdKey]=count($menu)-1;    //�����ۼӸ����ܵ��ӹ�����
					//dump($parentIdKey);
				
				
				for($childi=1;$childi<count($menu);$childi++)
				{
					//�Ȼ�ȡ���ݿ��е� �������µ��ӹ��ܵ������Ϣ
					$childMenu=explode(',',$menu[$childi]);  
					$childId=$childMenu[0];
					$childUrlAdd=$childMenu[1];
					$childTitle=$childMenu[3];

                    //dump($childUrlAdd);
					$this->childFilePlusNumbArray[$childId]=1;
					
					//�ٻ�ȡ�ӹ��ܵ���չ����
					$isFilePlus=$this->getIsFilePlusArray($childUrlAdd,$parentIdKey,$childId); //�Ƿ������չ����
					
					
					$this->funFileName[$parentIdKey][] =$childUrlAdd;              //����ǵ����п�ʼ��CHECKBOXʹ�õĹ��ܵ� ʵ���ļ���ַ,���Ҫÿ������������    //1201�޸�Ϊ��KEY������  ���ڰ������ܷ�����ʾ
					
					
					
					  //���������չ����,�����ݿ�����Ĺ��ܼ������� ���ڵ����е� �������
					  //��������չ����,��ڶ����Ѿ�������������,�Ͳ��������
					  //????����������,����б�ҳ���ǹ���,��ô��ʾ141026
					  //����Ǵ����ݿ��ȡ��,���ȷ�����ı��ļ��е�_����Ķ�Ӧ��,�Ժ���
					
					if($isFilePlus)
					{
						$this->fileTitle[$parentIdKey][] ="����";//1201�޸�Ϊ��KEY������  ���ڰ������ܷ�����ʾ
					
						$this->getFilePlusArray($childUrlAdd,$parentIdKey,$childId);
					}
					
					
					//$filename=$filenameArray[1];
					//dump($filename);
					//dump($baseConfigFunArray[$dirname]);
					

					
					///dump(array_search("dep_add.php",$baseConfigFunArray[$dirname]));
					
				}
			}

				
	}
	
	
	
	//�ж��ӹ��� �Ƿ������չ���� 
	//$childUrlAdd//�ӹ��ܵ�ʵ�ʵ�ַ
	//$parentIdKey /�����ܵ����ݿ�ID
	//$childId   //�ӹ��ܵ����ݿ�ID
	//RETURN bool ���� ��ǰ���ݿ��е��ӹ��� �Ƿ������չ����
	function getIsFilePlusArray($childUrlAdd,$parentIdKey,$childId)
	
	{
		    //���빦�ܵ��ı��ļ�
			require_once(DEDEDATA."/sys_function_data.php");		
			global $baseConfigFunArray;
		    $retuBool=false;
			//�õ����а���filename���ַ���
			//dump($childUrlAdd);
			$filenameArray=explode('/',$childUrlAdd);
			$dirname=$filenameArray[0];//�����ܵ�Ŀ¼����
			//dump($filenameArray[1]);
            
			if(count($filenameArray)>1)
		   {

				  $filename=str_replace(".php","",ClearUrlAddParameter($filenameArray[1]))."_"; //��ȡ�������Ƶ�ǰ׺���� �� emp_,�������ļ����������� ��չ�й���
				  
			//dump($filename);
				  
				  //dump($baseConfigFunArray[$dirname]);
				  foreach( $baseConfigFunArray[$dirname] as $key_plus=>$s )
				  {
					 if ( strpos( $s , $filename ) >0 && $key_plus > 0)    //�������  emp_���������ӹ��� 
					 {
							$childMenu_plus=explode(',', $baseConfigFunArray[$dirname][$key_plus]);  
							$isjeep=$childMenu_plus[3];
							
							//ֻ����ת������ �г�
							//������ת�� ��ϵͳ���������
							if($isjeep==1)
							{
								return true;  //ֻҪ��һ������ �ʹ��������չ����  Ȼ������
							}
						   
					 }
				  }
		   }
			return false;
		
		
		
		
	}
	//��ȡ��չ���ܵ����� ����������
	//$childUrlAdd//�ӹ��ܵ�ʵ�ʵ�ַ
	//$parentIdKey /�����ܵ����ݿ�ID
	//$childId   //�ӹ��ܵ����ݿ�ID
	//����������
	function getFilePlusArray($childUrlAdd,$parentIdKey,$childId)
	
	{
		    //���빦�ܵ��ı��ļ�
			require_once(DEDEDATA."/sys_function_data.php");		
			global $baseConfigFunArray;
			$filenameParameter="";//�ĵ����ҳ���ַ��� CID����
			
			//�õ����а���filename���ַ���
			$filenameArray=explode('/',$childUrlAdd);
			$dirname=$filenameArray[0];//�����ܵ�Ŀ¼����
			$filename=str_replace(".php","",ClearUrlAddParameter($filenameArray[1]))."_"; //��ȡ�������Ƶ�ǰ׺���� �� emp_,�������ļ����������� ��չ�й���
			$filenameParameter=ReturnUrlAddParameter($filenameArray[1]); //��ȡ�ĵ����ҳ���ַ��� CID����
			//dump($childUrlAdd);
			
			
			//dump($baseConfigFunArray[$dirname]);
			foreach( $baseConfigFunArray[$dirname] as $key_plus=>$s )
			{
			   //if ( strpos( $s , $filename ) !== false )   //���ﲻ��!==��  ���!==�����ҳ��ַ�����0λ,���Ǿ��ǲ�Ҫ��0λ��
						
			   if ( strpos( $s , $filename ) >0 && $key_plus > 0 )     //�������  emp_���������ӹ��� 
			   {
					 //dump( $baseConfigFunArray[$dirname][$key_plus] );
					  $childMenu_plus=explode(',', $baseConfigFunArray[$dirname][$key_plus]);  
					  //$childId_plus=$childMenu_plus[0];
					  $childUrlAdd_plus=$dirname."/".$childMenu_plus[1];   //�ı��ļ��е����ݵ�ַֻ���ļ�������Ŀ¼���� ����Ҫ����Ŀ¼����,�����������ȡ
					  if($filenameParameter!="")$childUrlAdd_plus.=$filenameParameter;
					  
					  $childTitle_plus_array=explode('_',$childMenu_plus[2]);  
					  if(is_array($childTitle_plus_array)&&count($childTitle_plus_array)>1)$childTitle_plus=$childTitle_plus_array[1];     //150131�޸�BUGԭ��û�м��㳤��
					  $isjeep=$childMenu_plus[3];
					  
					  //ֻ����ת������ �г�
					  //������ת�� ��ϵͳ���������
					  if($isjeep==1)
					  {
						  $this->childFileNumbArray[$parentIdKey]++;    //�����ۼӸ����ܵ��ӹ�����  ��һ��
						  $this->childFilePlusNumbArray[$childId]++;   //�ӹ��ܵ���չ���ܼ���  �ڶ���
						  $this->allFileNumb++;  //�����е�����
						  //dump($childUrlAdd_plus);
						  $this->funFileName[$parentIdKey][] =$childUrlAdd_plus;   //1201�޸�Ϊ��KEY������  ���ڰ������ܷ�����ʾ
						  $this->fileTitle[$parentIdKey][] =$childTitle_plus;      //1201�޸�Ϊ��KEY������  ���ڰ������ܷ�����ʾ
						 // dump($childTitle_plus);
						  
					  }
					 
			   }
			}
	}
	

	 //��ȡ���Ÿ���,����������ĸ���
	function getDepNumb()
	{
			//1\��������ʾ ֱ�����б�����ʾ�Ĺ���
			//���ݸ��������Ʒ��� �ӷ���
			if(file_exists(DEDEPATH.'/emp'))
			{
				$query = " SELECT  count(*) as dd FROM `#@__emp_dep`  ORDER BY dep_id ASC  ";	    //echo $query."<br>";//exit;
				$row = $this->dsql->GetOne($query);
				$this->allDepNumb=$row['dd'];
			}else
			{
				$this->allDepNumb=0;
			}
	}


	 //��ȡ���ŵ�����
	function getAllDepArray()
	{
			if(file_exists(DEDEPATH.'/emp'))
			{
				  $query = " SELECT * FROM `#@__emp_dep`  WHERE dep_topid=0 ORDER BY dep_id ASC ";
				  $this->dsql->SetQuery($query);
				  $this->dsql->Execute();
			  
				  while($row=$this->dsql->GetObject())
				  {
					  $this->depName[] = $row->dep_name;
					  $this->depId[] = $row->dep_id;
					  $this->LogicGetDepArray($row->dep_id, '&nbsp;&nbsp;', $dsql);
				  }
			}
	}
	
	/*($selid ѡ�е�ID
	,$id,  ��ID
	$step, �ڼ���
	&$dsql, SQL
	*/
	function LogicGetDepArray($id,$step,&$dsql)
	{
		$this->dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$id."'  order by dep_id asc");
		$this->dsql->Execute($id);
		while($row=$this->dsql->GetObject($id))
		{
			$this->depName[] = $step.$row->dep_name;
			$this->depId[] = $row->dep_id;
			$this->LogicGetDepArray($row->dep_id,$step.'&nbsp;&nbsp;',$dsql);
			
		}
		
		
	}
//-------------------------------------����ֻ�ڱ�ҳ���ڵ���  �ⲿ������ --------------------------------------------------


}//End Class