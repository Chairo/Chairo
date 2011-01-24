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

if(md5(enCrypt($password)) == $_password) {
    var_dump($_id); //登录成功，需要判断权限
} else {
    echo('not pass');
}