<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 工种单元
 *
 * @version        $Id: depunit.class.php 1 15:21 2010年7月5日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * 工种单元,主要用户管理后台管理处
 *
 * @package          WorktypeUnit
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class WorktypeUnit
{
    var $dsql;
    var $artDir;
    var $baseDir;
    var $idCounter;
    var $idArrary;
    var $shortName;
    var $CatalogNums;

    //php5构造函数
    function __construct()
    {
        $this->idCounter = 0;
        //$this->artDir = $GLOBALS['cfg_install_path'].$GLOBALS['cfg_arcdir'];
        //$this->baseDir = $GLOBALS['cfg_basedir'];
        //$this->shortName = $GLOBALS['art_shortname'];
        $this->idArrary = '';
        $this->dsql = 0;
    }

    function WorktypeUnit()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }

    //显示当前分类的人数  
    function GetOnlyTotalEmp($tid)
    {
       $total=0;
 		$this->dsql = $GLOBALS['dsql'];
	    $this->dsql->SetQuery("SELECT emp_worktype,count(emp_worktype) as dd FROM `#@__emp` where emp_isdel=0 and  emp_worktype=".$tid."   group by emp_worktype");
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {
            $total = $row['dd'];
        }
	       
            return $total;
    }
















    /**
     *  读出所有分类,在类目管理页(list_type)中使用
     *
     * @access    public
     * @return    string
     */
    function ListAllWorktype()
    {
        $this->dsql = $GLOBALS['dsql'];
           //echo DEDEINC.$GLOBALS['dsql'];
        
    

        $this->dsql->SetQuery("SELECT * FROM `#@__emp_worktype` WHERE worktype_topid=0 order by worktype_id");
        $this->dsql->Execute(0);
        while($row = $this->dsql->GetObject(0))
        {
		   
            $lastid = GetCookie('lastCid');
              $worktype_name = $row->worktype_name;
              $worktype_id = $row->worktype_id;
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='2'>\r\n";
				
                echo "  <tr>\r\n";
                echo "  <td style='background-color:#FBFCE2;' width='2%' class='bline'>";
				
				
				//如果有子类 则输出可以点击的连接,
				$imgfile="explode";
				if( $lastid==$worktype_id || isset($GLOBALS['exallct']) )  $imgfile="contract";//dump("1");}
				  	  if($this->isSun($worktype_id)>0)
				  {
						  echo "<img style='cursor:pointer' id='img".$worktype_id."' onClick=\"LoadSuns('suns".$worktype_id."',$worktype_id);\" src='../images/$imgfile.gif' width='11' height='11'>";
						  
				  }
				  else{
							  echo "<img style='cursor:pointer' id='img".$worktype_id."'  src='../images/contract.gif' width='11' height='11'>";
				  
					  }
				
				echo "</td>\r\n";
                echo "  <td style='background-color:#FBFCE2;' class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'>".$worktype_name."";
					//echo "<font color=\"#999999\">(人数".$this->GetOnlyTotalEmp($worktype_id).") </font> ";
                echo "    </td><td align='right'>";
              if(Test_webRole("emp/worktype_add.php"))  echo "<a href='worktype_add.php?id={$worktype_id}'>添加子类</a>";
              if(Test_webRole("emp/worktype_edit.php"))  echo "|<a href='worktype_edit.php?id={$worktype_id}'>更改</a>";
              if(Test_webRole("emp/worktype_del.php"))  echo "|<a href='javascript:isdel(\"worktype_del.php?id=\",{$worktype_id});'>删除</a> ";
                echo "</td></tr></table></td></tr>\r\n";
            echo "  <tr><td colspan='2' id='suns".$worktype_id."'>";
            if( $lastid==$worktype_id || isset($GLOBALS['exallct']) )
            {
                echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunWorktype($worktype_id,"　");
                echo "    </table>\r\n";
            }
            echo "</td></tr>\r\n</table>\r\n";
        }
    }


    function isSun($id)
	{
						        $this->dsql2 = $GLOBALS['dsql'];

									//如果有子类 则输出可以点击的连接,
				 $this->dsql2->SetQuery("SELECT * FROM `#@__emp_worktype` WHERE worktype_topid='".$id."' order by worktype_id");
				  $this->dsql2->Execute($id);
				  if($this->dsql2->GetTotalRow($id)>0)
				  {
						  return 1;
						  
				  }
				  else{
						  return 0;
				  
					  }
		
		
		}



    /**
     *  获得子类目的递归调用
     *
     * @access    public
     * @param     int  $id  工种ID
     * @param     string  $step  层级标志
     * @return    void
     */
    function LogicListAllSunWorktype($id, $step)
    {
        $fid = $id;
        $this->dsql->SetQuery("SELECT * FROM `#@__emp_worktype` WHERE worktype_topid='".$id."' order by worktype_id");
        $this->dsql->Execute($fid);
        if($this->dsql->GetTotalRow($fid)>0)
        {
            while($row = $this->dsql->GetObject($fid))
            {
                $worktype_name = $row->worktype_name;
                $topid = $row->worktype_topid;
                $id = $row->worktype_id;
                if($step=="　")
                {
                    $stepdd = 2;
                }
                else
                {
                    $stepdd = 3;
                }

                    echo "<tr height='24' >\r\n";
                    echo "<td class='nbline'>";
                    echo "<table width='98%' border='0' cellspacing='0' cellpadding='0'>";
                    echo "<tr onMouseMove=\"javascript:this.bgColor='#FAFCE0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td width='50%'>";
                    echo "$step ";
					
						       
				  if($this->isSun($id)>0)
				  {
						  echo "<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/contract.gif' width='11' height='11'>";
						  
				  }
				  else{
							  echo "<img style='cursor:pointer' id='img".$id."'  src='/images/contract.gif' width='11' height='11'>";
				  
					  }

					//echo"<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/explode.gif' width='11' height='11'>";
					
					
					echo" ".$worktype_name."";
					echo "<font color=\"#999999\">(人数:".$this->GetOnlyTotalEmp($id).") </font> ";
                    echo "</td><td align='right'>";
                    echo "<a href='worktype_add.php?id={$id}'>添加子类</a>";
                    echo "|<a href='worktype_edit.php?id={$id}'>更改</a>";
                 echo "|<a href='javascript:isdel(\"worktype_del.php?id=\",{$id});'>删除</a> ";
                   echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunWorktype($id,$step."　");
                echo "</table></td></tr>\r\n";
            }
        }
    }

    /**
     *  返回与某个目相关的下级目录的类目ID列表(删除类目或文章时调用)
     *
     * @access    public
     * @param     int   $id  工种ID
     * @param     int   $channel  频道ID
     * @return    array
     */
    function GetSunWorktypes($id, $channel=0)
    {
        $this->dsql = $GLOBALS['dsql'];
        $this->idArray[$this->idCounter]=$id;
        $this->idCounter++;
        $fid = $id;
        $this->dsql->SetQuery("SELECT id FROM `#@__emp_worktype` WHERE topid=$id");
        $this->dsql->Execute("gs".$fid);

        //if($this->dsql->GetTotalRow("gs".$fid)!=0)
        //{
        while($row=$this->dsql->GetObject("gs".$fid))
        {
            $nid = $row->id;
            $this->GetSunWorktypes($nid,$channel);
        }
        //}
        return $this->idArray;
    }

    /**
     *  删除
     *
     * @access    public
     * @param     int   $id  工种ID
     * @return    string
     */
    function DelWorktype($id)
    {
         //dump($id);
  $query = "
        SELECT #@__emp.*
        FROM `#@__emp`
        WHERE #@__emp.emp_worktype='$id'
        ";
		        $this->dsql = $GLOBALS['dsql'];
//
//        $typeinfos = $this->dsql->GetOne($query);
//        if(!is_array($typeinfos))
//        {
//            return FALSE;
//        }//如果有员工属于此工种则不能删除 
//         dump($query);
      

            //删除数据库信息
			$sql="DELETE FROM `#@__emp_worktype` WHERE worktype_id='$id'";
			//dump($sql);
            $this->dsql->ExecuteNoneQuery($sql);

       
        return TRUE;
    }

}//End Class