<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 员工选择RADIO
 *
 * @version        $Id: empMapRadio.class.admin.php 1 15:21 2010年7月5日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * 工种单元,主要用户管理后台管理处
 *
 * @package          empMapRadio
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class empMapRadio
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

    function empMapRadio()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }

	//
    function GetTotalEmp($depId)
    {
       
      //$total="";
	   
	    $this->dsql->SetQuery("SELECT emp_id,emp_realname,emp_code FROM `#@__emp` where  emp_isdel=0 and emp_dep=".$depId."   order by convert(emp_realname using gbk) asc");
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {$id=$row['emp_id'];
           $total .= "\r\n<div style='width:100px; float:left'>
		   <label  style='white-space:nowrap;'><input type='radio' name='selempid' id='selempid{$id}' value='{$id}'  />".GetIntAddZero($row['emp_code'])."-".$row['emp_realname']."</label>
		   </div>\r\n";
           // $total = $row['dd'];
        }
	        //($total == "")$total = "0";
            return $total;
    }

    /**
     *  读出所有部门 并分别显示包含员工
     *
     * @access    public
     * @return    string
     */
    function empAllRadio()
    {
        $this->dsql = $GLOBALS['dsql'];
           //echo DEDEINC.$GLOBALS['dsql'];
		  global $DepArray;    //保存已经查询过的部门ID
        
		 global $funAllName;
	    // echo $funAllName;
		 $wheresql  .= getDepRole($funAllName,"dep_id");    //返回可以管理的部门ID的 查询语句
	   //由于权限查出来的部门有可能,是没有子部门的权限的,所以这里和下面的部门查询部分,要检查 查询出来的子ID是否在部门权限里
	   //返回的权限查询语句,里面包含所有的可以查询的ID,所以在获取子分类时 要检测是否已经查询过此ID
		global $DepRole;
		$DepRole=getDepRole($funAllName);  //获得具有权限的ID,如果没有权限则跳过
		if($wheresql==""){$wheresql=" and dep_topid=0";}  

		$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
        //dump($query);
        $this->dsql->SetQuery($query);
        $this->dsql->Execute(0);
        while($row = $this->dsql->GetObject(0))
        {
			  //检查已经查询过的部门ID,如果已经查询过,则跳过		
			  $DepArrays = explode(',', rtrim($DepArray,","));
			  if(in_array($row->dep_id,$DepArrays ))
			  {
				  //dump($row->dep_id);
				  continue;
			  }
		   
              $dep_name = $row->dep_name;
              $dep_id = $row->dep_id;
            echo "<table  width='630px'  border='0' cellspacing='0' cellpadding='2'>\r\n";
				
                echo "  <tr>\r\n";
                echo "  <td style='background-color:#FBFCE2;' class='bline'><table width='630px'  border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'>{$nss}<strong>".$dep_name."</strong>";
				echo"<br>".$this->GetTotalEmp($dep_id)."  ";
                echo "    </td></tr></table></td></tr>\r\n";
            echo "  <tr><td >";
                echo "    <table  width='630px'  border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunDep($dep_id,"　");
                echo "    </table>\r\n";
            echo "</td></tr>\r\n</table>\r\n";
					$DepArray .= $row->dep_id.",";
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
		global $DepArray;    //保存已经查询过的部门ID
		global $DepRole;    //保存已经查询过的部门ID
        $fid = $id;
        $this->dsql->SetQuery("SELECT * FROM `#@__emp_dep` WHERE dep_topid='".$id."' order by dep_id");
        $this->dsql->Execute($fid);
        if($this->dsql->GetTotalRow($fid)>0)
        {
            while($row = $this->dsql->GetObject($fid))
            {
				if($DepRole!="")
				{
					$DepRoleArrays = explode(',', $DepRole);
					if(!in_array($row->dep_id,$DepRoleArrays ))
					{
						//dump($row->dep_id);
						continue;
					}
				}
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
                    echo "<td class='nbline'  width='630px' >";
                    echo "<table  width='630px'  border='0' cellspacing='0' cellpadding='0'>";
                    echo "<tr onMouseMove=\"javascript:this.bgColor='#FAFCE0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td>";
                    echo "$step ";
					
						       
				

					//echo"<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/explode.gif' width='11' height='11'>";
					
					
					echo" {$nss}<strong>".$dep_name."</strong>";
				echo"<br>$step".$this->GetTotalEmp($id)."  ";
                    echo "</td><td align='right'>";
                    echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table  width='630px'  border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunDep($id,$step."　");
                echo "</table></td></tr>\r\n";
				$DepArray .= $id.",";
            }
        }
    }


}//End Class