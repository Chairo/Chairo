<?php
/**
 *��¼ҳ
 *Create@2011-01-19Vpc:
 */

//������վ�ļ�
require('../web.config.php');

includeFiles(array(
    'template.php',    //ģ����
    'xml.php'    //XML������
));

$twig = new Template($webTempConfig);
$template = $twig->t->loadTemplate('admin/index.twig');
$template->display(array('CONFIG' => $config
                        )
                  );
ob_end_flush();