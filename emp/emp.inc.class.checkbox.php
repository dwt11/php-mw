<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * Ա��ѡ��CHECKBOX
 *
 * @version        $Id: empMapCheckbox.class.admin.php 1 15:21 2010��7��5��Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 

/**
 * ���ֵ�Ԫ,��Ҫ�û������̨����
 *
 * @package          empMapCheckbox
 * @subpackage       DedeCMS.Libraries
 * @link             http://www.dedecms.com
 */
class empMapCheckbox
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

    function empMapCheckbox()
    {
        $this->__construct();
    }

    //������
    function Close()
    {
    }

	//��ȡ���ŵ�Ա��CHECKBOX
    function GetEmp($depId)
    {
       
      $total="";//150130ԭ��ע��
	   
	    $this->dsql->SetQuery("SELECT emp_id,emp_realname,emp_code FROM `#@__emp` where  emp_isdel=0 and emp_dep=".$depId."   order by convert(emp_realname using gbk) asc");
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {$id=$row['emp_id'];
           $total .= "\r\n<div style='width:100px; float:left'>
		   <label  style='white-space:nowrap;'>
		   <input type='checkbox' name='dep{$depId}' id='selempid' value='{$id}'  />".GetIntAddZero($row['emp_code'])."-".$row['emp_realname']."</label>
		   </div>\r\n";
           // $total = $row['dd'];
        }
	        //($total == "")$total = "0";
            return $total;
    }

	//��ȡ���ŵ�Ա������ �����ж� �Ƿ������ѡ��
    function GetEmpNumb($depId)
    {
       
      $total=0; 
 	    $row =$this->dsql->GetOne("SELECT count(*) as numb FROM `#@__emp` where  emp_isdel=0 and emp_dep=".$depId."   order by convert(emp_realname using gbk) asc");
		if(!is_array($row))
		{
		  $total=0;
		}
		else
		{
		
			$total=$row['numb'];
		
		
		}
	        //($total == "")$total = "0";
            return $total;
    }

    /**
     *  �������в��� ���ֱ���ʾ����Ա��
     *
     * @access    public
     * @return    string
     */
    function empAllCheckbox()
    {
        $this->dsql = $GLOBALS['dsql'];
           //echo DEDEINC.$GLOBALS['dsql'];
		  global $DepArray;    //�����Ѿ���ѯ���Ĳ���ID
        
		 global $funAllName;
	    $wheresql="";//150130
		// echo $funAllName;
		 $wheresql  .= getDepRole($funAllName,"dep_id");    //���ؿ��Թ���Ĳ���ID�� ��ѯ���
	   //����Ȩ�޲�����Ĳ����п���,��û���Ӳ��ŵ�Ȩ�޵�,�������������Ĳ��Ų�ѯ����,Ҫ��� ��ѯ��������ID�Ƿ��ڲ���Ȩ����
	   //���ص�Ȩ�޲�ѯ���,����������еĿ��Բ�ѯ��ID,�����ڻ�ȡ�ӷ���ʱ Ҫ����Ƿ��Ѿ���ѯ����ID
		global $DepRole;
		$DepRole=getDepRole($funAllName);  //��þ���Ȩ�޵�ID,���û��Ȩ��������
		if($wheresql==""){$wheresql=" and dep_topid=0";}  

		$query = " SELECT * FROM `#@__emp_dep`  WHERE 1=1 $wheresql ORDER BY dep_id ASC ";
        //dump($query);
        $this->dsql->SetQuery($query);
        $this->dsql->Execute(0);
        while($row = $this->dsql->GetObject(0))
        {
			  //����Ѿ���ѯ���Ĳ���ID,����Ѿ���ѯ��,������		
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
			echo "  <td style='background-color:#FBFCE2;' class='bline'><table width='630px'  border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><strong>".$dep_name."</strong> &nbsp;
		 
";
			echo"<br>".$this->GetEmp($dep_id)."  ";
			echo "    </td></tr></table></td></tr>\r\n";
            echo "  <tr><td>";
			echo "    <table  width='630px'  border='0' cellspacing='0' cellpadding='0'>\r\n";
			$this->LogicListAllSunDep($dep_id,"��");
			echo "    </table>\r\n";
            echo "</td></tr>\r\n</table>\r\n";
					$DepArray .= $row->dep_id.",";

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
		global $DepArray;    //�����Ѿ���ѯ���Ĳ���ID
		global $DepRole;    //�����Ѿ���ѯ���Ĳ���ID
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
                if($step=="��")
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
					
					
					echo" <strong>".$dep_name." </strong>";
					if($this->GetEmpNumb($id)>1)echo" <a href=\"javascript:selAllMore('dep{$id}')\" id=\"dep{$id}\" class=\"coolbg np\">ȫѡ</a>";
				echo"<br>$step".$this->GetEmp($id)."  ";
                    echo "</td><td align='right'>";
                    echo "</td></tr></table></td></tr>\r\n";




                echo "  <tr><td id='suns".$id."' ><table  width='630px'  border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunDep($id,$step."��");
                echo "</table></td></tr>\r\n";
				$DepArray .= $id.",";
            }
        }
    }


}//End Class