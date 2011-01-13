<?php
/**
 *获得远程页面数据工厂类
 *Create@2010-12-30Vpc:
 */

class GetContentFactory {
    //数据对象
    private $_getContent;

    /**
     *Action: 实例化对象
     *Input: string $gcType 获取数据方式，默认FsockOpen
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public function getContent($gcType = 'FsockOpen') {
        switch($gcType) {
            case 'FsockOpen':
               require_once('data/FskOpen.php');
               $this->_getContent = new FskOpen();
               break;
        }
        return $this->_getContent;
    }
}