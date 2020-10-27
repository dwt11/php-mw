<?php   if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 动态分页类
 * 说明:数据量不大的数据分页,使得数据分页处理变得更加简单化
 * 使用方法:
 *     $dl = new DataListCP();  //初始化动态列表类
 *     $dl->pageSize = 25;      //设定每页显示记录数（默认25条）
 *     $dl->SetParameter($key,$value);  //设定get字符串的变量
 *     //这两句的顺序不能更换
 *     $dl->SetTemplate($tplfile);      //载入模板
 *     $dl->SetSource($sql);            //设定查询SQL
 *     $dl->Display();                  //显示
 *
 * @version        $Id: datalistcp.class.php 3 17:02 2010年7月9日Z tianya $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(DEDEINC.'/dedetemplate.class.php');
$lang_pre_page = '上页';
$lang_next_page = '下页';
$lang_index_page = '首页';
$lang_end_page = '末页';
$lang_record_number = '条记录';
$lang_page = '页';
$lang_total = '共';

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
    var $totalPage;  //总页数
    var $totalResult;
    var $pageSize;
    var $getValues;
    var $sourceSql;
    var $isQuery;
    var $queryTime;

    /**
     *  用指定的文档ID进行初始化
     *
     * @access    public
     * @param     string  $tplfile  模板文件
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
     *  兼容PHP4版本
     *
     * @access    private
     * @param     string  $tplfile  模板文件
     * @return    void
     */
    function DataListCP($tplfile='')
    {
        $this->__construct($tplfile);
    }

    //设置SQL语句
    function SetSource($sql)
    {
        $this->sourceSql = $sql;
		//dump($sql);
   }
    //设置模板
    //如果想要使用模板中指定的pagesize，必须在调用模板后才调用 SetSource($sql)
    function SetTemplate($tplfile)
    {
        $this->tpl->LoadTemplate($tplfile);
    }
    function SetTemplet($tplfile)
    {
        $this->tpl->LoadTemplate($tplfile);
    }

    /**
     *  对config参数及get参数等进行预处理
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

    //设置网址的Get参数键值
    function SetParameter($key,$value)
    {
        $this->getValues[$key] = $value;
    }

    //设置/获取文档相关的各种变量
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

    //获取当前页数据列表
    function GetArcList($atts,$refObj='',$fields=array())
    {
        $rsArray = array();
        $t1 = Exectime();
        if(!$this->isQuery) $this->dsql->Execute('dlist',$this->sourceSql);
        
		$i = 0;
        while($arr=$this->dsql->GetArray('dlist'))
        {
            $i++;
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

    //获取分页导航列表
    function GetPageList($atts,$refObj='',$fields=array())
    {
        global $lang_pre_page,$lang_next_page,$lang_index_page,$lang_end_page,$lang_record_number,$lang_page,$lang_total;
     //dump($atts);
	   
	
	
	
	
	
	//140425添中这一段   如果页数少于10页的话,得不到这些字符
	$lang_pre_page = '上页';
    $lang_next_page = '下页';
    $lang_index_page = '首页';
    $lang_end_page = '末页';
    $lang_record_number = '条记录';
    $lang_page = '页';
    $lang_total = '共';





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
        //无结果或只有一页的情况
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
        $infos = "<span>当前第".$this->pageNO."页 每页".$this->pageSize."条 {$lang_total}{$totalpage}{$lang_page}/{$this->totalResult}{$lang_record_number} </span>";
        if($this->totalResult!=0)
        {
            $this->getValues['totalresult'] = $this->totalResult;
        }
//dump($geturl);
        if(count($this->getValues)>0)
        {
            foreach($this->getValues as $key=>$value)
            {
                $value = urlencode($value);
                $geturl .= "$key=$value"."&";
                $hidenform .= "<input type='hidden' name='$key' value='$value' />\n";
            }
        }
        $purl .= "?".$geturl;
        //获得上一页和下一页的链接
        if($this->pageNO != 1)
        {
            $prepage .= "<a class='prePage' href='".$purl."pageno=$prepagenum'>$lang_pre_page</a> \n";
            $indexpage = "<a class='indexPage' href='".$purl."pageno=1'>$lang_index_page</a> \n";
        }
        else
        {
            $indexpage = "<span class='indexPage'>"."$lang_index_page \n"."</span>";
        }
        if($this->pageNO != $totalpage && $totalpage > 1)
        {
            $nextpage.="<a class='nextPage' href='".$purl."pageno=$nextpagenum'>$lang_next_page</a> \n";
            $endpage="<a class='endPage' href='".$purl."pageno=$totalpage'>$lang_end_page</a> \n";
        }
        else
        {
            $endpage=" <strong>$lang_end_page</strong> \n";
        }

        //获得数字链接
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
            $listdd .= $j==$this->pageNO ? "<strong>$j</strong>\n" : "<a href='".$purl."pageno=$j'>".$j."</a>\n";
        }

        $plist = "<div class=\"pagelistbox\">\n";

        //info 共 7 页/153条记录,
		//index 首页
		//,end   末页,
		//pre,next  上页  下页
		//pageno数字连接
		//,form 跳转连接
		
	            $plist .=" <form name='pagelist' action='".$this->GetCurUrl()."' >$hidenform";
	  
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
        if(preg_match("#form#i", $atts['listitem']))
        {
                        //dump($totalpage);
                       // dump($total_list);

			//if($totalpage>$total_list)
			if($totalpage>1)  //如果总页数大于1就显示跳转连接
            {
                $plist.="&nbsp;&nbsp;跳转到第<input type='text' name='pageno' style='padding:0px;width:30px;height:18px;font-size:11px' value='".$this->pageNO."' />页\r\n";
                $plist.="<input type='submit' name='plistgo' value='GO' style='padding:0px;width:30px;height:22px;font-size:11px' />\r\n";
            }
        }
            $plist .= "</form>\n";
        $plist .= "</div>\n";
        return $plist;
    }

    //获得当前网址
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
		//dump($nowurl);
        return $nowurl;
    }

    //关闭
    function Close()
    {

    }

    //显示数据
    function Display()
    {
        $this->PreLoad();

        //在PHP4中，对象引用必须放在display之前，放在其它位置中无效
        $this->tpl->SetObject($this);
        $this->tpl->Display();
    }

    
}