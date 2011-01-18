<?php
require('io/xml.php');

class XML extends XMLOBJ {
    public function __construct($str = '<root/>') {
        parent::__construct($str);
    }
}