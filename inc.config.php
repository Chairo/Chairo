<?php
/**
 *主要配置文件
 *Create@2010-12-30Vpc:
 *Update@2010-01-06Vpc:1)原inc.config.php中部分和网站相关配置迁移至网站对应目录下web.config.php中
 */

//开启Session支持
session_start();

//程序执行时间不限制
set_time_limit(0);

//错误提示(6143为全部错误, 0为不提示)
error_reporting(6143);
#error_reporting(0);

//gzip压缩页面
ob_start("ob_gzhandler");

//页面编码UTF-8
header("Content-Type: text/html; charset=utf-8");

//默认时区
date_default_timezone_set('Asia/Shanghai');

//网站物理根目录
define('WEB_DIR', str_replace('\\', '/', dirName(__FILE__)).'/');

//设置包含路径
@set_include_path(get_include_path().PATH_SEPARATOR.
WEB_DIR.'core/'.PATH_SEPARATOR.
WEB_DIR.'business/');

//加载公用函数
require('pub-functions.php');

includeFiles(array(
    'config.php',    //配置类
    'exception.php',    //异常类
    'io/FileObject.php',    //文件操作类
    'log/log.php',    //日志类
    'data/cache.php',    //缓存类
    'data/database.php'    //数据库逻辑层类
));

//日志配置
$logConfig = new IncConfig(array(
    'log4phpproperties' => WEB_DIR.'log4php.properties',
    'type' => 'txt'
));