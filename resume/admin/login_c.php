<?php
/**
 *��¼��֤ҳ
 *Create@2011-01-24Vpc:
 */

//������վ�ļ�
require('../web.config.php');

includeFiles(array(
    'template.php',    //ģ����
    'functions/resume/admin/login.php'    //��¼��֤
));

//��ȡҳ�洫������
$user_name = noAnnotate(Post('txtUserName', ''));
$password = noAnnotate(Post('txtPassword', ''));

//���ݿ��л�ȡ����
$_arr = login_c($dbConfig, $user_name);
$_password = count($_arr)>0 ? $_arr[0]['password'] : '';
$_id = count($_arr)>0 ? $_arr[0]['id'] : '0';

if(md5(enCrypt($password)) == $_password) {
    var_dump($_id); //��¼�ɹ�����Ҫ�ж�Ȩ��
} else {
    echo('not pass');
}