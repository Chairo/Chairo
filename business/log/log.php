<?php
/**
 *日志类
 *Create@2010-12-30Vpc:
 */

require('log-factory.php');

class Loger {
    public static function getLog(IncConfig $config) {
        return LogFactory::getLog($config);
    }
}