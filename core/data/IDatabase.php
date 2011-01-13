<?php
/**
 *数据库操作接口
 *Create@2010-12-30Vpc:
 */

interface IDatebase {

    /**
     *Action: 打开数据库连接
     *Input: IncConfig $config 配置
     *Output: resource
     *Create@2010-12-30Vpc:
     */
    public function open(IncConfig $config);

    /**
     *Action: 关闭数据库连接
     *Input: resource $handle 连接对象
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function close($handle = null);

    /**
     *Action: 设置需要执行的Sql语句
     *Input: string $strSql Sql语句
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function setQuery($strSql);

    /**
     *Action: 获取当前执行的Sql语句
     *Input:
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getQuery();

    /**
     *Action: 执行数据库查询
     *Input: resource $handle 数据库连接对象
     *Output: resource
     *Create@2010-12-30Vpc:
     */
    public function executeQuery($handle);

    /**
     *Action: 将数据查询的其中一行作为数组取出,其中字段名对应数组键值
     *Input: resource $resource 查询的资源数据
     *Output: array
     *Create@2010-12-30Vpc:
     */
    public function getArray($resource);

    /**
     *Action: 将数据查询的其中一行作为对象取出,其中字段名对应对象属性
     *Input: resource $resource 查询的资源数据
     *Output: object
     *Create@2010-12-30Vpc:
     */
    public function getObject($resource);

    /**
     *Action: 获取最后操作ID
     *Input:
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getLastID();

    /**
     *Action: 获取最后操作ID
     *Input:
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getTotalRow($resource);

    /**
     *Action: 获取字段详细信息
     *Input: resource $resource 查询的资源数据
     *Output: object
     *             name - 列名
     *             table - 该列所在的表名
     *             max_length - 该列最大长度
     *             not_null - 1，如果该列不能为 NULL
     *             primary_key - 1，如果该列是 primary key
     *             unique_key - 1，如果该列是 unique key
     *             multiple_key - 1，如果该列是 non-unique key
     *             numeric - 1，如果该列是 numeric
     *             blob - 1，如果该列是 BLOB
     *             type - 该列的类型
     *             unsigned - 1，如果该列是无符号数
     *             zerofill - 1，如果该列是 zero-filled
     *Create@2010-12-30Vpc:
     */
    public function getField($resource);

    /**
     *Action: 显示执行错误
     *Input: string $strError 错误内容
     *Output:
     *Create@2010-12-30Vpc:
     */
    public function displayError($strError);
}