<?php
/**
 *首页
 *Create@2010-12-07Vpc:
 *Update@2011-01-07Vpc:1)增加XML操作类
 *Update@2011-01-12Vpc:1)修改为Twig模板
 */

//加载网站文件
require('web.config.php');

includeFiles(array(
    'template.php',    //模板类
    'functions/www/hot-search.php',    //热门搜索类
    'functions/www/index-web.php',    //首页函数
    'xml.php'    //XML操作类
));

$id = formatNumber(Get('id', '0'));
if('0' != $id){header("Location:/$id.html");}

$twig = new Template($webTempConfig);
$template = $twig->t->loadTemplate('index.twig');
$template->display(array('CONFIG' => $config,
                         'ARTICLES' => getData($dbConfig, $logConfig, $cacheConfig, $config['xml_cache']),
                         'HOTSEARCHS' => hotSearch($dbConfig, 10)
                        )
                  );
ob_end_flush();