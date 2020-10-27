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
class sys_function
{
    var $dsql;

    //php5���캯��
    function __construct()
    {
        $this->dsql = 0;
    }

    function sys_function()
    {
        $this->__construct();
    }

    //������
    function Close()
    {
    }



    //SYS_FUNCTION.PHP INDEX_MEUN.PHP  INDEX_BODY.PHP����ҳ�����ô���
	//	$hidden  false ������ع���    true ��������ع���
	//$shartcut   false ȫ�����       true ֻ������
	function getSysFunArray($hidden=false,$shartcut=false)
	{
          $this->dsql = $GLOBALS['dsql'];
		  $sys_function = array();
		  $wheresql="";
		  if($hidden)$wheresql=" and ishidden=0";
		  if($shartcut)$wheresql .=" and isshartcut=1";		  
		  $query = " SELECT * FROM `#@__sys_function`  where topid=0 $wheresql   ORDER BY 	disorder ASC";
		  $this->dsql->SetQuery($query);
		  $this->dsql->Execute();
		  while($row=$this->dsql->GetObject())
		  {
					$parentid=$row->id;
					$urladd=$row->urladd;
					$groups=$row->groups;
					$parenttitle=$row->title;
					$disorder=$row->disorder;
					$ishidden=$row->ishidden;
					$isshartcut=$row->isshartcut;
					$isputred=$row->isputred;
					$remark=$row->remark;
					$isbasefuc=$row->isbasefuc;
					
					
					//����˳������ݿ���ͬ
					$sys_function[$parentid][]="$parentid,$urladd,$groups,$parenttitle,$disorder,$ishidden,$isshartcut,$isputred,$remark,$isbasefuc";



                    //��ȡ�ӹ���
					$query2 = " SELECT * FROM `dede_sys_function` WHERE topid = '".$parentid."' $wheresql   ORDER BY convert(groups using gbk) ASC,disorder ASC";
					//dump($query2);
					//dump($parentid);
					$this->dsql->SetQuery($query2);
					$this->dsql->Execute($parentid+1);    //141206�޸�  ԭû��+1,����������������һ����˾������ʾ������
					while($row2=$this->dsql->GetObject($parentid+1))
					{
						
						$childid=$row2->id;
						$urladd=$row2->urladd;
						//dump($urladd);
						if(Test_webRole($urladd))
						{
							$groups=$row2->groups;
							$childtitle=$row2->title;
							$disorder=$row2->disorder;
							$ishidden=$row2->ishidden;
							$isshartcut=$row2->isshartcut;
							$isputred=$row2->isputred;
							$remark=$row2->remark;
							$isbasefuc=$row2->isbasefuc;
							$sys_function[$parentid][]="$childid,$urladd,$groups,$childtitle,$disorder,$ishidden,$isshartcut,$isputred,$remark,$isbasefuc";
						}
					}
		  }
		  
		  return $sys_function;
	}



	


	//"//�����ʽ:   �ļ������ƣ��ļ����ƣ��ļ�����˵�����⣬�Ƿ���ת���Ƿ��в�������\r\n");

    function getDirFileOption()
    {
			global $inDateUrlAddArray;  //ϵͳ���� ���ݱ������ù�

			$rtuStr="";
			$isRtuStrNotNull=false;

            //����Ѿ����������ݿ���Ĺ��ܵ�ַ ��������,���ļ��е��ж� 
			//������ݿ����Ѿ����˴˹���,�����г�
			$inDateArray=$this->getSysFunArray();
			foreach ($inDateArray as $key=>$menu)
			{
				 if(count($menu)>1) 
				 {
						for($inDatei=1;$inDatei<count($menu);$inDatei++)
						{
								$inDateMenu=explode(',',$menu[$inDatei]);  //��ȡ�ӹ�������
								$inDateUrlAddArray[]=$inDateMenu[1];
						}
			
				 }
			}

		
			
			//���ı��ļ����ж�
			foreach($GLOBALS['baseConfigFunArray'] as $key => $row)
			{
		
				//dump($key);
				for($funi=0;$funi<count($row);$funi++)
				{
    				  $fun_info=explode(',',$row[$funi]);  //��ȡ���ļ�������
					  $funUrladd=$fun_info[0]."/".$fun_info[1];
					  $funFile=$fun_info[1];
					  $funTitle=$fun_info[2];
					  $isjeep=$fun_info[3];
					  //$isPutTypeDate=$fun_info[5];//���ù�����Ŀ���������ļ����ƺ͵�ַ(������õ��Ǹ��ļ�����,Ȼ���������ļ�)
					  
				//dump($isPutTypeDate);
					  
					  //�鿴�ļ��� �Ƿ�ʵ�ʴ���,���Ҳ�����ת����
    				  if(file_exists($GLOBALS["cfg_basedir"]."/".$funUrladd)&&$isjeep==0)   
					  {
				//dump($fun_info[0]);
							if($funFile=="") //���ֻ��Ŀ¼,����ʵ�ʹ��ܵĵ�ַ,�������ɫ����,�û�����ʱ ��ʾ�û� ���������ѡ
							 {
								$rtuStr .= "<option value='0' style='background-color:#DFDFDB;color:#888888' >".$funTitle."</option>\r\n";
									
                                
								
							      //150118  �Զ������Ƿ������������,����з��� ������½�����  ԭʹ�õ�$fun_info����5 catalog.inc.once.toSysFunAdd.php ������û������
								  $dirName=$fun_info[0];//����ļ�������
								  $dh = dir(DEDEPATH."/".$dirName);  //����ɨ��Ŀ¼ �µ��ļ�,���Ż�ʹ��scandir���Ŀ¼�µ������ļ���Ϊ����,��PHP��һ���ǽ��õ�,��δʹ��
								  while(($file = $dh->read()) !== false)
								  {
									  //����ϵͳĿ¼
									  if(preg_match("#^_(.*)$#i",$file)) continue; #����FrontPage��չĿ¼��linux����Ŀ¼
									  if(preg_match("#^\.(.*)$#i",$file)) continue;
									   //���� XXX.do.php xxx.class.php��ҳ��
									   $doClassFiles = explode('.', $file);
									   if(count($doClassFiles)>2)continue;
									   //��ǰ�ļ��Ƿ���catalog.php���๦��
									   if($file=="catalog.php")
									   {
											  require_once("../".$dirName."/catalog.inc.class.php");
											  $classname=$dirName."CatalogInc";
											  $newClassName=$dirName."ClI";
											  $$newClassName = new $classname();
											  $rtuStr.=$$newClassName->GetOptionListToSysFunAdd();  
											  $isRtuStrNotNull=true;
											   break;
									   }
								  }
							}
							else {
								//����ļ��еĹ���,δ�����ݿ�����ӹ� ����ʾ
								//dump($funFile);
								//dump($inDateUrlAddArray);
								//dump(in_array($funUrladd,$inDateUrlAddArray));
								if(!in_array($funUrladd,$inDateUrlAddArray))
								{
									$rtuStr .= "<option value='".$funUrladd."' >&nbsp;&nbsp;".$funTitle."</option>\r\n";
									$isRtuStrNotNull=true;
								}
							}
					  }
				}
			}
            if($isRtuStrNotNull)
			{
				return $rtuStr;
			}else
			{
				return "";
			}
    }
	













}//End Class