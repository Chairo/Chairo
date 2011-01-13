<?php
/**
 *缓存工厂类
 *Create@2010-12-30Vpc:
 */

class CacheFactory {
    private $_cache;

    /**
     *Action: 实例化缓存对象
     *Input: string $cacheType 缓存种类，默认XML
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public function getCache($cacheType = 'XML') {
        switch($cacheType) {
            case 'XML':
                require_once('cache/XmlCache.php');
                $this->_cache = new XmlCache();
                break;
            case 'MemCache':
                require_once('cache/MmCache.php');
                $this->_cache = new MmCache();
                break;
        }
        return $this->_cache;
    }
}