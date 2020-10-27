<?php
/**
 * @version        $Id: index.php 1 9:23 2010-11-11 tianya $
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
 
 
 
 
 
 
 //判断系统是否安装
if(!file_exists(dirname(__FILE__).'/data/common.inc.php'))
{
    header('Location:install/index.php');
    exit();
}else
{
	//这里判断一下archives文件夹是否存在,如果存在代表系统有新闻功能,有前台功能,则跳转到WEB目录
	//如果没有,则跳转到后台主页面main.php
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