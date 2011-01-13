<?php
/**
 *缓存接口
 *Create@2010-12-30Vpc:
 */

interface ICache
{
    /**
     *Action: 初始化参数
     *Input: IncConfig $config 缓存配置
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function open(IncConfig $config);

    /**
     *Action: 缓存文件
     *Input: string $key 缓存文件路径/文件名
     *       string $value 缓存文件内容
     *       MEMCACHE_COMPRESSED $flag 压缩缓存文件(memcache使用MEMCACHE_COMPRESSED)
     *       int $expire=0 过期时间(秒)
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function set($key, $value, $flag=null, $expire=0);

    /**
     *Action: 获取缓存的文件
     *Input: string $key 缓存文件路径/文件名
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function get($key);

    /**
     *Action: 删除缓存,释放空间
     *Input: string $key 缓存文件路径/文件名
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function flush($key);

    /**
     *Action: 删除所有缓存,释放空间
     *Input:
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function flushAll();
}