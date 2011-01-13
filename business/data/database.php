<?php
/**
 *数据库操作类
 *Create@2010-12-30Vpc:
*/

require('database-factory.php');

class Database {
    public static function getDatebase($dbType = 'Mysql') {
        return DatabaseFactory::getDatebase($dbType);
    }
}