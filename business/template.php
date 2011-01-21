<?php
/**
 *模板类
 *Create@2010-12-30Vpc: 1)Extend Smarty v3.0.6
 *Update@2011-01-12Vpc: 1)Change Smarty to Twig
 */

require_once 'Twig/Autoloader.php';
class Template {
    public $t;
    public function __construct(IncConfig $config) {
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem($config->template_dir);
        $this->t = new Twig_Environment($loader, array(
                                                 'cache' => $config->compile_dir,
                                                 'auto_reload' => true));
        $lexer = new Twig_Lexer($this->t, array(
            'tag_comment'  => array('{#', '#}'),    //注释
            'tag_block'    => array('{%', '%}'),    //tag
            'tag_variable' => array('{{', '}}'),    //变量
        ));
        $this->t->setLexer($lexer);
        $this->t->addExtension(new Twig_Extensions_Extension_Text());
        $this->t->addExtension(new Twig_Extensions_Extension_Page());
        $this->t->addExtension(new Twig_Extensions_Extension_Debug());
        return $this->t;
    }
}