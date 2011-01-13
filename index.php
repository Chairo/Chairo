<?php
//加载配置文件
require('inc.config.php');

require('xml.php');
$_xml = new XML('<root><rows></rows></root>');

$_xml->createElement(new IncConfig(array (
  'name' => 'row',
  'value' => array(array('title'=>'t','descrption'=>'d'),array('title'=>'t','descrption'=>'d'),array('title'=>'t','descrption'=>'d')),
  'cdata' => '|,row,title,|',
  'obj' => $_xml->_obj,
  'parent' => $_xml->_obj->getElementsByTagName('rows')->item(0)
)));
print_r($_xml->_obj->saveXML());


print_r($_xml);
exit();


/*测试Cache
$cacheConfig = new IncConfig(array (
  'base_path' => WEB_DIR.'test/',
  'file_obj'=> new FileObject(),
  'base_timeout' => 60*30
));

$objCache = Cache::getCache();
$objCache->open($cacheConfig);
echo($objCache->set('test.xml', '23424234'));
echo($objCache->get('test.xml'));
//$objCache->flush('test.xml');
echo($objCache->flushAll());
var_dump($objCache);
debug_zval_dump($objCache);
*/

/*测试工厂类
$objCache = Cache::getCache();
$objCache->open($cacheConfig);
var_dump($objCache);
unSet($objCache);
$objCache = Cache::getCache('MemCache');
$objCache->open($cacheConfig2);
var_dump($objCache);
unSet($objCache);
*/

/*测试log
$objLog = Loger::getLog($logConfig);
$objLog->logger->error('444');
debug_zval_dump($objLog);
*/

//实例化数据库类
$objDB= Database::getDatebase('Mysqli');

//打开数据库连接
try {
    $objConn = $objDB->open($dbConfig);
} catch(Exception $ex) {
     Loger::getLog($logConfig)->logger->error($ex);
     exit($ex);
}

//*设置查询语句
$objDB->setQuery("CALL article_add ('Title', 'Content', 'Description','Keywords', @intResult, @strResult)");
//执行存储过程
$objDB->executeQuery($objConn);

$objDB->setQuery("SELECT @strResult, @intResult");
//获取存储过程返回值
$objRs = $objDB->executeQuery($objConn);
//获得查询结果
print_r($objDB->getArray($objRs));

$objDB->freeResult($objRs);
unSet($objRs);
//*/


//设置查询语句
$objDB->setQuery("SELECT * FROM article");
//执行查询语句
$objRs = $objDB->executeQuery($objConn);
//获得查询结果
while($row = $objDB->getArray($objRs)) {
    print_r($row);
}
unSet($objRs);

//关闭数据库连接
$objDB->close($objConn);


unSet($objConn);
unSet($objDB);