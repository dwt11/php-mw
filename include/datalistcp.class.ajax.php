<?php   if(!defined('DEDEINC')) exit('Request Error!');
/**
 * ��̬��ҳ��(AJAX��ʾ)

------------------��ҳ�� ���������´���
<script language="javascript">


//��ҳ������ӵ����,��ʾ������
function LoadGoodsLog(ajaxurl)
{
	ename=ajaxurl.split("ename=")[1];//��ȡ��Ԫ�ص�ID����,URL��ENAME=���������һ������
	ShowHide(ename); 
	sunslength=$DE(ename).innerHTML.length;  //�����ݳ���,
	if(sunslength < 60){ //��������ݳ��� С��60��AJAX��ȡ����
		showAjaxSuns(ajaxurl)
	}
}

//��ȡAJAX������,����ҳ����
//�Զ��������ĸ�ID��������,���������еķ�ҳ�����,��������
function showAjaxSuns(ajaxurl)
{
	//alert(ajaxurl.split("ename=")[1]);
	ename=ajaxurl.split("ename=")[1];//��ȡ��Ԫ�ص�ID����,URL��ENAME=���������һ������
	var myajax = new DedeAjax($DE(ename));
	myajax.SendGet(ajaxurl);
}

</script>








          <a onclick="LoadGoodsLog('goods.log.ajax.php?goodsid={dede:field.id/}&ename=goodsLog{dede:field.id/}');" href="javascript:;">������¼</a>
 
 
 
 
    <?php 
    $lastgoodslogid = GetCookie('lastgoodslogid');
    if($lastgoodslogid==$fields['id']){//����ϴ���ʾ����Ʒ��¼ID,�뵱ǰ��ͬ,��ֱ����ʾ
            
            echo "<tr  bgcolor=\"#FFFFFF\" id='goodsLog".$fields['id']."'><td  colspan=\"11\" align='center' bgcolor=\"#6699CC\"  >\r\n";
            echo "<script >showAjaxSuns('goods.log.ajax.php?goodsid=".$fields['id']."&ename=goodsLog".$fields['id']."')</script>";
            echo "</td></tr>\r\n";
     }else
     {
            echo "<tr  bgcolor=\"#FFFFFF\" style=\"display:none\" id='goodsLog".$fields['id']."'></tr>\r\n";
     }
    ?>




------------------��ҳ�� ���������ϴ���






 * ˵��:��������������ݷ�ҳ,ʹ�����ݷ�ҳ�����ø��Ӽ򵥻�
 * ʹ�÷���:


		
		PutCookie('lastgoodslogid', $goodsid, 3600*24, "/");    //����ȡ��AJAXid,Ҫ�ڸ�ҳ����бȽ�
		AjaxHead();                                               //���AJAXͷ

 *     $dl = new DataListCP();  //��ʼ����̬�б���
 *     $dl->pageSize = 25;      //�趨ÿҳ��ʾ��¼����Ĭ��25����
 *     $dl->SetParameter($key,$value);  //�趨get�ַ����ı���
 *     //�������˳���ܸ���
 *     $dl->SetTemplate($tplfile);      //����ģ��
 *     $dl->SetSource($sql);            //�趨��ѯSQL
 *     $dl->Display();                  //��ʾ
 *
 * @version        $Id: datalistcp.class.php 3 17:02 2010��7��9��Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(DEDEINC.'/dedetemplate.class.php');
$lang_pre_page = '��ҳ';
$lang_next_page = '��ҳ';
$lang_index_page = '��ҳ';
$lang_end_page = 'ĩҳ';
$lang_record_number = '����¼';
$lang_page = 'ҳ';
$lang_total = '��';

/**
 * DataListCP
 *
 * @package DedeCMS.Libraries
 */
class DataListCP
{
    var $dsql;
    var $tpl;
    var $pageNO;
    var $totalPage;  //��ҳ��
    var $totalResult;
    var $pageSize;
    var $getValues;
    var $sourceSql;
    var $isQuery;
    var $queryTime;

