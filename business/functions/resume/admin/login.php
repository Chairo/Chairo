<?php
/**
 *Action: 根据用户名获取对应密码
 *Input: IncConfig $dbConfig 数据库配置
 *       string $name 用户名
 *Output: array
 *Create@2011-01-24Vpc:
 */
function login_c($dbConfig, $name='') {
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