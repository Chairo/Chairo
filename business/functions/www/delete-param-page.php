<?php
function deleteParamPage(&$get){
    $_t=array();
    foreach($get as $k=>$v) {
        if($k !== 'page'){$_t[$k]=$v;}
    }
    $get = $_t;
    return $get;
}