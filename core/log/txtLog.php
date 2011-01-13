<?php
/**
 *日志操作类(log4php实现方案)
 *Create@2010-12-30Vpc:
 */

require('ILog.php');
require("log4php/Logger.php");

class Logor implements ILog {

    public $logger;

    public function __construct(IncConfig $config) {
        Logger::configure($config->log4phpproperties);
        $this->logger = @Logger::getLogger();
    }

    public function add($msg) {}
    public function getAll() {}
    public function getByConstraints() {}
}