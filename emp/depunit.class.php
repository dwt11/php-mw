<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 部门管理
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
 * @package          DepUnit
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class DepUnit
{
    var $dsql;
    var $idCounter;
    var $idArrary;

    //php5构造函数
    function __construct()
    {
        $this->idCounter = 0;
        $this->idArrary = '';
        $this->dsql = 0;
    }

    function DepUnit()
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
	    $this->dsql->SetQuery("SELECT emp_dep,count(emp_dep) as dd FROM `#@__emp` where emp_isdel=0 and  emp_dep=".$tid."   group by emp_dep");
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {
            $total = $row['dd'];
        }
            return $total;
    }













    //显示当前分类(包含子分类)的人数  
    function GetChildTotalEmp($tid)
    {
		global $DepArray;
		$DepArray="";
 		$this->dsql = $GLOBALS['dsql'];
		$depids= $this->GetDepChildArray($tid);
		$sqlstr="SELECT count(*) as dd FROM `#@__emp` where emp_isdel=0 and   emp_dep in (".$depids.") ";
       // dump($sqlstr);
	    $this->dsql->SetQuery($sqlstr);
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {
            $total = $row['dd'];
        }
	        if($total == "")$total = "0";
            return $total;
    }




	//返回当前所选定的部门  的所有下级部门的子ID，列表供查询相关部门下包含的记录时使用
	function GetDepChildArray($selid=0)
	{
		global $DepArray, $dsql;
	
	
		//当前选中的部门
		if($selid > 0)
		{
			//$row = $dsql->GetOne("SELECT * FROM `#@__emp_dep` WHERE dep_id='$selid'");
			$DepArray .= $selid.",";
			$this->LogicGetDepArray($selid,$dsql);
		}
	
		//echo $OptionDepArrayList;
		return rtrim($DepArray, ",");
	}
	function LogicGetDepArray($selid,&$dsql)
	{
		global $DepArray;
		$dsql->SetQuery("Select * From `#@__emp_dep` where dep_topid='".$selid."'  order by dep_id asc");
		$dsql->Execute($selid);
		while($row=$dsql->GetObject($selid))
		{
			$DepArray .= $row->dep_id.",";
			$this->LogicGetDepArray($row->dep_id,$dsql);
		}
		
		
	}







    /**
     *  读出所有分类,在类目管理页(list_type)中使用
     *
     * @access    public
     * @param     int   $channel  频道ID
     * @param     int   $nowdir  当前操作ID
     * @return    string
     */
    function ListAllDep($nowdir=0)
    {
        $this->dsql = $GLOBALS['dsql'];
           //echo DEDEINC.$GLOBALS['dsql'];
        
    

        $this->dsql->SetQuery("SELECT * FROM `#@__emp_dep` WHERE dep_topid=0 order by dep_id");
        $this->dsql->Execute(0);
        while($row = $this->dsql->GetObject(0))
        {
		   
            $lastid = GetCookie('lastCid');
              $dep_name = $row->dep_name;
              $dep_id = $row->dep_id;
			//  dump($dep_name);
              $dep_id = $row->dep_id;
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='2'>\r\n";
				
                echo "  <tr>\r\n";
                echo "  <td style='background-color:#FBFCE2;' width='2%' class='bline'>";
				
				
				//如果有子类 则输出可以点击的连接,
				$imgfile="explode";
				if( $lastid==$dep_id || isset($GLOBALS['exallct']) )  $imgfile="contract";//dump("1");}
				if($this->isSun($dep_id))
				  {
						  echo "<img style='cursor:pointer' id='img".$dep_id."' onClick=\"LoadSuns('suns".$dep_id."',$dep_id);\" src='../images/$imgfile.gif' width='11' height='11'>";
						  
				  }
				  else{
							  echo "<img style='cursor:pointer' id='img".$dep_id."'  src='../images/contract.gif' width='11' height='11'>";
				  
				}
				
				echo "</td>\r\n";
                echo "  <td style='background-color:#FBFCE2;' class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><a href='dep.do.php?did=".$dep_id."&dopost=listEmp' >".$dep_name."</a>";
		echo "<font color=\"#999999\">(部门总人数:".$this->GetChildTotalEmp($dep_id).",不包含子部门：".$this->GetOnlyTotalEmp($dep_id).") </font> ";
                echo "    </td><td align='right'>";
               if(Test_webRole("emp/dep_add.php"))echo "<a href='dep_add.php?id={$dep_id}'>添加子类</a>";
               if(Test_webRole("emp/dep_edit.php"))  echo " <a href='dep_edit.php?id={$dep_id}'>更改</a>";
               if(Test_webRole("emp/dep_del.php"))  echo " <a href='javascript:isdel(\"dep_del.php?id=\",{$dep_id});'>删除</a> ";
                echo "</td></tr></table></td></tr>\r\n";
            echo "  <tr><td colspan='2' id='suns".$dep_id."'>";
            if( $lastid==$dep_id || isset($GLOBALS['exallct']) )
           {
                echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunDep($dep_id,"　");
                echo "    </table>\r\n";
           }
            echo "</td></tr>\r\n</table>\r\n";
        }
    }



