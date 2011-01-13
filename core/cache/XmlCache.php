<?php
/**
 *XML缓存(需要FileObject类)
 *Create@2010-12-30Vpc:
 *Update@2011-01-07Vpc:1)set方法更新expire参数
 */

require_once('ICache.php');

class XmlCache implements ICache {
    private static $_basePath;
    private $_fileName;
    private $_file;

    public function open(IncConfig $config) {
        $this->_basePath = $config->base_path;
        if(is_object($config->file_obj)) {
            $this->_file = $config->file_obj;
            return;
        }
        throw new PubException('Need FileObject');
    }

    public function set($key, $value, $flag=null, $expire=315360000) {
        if(!file_exists($this->_basePath.$key)) {
            $this->_file->createFile($this->_basePath.$key, $value);
        } elseif((time()-fileMTime($this->_basePath.$key))>=$expire) {
            $this->_file->updateContent($this->_basePath.$key, $value);
        }
    }

    public function get($key) {
        return $this->_file->readContent($this->_basePath.$key);
    }

    public function flush($key) {
        return $this->_file->deleteFile($this->_basePath.$key);
    }

    public function flushAll() {
        return $this->_file->reNameDirectory($this->_basePath, cutStr($this->_basePath, strLen($this->_basePath)-1).'_'.getDateMk(Time()).randCode(4, 7).'.bak');
    }
}