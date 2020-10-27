<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * ���Ź���
 *
 * @version        $Id: depunit.class.php 1 15:21 2010��7��5��Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * ���ֵ�Ԫ,��Ҫ�û������̨����
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

    //php5���캯��
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

    //������
    function Close()
    {
    }

    //��ʾ��ǰ���������  
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













    //��ʾ��ǰ����(�����ӷ���)������  
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




	//���ص�ǰ��ѡ���Ĳ���  �������¼����ŵ���ID���б���ѯ��ز����°����ļ�¼ʱʹ��
	function GetDepChildArray($selid=0)
	{
		global $DepArray, $dsql;
	
	
		//��ǰѡ�еĲ���
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
     *  �������з���,����Ŀ����ҳ(list_type)��ʹ��
     *
     * @access    public
     * @param     int   $channel  Ƶ��ID
     * @param     int   $nowdir  ��ǰ����ID
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
				
				
				//��������� ��������Ե��������,
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
		echo "<font color=\"#999999\">(����������:".$this->GetChildTotalEmp($dep_id).",�������Ӳ��ţ�".$this->GetOnlyTotalEmp($dep_id).") </font> ";
                echo "    </td><td align='right'>";
               if(Test_webRole("emp/dep_add.php"))echo "<a href='dep_add.php?id={$dep_id}'>�������</a>";
               if(Test_webRole("emp/dep_edit.php"))  echo " <a href='dep_edit.php?id={$dep_id}'>����</a>";
               if(Test_webRole("emp/dep_del.php"))  echo " <a href='javascript:isdel(\"dep_del.php?id=\",{$dep_id});'>ɾ��</a> ";
                echo "</td></tr></table></td></tr>\r\n";
            echo "  <tr><td colspan='2' id='suns".$dep_id."'>";
            if( $lastid==$dep_id || isset($GLOBALS['exallct']) )
           {
                echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunDep($dep_id,"��");
                echo "    </table>\r\n";
           }
            echo "</td></tr>\r\n</table>\r\n";
        }
    }



//�Ƿ�����ӷ���
    function isSun($id)
	{
				 $this->dsql2 = $GLOBALS['dsql'];

				//��������� ��������Ե��������,
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
     *  �������Ŀ�ĵݹ����
     *
     * @access    public
     * @param     int  $id  ����ID
     * @param     string  $step  �㼶��־
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
                if($step=="��")
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
					echo "<font color=\"#999999\">(����������:".$this->GetChildTotalEmp($id).",�������Ӳ��ţ�".$this->GetOnlyTotalEmp($id).") </font> ";
                    echo "</td><td align='right'>";
 
                if(Test_webRole("emp/dep_add.php"))echo "<a href='dep_add.php?id={$id}'>�������</a>";
               if(Test_webRole("emp/dep_edit.php"))  echo " <a href='dep_edit.php?id={$id}'>����</a>";
               if(Test_webRole("emp/dep_del.php"))  echo " <a href='javascript:isdel(\"dep_del.php?id=\",{$id});'>ɾ��</a> ";

                 
                    echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunDep($id,$step."��");
                echo "</table></td></tr>\r\n";
            }
        }
    }

    /**
     *  ������ĳ��Ŀ��ص��¼�Ŀ¼����ĿID�б�(ɾ����Ŀ������ʱ����)
     *
     * @access    public
     * @param     int   $id  ����ID
     * @param     int   $channel  Ƶ��ID
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
     *  ɾ��
     *
     * @access    public
     * @param     int   $id  ����ID
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
//        }//�����Ա�����ڴ˹�������ɾ�� 
//         dump($query);
      

            //ɾ�����ݿ���Ϣ
			$sql="DELETE FROM `#@__emp_dep` WHERE dep_id='$id'";
			//dump($sql);
            $this->dsql->ExecuteNoneQuery($sql);

       
        return TRUE;
    }

}//End Class