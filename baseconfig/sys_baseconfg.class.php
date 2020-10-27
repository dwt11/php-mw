<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 功能管理
 *
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * 系统功能管理   
 *
 */
class sys_baseconfg
{

    //php5构造函数
    function __construct()
    {
				require_once(DEDEDATA."/sys_function_data.php");

    }

    function sys_baseconfg()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }








//----------------------------------------sys_function_set2file.php中使用-----------begin--------------------------------
    /**
     *  列出所有父功能(文件夹)
     *sys/sys_function中使用
     * @access    public
     * @return    string
     */
    function listDir()
    {
            $inDateName=""; //已经保存到数据库中的文件夹名称
			global $baseConfigFunArray;
			foreach($baseConfigFunArray as $key => $row)
			{
		
				//dump($key);
				//dump($row);


                      //1、获取已经保存的父文件夹
    				  $fun_info=explode(',',$row[0]);  //获取父文件夹数组
					  $rowtitle=$fun_info[2];
					  $rowdir=$fun_info[0];
					  $inDateName.=$rowdir." ";   //已经保存到数据库中的文件夹名称
					  if(file_exists($GLOBALS["cfg_basedir"]."/".$rowdir))   //查看文件夹 是否实际存在
					  {
							 echo $this->dirHtmls($rowtitle, $rowdir); //输出父文件夹
							 echo $this->getChildFileName($rowdir,$row);
					  }
			}
           





					  
					  //获取子文件 
					// echo $this->getChildFileName($rowdir,$row->id);



            //2获取未保存到数据库中的目录 
			foreach($this->listNoDate("",trim($inDateName),1) as $dirName)
			{
				echo $this->dirHtmls("", $dirName);
				
				//获取子文件 
			   echo $this->getChildFileName($dirName,"");

			}

    }
	
    //列出不在文件中中保存的文件夹或目录 
	//$nowDir,      当前目录 
	//$inDateName   已经保存到数据库中的名称
	//$isdir  列出目录还是文件  1列目录 0列PHP文件-----这个好像没有用
	
	//return array[]
    function listNoDate($nowDir,$inDateName,$isDir)
    {
			  $rowdir=array();
             $noListDirFile=$inDateName; //不显示在列表里的系统文件夹   只搜索目录时用户
		    if($isDir==1)
			{
				$noListDirFile.=" css data images inc js plus templets uploads include web baseconfig inputdate"; 
			}
		
			//$noListDirFile.=" ".$inDateName;     //添加已经保存到数据库里的文件夹名称
			
			$dh = dir(DEDEPATH."/".$nowDir);
			$files = $dirs = array();//??此处两个变量 没找到使用的地方 待查150118
			//dump($nowDir,$inDateName,$isDir);
			while(($file = $dh->read()) !== false)
			{
				//屏蔽系统目录
				if(preg_match("#^_(.*)$#i",$file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
				if(preg_match("#^\.(.*)$#i",$file)) continue;

				//屏蔽已经保存到数据库的目录或文件夹
				//dump($file);
				$checkdir=false;
				$noListDirFiles=explode(' ',$noListDirFile);
				foreach($noListDirFiles as $dirFileName)
				{
						//dump($dirName."---".$file)
					if($dirFileName==$file){ $checkdir=TRUE;continue;}
		
				}
				if($checkdir)continue;
				


			
				 
				 //屏蔽 XXX.do.php xxx.class.php的页面
				 $doClassFiles = explode('.', $file);
//dump(count($doClassFiles)."-----".$file);
				 if(count($doClassFiles)>2)continue;

				//如果是检索目录 则判断是目录的输出
				 if($isDir==1&&is_dir(DEDEPATH."/$file")){$rowdir[]=$file;}
				
//				
				//如果是检索文件 则判断文件是否以PHP结尾
				 if($isDir==0&&preg_match("#\.(php)#i",$file))$rowdir[]=$file;
			}
			//dump($rowdir);
			return $rowdir;

    }


	//父功能 文件夹的格式化文本
	//return str

	function dirHtmls($rowtitle, $rowdir)
	{
			 global $i;
			 if(empty($i)) $i = 0;
			 $rstr= "\n<tr  bgcolor=\"#ffffff\"  height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">";
			 $rstr.= "    <td style='padding-left:5px'>\r\n
									  ".$i." 	 $rowdir-\r\n
							<input type='text' name='title[]' value='".$rowtitle."' class='abt' />\r\n
						   <input type='hidden'  name='dir[]' value='".$rowdir."'  />\r\n
						   <input type='hidden'  name='childfilename[]' value=''  />\r\n
					   
					   
					   </td>\r\n";
			 
					
			  $rstr.=  "
				   </tr>";

		  $i++;
		  return $rstr;					 
	}


	//子功能 文件的格式化文本
	//return str
	//
	function fileHtmls($dir,$childfilename,$childtitle,$childisdepdate,$childisjeep)
	{
						global $i;
						if(empty($i)) $i = 0;
						$rstr  = "\n<tr bgcolor='#FFFFFF' height='35' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n";

					    
					    $rstr .= "  <td>".$i." $childfilename </td>\r\n";
						$rstr .= " <td><input type='text'   name='title[]' value='".$childtitle."' class='abt' />
								<input type='hidden'   name='dir[]' value='".$dir."'  />
							   <input type='hidden'  name='childfilename[]' value='".$childfilename."'  />
							   
							  </td>\r\n";
						
						  //是否跳转状态显示
						  $isjeep=$childisjeep==1? ' checked=\"checked\"' : '';
						 $rstr .= " <td align='center'> <input type=\"checkbox\" name=\"isjeep[]\" value=$i ";
								$rstr .= "$isjeep";
						  $rstr .= "></td>\r\n";
						 
						 //是否包含部门相关数据
						  $isdepdate=$childisdepdate==1? ' checked=\"checked\"' : '';
						 $rstr .= " <td align='center'> <input type=\"checkbox\" name=\"isdepdate[]\" value=$i ";
								$rstr .= "$isdepdate";
						  $rstr .= "></td>\r\n";

						



						 $rstr .= "</tr>  ";





						 $i++;
		
		  return $rstr;					 
	}




	//从数据库获取子功能,
	//$rowdir 父功能名称
	//$row 从文件中读取出来的数组
	function getChildFileName($rowdir,$row)
	{
    				 
					 
					  if(is_array($row))sort($row);  //重新按文件字母顺序排序 
	
	//dump($row);
					  $inChildDateName="";
					  $retuStr="";
					   for($childi=1;$childi<count($row);$childi++)
					   {
						//   dump($row);
							  $fun_info=explode(',',$row[$childi]);  //获取子文件数组
							  $childfilename=$fun_info[1];
							  $childtitle=$fun_info[2];
							  $childisjeep=$fun_info[3];
							  $childisdepdate=$fun_info[4];
							  $inChildDateName.=$childfilename." ";   //已经保存到数据库中的子文件名称
							  if(file_exists($GLOBALS["cfg_basedir"]."/".$rowdir."/".$childfilename))   //查看文件 是否实际存在
							  {
									$retuStr.= $this->fileHtmls($rowdir,$childfilename,$childtitle,$childisdepdate,$childisjeep);
							  }
					   }


					//3获取未保存到数据库中的子文件 
					if($this->isFileExists($rowdir))   //如果目录实际存在才检测
					{
						foreach($this->listNoDate($rowdir,trim($inChildDateName),0) as $fileName)
						{
							
							$retuStr.=$this->fileHtmls($rowdir,$fileName,"","","");
			
						}
					}
					if($retuStr==""){
						$retuStr_temp="无子分类";
					}else
					{	
						$retuStr_temp="<table   width='90%'   border='0' cellspacing='1' cellpadding='0' align='center' style='background:#cfcfcf;'>";
						$retuStr_temp.="<tr align=\"center\" bgcolor=\"#FBFCE2\" height=\"28\"> 
														<td><strong>文件名称</strong></td>
														<td ><strong>功能说明</strong></td>
														<td><strong>是否扩展功能(列表页是主功能,不要勾选.在权限管理中系统获取主功能后,会自己获取他的扩展功能)</strong></td>
														<td><strong>是否包含部门数据</strong></td>
													  </tr>
													  ";
						$retuStr_temp.=$retuStr."</table>";
					}
					
				  // $line .="\n<tr bgcolor='#FFFFFF'><td  colspan='8'  style='display:none'  id='info$dirid' style='padding:10px'>". getChildFileName($rowdir,$dirid)."</td></tr>";
		
					$retuStr_temp= "\n<tr bgcolor='#FFFFFF'><td  colspan='8'   style='padding:10px'>". $retuStr_temp."</td></tr>";
			return $retuStr_temp;
					
	
	}

	//判断文件夹或文件是否存在,如果不存在则给出删除连接
	//$dirFileName  文件夹或文件的名称
	//$dateId   在数据库中保存的ID
	//return bool
	function isFileExists($dirFileName)
	{
		$dirFileName=DEDEPATH."/".$dirFileName;
		return file_exists($dirFileName);
	}


//----------------------------------------sys_function_set2file.php中使用---END----------------------------------------
    
	



	
	






	//根据文件名称 获取基本文件中单条信息
	//四个地方使用
	//---------------------------------------1\sys_group.class.php  是否isdep部门数据(原来调用这个,但速度太慢,141107又改回到ISDEP里)
	//---------------------获取多条符合条件的,这里不用了------------------2\sys_group.class.php  获取ISJEEP跳转的相关数据供使用
	//3config.php    获取跳转文件页面的页面名称
	//4sys_function.php  判断文件是否跳转页面
	
	
	//$key  搜索的键值
	
	//返回包含键值的单条文件信息
	function getOneBaseConfig($keyword)
	{
		
/*			dump($keyword);*/	
		global $baseConfigFunArray;
					//在文本文件里判断
			foreach($baseConfigFunArray as  $row)
			{
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //这里不用!==了  这个!==是怕找出字符串在0位,我们就是不要用0位的
					 if ( strpos( $row[$funi] , $keyword ) >0 )   
					 {
						  return $row[$funi];	
					 }
				}
			}
	//return ",,,,";
	}
}//End Class