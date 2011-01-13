<?php
/**
 *日志操作工厂类
 *Create@2010-12-30Vpc:
 */

class LogFactory {
    //日志对象
    private static $_log;

    /**
     *Action: 实例化对象
     *Input: IncConfig $config Array 日志配置信息
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public static function getLog(IncConfig $config) {
        switch($config->type) {
            case 'txt':
                require_once('log/txtLog.php');
                if(null == self::$_log) {
                    self::$_log = new Logor($config);
                }
                break;
        }
        return self::$_log;
    }
}