    /**
     *  ��ָ�����ĵ�ID���г�ʼ��
     *
     * @access    public
     * @param     string  $tplfile  ģ���ļ�
     * @return    string
     */
    function __construct($tplfile='')
    {
//        if ($GLOBALS['cfg_mysql_type'] == 'mysqli' && function_exists("mysqli_init"))
//        {
//            $dsql = $GLOBALS['dsqli'];
//        } else {
            $dsql = $GLOBALS['dsql'];
//        }
        $this->sourceSql='';
        $this->pageSize=25;
        $this->queryTime=0;
        $this->getValues=Array();
        $this->isQuery = false;
        $this->totalResult = 0;
		
        $this->totalPage = 0;
        $this->pageNO = 0;
        $this->dsql = $dsql;
        $this->SetVar('ParseEnv','datalist');
        $this->tpl = new DedeTemplate();
        if($tplfile!='')
        {
            $this->tpl->LoadTemplate($tplfile);
        }
    }
    
    /**
     *  ����PHP4�汾
     *
     * @access    private
     * @param     string  $tplfile  ģ���ļ�
     * @return    void
     */
    function DataListCP($tplfile='')
    {
        $this->__construct($tplfile);
    }

    //����SQL���
    function SetSource($sql)
    {
        $this->sourceSql = $sql;
		//dump($sql);
   }
    //����ģ��
    //�����Ҫʹ��ģ����ָ����pagesize�������ڵ���ģ���ŵ��� SetSource($sql)
    function SetTemplate($tplfile)
    {
        $this->tpl->LoadTemplate($tplfile);
    }
    function SetTemplet($tplfile)
    {
        $this->tpl->LoadTemplate($tplfile);
    }

    /**
     *  ��config������get�����Ƚ���Ԥ����
     *
     * @access    public
     * @return    void
     */
    function PreLoad()
    {
        global $totalresult,$pageno;
        if(empty($pageno) || preg_match("#[^0-9]#", $pageno))
        {
            $pageno = 1;
        }
        if(empty($totalresult) || preg_match("#[^0-9]#", $totalresult))
        {
            $totalresult = 0;
        }
        $this->pageNO = $pageno;
        $this->totalResult = $totalresult;

        if(isset($this->tpl->tpCfgs['pagesize']))
        {
            $this->pageSize = $this->tpl->tpCfgs['pagesize'];
        }
        $this->totalPage = ceil($this->totalResult / $this->pageSize);
  		//dump ($this->pageSize);
      if($this->totalResult==0)
        {
            
				$countQuery = $this->sourceSql;
           //dump($countQuery)."9999999"; 
		

		   
			
						       
				 $this->dsql->SetQuery($countQuery);
				  $this->dsql->Execute();
				  $dd=$this->dsql->GetTotalRow();
			
			
			
            $this->totalResult = isset($dd)? $dd : 0;
            $this->sourceSql .= " LIMIT 0,".$this->pageSize;
			//dump($this->totalResult."kkkk");
        }
        else
        {
            $this->sourceSql .= " LIMIT ".(($this->pageNO-1) * $this->pageSize).",".$this->pageSize;
					//dump($this->sourceSql);

        }
    }

    //������ַ��Get������ֵ
    function SetParameter($key,$value)
    {
        $this->getValues[$key] = $value;
    }

    //����/��ȡ�ĵ���صĸ��ֱ���
    function SetVar($k,$v)
    {
        global $_vars;
        if(!isset($_vars[$k]))
        {
            $_vars[$k] = $v;
        }
    }

    function GetVar($k)
    {
        global $_vars;
        return isset($_vars[$k]) ? $_vars[$k] : '';
    }

