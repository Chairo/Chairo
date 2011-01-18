<?php
/**
 *XML操作类
 *Create@2010-12-30Vpc:
 *Update@2011-01-07Vpc: 1)新增方法__construct, createElement, createElementFromString, createElementFromArray
 */

require('IXML.php');

class XMLOBJ implements IXML {
    public $_obj;

    public function __construct($str = '') {
        if($str != '') {
            return $this->load($str);
        }
    }

    public function load($str) {
        $this->_obj = new DOMDocument('1.0', 'utf-8');
        file_exists($str) ? $this->_obj->load($str) : $this->_obj->loadXML($str);
        return $this->_obj;
    }

    public function translate() {
    }

    public function createElement(IncConfig $config) {
        is_array($config->value) ? $this->createElementFromArray($config) : $this->createElementFromString($config);
    }

    /**
     *Action: 新建节点
     *Input: IncConfig $config 节点配置
     *Output:
     *Create@2011-01-07Vpc:
     */
    private function createElementFromString($config) {
        $_e = $config->obj->createElement($config->name);
        strPos($config->cdata, ','.$config->name.',') ? $_e->appendChild($config->obj->createCDATASection($config->value)) : $_e->appendChild($config->obj->createTextNode($config->value));
        $config->parent->appendChild($_e);
    }

    /**
     *Action: 新建节点
     *Input: IncConfig $config 节点配置
     *Output:
     *Create@2011-01-07Vpc:
     */
    private function createElementFromArray($config) {
        foreach($config->value as $_a) {
            $_e = $config->obj->createElement($config->name);
            foreach($_a as $k=>$v) {
                $_t = $config->obj->createElement($k);
                strPos($config->cdata, ','.$k.',') ? $_t->appendChild($config->obj->createCDATASection($v)) : $_t->appendChild($config->obj->createTextNode($v));
                $_e->appendChild($_t);
            }
            $config->parent->appendChild($_e);
        }
    }
}