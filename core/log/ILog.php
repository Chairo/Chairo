<?php
/**
 *日志接口
 *Create@2010-12-30Vpc:
 */

interface ILog {

    /**
     *Action: 添加log
     *Input: string $msg 需记录的log内容
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function add($msg);

    /**
     *Action: 获取所有log
     *Input:
     *Output: resource
     *Create@2010-12-30Vpc:
     */
    public function getAll();

    /**
     *Action: 根据条件获取log
     *Input:
     *Output: resource
     *Create@2010-12-30Vpc:
     */
    public function getByConstraints();
}