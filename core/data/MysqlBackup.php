<?php
/**
 *数据库备份类
 *Create@2010-12-30Vpc:
 */

require('IBackup.php');

class MysqlBackup implements IBackup {
    private $_conn;    //数据库连接串
    private $_maxCountPerFile;    //单文件最大数据条数
    private $_fileSavePath;    //文件保存目录
    private $_config;

    public function open(IncConfig $config) {
        $this->_conn = $config->db;
        $this->_maxCountPerFile = $config->max_count_per_file;
        $this->_fileSavePath = $config->file_save_path
    }

    public function getTables($handle) {
        $_tables = array();
        $this->_conn->setQuery('SHOW TABLES');
        $_rs = $this->_conn->executeQuery($_conn);
        while($row = $this->_conn->getArray($_rs)) {
            $_tables[] = $row;
        }
        return $_tables;
    }

    public function getCreateTableSql($handle, $tableName) {
        $_sql = "DROP TABLE IF EXISTS $tableName; \r\n";
        "SHOW CREATE TABLE $tableName;"
    }

    public function getCreateIndexSql($handle, $tableName) {
    }

    public function getDataFromTable($handle, $tableName, $maxCountPerFile) {
    }
}