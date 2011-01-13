<?php
/**
 *FsockOpen小偷类
 *Create@2010-12-30Vpc:
 */

require_once('IGetcontent.php');

class FskOpen implements IGetcontent {
    private $_data;

    public function open(IncConfig $config) {
        if('' == $config->method) {strToUpper($config->method) = 'GET';}
        if('' == $config->port) {$config->port = '80';}
        if('' == $config->url) {$config->url = '/';}
        if('' == $config->refer) {$config->refer = '';}
        $fp = fSockOpen($config->host, $config->port, $errno, $errstr, 10);
        $out = "$config->method $config->url HTTP/1.1\r\n";
        $out .= "Accept: image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, application/vnd.ms-powerpoint, application/vnd.ms-excel, application/msword, */*\r\n";
        if('POST' == strToUpper($config->method)) {$out .= "Content-Type: application/x-www-form-urlencoded\r\n";}
        $out .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)\r\n";
        $out .= "Host: $config->host\r\n";
        $out .= "Referer: $config->refer\r\n";
        $out .= "Connection: Close\r\n";
        if('POST' == strToUpper($config->method)) {$out .= "Content-Length: ".strLen($config->datas)."\r\n";}
        $out .= "Connection: Close\r\n";
        $out .= "\r\n";
        if('POST' == strToUpper($config->method)) {$out .= $config->datas;}
        fWrite($fp, $out);
        while(!fEof($fp)) {
            $this->_data .= fGets($fp, 128);
        }
        fClose($fp);
        return $this->_data;
    }

    public function getContentByRegular($strRegular, $strData = "") {
        $strData = ($strData === "") ? $this->_data : $strData;
        preg_match_all($strRegular, $strData, $_arr, PREG_PATTERN_ORDER);
        $strResult = (count($arr[1])!== 0) ? $_arr[1][0] : "Not find";
        return $strResult;
    }

    public function getContentByTag($strBegin, $strEnd, $strData = '') {
        $strData = ($strData == '') ? $this->_data : $strData;
        $_temp = strStr($strData, $strBegin);
        return(subStr($_temp, strLen($strBegin), strPos($_temp, $strEnd)-strLen($strBegin)));
    }
}