    //��ȡ��ǰҳ�����б�
    function GetArcList($atts,$refObj='',$fields=array())
    {
        $rsArray = array();
        $t1 = Exectime();
        if(!$this->isQuery) $this->dsql->Execute('dlist',$this->sourceSql);
        
		$i = 0;
        while($arr=$this->dsql->GetArray('dlist'))
        {
            $i++;
            $arr['autoindex']=$i;  //141127���� ҳ���ȡ�Զ����������  ���ô���:{dede:field.autoindex/}  ���ÿҳ�������¼���
			$rsArray[$i]  =  $arr;
            //dump ($arr);
		    if($i >= $this->pageSize)
            {
                break;
            }
        }
        $this->dsql->FreeResult('dlist');
        $this->queryTime = (Exectime() - $t1);
        return $rsArray;
    }

    //��ȡ��ҳ�����б�
    function GetPageList($atts,$refObj='',$fields=array())
    {
        global $lang_pre_page,$lang_next_page,$lang_index_page,$lang_end_page,$lang_record_number,$lang_page,$lang_total;
     //dump($atts);
	   
	
	
	
	
	
	//140425������һ��   ���ҳ������10ҳ�Ļ�,�ò�����Щ�ַ�
	$lang_pre_page = '��ҳ';
    $lang_next_page = '��ҳ';
    $lang_index_page = '��ҳ';
    $lang_end_page = 'ĩҳ';
    $lang_record_number = '����¼';
    $lang_page = 'ҳ';
    $lang_total = '��';





	    $prepage = $nextpage = $geturl= $hidenform = '';
        $purl = $this->GetCurUrl();
        $prepagenum = $this->pageNO-1;
        $nextpagenum = $this->pageNO+1;
        if(!isset($atts['listsize']) || preg_match("#[^0-9]#", $atts['listsize']))
        {
            $atts['listsize'] = 5;
        }
        if(!isset($atts['listitem']))
        {
            $atts['listitem'] = "info,index,end,pre,next,pageno,form";
        }

        $totalpage = ceil($this->totalResult/$this->pageSize);
//dump($this->totalResult);
//dump($this->pageSize);
        //echo " {$totalpage}=={$this->totalResult}=={$this->pageSize}";
        //�޽����ֻ��һҳ�����
        if($totalpage<=1 && $this->totalResult > 0)
        {
            //return "<span>{$lang_total} 1 {$lang_page}/".$this->totalResult.$lang_record_number."</span>";
			return "<span>{$lang_total}".$this->totalResult.$lang_record_number."</span>";
        }
        if($this->totalResult == 0)
        {
            //return "<span>{$lang_total} 0 {$lang_page}/".$this->totalResult.$lang_record_number."</span>";
            return "{$lang_total}".$this->totalResult.$lang_record_number."</span>";
        }
        $infos = "<span>��ǰ��".$this->pageNO."ҳ ÿҳ".$this->pageSize."�� {$lang_total}{$totalpage}{$lang_page}/{$this->totalResult}{$lang_record_number} </span>";
        if($this->totalResult!=0)
        {//$this->getValues['totalresult'];
            $this->getValues=array('totalresult'=>$this->totalResult)+$this->getValues;  //�������ӵ���ǰ��  ȷ��EANME�����������,��JAVASCRIPT��ȡ
        }
//dump($this->getValues);
        //�����Ӽ������
	    if(count($this->getValues)>0)
        {
            foreach($this->getValues as $key=>$value)
            {
                $value = urlencode($value);
                $geturl .= "$key=$value"."&";
                $hidenform .= "<input type='hidden' name='$key' value='$value' />\n";
            }
        }
        //dump($purl);
		$geturl=trim($geturl,"&");  //������Ҳ��&
		//$purl .= "?".$geturl;
        //�����һҳ����һҳ������
        if($this->pageNO != 1)
        {
            $prepage .= "<a class='prePage' href='javascript:;' onclick=\"showAjaxSuns('".$purl."?pageno=$prepagenum&".$geturl."');\">$lang_pre_page</a> \n";
            $indexpage = "<a class='indexPage' href='javascript:;' onclick=\"showAjaxSuns('".$purl."?pageno=1&".$geturl."');\">$lang_index_page</a> \n";
        }
        else
        {
            $indexpage = "<span class='indexPage'>"."$lang_index_page \n"."</span>";
        }
        if($this->pageNO != $totalpage && $totalpage > 1)
        {
            $nextpage.="<a class='nextPage' href='javascript:;' onclick=\"showAjaxSuns('".$purl."?pageno=$nextpagenum&".$geturl."');\">$lang_next_page</a> \n";
            $endpage="<a class='endPage' href='javascript:;' onclick=\"showAjaxSuns('".$purl."?pageno=$totalpage&".$geturl."');\">$lang_end_page</a> \n";
        }
        else
        {
            $endpage=" <strong>$lang_end_page</strong> \n";
        }

        //�����������
        $listdd = "";
        //$total_list = $atts['listsize'] * 2 + 1;
		$total_list = 10;
		//dump($atts['listsize']."----".$total_list);
        if($this->pageNO >= $total_list)
        {
            $j = $this->pageNO - $atts['listsize'];
            $total_list=$this->pageNO + $atts['listsize'];
            if($total_list > $totalpage)
            {
                $total_list = $totalpage;
            }
        }
        else
        {
            $j=1;
            if($total_list > $totalpage)
            {
                $total_list = $totalpage;
            }
        }
        for($j; $j<=$total_list; $j++)
        {
            //$listdd .= $j==$this->pageNO ? "<strong>$j</strong>\n" : "<a href='".$purl."pageno=$j'>".$j."</a>\n";
            $listdd .= $j==$this->pageNO ? "<strong>$j</strong>\n" : "<a onclick=\"showAjaxSuns('".$purl."?pageno=$j&".$geturl."');\" href=\"javascript:;\">".$j."</a>\n";
		}
		
		///???����Ҫ�Ҹ�����  �� ������ҳ��JAVASCRIPT����  �������,Ȼ������ ��ҳ�������
		

        $plist = "<div class=\"pagelistbox\">\n";

        //info �� 7 ҳ/153����¼,
		//index ��ҳ
		//,end   ĩҳ,
		//pre,next  ��ҳ  ��ҳ
		//pageno��������
		//,form ��ת����
		
	  
        if(preg_match("#info#i",$atts['listitem']))
        {
            $plist .= $infos;
        }
        if(preg_match("#index#i", $atts['listitem']))
        {
            $plist .= $indexpage;
        }
        if(preg_match("#pre#i", $atts['listitem']))
        {
            $plist .= $prepage;
        }
        if(preg_match("#pageno#i", $atts['listitem']))
        {
            $plist .= $listdd;
        }
        if(preg_match("#next#i", $atts['listitem']))
        {
            $plist .= $nextpage;
        }
        if(preg_match("#end#i", $atts['listitem']))
        {
            $plist .= $endpage;
        }
       
        $plist .= "</div>\n";
        return $plist;
    }

    //��õ�ǰ��ַ
    function GetCurUrl()
    {
        if(!empty($_SERVER["REQUEST_URI"]))
        {
            $nowurl = $_SERVER["REQUEST_URI"];
            $nowurls = explode("?",$nowurl);
            $nowurl = $nowurls[0];
        }
        else
        {
            $nowurl = $_SERVER["PHP_SELF"];
        }
        return $nowurl;
    }

    //�ر�
    function Close()
    {

    }

    //��ʾ����
    function Display()
    {
        $this->PreLoad();

        //��PHP4�У��������ñ������display֮ǰ����������λ������Ч
        $this->tpl->SetObject($this);
        $this->tpl->Display();
    }

    //����ΪHTML
    function SaveTo($filename)
    {
        $this->tpl->SaveTo($filename);
    }
}