<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * ���ֵ�Ԫ
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

    //php5���캯��
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

    //������
    function Close()
    {
    }

    //��ʾ��ǰ���������  
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
     *  �������з���,����Ŀ����ҳ(list_type)��ʹ��
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
				
				
				//��������� ��������Ե��������,
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
					//echo "<font color=\"#999999\">(����".$this->GetOnlyTotalEmp($worktype_id).") </font> ";
                echo "    </td><td align='right'>";
              if(Test_webRole("emp/worktype_add.php"))  echo "<a href='worktype_add.php?id={$worktype_id}'>�������</a>";
              if(Test_webRole("emp/worktype_edit.php"))  echo "|<a href='worktype_edit.php?id={$worktype_id}'>����</a>";
              if(Test_webRole("emp/worktype_del.php"))  echo "|<a href='javascript:isdel(\"worktype_del.php?id=\",{$worktype_id});'>ɾ��</a> ";
                echo "</td></tr></table></td></tr>\r\n";
            echo "  <tr><td colspan='2' id='suns".$worktype_id."'>";
            if( $lastid==$worktype_id || isset($GLOBALS['exallct']) )
            {
                echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunWorktype($worktype_id,"��");
                echo "    </table>\r\n";
            }
            echo "</td></tr>\r\n</table>\r\n";
        }
    }


    function isSun($id)
	{
						        $this->dsql2 = $GLOBALS['dsql'];

									//��������� ��������Ե��������,
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
     *  �������Ŀ�ĵݹ����
     *
     * @access    public
     * @param     int  $id  ����ID
     * @param     string  $step  �㼶��־
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
						  echo "<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/contract.gif' width='11' height='11'>";
						  
				  }
				  else{
							  echo "<img style='cursor:pointer' id='img".$id."'  src='/images/contract.gif' width='11' height='11'>";
				  
					  }

					//echo"<img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='/images/explode.gif' width='11' height='11'>";
					
					
					echo" ".$worktype_name."";
					echo "<font color=\"#999999\">(����:".$this->GetOnlyTotalEmp($id).") </font> ";
                    echo "</td><td align='right'>";
                    echo "<a href='worktype_add.php?id={$id}'>�������</a>";
                    echo "|<a href='worktype_edit.php?id={$id}'>����</a>";
                 echo "|<a href='javascript:isdel(\"worktype_del.php?id=\",{$id});'>ɾ��</a> ";
                   echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunWorktype($id,$step."��");
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
     *  ɾ��
     *
     * @access    public
     * @param     int   $id  ����ID
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
//        }//�����Ա�����ڴ˹�������ɾ�� 
//         dump($query);
      

            //ɾ�����ݿ���Ϣ
			$sql="DELETE FROM `#@__emp_worktype` WHERE worktype_id='$id'";
			//dump($sql);
            $this->dsql->ExecuteNoneQuery($sql);

       
        return TRUE;
    }

}//End Class