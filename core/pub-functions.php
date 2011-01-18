<?php
/**
 *Action: 包含文件
 *Input: array $files 文件名称
 *Output:
 *Create@2010-12-30Vpc
 */
function includeFiles($files) {
    foreach($files as $file) {
        require_once($file);
    }
}

/**
 *Action: 输入内容检查
 *Input: string $str 要检查内容
 *       string $quotes all:全部替换;double:替换双引号;single:替换单引号;none:不替换
 *Output: string
 *Create@2010-12-30Vpc
 */
function inputCheck(&$str, $quotes = 'all') {
    $str= strIpslashes($str);
    //replace only one '&' or behind '&' is not '#' and 1-8 charactesr or numbers(not between 1-4) and ';'
	$str = preg_replace('/&(?:$|([^#])(?![a-z1-4]{1,8};))/', '&#038;$1', $str);
	$str = str_replace('&&', '&#038;&', $str);
	$str = str_replace('&&', '&#038;&', $str);
    switch ($quotes) {
        case 'double':
			$str = str_replace('"', '&#034;', $str);
            break;
        case 'single':
			$str = str_replace("'", '&#039;', $str);
            break;
        case 'none':
            break;
        default:
            $str = str_replace('"', '&#034;', $str);
            $str = str_replace('\'', '&#039;', $str);
            break;
    }
    $str = str_replace('|', '&#124;', $str);
    $str = str_replace('\\', '&#092;', $str);
    return $str;
}

/**
 *Action: 过滤数据库注入危险字符
 *Input: string $str 要检查的内容
 *Output: string
 *Create@2010-12-30Vpc
 */
function noAnnotate(&$str) {
    $str = str_replace('--', '&#045;-', $str);
    $str = str_replace(' ', '&nbsp;', $str);
    $str = str_replace('#', '&#035;', $str);
    $str = str_replace('/*', '&#047;&#042;', $str);
    return $str;
}

/**
 *Action: 过滤域名
 *Input: string $str 要过滤的域名
 *Output: string
 *Create@2010-12-30Vpc
 */
function formatUrl(&$str) {
    $str = preg_replace('/[^a-z0-9_-]/i', '', strToLower($str));
    return $str;
}

/**
 *Action: 过滤非数字
 *Input: string $str 要过滤的字符串
 *Output: string
 *Create@2010-12-30Vpc
 */
function formatNumber(&$str) {
    $str = preg_replace('/[^0-9]/i', '', $str);
    return $str;
}

/**
 *Action: 格式化日期为YYYY-MM-DD H-M-S格式
 *Input: string $mktime 要格式化的日期时间戳
 *Output: string
 *Create@2010-12-30Vpc
 */
function getDateTimeMk(&$mktime) {
    $mktime = ($mktime == '' || eReg('[^0-9]', $mktime)) ? '' : strfTime('%Y-%m-%d %H:%M:%S', $mktime);
    return $mktime;
}

/**
 *Action: 格式化日期为YYYY-MM-DD格式
 *Input: string $mktime 要格式化的日期时间戳
 *Output: string
 *Create@2010-12-30Vpc
 */
function getDateMk(&$mktime) {
    $mktime = ($mktime == '' || eReg('[^0-9]', $mktime)) ? '' : strfTime('%Y-%m-%d', $mktime);
    return $mktime;
}

/**
 *Action: 格式化日期为H-M-S格式
 *Input: string $mktime 要格式化的日期时间戳
 *Output: string
 *Create@2010-12-30Vpc
 */
function getimeMk(&$mktime) {
    $mktime = ($mktime == '' || eReg('[^0-9]', $mktime)) ? '' : strfTime('%H:%M:%S', $mktime);
    return $mktime;
}

/**
 *Action: 格式化日期为时间戳
 *Input: string $mktime 要格式化的日期(YYYY-MM-DD格式)
 *Output: int
 *Create@2010-12-30Vpc
 */
