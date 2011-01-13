<?php
/**
 *Mysql数据库操作类(Mysqli)
 *Create@2010-12-30Vpc:
 */

require('IDatabase.php');

class Datebase implements IDatebase {

    private $_dbLink;    //数据库连接字符串标示
    private $_sql;    //查询Sql
    private $_dbPrefix;    //表前缀

    public function open(IncConfig $config) {
        if($this->_dbLink = @mysqli_connect($config->host, $config->user, $config->password, $config->database)) {

            if($config->charset) {
                mysqli_query($this->_dbLink, "SET NAMES $config->charset");
            }
            $this->_dbPrefix = $config->prefix;
            return $this->_dbLink;
        }

        throw new PubException('Can\'t connect datebase');
    }

    public function close($handle = null) {
        is_null($handle) ? mysqli_close($this->_dbLink) : mysqli_close($handle);
    }

    public function setQuery($strSql) {
        $prefix="#@__";
        $sql = trim($strSql);
        $inQuote = false;
        $escaped = False;
        $quoteChar = '';
        $n = strLen($strSql);
        $np = strLen($prefix);
        $restr = '';
        for($j=0; $j < $n; $j++) {
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
        		} else if($c == "\\" && !$escaped) {
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

    public function executeQuery($handle)
    {
        if($resource = @mysqli_query($handle, $this->_sql)) {
            return $resource;
        }
        throw new PubException("Execute Query False!$this->_sql");
    }

    public function getArray($resource) {
        return mysqli_fetch_assoc($resource);
    }

    public function freeResult($resource) {
        mysqli_free_result($resource);
    }

    public function getObject($resource) {
        return mysqli_fetch_object($resource);
    }

    public function getLastID() {
        $rs = mysqli_query($this->_dbLink, "SELECT LAST_INSERT_ID() AS lid");
        $row = mysqli_fetch_array($rs);
        return $row["lid"];
    }

    public function getTotalRow($resource) {
        return mysqli_num_rows($resource);
    }

    public function getField($resource) {
        return mysqli_fetch_field($resource);
    }

    public function displayError($strError) {
        exit($strError);
    }
}