<?php
/**
 *数据库备份接口
 *Create@2010-12-30Vpc:
 */

interface IBackup {

    /**
     *Action: 设置文件保存目录,单文件最大数据条数等
     *Input: IncConfig $config 配置
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function open(IncConfig $config);

    /**
     *Action: 返回库中表名
     *Input: resource $handle 数据库连接对象
     *Output: array
     *Create@2010-12-30Vpc:
     */
    public function getTables($handle);

    /**
     *Action: 返回库建表语句
     *Input: resource $handle 数据库连接对象
     *       string $tableName 表名
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function getCreateTableSql($handle, $tableName);

    /**
     *Action: 返回创建索引语句
     *Input: resource $handle 数据库连接对象
     *       string $tableName 表名
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function getCreateIndexSql($handle, $tableName);

    /**
     *Action: 返回创建索引语句
     *Input: resource $handle 数据库连接对象
     *       string $tableName 表名
     *       int $maxCountPerFile 每个文件最多数据条数
     *Output:bool
     *Create@2010-12-30Vpc:
     */
    public function getDataFromTable($handle, $tableName, $maxCountPerFile);
}