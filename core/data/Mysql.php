<?php
/**
 *Mysql数据库操作类(Mysql)
 *Create@2010-12-30Vpc:
 */

require('IDatabase.php');

class Datebase implements IDatebase {

    private $_dbLink;    //数据库连接字符串标示
    private $_sql;    //查询Sql
    private $_dbPrefix;    //表前缀

    public function open(IncConfig $config) {
        if($this->_dbLink = @mysql_connect($config->host . ':' . $config->port, $config->user, $config->password)) {
            if(@mysql_select_db($config->database, $this->_dbLink)) {
                if($config->charset) {
                    mysql_query("SET NAMES $config->charset", $this->_dbLink);
                }
                $this->_dbPrefix = $config->prefix;
                return $this->_dbLink;
            }
        }

        throw new PubException('Can\'t connect datebase');
    }

    public function close($handle = null) {
        is_null($handle) ? mysql_close($this->_dbLink) : mysql_close($handle);
    }

    public function setQuery($strSql) {
        $prefix="#@__";
        $sql = trim($strSql);
        $inQuote = false;
        $escaped = false;
        $quoteChar = '';
        $n = strLen($strSql);
        $np = strLen($prefix);
        $restr = '';
        for($j=0; $j<$n; $j++) {
        	$c = $strSql{$j};
        	$test = subStr($strSql, $j, $np);
        	if(!$inQuote) {
        		if($c == '"' || $c == "'") {
        			$inQuote = true;
        			$escaped = false;
        			$quoteChar = $c;
        		}
        	} else {
        		if($c == $quoteChar && !$escaped) {
        			$inQuote = false;
        		} else if ($c == "\\" && !$escaped) {
        			$escaped = true;
        		} else {
        			$escaped = false;
        		}
        	}
        	if($test == $prefix && !$inQuote) {
        	    $restr .= $this->_dbPrefix;
        	    $j += $np-1;
        	} else {
        		$restr .= $c;
        	}
        }
        $this->_sql = $restr;
    }

    public function getQuery() {
        return $this->_sql;
    }

    public function executeQuery($handle) {
        if($resource = @mysql_query($this->_sql, $handle)) {
            return $resource;
        }
        throw new PubException("Execute Query False!$this->_sql");
    }

    public function getArray($resource) {
        return mysql_fetch_assoc($resource);
    }

    public function getObject($resource) {
        return mysql_fetch_object($resource);
    }

    public function getLastID() {
        $rs = mysql_query("SELECT LAST_INSERT_ID() AS lid", $this->_dbLink);
        $row = mysql_fetch_array($rs);
        return $row["lid"];
    }

    public function getTotalRow($resource) {
        return mysql_num_rows($resource);
    }

    public function getField($resource) {
        return mysql_fetch_field($resource);
    }

    public function displayError($strError) {
        exit($strError);
    }
}