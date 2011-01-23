<?php
/**
 *网站配置文件
 *Create@2011-01-19Vpc:
 */

//加载配置文件
require(dirName(__FILE__).'/../inc.config.php');

//数据库配置
$dbConfig = new IncConfig(array (
  'host' => 'localhost',
  'user' => 'root',
  'password' => 'pengxing',
  'charset' => 'utf8',
  'port' => '3306',
  'prefix' => 'ori_',
  'database' => 'resume'
));

//网站相关配置
$config = array(
    'web_url' => 'http://localhost:60000/Chairo/resume/',    //网站网址
    'web_css_url' => 'http://localhost:60000/Chairo/resume/templates/style/',    //网站样式表地址
    'web_js_url' => 'http://localhost:60000/Chairo/resume/templates/javascript/',    //网站js地址
    'web_img_url' => 'http://localhost:60000/Chairo/resume/templates/images/',    //网站图片地址
    'web_name' => '标题',    //网站名称
    'web_description' => '描述',    //网站描述
    'web_author' => 'Chairo',    //网站作者
    'web_copyright' => '&copy; 版权',    //网站版权
    'relase' => false,    //网站是否已经发布
    'xml_cache' => false    //是否开启xml缓存
);


//缓存配置
$cacheConfig = new IncConfig(array (
  'base_path' => WEB_DIR.'file_cache_xml/resume/',
  'file_obj'=> new FileObject(),
  'base_timeout' => 60*60
));

$webTempConfig = new IncConfig(array(
                               'template_dir' => WEB_DIR.'resume/templates',
                               'compile_dir' => false    //WEB_DIR.'www/templates_c'
                              ));