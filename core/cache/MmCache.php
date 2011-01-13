<?php
/**
 *MemCache缓存
 *Create@2010-12-30Vpc:
 */

require_once('ICache.php');

class MmCache implements ICache {
    private static $_memCache;

    public function __construct() {
        $this->_memCache = new Memcache();
    }

    public function open(IncConfig $config) {
        $this->_memCache->connect($config->base_host, $config->base_port, $config->base_timeout);
    }

    public function set($key, $value, $flag=null, $expire=0) {
        $this->_memCache->set($key, $value, $flag, $expire);
    }

    public function get($key) {
        return $this->_memCache->get($key);
    }

    public function flush($key) {
        $this->_memCache->delete($key);
    }

    public function flushAll() {
        $this->_memCache->flush();
    }
}