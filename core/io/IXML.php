<?php
/**
 *XML操作接口
 *Create@2010-12-30Vpc:
 */

interface IXML {
    /**
     *Action: 加载XML
     *Input: string $str 文件物理路径或者文件内容
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public function load($str);

    public function translate();

    /**
     *Action: 创建节点
     *Input: IncConfig $config 节点内容(name value attribute type)
     *Output: object
     *Create@2010-12-30Vpc:
     */
     public function createElement(IncConfig $config);
}