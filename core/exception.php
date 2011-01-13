<?php
/**
 *异常类
 *Create@2010-12-30Vpc:
 */

class PubException extends Exception {
    public function __construct($message, $code = 0) {
        //赋值给父类
        parent::__construct($message, $code);
    }

    /**
     *Action: 魔术函数返回异常信息
     *Input:
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function __toString() {
        return "File:$this->file\n Line:$this->line\n Code:$this->code\n Message:$this->message";
    }
}