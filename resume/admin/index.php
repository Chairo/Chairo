<?php
/**
 *登录页
 *Create@2011-01-19Vpc:
 */

//加载网站文件
require('../web.config.php');

includeFiles(array(
    'template.php',    //模板类
    'xml.php'    //XML操作类
));

$twig = new Template($webTempConfig);
$template = $twig->t->loadTemplate('admin/index.twig');
$template->display(array('CONFIG' => $config
                        )
                  );
ob_end_flush();