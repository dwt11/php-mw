<?php
/**
 * @version        $Id: index.php 1 9:23 2010-11-11 tianya $
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
 
 
 
 
 
 
 //�ж�ϵͳ�Ƿ�װ
if(!file_exists(dirname(__FILE__).'/data/common.inc.php'))
{
    header('Location:install/index.php');
    exit();
}else
{
	//�����ж�һ��archives�ļ����Ƿ����,������ڴ���ϵͳ�����Ź���,��ǰ̨����,����ת��WEBĿ¼
	//���û��,����ת����̨��ҳ��main.php
	if(!file_exists(dirname(__FILE__).'/archives'))
	{
		header('Location:main.php');
		exit();
	}else
	{
		header('Location:web/index.php');
		exit();
	}
}


?>