function getMkTime(&$dtime) {
    if(!eReg('[^0-9]',$dtime)) return $dtime;
    $dt = array(1970, 1, 1, 0, 0, 0);
    $dtime = ereg_replace('[\r\n\t]|日|秒', ' ', $dtime);
    $dtime = str_replace('年', '-', $dtime);
    $dtime = str_replace('月', '-', $dtime);
    $dtime = str_replace('时', ':', $dtime);
    $dtime = str_replace('分', ':', $dtime);
    $dtime = trim(ereg_replace('[ ]{1,}', ' ', $dtime));
    $ds = explode(' ', $dtime);
    $ymd = explode('-', $ds[0]);
    if(isset($ymd[0])) $dt[0] = $ymd[0];
    if(isset($ymd[1])) $dt[1] = $ymd[1];
    if(isset($ymd[2])) $dt[2] = $ymd[2];
    if(strlen($dt[0])==2) $dt[0] = '20'.$dt[0];
    if(isset($ds[1])) {
        $hms = explode(':', $ds[1]);
        if(isset($hms[0])) $dt[3] = $hms[0];
        if(isset($hms[1])) $dt[4] = $hms[1];
        if(isset($hms[2])) $dt[5] = $hms[2];
    }
    foreach($dt as $k=>$v) {
      $v = ereg_replace('^0{1,}', '', trim($v));
      if($v == '') $dt[$k] = 0;
    }
    $mt = @mkTime($dt[3], $dt[4], $dt[5], $dt[1], $dt[2], $dt[0]);
    $dtime = $mt>0 ? $mt : time();
    return $dtime;
}

/**
 *Action: 获取浏览者IP
 *Input:
 *Output: string
 *Create@2010-12-30Vpc
 */
