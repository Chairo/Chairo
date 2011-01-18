<?php
/**
 *网站配置文件
 *Create@2010-12-30Vpc:
 *Update@2010-01-06Vpc:1)原inc.config.php中部分和网站相关配置迁移到此文件
 *                     2)新增网站css、js域名配置
 *Update@2011-01-07Vpc:1)增加XML配置相关
 */

//加载配置文件
require('../inc.config.php');

//数据库配置
$dbConfig = new IncConfig(array (
  'host' => 'localhost',
  'user' => 'root',
  'password' => 'pengxing',
  'charset' => 'utf8',
  'port' => '3306',
  'prefix' => 'ori_',
  'database' => 'article'
));

//网站相关配置
$config = array(
    'web_url' => 'http://localhost:60000/Chairo/www/',    //网站网址
    'web_css_url' => 'http://localhost:60000/Chairo/www/templates/style/',    //网站样式表地址
    'web_js_url' => 'http://localhost:60000/Chairo/www/templates/javascript/',    //网站js地址
    'web_name' => '药酒配方大全',    //网站名称
    'web_description' => '药酒，既可治病防病，凡临床各科190余种常见多发病和部分疑难病症均可疗之；又可养生保健、美容润肤；还可作病后调养和日常饮酒使用而延年益寿，真可谓神通广大。难怪有人称药酒为神酒，是中国医学宝库中的一股香泉。',    //网站描述
    'web_author' => 'Chairo',    //网站作者
    'web_copyright' => '&copy; <a href="http://localhost:60000/Chairo/www/"><strong>药酒配方大全<strong></a> 2010 - Via Chairo<br/><strong class="strong txt-shadow">相关药酒配方均由Chairo收集自互联网，Chairo仅提供药酒配方分享，使用前请参考医生意见，如有任何不适请立即停止使用。</strong><br />如发现<a href="http://localhost:60000/Chairo/www/"><strong>药酒配方</strong></a>有任何错误请反馈<a href="http://localhost:60000/Chairo/www/"><strong>药酒配方</strong></a>错误给Chairo<a href="mailto:102xing@gmail.com?subject=Error page:'.getCurUrl().'">Via Email</a> Or <a href="http://sighttp.qq.com/authd?IDKEY=c99a301c8a0362d539261e9cfa418e3ef8e93539f972a1a7">Via QQ</a>',    //网站版权
    'relase' => false,    //网站是否已经发布
    'xml_cache' => true    //是否开启xml缓存
);


//缓存配置
$cacheConfig = new IncConfig(array (
  'base_path' => WEB_DIR.'file_cache_xml/',
  'file_obj'=> new FileObject(),
  'base_timeout' => 10
));

///*缓存配置
$cacheConfig2 = new IncConfig(array (
  'base_host' => '127.0.0.1',
  'base_port' => 11211,
  'base_timeout' => 1
));
//*/

$webTempConfig = new IncConfig(array(
                               'template_dir' => WEB_DIR.'www/templates',
                               'compile_dir' => WEB_DIR.'www/templates_c'));

//Smarty配置
$webSmartyConfig = new IncConfig(array(
    'template_dir' => WEB_DIR.'www/templates',    //模板存放目录
    'compile_dir' => WEB_DIR.'www/templates_c',    //模板解析后目录
    'compile_id' => 'www',    //模板解析ID
    'caching' => $config['relase'],    //是否缓存
    'cache_lifetime' => 60*30,    //缓存时间(秒)
    'cache_dir' => WEB_DIR.'www/cache',    //缓存目录
    'cache_id' => 'www',    //缓存id
    'config_dir' => WEB_DIR.'www/configs',    //配置文件目录
    'left_delimiter' => '<{',    //Smarty标记左
    'right_delimiter' => '}>',    //Smarty标记右
    'allow_php_tag' => true,    //是否支持php标记
    'allow_php_templates' => true,    //是否支持include php文件
    'debugging' => false    //是否开启debug
));