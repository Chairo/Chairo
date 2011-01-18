<?php
/**
 *��ʾ������ϸ����
 *Create@2011-01-08Vpc:
 */

 /**
 *Action: ��ȡ������ϸ����
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       bool $is_cache �Ƿ�������
 *       int $article_id ����ID
 *Output: array
 *Create@2011-01-08Vpc:
 */
function getArticle($dbConfig, $logConfig, $cacheConfig, $is_cache=true, $article_id=0) {
    $_row = array();

    file_exists($cacheConfig->base_path.$article_id.'.xml') && $is_cache ? getArticleFromXML($dbConfig, $logConfig, $cacheConfig, &$_row, $article_id) : getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, $is_cache, $article_id);

    return $_row;
}

/**
 *Action: ��XML�ļ���ȡ����
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       reference $_row ��������
 *       int $article_id ����ID
 *Output:
 *Create@2011-01-08Vpc:
 */
function getArticleFromXML($dbConfig, $logConfig, $cacheConfig, &$_row, $article_id) {
    if((time()-fileMTime($cacheConfig->base_path.$article_id.'.xml'))>=$cacheConfig->base_timeout) {    //�ļ�������������´����ݿ��л�ȡ
        getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, true, $article_id);
    } else {    //���ļ��ж�ȡ����
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
 *Action: �����ݿ��ȡ����
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       reference $_row ��������
 *       bool $is_cache �Ƿ�������
 *       int $article_id ����ID
 *Output:
 *Create@2011-01-08Vpc:
 */
function getArticleFromSQL($dbConfig, $logConfig, $cacheConfig, &$_row, $is_cache=true, $article_id) {
    $_tmp = array();
    //ʵ�������ݿ���
    $objDB= Database::getDatebase('Mysqli');
    try {
        $objConn = $objDB->open($dbConfig);
    } catch(Exception $ex) {
         Loger::getLog($logConfig)->logger->error($ex);
         header("Location:/error.php");
    }
    $objDB->setQuery("SELECT `title`, `content`, `description`, `keywords`, FROM_UNIXTIME(`create_date`, '%Y-%m-%d %H:%i:%S') AS create_date FROM article WHERE `id`=$article_id");
    $objRs = $objDB->executeQuery($objConn);

    while($row = $objDB->getArray($objRs)) {    //��ò�ѯ���
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

    $objDB->close($objConn);    //�ر����ݿ�����

    unSet($objConn);
    unSet($objDB);

    //��������ļ������xml
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
 *Action: ��ȡ�������
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       bool $is_cache �Ƿ�������
 *Output: array
 *Create@2011-01-08Vpc:
 */
function getData($dbConfig, $logConfig, $cacheConfig, $is_cache=true) {
    $_arrResult = array();

    file_exists($cacheConfig->base_path.'article.xml') && $is_cache ? getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) : getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult, $is_cache);

    return $_arrResult;
}

/**
 *Action: ��XML�ļ���ȡ����
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       reference $_arrResult ��������
 *Output:
 *Create@2011-01-08Vpc:
 */
function getDataFromXML($dbConfig, $logConfig, $cacheConfig, &$_arrResult) {
    if((time()-fileMTime($cacheConfig->base_path.'article.xml'))>=$cacheConfig->base_timeout) {    //�ļ�������������´����ݿ��л�ȡ
        getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult);
    } else {    //���ļ��ж�ȡ����
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
 *Action: �����ݿ��ȡ����
 *Input: IncConfig $dbConfig ���ݿ�����
 *       IncConfig $logConfig ��־����
 *       IncConfig $cacheConfig ��������
 *       reference $_arrResult ��������
 *       bool $is_cache �Ƿ�������
 *Output:
 *Create@2011-01-07Vpc:
 */
function getDataFromSQL($dbConfig, $logConfig, $cacheConfig, &$_arrResult, $is_cache=true) {
    //ʵ�������ݿ���
    $objDB= Database::getDatebase('Mysqli');
    try {
        $objConn = $objDB->open($dbConfig);
    } catch(Exception $ex) {
         Loger::getLog($logConfig)->logger->error($ex);
         header("Location:/error.php");
    }
   //���12����¼
    $objDB->setQuery("SELECT `id`, `title`, `content`, `description`, `keywords`, FROM_UNIXTIME(`create_date`, '%Y-%m-%d %H:%i:%S') AS create_date FROM article ORDER BY RAND() LIMIT 0, 12");
    $objRs = $objDB->executeQuery($objConn);    //ִ�в�ѯ���
    while($row = $objDB->getArray($objRs)) {    //��ò�ѯ���
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

    $objDB->close($objConn);    //�ر����ݿ�����

    unSet($objConn);
    unSet($objDB);

    //��������ļ������xml
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