function getIP() {
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
        $_remoteIP = $_SERVER['HTTP_CLIENT_IP'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $_remoteIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (!empty($_SERVER['REMOTE_ADDR']))
        $_remoteIP = $_SERVER['REMOTE_ADDR'];
    return isIP($_remoteIP) ? $_remoteIP : 'Can\'t get!';
}

/**
 *Action: 是否一个IP地址
 *Input: string $str ip地址
 *Output: bool
 *Create@2010-12-30Vpc
 */
function isIP($str) {
    return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
}

/**
 *Action: IP地址转换成数字
 *Input: string $ip ip地址
 *Output: int
 *Create@2010-12-30Vpc
 */
function ip2Number(&$ip) {
    $_ipArray = explode(".", $ip);
    $int = ($_ipArray[0] << 24) | ($_ipArray[1] << 16) | ($_ipArray[2] << 8) | $_ipArray[3];
    if($int < 0) $int+=4294967296;
    $ip = $int;
    return $ip;
}

/**
 *Action: 数字转换成IP地址
 *Input: int $int ip地址
 *Output: string
 *Create@2010-12-30Vpc
 */
function number2Ip(&$int) {
    if($int>2147483647){$int = $int-4294967296;}
    $xor = array(0x000000ff, 0x0000ff00, 0x00ff0000, 0xff000000);
    for($i=0; $i<4; $i++) {
        ${"b".$i} = ($int & $xor[$i]) >> ($i*8);
        if(${"b".$i} < 0) ${"b".$i} += 256;
    }
    $int = "$b3.$b2.$b1.$b0";
    return $int;
}

/**
 *Action: 检查email格式
 *Input: int $str email
 *Output: bool
 *Create@2010-12-30Vpc
 */
function isEmail($str) {
	return preg_match('/^[_\.0-9a-z-]+@([0-9a-z-]+\.)+[a-z]{2,5}$/', $str);
}

/**
 *Action: 检查Website格式
 *Input: int $str Website
 *Output: bool
 *Create@2010-12-30Vpc
 */
function isWebsite($str) {
    return preg_match('/[\w-]+\.+[a-z]{2,5}$/', $str);
}

/**
 *Action: 获取当前url
 *Input:
 *Output: string
 *Create@2010-12-30Vpc
 */
function getCurUrl() {
    if(!empty($_SERVER['REQUEST_URI'])) {
        $scriptName = $_SERVER['REQUEST_URI'];
        $currentlyurl = $scriptName;
    } else {
        $scriptName = $_SERVER['PHP_SELF'];
        if($_SERVER['QUERY_STRING']=='') {
            $currentlyurl = $scriptName;
        } else {
            $currentlyurl = $scriptName.'?'.$_SERVER['QUERY_STRING'];
        }
    }
    return $currentlyurl;
}

/**
 *Action: 生成随机数
 *Input: int $length 生成随机数长度
 *       int $kind 生成的随机数类型
 *                 1:全部是数字;2:全部是小写字母;3:全部是大写字母;4:小写字母和数字组合;
 *                 5:大写字母和数字组合;6:大小写字母组合;7:大小写字母和数字组合;
 *Output: string
 *Create@2010-12-30Vpc
 */
function randCode($length=6, $kind=7) {
    $RandCode = '';
    $ArrLower = explode(',', 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z');
    $ArrCpita = explode(',', 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z');
    $ArrNumb = explode(',', '0,1,2,3,4,5,6,7,8,9');
    switch($kind) {
        case 1:
            $ArrSeed = $ArrNumb;
            $Longth = 9;
        break;
        case 2:
            $ArrSeed = $ArrLower;
            $Longth = 25;
        break;
        case 3:
            $ArrSeed = $ArrCpita;
            $Longth = 25;
        break;
        case 4:
            $ArrSeed = array_merge($ArrNumb, $ArrLower);
            $Longth = 35;
        break;
        case 5:
            $ArrSeed = array_merge($ArrNumb, $ArrCpita);
            $Longth = 35;
        break;
        case 6:
            $ArrSeed = array_merge($ArrLower, $ArrCpita);
            $Longth = 51;
        break;
        case 7:
            $ArrSeed = array_merge($ArrNumb, $ArrLower, $ArrCpita);
            $Longth = 61;
        break;
    }
    for($i=0; $i<$length; $i++) {
        $RandCode .= $ArrSeed[rand(0, $Longth)];
    }
    return $RandCode;
}

/**
 *Action: 截取UTF-8中文字符串
 *Input: string $str 要截取的字符串
 *       int $len 截取长度
 *Output: string
 *Create@2010-12-30Vpc
 */
function cutStr($str, $len) {
    $returnstr = '';
    $i = 0;
    $n = 0;
    //Count of the string
    $str_length = strLen($str);
    while(($n < $len) and ($i <= $str_length)) {
        $temp_str=subStr($str, $i, 1);
        // Get the $i letter's ascii number
        $ascnum=ord($temp_str);

        if($ascnum >= 224) {    //If the ascii number bigger than 224
            //Make 3 consecutive letter as one(because it's code is UTF-8)
             $returnstr = $returnstr.subStr($str, $i, 3);
             $i = $i+3;
             //Letter's amount+1
             $n++;
        } elseif($ascnum >= 192) {    //If the ascii number bigger than 192，
            //Make 2 consecutive letter as one(because it's code is UTF-8)
            $returnstr=$returnstr.subStr($str, $i, 2);
            $i = $i+2;
            //Letter's amount+1
            $n++;
        } elseif($ascnum>=65 && $ascnum<=90) {    //If it's capital letter
            $returnstr = $returnstr.subStr($str, $i, 1);
            $i = $i+1;
            //Letter's amount+1
            $n++;
        } else {    //Others
            $returnstr = $returnstr.subStr($str, $i, 1);
            $i = $i+1;
            //Letter's amount+1
            $n++;
        }
    }
    if($str_length>$len) {
        //If the string is longer than you need put the ellipsis at the end
        $returnstr = $returnstr;
    }
    return $returnstr;
}

/**
 *Action: Cookie
 *Input: string $name Cookie名称
 *       string $value 值
 *       int $expire 过期时间
 *       string $expireType 过期时间类型 (day,hour,minute,second)
 *       string $path Cookie path
 *Output:
 *Create@2010-12-30Vpc
 */
function addCookies($name = '', $value = '', $expire = 0, $expireType = 'day', $path = '/') {
    switch($expireType) {
        case 'day': $expire = $expire*60*60*24; break;
        case 'hour': $expire = $expire*60*60; break;
        case 'minute': $expire = $expire*60; break;
    }
    setCookie($name, enCrypt($value), time()+$expire, $path);
}

/**
 *Action: 字符串to十六进制格式
 *Input: string $str 转换的字符串
 *Output: string
 *Create@2010-12-30Vpc
 */
function strToHex(&$str) {
    $strTemp = '';
    for($i=0; $i<strLen($str); $i++) {
        $strTemp .= base_convert(ord($str[$i]), 10, 16);
    }
    $str = '0x'.$strTemp;
    return $str;
}

/**
 *Action: 加密解密
 *Input: string $str 要加密/解密的字符串
 *Output: string
 *Create@2010-12-30Vpc
 */
function enCrypt(&$str) {
    $key = 'WXH@3FT*WFW`9T(]Z8+S@B8=#Q2$F2?ES>OGD\22_J8DJ0*X_KNM#-?N7:K`0K.F0SR,NX..]
    <\&3T]OAXS5JVZ5]:0M])#C%.ZN,-3]L.R\'L6.D84C-R142Q`*J*;G@-\4S5I+F&1$)2FC8@-(VT.5FLDA:/
    5F=B4&ZE$?)`WVM<6G/RUIT+?G5I5C>EGJ=_D;G7*ZE<699E8&)*A5H.WV@@D99G&=A?^?;$P(^/ZRK)
    >F)?A3T9*K*-D+LP@GLYX:W$HN93Y0)>;T0M(MZ\'&O4GG%Z:JT`*A6@RD;SCEW0`^;AMFN=N>N_L^
    /E]7M@*,>TK6U2Y/VE,]#^;1@\M&114]S.U5]-R)[9\'OJT1(6J8*6JN6-\;L`(8U]8<9/(^KYM>CA@AB?`^
    3]EB+]^4(HGRWWD+5)3I&A6.A&5EQ<,;-EQP^\FN(RP?8K5;X8QJI[SL>_48\'7K\'HU35\'63)=)F7FA-HWE
    E]H4G7+Z@RS;$<8;*\'R1GY[5+3UDK';
    $_result = '';

    $keyChr = ord(subStr($key, 1, StrLen($str)));

    for($i = 0; $i<strLen($str); $i ++) {
        $encryptChr = ord(subStr($str, $i, 1));
        $xor = $keyChr ^ $encryptChr;
        $_result .= chr($xor);
    }
    $str = $_result;

    return $str;
}

/**
 *Action: 获取$_GET内容
 *Input: string $str 要获取的key
 *       string $value key对应的值
 *Output: string
 *Create@2010-12-30Vpc
 */
function get($str, $value = '') {
    return isSet($_GET[$str]) ? $_GET[$str] : $value;
}

/**
 *Action: 获取$_POST内容
 *Input: string $str 要获取的key
 *       string $value key对应的值
 *Output: string
 *Create@2010-12-30Vpc
 */
function post($str, $value = '') {
    return isSet($_POST[$str]) ? $_POST[$str] : $value;
}

/**
 *Action: 获取$_COOKIE内容
 *Input: string $str 要获取的key
 *       string $value key对应的值
 *Output: string
 *Create@2010-12-30Vpc
 */
function cookie($str, $value = '') {
    return isSet($_COOKIE[$str]) ? $_COOKIE[$str] : $value;
}

/**
 *Action: 获取$_SESSION内容
 *Input: string $str 要获取的key
 *       string $value key对应的值
 *Output: string
 *Create@2010-12-30Vpc
 */
function session($str, $value = '') {
    return isSet($_SESSION[$str]) ? $_SESSION[$str] : $value;
}