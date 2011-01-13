<?php
/**
 *远程文件操作类
 *Create@2010-12-30Vpc:
 */

require('getcontent-factory.php');

class Content {
    public static function getContent($gcType = 'FsockOpen') {
        $_gc = new GetContentFactory();
        return $_gc->getContent($gcType);
    }
}