<?php

/* functions.twig */
class __TwigTemplate_330ff3a216776bdfffdf23b23133f002 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

    }

    // line 1
    public function geturl($id = null)
    {
        $context = array_merge($this->env->getGlobals(), array(
            "id" => $id,
        ));

        ob_start();
        echo "article.php?id=";
        echo twig_escape_filter($this->env, (isset($context['id']) ? $context['id'] : null), "html");

        return ob_get_clean();
    }

    public function getTemplateName()
    {
        return "functions.twig";
    }
}
