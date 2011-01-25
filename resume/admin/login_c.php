<?php
/**
 *登录验证页
 *Create@2011-01-24Vpc:
 */

//加载网站文件
require('../web.config.php');

includeFiles(array(
    'template.php',    //模板类
    'functions/resume/admin/login.php'    //登录验证
));

//获取页面传递数据
$user_name = noAnnotate(Post('txtUserName', ''));
$password = noAnnotate(Post('txtPassword', ''));

//数据库中获取密码
$_arr = login_c($dbConfig, $user_name);
$_password = count($_arr)>0 ? $_arr[0]['password'] : '';
$_id = count($_arr)>0 ? $_arr[0]['id'] : '0';

md5(enCrypt($password)) == $_password ? checkRight($_id) : exit(json_encode(array('id'=>'-1','message'=>'密码错误')));

function checkRight($dbConfig, $user_id) {
    $_result = array();
    $_db = Database::getDatebase('Mysqli');
    $_conn = $_db->open($dbConfig);
    $_db->setQuery("SELECT `id`, `password` FROM users WHERE `name` = '$name'");
    $_rs = $_db->executeQuery($_conn);
    while($row = $_db->getArray($_rs)) {
        $_result[] = array('id' => $row['id'],
                           'password' => $row['password']
                          );
    }
    $_db->close($_conn);
    unset($_conn);
    unset($_db);
    return $_result;
}