<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * �ִʹ���110723����
 *
 * @version        $Id: test.helper.php 5 15:01 2011��7��23��Z  $
 * 
 */

//����ִʣ�����DEDE�ִ����֣��жϽ��ô����Ƿ��зִʣ����û��������ִ�
if ( ! function_exists('getsplitword'))
{
   function getsplitword($word)
    {
		require_once(DEDEINC."/splitword.class.php");
 		require(DEDEPATH."/data/cache/jykeywords.inc");
 
		global $cfg_soft_lang;
		global $dsql;

		//echo $keyword;
		$sp = new SplitWord($cfg_soft_lang, $cfg_soft_lang);
		$sp->SetSource($word, $cfg_soft_lang, $cfg_soft_lang);
		$sp->StartAnalysis();
		$keywords = $sp->GetFinallyResult(' ');
		//$titles = ereg_replace("[ ]{1,}"," ",trim($keywords));
  
  
		$ks = explode(' ',$keywords);
		$keywords="";
		
		
		//����TAGS���ݿ��б���Ĵ���չ�ִ�
		//����DEDE�ִʣ�������������ֽڣ�����TAGS�����������ƵĴʣ�Ȼ�������ƵĴ��ڱ������ң�����������
			  $liketag="";
		foreach($ks as $k)//�ִ�ѭ��
		{
			//dump("�����ִʣ�".$k);
			if (strlen($k)>2&&strlen($k)<5)
			{
		
			  
			  
			    $dsql->SetQuery("select id,tag from `#@__tagindex` where tag like '%$k%' and tag<>'$k' order by total desc");
				$dsql->Execute('word');
				//$hotword = "";
				if(is_array($row=$dsql->GetArray('word')))
				{
					while($row=$dsql->GetArray('word'))
					{
						$isjy=strpos($word,$row['tag']);//dump($_Csff);//�жϽ��ô����Ƿ��зִʣ����û�������
						if($isjy)$liketag.=$row['tag']." ";
					
					}
				//	dump("���Ʒִʣ�".$liketag);

				}
				else
				{
					$liketag.=$k." ";
				}
			}
					if(strlen($k)>4)$liketag.=$k." ";
		}  
			//dump("�������ƺ�ķִ�:".$liketag);
		
		
		
		
		$ks = explode(' ',$liketag);
		$jykeyword=implode(",",$_Csff);//��ý��ùؼ��ʣ�ת��Ϊ�ַ���
					

		foreach($ks as $k)//�ִ�ѭ��
		{
			$k = trim($k);
			if(strlen($k)>2)
			{
				$isjy=strpos($jykeyword,$k);//dump($_Csff);//�жϽ��ô����Ƿ��зִʣ����û�������
				if($isjy==false)$keywords.=$k." ";
			}
		}  
			//dump("���շִ�:".$keywords);
		return $keywords;
    }
}