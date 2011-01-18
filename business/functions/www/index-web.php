<?php
/**
 *显示随机数据
 *Create@2011-01-08Vpc:
 */

/**
 *Action: 获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       bool $is_cache 是否开启缓存
 *Output: array
 *Create@2011-01-08Vpc:
 */
function getData($dbConfig, $logConfig, $cacheConfig, $is_cache=true) {
    $_arrResult = array();

    file_exists($cacheConfig->base_path.'index.xml') && $is_cache ? getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) : getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult, $is_cache);

    return $_arrResult;
}

/**
 *Action: 获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       reference $_arrResult 返回数据
 *Output:
 *Create@2011-01-08Vpc:
 */
function getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) {
    if((time()-fileMTime($cacheConfig->base_path.'index.xml'))>=$cacheConfig->base_timeout) {    //文件缓存过期则重新从数据库中获取
        getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult);
    } else {    //从文件中读取数据
        $_xml = new XML();
        $_xml->load($cacheConfig->base_path.'index.xml');

        $_rows = $_xml->_obj->getElementsByTagName('row');
        $_k = array();

        foreach($_rows as $_row) {
            foreach($_row->childNodes as $_a) {
                $_k[$_a->nodeName] = $_a->nodeValue;
            }
            $_arrResult[] = $_k;
        }
    }
}

/**
 *Action: 获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       reference $_arrResult 返回数据
 *       bool $is_cache 是否开启缓存
 *Output:
 *Create@2011-01-07Vpc:
 */
function getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult, $is_cache=true) {
    //实例化数据库类
    $objDB= Database::getDatebase('Mysqli');
    try {
        $objConn = $objDB->Open($dbConfig);
    } catch(Exception $ex) {
         Loger::getLog($logConfig)->logger->error($ex);
         header("Location:/error.php");
    }

    //设置查询语句
    $objDB->setQuery("SELECT `id`, `title`, `content`, `description`, `keywords`, FROM_UNIXTIME(`create_date`, '%Y-%m-%d %H:%i:%S') AS create_date FROM article ORDER BY RAND() LIMIT 0, 80");
    $objRs = $objDB->executeQuery($objConn);    //执行查询语句

    while($row = $objDB->getArray($objRs)) {    //获得查询结果
        $_arrResult[] = array(
            'id'=>$row['id'],
            'title'=>$row['title'],
            'content'=>$row['content'],
            'description'=>$row['description'],
            'keywords'=>$row['keywords'],
            'create_date'=>$row['create_date']
        );
    }

    unSet($objRs);

    $objDB->close($objConn);    //关闭数据库连接

    unSet($objConn);
    unSet($objDB);

    //如果缓存文件则存入xml
    if($is_cache) {
        $_xml = new XML('<root><rows></rows></root>');
        $_xml->createElement(new IncConfig(array (
          'name' => 'row',
          'value' => $_arrResult,
          'cdata' => '|,title,description,content,keywords,|',
          'obj' => $_xml->_obj,
          'parent' => $_xml->_obj->getElementsByTagName('rows')->item(0)
        )));
        $objCache = Cache::getCache();
        $objCache->open($cacheConfig);
        $objCache->set('index.xml', $_xml->_obj->saveXML(), null, $cacheConfig->base_timeout);
    }
}