<?php
/**
 *配置类
 *Create@2010-12-30Vpc:
 */

class IncConfig {

    private $_currentConfig = array();

    public function __construct($config = array()) {
        $this->setDefault($config);
    }

    /**
     *Action: 初始化参数
     *Input: array/string $config 配置参数
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function setDefault($config) {
        is_string($config) ? parse_str($config, $params) : $params = $config;    //初始化参数

        //设置默认参数
        foreach($params as $name=>$value) {
            if(!array_key_exists($name, $this->_currentConfig)) {
                $this->_currentConfig[$name] = $value;
            }
        }
    }

    /**
     *Action: 魔术函数获取一个配置值
     *Input: string $name 配置名称
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function __get($name) {
        return isset($this->_currentConfig[$name]) ? $this->_currentConfig[$name] : null;
    }

    /**
     *Action: 魔术函数设置一个配置值
     *Input: string $name 配置名称
     *       string $value 配置值
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function __set($name, $value) {
        $this->_currentConfig[$name] = $value;
    }

    /**
     *Action: 直接输出默认配置值
     *Input: string $name 配置名称
     *       array $args 参数
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function __call($name, $args) {
        echo $this->_currentConfig[$name];
    }

    /**
     *Action: 判断当前配置值是否存在
     *Input: string $name 配置名称
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function __isSet($name) {
        return isset($this->_currentConfig[$name]);
    }

    /**
     *Action: 魔术方法,打印当前配置数组
     *Input:
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function __toString() {
        return serialize($this->_currentConfig);
    }
}