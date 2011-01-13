<?php
/**
 *显示文章详细内容
 *Create@2011-01-08Vpc:
 */

 /**
 *Action: 获取文章详细内容
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       bool $is_cache 是否开启缓存
 *       int $article_id 文章ID
 *Output: array
 *Create@2011-01-08Vpc:
 */
function getArticle($dbConfig, $logConfig, $cacheConfig, $is_cache=true, $article_id=0) {
    $_row = array();

    file_exists($cacheConfig->base_path.$article_id.'.xml') && $is_cache ? getArticleFromXML($dbConfig, $logConfig, $cacheConfig, &$_row, $article_id) : getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, $is_cache, $article_id);

    return $_row;
}

/**
 *Action: 从XML文件获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       reference $_row 返回数据
 *       int $article_id 文章ID
 *Output:
 *Create@2011-01-08Vpc:
 */
function getArticleFromXML($dbConfig, $logConfig, $cacheConfig, &$_row, $article_id) {
    if((time()-fileMTime($cacheConfig->base_path.$article_id.'.xml'))>=$cacheConfig->base_timeout) {    //文件缓存过期则重新从数据库中获取
        getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, true, $article_id);
    } else {    //从文件中读取数据
        $_xml = new XML();
        $_xml->load($cacheConfig->base_path.$article_id.'.xml');

        $_rows = $_xml->_obj->getElementsByTagName('row');
        $_k = array();

        foreach($_rows as $_row) {
            foreach($_row->childNodes as $_a) {
                $_k[$_a->nodeName] = $_a->nodeValue;
            }
        }
        $_row = $_k;
    }
}

/**
 *Action: 从数据库获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       reference $_row 返回数据
 *       bool $is_cache 是否开启缓存
 *       int $article_id 文章ID
 *Output:
 *Create@2011-01-08Vpc:
 */
function getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, $is_cache=true, $article_id) {
    $_tmp = array();
    //实例化数据库类
    $objDB= Database::getDatebase('Mysqli');
    try {
        $objConn = $objDB->open($dbConfig);
    } catch(Exception $ex) {
         Loger::getLog($logConfig)->logger->error($ex);
         header("Location:/error.php");
    }
    $objDB->setQuery("SELECT `title`, `content`, `description`, `keywords`, FROM_UNIXTIME(`create_date`, '%Y-%m-%d %H:%i:%S') AS create_date FROM article WHERE `id`=$article_id");
    $objRs = $objDB->executeQuery($objConn);

    while($row = $objDB->getArray($objRs)) {    //获得查询结果
        $_tmp[] = array(
            'title'=>$row['title'],
            'content'=>$row['content'],
            'description'=>$row['description'],
            'keywords'=>$row['keywords'],
            'create_date'=>$row['create_date']
        );
    }
    $_row = count($_tmp)>0 ? $_tmp[0] : array();
    unSet($objRs);

    $objDB->close($objConn);    //关闭数据库连接

    unSet($objConn);
    unSet($objDB);

    //如果缓存文件则存入xml
    if($is_cache) {
        $_xml = new XML('<root><rows></rows></root>');

        $_xml->createElement(new IncConfig(array (
          'name' => 'row',
          'value' => $_tmp,
          'cdata' => '|,title,description,content,keywords,|',
          'obj' => $_xml->_obj,
          'parent' => $_xml->_obj->getElementsByTagName('rows')->item(0)
        )));
        $objCache = Cache::getCache();
        $objCache->open($cacheConfig);
        $objCache->set($article_id.'.xml', $_xml->_obj->saveXML(), null, $cacheConfig->base_timeout);
    }
}

 /**
 *Action: 获取随机数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       bool $is_cache 是否开启缓存
 *Output: array
 *Create@2011-01-08Vpc:
 */
function getData($dbConfig, $logConfig, $cacheConfig, $is_cache=true) {
    $_arrResult = array();

    file_exists($cacheConfig->base_path.'article.xml') && $is_cache ? getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) : getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult, $is_cache);

    return $_arrResult;
}

/**
 *Action: 从XML文件获取数据
 *Input: IncConfig $dbConfig 数据库配置
 *       IncConfig $logConfig 日志配置
 *       IncConfig $cacheConfig 缓存配置
 *       reference $_arrResult 返回数据
 *Output:
 *Create@2011-01-08Vpc:
 */
function getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) {
    if((time()-fileMTime($cacheConfig->base_path.'article.xml'))>=$cacheConfig->base_timeout) {    //文件缓存过期则重新从数据库中获取
        getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult);
    } else {    //从文件中读取数据
        $_xml = new XML();
        $_xml->load($cacheConfig->base_path.'article.xml');

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
 *Action: 从数据库获取数据
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
        $objConn = $objDB->open($dbConfig);
    } catch(Exception $ex) {
         Loger::getLog($logConfig)->logger->error($ex);
         header("Location:/error.php");
    }
   //随机12条记录
    $objDB->setQuery("SELECT `id`, `title`, `content`, `description`, `keywords`, FROM_UNIXTIME(`create_date`, '%Y-%m-%d %H:%i:%S') AS create_date FROM article ORDER BY RAND() LIMIT 0, 12");
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
    unset($objRs);

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
        $objCache->set('article.xml', $_xml->_obj->saveXML(), null, $cacheConfig->base_timeout);
    }
}