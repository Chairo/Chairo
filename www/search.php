<?php
/**
 *显示搜索结果
 *Create@2010-12-07Vpc:
 */

//加载网站文件
require('web.config.php');

includeFiles(Array(
    'template.php',    //模板类
    'functions/www/record.php',    //记录日志
    'functions/www/search-web.php',    //获取文章内容函数
    'functions/www/hot-search.php',    //热门搜索类
    'functions/www/delete-param-page.php',    //去掉GET参数中page=*
    'xml.php'    //XML操作类
));

//初始化基本数据
$arrResult = array();
$_arr = array();
$_keywords = noAnnotate(inputCheck(mb_convert_encoding(urlDeCode(get('txtKeywords', '')), 'UTF-8', 'GB2312,UTF-8')));
$_page = formatNumber(get('page', '1'));
$_pageSize = 20;
$_limit = ($_page-1)*$_pageSize;
$tplName = 'search-result.tpl';

$_c = 0;
$_where = 'ORDER BY `id`';

if('' != $_keywords) {
    $_arr = split(',', $_keywords);
    $_c = count($_arr);
}
for($i = 0; $i<$_c; $i++) {
    if(0 == $i) {
        $_where = "WHERE (`title` LIKE '%$_arr[$i]%' OR `content` LIKE '%$_arr[$i]%')";
    } else {
        $_where .= " OR (`title` LIKE '%$_arr[$i]%' OR `content` LIKE '%$_arr[$i]%')";
    }
}

//实例化数据库类
$objDB= Database::getDatebase('Mysqli');
try {
    $objConn = $objDB->open($dbConfig);
} catch(Exception $ex) {
     Loger::GetLog($logConfig)->logger->error($ex);
     header("Location:/error.php");
}

//设置查询语句
$objDB->setQuery("SELECT COUNT(*) AS numb FROM article $_where");
$objRs = $objDB->executeQuery($objConn);    //执行查询语句
$row = $objDB->getArray($objRs);
$_dataCount = $row['numb'];    //查询记录总数
unSet($objRs);

$objDB->close($objConn);    //关闭数据库连接

unSet($objConn);
unSet($objDB);

$_keywords = $_keywords == '' ? '全部酒方' : $_keywords;

deleteParamPage($_GET);    //去除URL参数中page参数
$_param = '';
foreach($_GET as $k=>$v) {
    $_param .= $k.'='.mb_convert_encoding($v, 'UTF-8', 'GB2312,UTF-8').'&';
}
$_pageCount = intval($_dataCount/$_pageSize)<($_dataCount/$_pageSize) ? intval($_dataCount/$_pageSize)+1 : intval($_dataCount/$_pageSize);

$twig = new Template($webTempConfig);
$twig->t->addfunction('page', new Twig_Function_Function('page', array('is_safe' => array('html'))));
$template = $twig->t->loadTemplate('search-result.twig');
$template->display(array('CONFIG' => $config,
                         'ARTICLES' => getData($dbConfig, $logConfig, $cacheConfig, $is_cache=true, $_where, $_limit, $_pageSize),
                         'HOTSEARCHS' => hotSearch($dbConfig, 10),
                         'SEARCH' => $_keywords,
                         'PAGE' => array('page_count' => $_pageCount,
                                         'data_count' => $_dataCount,
                                         'page_size' => $_pageSize,
                                         'page' => $_page,
                                         'page_link' => $config['web_url'].'search.php?'.$_param.'page=',
                                         'list' => 10
                                        )
                        )
                  );
ob_end_flush();

record(0, $_keywords, getIP(), $dbConfig);