//是否包含子分类
    function isSun($id)
	{
				 $this->dsql2 = $GLOBALS['dsql'];

				//如果有子类 则输出可以点击的连接,
				 $this->dsql2->SetQuery("SELECT * FROM `#@__emp_dep` WHERE dep_topid='".$id."' order by dep_id");
				  $this->dsql2->Execute($id);
				  if($this->dsql2->GetTotalRow($id)>0)
				  {
						  return true;
						  
				  }
				  else{
						  return false;
				  
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
    function LogicListAllSunDep($id, $step)
    {
        $fid = $id;

        $this->dsql->SetQuery("SELECT * FROM `#@__emp_dep` WHERE dep_topid='".$id."' order by dep_id");
        $this->dsql->Execute($fid);
        if($this->dsql->GetTotalRow($fid)>0)
        {
            while($row = $this->dsql->GetObject($fid))
            {
                $dep_name = $row->dep_name;
                $topid = $row->dep_topid;
                $id = $row->dep_id;
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
						  echo"<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/contract.gif' width='11' height='11'>";
						  
				  }
				  else{
							  echo "<img id='img".$id."'  src='/images/contract.gif' width='11' height='11'>";
				  
					  }

					//echo"<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/explode.gif' width='11' height='11'>";
					
					
					//echo" <a href='dep.do.php?did=".$id."&dopost=listEmp'>{$nss}".$dep_name."</a>";
					echo" <a href='dep.do.php?did=".$id."&dopost=listEmp'>".$dep_name."</a>";
					echo "<font color=\"#999999\">(部门总人数:".$this->GetChildTotalEmp($id).",不包含子部门：".$this->GetOnlyTotalEmp($id).") </font> ";
                    echo "</td><td align='right'>";
 
                if(Test_webRole("emp/dep_add.php"))echo "<a href='dep_add.php?id={$id}'>添加子类</a>";
               if(Test_webRole("emp/dep_edit.php"))  echo " <a href='dep_edit.php?id={$id}'>更改</a>";
               if(Test_webRole("emp/dep_del.php"))  echo " <a href='javascript:isdel(\"dep_del.php?id=\",{$id});'>删除</a> ";

                 
                    echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunDep($id,$step."　");
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
/*    function GetSunDeps($id, $channel=0)
    {
        $this->dsql = $GLOBALS['dsql'];
        $this->idArray[$this->idCounter]=$id;
        $this->idCounter++;
        $fid = $id;
        $this->dsql->SetQuery("SELECT id FROM `#@__emp_dep` WHERE topid=$id");
        $this->dsql->Execute("gs".$fid);

        //if($this->dsql->GetTotalRow("gs".$fid)!=0)
        //{
        while($row=$this->dsql->GetObject("gs".$fid))
        {
            $nid = $row->id;
            $this->GetSunDeps($nid,$channel);
        }
        //}
        return $this->idArray;
    }
*/
    /**
     *  删除
     *
     * @access    public
     * @param     int   $id  工种ID
     * @return    string
     */
    function DelDep($id)
    {
         //dump($id);
		$query = "SELECT #@__emp.* FROM `#@__emp`  WHERE #@__emp.emp_dep='$id'";
		$this->dsql = $GLOBALS['dsql'];
//
//        $typeinfos = $this->dsql->GetOne($query);
//        if(!is_array($typeinfos))
//        {
//            return FALSE;
//        }//如果有员工属于此工种则不能删除 
//         dump($query);
      

            //删除数据库信息
			$sql="DELETE FROM `#@__emp_dep` WHERE dep_id='$id'";
			//dump($sql);
            $this->dsql->ExecuteNoneQuery($sql);

       
        return TRUE;
    }

}//End Class