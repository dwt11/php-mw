<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * ���ܹ���
 *
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * ϵͳ���ܹ���   
 *
 */
class sys_baseconfg
{

    //php5���캯��
    function __construct()
    {
				require_once(DEDEDATA."/sys_function_data.php");

    }

    function sys_baseconfg()
    {
        $this->__construct();
    }

    //������
    function Close()
    {
    }








//----------------------------------------sys_function_set2file.php��ʹ��-----------begin--------------------------------
    /**
     *  �г����и�����(�ļ���)
     *sys/sys_function��ʹ��
     * @access    public
     * @return    string
     */
    function listDir()
    {
            $inDateName=""; //�Ѿ����浽���ݿ��е��ļ�������
			global $baseConfigFunArray;
			foreach($baseConfigFunArray as $key => $row)
			{
		
				//dump($key);
				//dump($row);


                      //1����ȡ�Ѿ�����ĸ��ļ���
    				  $fun_info=explode(',',$row[0]);  //��ȡ���ļ�������
					  $rowtitle=$fun_info[2];
					  $rowdir=$fun_info[0];
					  $inDateName.=$rowdir." ";   //�Ѿ����浽���ݿ��е��ļ�������
					  if(file_exists($GLOBALS["cfg_basedir"]."/".$rowdir))   //�鿴�ļ��� �Ƿ�ʵ�ʴ���
					  {
							 echo $this->dirHtmls($rowtitle, $rowdir); //������ļ���
							 echo $this->getChildFileName($rowdir,$row);
					  }
			}
           





					  
					  //��ȡ���ļ� 
					// echo $this->getChildFileName($rowdir,$row->id);



            //2��ȡδ���浽���ݿ��е�Ŀ¼ 
			foreach($this->listNoDate("",trim($inDateName),1) as $dirName)
			{
				echo $this->dirHtmls("", $dirName);
				
				//��ȡ���ļ� 
			   echo $this->getChildFileName($dirName,"");

			}

    }
	
    //�г������ļ����б�����ļ��л�Ŀ¼ 
	//$nowDir,      ��ǰĿ¼ 
	//$inDateName   �Ѿ����浽���ݿ��е�����
	//$isdir  �г�Ŀ¼�����ļ�  1��Ŀ¼ 0��PHP�ļ�-----�������û����
	
	//return array[]
    function listNoDate($nowDir,$inDateName,$isDir)
    {
			  $rowdir=array();
             $noListDirFile=$inDateName; //����ʾ���б����ϵͳ�ļ���   ֻ����Ŀ¼ʱ�û�
		    if($isDir==1)
			{
				$noListDirFile.=" css data images inc js plus templets uploads include web baseconfig inputdate"; 
			}
		
			//$noListDirFile.=" ".$inDateName;     //����Ѿ����浽���ݿ�����ļ�������
			
			$dh = dir(DEDEPATH."/".$nowDir);
			$files = $dirs = array();//??�˴��������� û�ҵ�ʹ�õĵط� ����150118
			//dump($nowDir,$inDateName,$isDir);
			while(($file = $dh->read()) !== false)
			{
				//����ϵͳĿ¼
				if(preg_match("#^_(.*)$#i",$file)) continue; #����FrontPage��չĿ¼��linux����Ŀ¼
				if(preg_match("#^\.(.*)$#i",$file)) continue;

				//�����Ѿ����浽���ݿ��Ŀ¼���ļ���
				//dump($file);
				$checkdir=false;
				$noListDirFiles=explode(' ',$noListDirFile);
				foreach($noListDirFiles as $dirFileName)
				{
						//dump($dirName."---".$file)
					if($dirFileName==$file){ $checkdir=TRUE;continue;}
		
				}
				if($checkdir)continue;
				


			
				 
				 //���� XXX.do.php xxx.class.php��ҳ��
				 $doClassFiles = explode('.', $file);
//dump(count($doClassFiles)."-----".$file);
				 if(count($doClassFiles)>2)continue;

				//����Ǽ���Ŀ¼ ���ж���Ŀ¼�����
				 if($isDir==1&&is_dir(DEDEPATH."/$file")){$rowdir[]=$file;}
				
//				
				//����Ǽ����ļ� ���ж��ļ��Ƿ���PHP��β
				 if($isDir==0&&preg_match("#\.(php)#i",$file))$rowdir[]=$file;
			}
			//dump($rowdir);
			return $rowdir;

    }


	//������ �ļ��еĸ�ʽ���ı�
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


	//�ӹ��� �ļ��ĸ�ʽ���ı�
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
						
						  //�Ƿ���ת״̬��ʾ
						  $isjeep=$childisjeep==1? ' checked=\"checked\"' : '';
						 $rstr .= " <td align='center'> <input type=\"checkbox\" name=\"isjeep[]\" value=$i ";
								$rstr .= "$isjeep";
						  $rstr .= "></td>\r\n";
						 
