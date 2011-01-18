<?php
/**
 *显示详细内容
 *Create@2010-12-07Vpc:
 *Update@2011-01-13Vpc:1)修改为Twig模板
 */

//加载网站文件
require('web.config.php');

includeFiles(array(
    'template.php',    //模板类
    'functions/www/record.php',    //记录日志
    'functions/www/article-web.php',    //获取文章内容函数
    'functions/www/hot-search.php',    //热门搜索类
    'xml.php'    //XML操作类
));

$article = getArticle($dbConfig, $logConfig, $cacheConfig, $config['xml_cache'], formatNumber(get('id', '0')));

$twig = new Template($webTempConfig);
$template = $twig->t->loadTemplate('article.twig');
$template->display(array('CONFIG' => $config,
                         'ARTICLES' => getData($dbConfig, $logConfig, $cacheConfig, $config['xml_cache']),
                         'ARTICLE' => $article,
                         'HOTSEARCHS' => hotSearch($dbConfig, 10)
                        )
                  );
ob_end_flush();

record($id, $article['title'], getIP(), $dbConfig);