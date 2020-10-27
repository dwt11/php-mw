<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 功能管理
 *
 * @version        $Id: depunit.class.php 1 15:21 2010年7月5日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * 系统功能管理   
 *
 * @package          DepUnit
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class sys_function
{
    var $dsql;

    //php5构造函数
    function __construct()
    {
        $this->dsql = 0;
    }

    function sys_function()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }



    //SYS_FUNCTION.PHP INDEX_MEUN.PHP  INDEX_BODY.PHP三个页面引用此类
	//	$hidden  false 输出隐藏功能    true 不输出隐藏功能
	//$shartcut   false 全部输出       true 只输出快捷
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
					
					
					//数组顺序和数据库相同
					$sys_function[$parentid][]="$parentid,$urladd,$groups,$parenttitle,$disorder,$ishidden,$isshartcut,$isputred,$remark,$isbasefuc";



                    //获取子功能
					$query2 = " SELECT * FROM `dede_sys_function` WHERE topid = '".$parentid."' $wheresql   ORDER BY convert(groups using gbk) ASC,disorder ASC";
					//dump($query2);
					//dump($parentid);
					$this->dsql->SetQuery($query2);
					$this->dsql->Execute($parentid+1);    //141206修改  原没有+1,导致行政管理的最后一个公司来文显示不出来
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



	


	//"//数组格式:   文件夹名称，文件名称，文件功能说明标题，是否跳转，是否含有部门数据\r\n");

    function getDirFileOption()
    {
			global $inDateUrlAddArray;  //系统功能 数据表中引用过

			$rtuStr="";
			$isRtuStrNotNull=false;

            //获得已经保存在数据库里的功能地址 存入数组,与文件中的判断 
			//如果数据库中已经有了此功能,则不再列出
			$inDateArray=$this->getSysFunArray();
			foreach ($inDateArray as $key=>$menu)
			{
				 if(count($menu)>1) 
				 {
						for($inDatei=1;$inDatei<count($menu);$inDatei++)
						{
								$inDateMenu=explode(',',$menu[$inDatei]);  //获取子功能数组
								$inDateUrlAddArray[]=$inDateMenu[1];
						}
			
				 }
			}

		
			
			//在文本文件里判断
			foreach($GLOBALS['baseConfigFunArray'] as $key => $row)
			{
		
				//dump($key);
				for($funi=0;$funi<count($row);$funi++)
				{
    				  $fun_info=explode(',',$row[$funi]);  //获取父文件夹数组
					  $funUrladd=$fun_info[0]."/".$fun_info[1];
					  $funFile=$fun_info[1];
					  $funTitle=$fun_info[2];
					  $isjeep=$fun_info[3];
					  //$isPutTypeDate=$fun_info[5];//调用功能栏目分类引用文件名称和地址(这里调用的是个文件名称,然后此入这个文件)
					  
				//dump($isPutTypeDate);
					  
					  //查看文件夹 是否实际存在,并且不是跳转数据
    				  if(file_exists($GLOBALS["cfg_basedir"]."/".$funUrladd)&&$isjeep==0)   
					  {
				//dump($fun_info[0]);
							if($funFile=="") //如果只是目录,不是实际功能的地址,则输出灰色连接,用户保存时 提示用户 这个不可以选
							 {
								$rtuStr .= "<option value='0' style='background-color:#DFDFDB;color:#888888' >".$funTitle."</option>\r\n";
									
                                
								
							      //150118  自动搜索是否包含分类连接,如果有分类 则输出下接连接  原使用的$fun_info参数5 catalog.inc.once.toSysFunAdd.php 这样的没有用了
								  $dirName=$fun_info[0];//获得文件夹名称
								  $dh = dir(DEDEPATH."/".$dirName);  //引段扫描目录 下的文件,可优化使用scandir获得目录下的所有文件存为数组,但PHP中一般是禁用的,故未使用
								  while(($file = $dh->read()) !== false)
								  {
									  //屏蔽系统目录
									  if(preg_match("#^_(.*)$#i",$file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
									  if(preg_match("#^\.(.*)$#i",$file)) continue;
									   //屏蔽 XXX.do.php xxx.class.php的页面
									   $doClassFiles = explode('.', $file);
									   if(count($doClassFiles)>2)continue;
									   //当前文件是否有catalog.php分类功能
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
								//如果文件中的功能,未在数据库中添加过 则显示
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