						 //�Ƿ���������������
						  $isdepdate=$childisdepdate==1? ' checked=\"checked\"' : '';
						 $rstr .= " <td align='center'> <input type=\"checkbox\" name=\"isdepdate[]\" value=$i ";
								$rstr .= "$isdepdate";
						  $rstr .= "></td>\r\n";

						



						 $rstr .= "</tr>  ";





						 $i++;
		
		  return $rstr;					 
	}




	//�����ݿ��ȡ�ӹ���,
	//$rowdir ����������
	//$row ���ļ��ж�ȡ����������
	function getChildFileName($rowdir,$row)
	{
    				 
					 
					  if(is_array($row))sort($row);  //���°��ļ���ĸ˳������ 
	
	//dump($row);
					  $inChildDateName="";
					  $retuStr="";
					   for($childi=1;$childi<count($row);$childi++)
					   {
						//   dump($row);
							  $fun_info=explode(',',$row[$childi]);  //��ȡ���ļ�����
							  $childfilename=$fun_info[1];
							  $childtitle=$fun_info[2];
							  $childisjeep=$fun_info[3];
							  $childisdepdate=$fun_info[4];
							  $inChildDateName.=$childfilename." ";   //�Ѿ����浽���ݿ��е����ļ�����
							  if(file_exists($GLOBALS["cfg_basedir"]."/".$rowdir."/".$childfilename))   //�鿴�ļ� �Ƿ�ʵ�ʴ���
							  {
									$retuStr.= $this->fileHtmls($rowdir,$childfilename,$childtitle,$childisdepdate,$childisjeep);
							  }
					   }


					//3��ȡδ���浽���ݿ��е����ļ� 
					if($this->isFileExists($rowdir))   //���Ŀ¼ʵ�ʴ��ڲż��
					{
						foreach($this->listNoDate($rowdir,trim($inChildDateName),0) as $fileName)
						{
							
							$retuStr.=$this->fileHtmls($rowdir,$fileName,"","","");
			
						}
					}
					if($retuStr==""){
						$retuStr_temp="���ӷ���";
					}else
					{	
						$retuStr_temp="<table   width='90%'   border='0' cellspacing='1' cellpadding='0' align='center' style='background:#cfcfcf;'>";
						$retuStr_temp.="<tr align=\"center\" bgcolor=\"#FBFCE2\" height=\"28\"> 
														<td><strong>�ļ�����</strong></td>
														<td ><strong>����˵��</strong></td>
														<td><strong>�Ƿ���չ����(�б�ҳ��������,��Ҫ��ѡ.��Ȩ�޹�����ϵͳ��ȡ�����ܺ�,���Լ���ȡ������չ����)</strong></td>
														<td><strong>�Ƿ������������</strong></td>
													  </tr>
													  ";
						$retuStr_temp.=$retuStr."</table>";
					}
					
				  // $line .="\n<tr bgcolor='#FFFFFF'><td  colspan='8'  style='display:none'  id='info$dirid' style='padding:10px'>". getChildFileName($rowdir,$dirid)."</td></tr>";
		
					$retuStr_temp= "\n<tr bgcolor='#FFFFFF'><td  colspan='8'   style='padding:10px'>". $retuStr_temp."</td></tr>";
			return $retuStr_temp;
					
	
	}

	//�ж��ļ��л��ļ��Ƿ����,��������������ɾ������
	//$dirFileName  �ļ��л��ļ�������
	//$dateId   �����ݿ��б����ID
	//return bool
	function isFileExists($dirFileName)
	{
		$dirFileName=DEDEPATH."/".$dirFileName;
		return file_exists($dirFileName);
	}


//----------------------------------------sys_function_set2file.php��ʹ��---END----------------------------------------
    
	



	
	






	//�����ļ����� ��ȡ�����ļ��е�����Ϣ
	//�ĸ��ط�ʹ��
	//---------------------------------------1\sys_group.class.php  �Ƿ�isdep��������(ԭ���������,���ٶ�̫��,141107�ָĻص�ISDEP��)
	//---------------------��ȡ��������������,���ﲻ����------------------2\sys_group.class.php  ��ȡISJEEP��ת��������ݹ�ʹ��
	//3config.php    ��ȡ��ת�ļ�ҳ���ҳ������
	//4sys_function.php  �ж��ļ��Ƿ���תҳ��
	
	
	//$key  �����ļ�ֵ
	
	//���ذ�����ֵ�ĵ����ļ���Ϣ
	function getOneBaseConfig($keyword)
	{
		
/*			dump($keyword);*/	
		global $baseConfigFunArray;
					//���ı��ļ����ж�
			foreach($baseConfigFunArray as  $row)
			{
				for($funi=0;$funi<count($row);$funi++)
				{
					 //if ( strpos( $s , $key ) !== false )   //���ﲻ��!==��  ���!==�����ҳ��ַ�����0λ,���Ǿ��ǲ�Ҫ��0λ��
					 if ( strpos( $row[$funi] , $keyword ) >0 )   
					 {
						  return $row[$funi];	
					 }
				}
			}
	//return ",,,,";
	}
}//End Class