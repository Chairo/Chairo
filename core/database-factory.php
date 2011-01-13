<?php
/**
 *数据库操作工厂类
 *Create@2010-12-30Vpc:
 */

class DatabaseFactory {
    //数据库对象
    private static $_database;

    /**
     *Action: 实例化数据库对象
     *Input: string $dbType 数据库种类，默认Mysql
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public static function getDatebase($dbType = 'Mysql') {
        switch($dbType) {
            case 'Mysql':
                require_once('data/Mysql.php');
                if(null == self::$_database) {
                    self::$_database = new Datebase();
                }
                break;
            case 'Mysqli':
                require_once('data/Mysqli.php');
                if(null == self::$_database) {
                    self::$_database = new Datebase();
                }
                break;
        }
        return self::$_database;
    }
}