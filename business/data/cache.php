<?php
/**
 *缓存类
 *Create@2010-12-30Vpc:
 */

require('cache-factory.php');

class Cache {
    public static function getCache($cacheType = 'XML') {
        $_cache = new CacheFactory();
        return $_cache->getCache($cacheType);
    }
}