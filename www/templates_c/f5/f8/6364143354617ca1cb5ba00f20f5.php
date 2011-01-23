<?php

/* base.twig */
class __TwigTemplate_f5f86364143354617ca1cb5ba00f20f5 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        $context['funcs'] = $this->env->loadTemplate("functions.twig", true);
        echo " ";
        // line 2
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>";
        // line 6
        echo twig_escape_filter($this->env, $this->renderBlock("web_title", $context, $blocks), "html");
        echo "</title>
";
        // line 7
        echo twig_escape_filter($this->env, $this->renderBlock("meta", $context, $blocks), "html");
        echo " ";
        // line 8
        echo twig_escape_filter($this->env, $this->renderBlock("style", $context, $blocks), "html");
        echo " ";
        // line 9
        echo "</head>
<body>
";
        // line 11
        ob_start();
        // line 13
        $this->env->loadTemplate("header.twig")->display(array_merge($context, (isset($context['CONFIG']) ? $context['CONFIG'] : null)));
        echo " ";
        // line 16
        echo "<div id=\"main\" class=\"center clearfix\">
";
        // line 17
        echo twig_escape_filter($this->env, $this->renderBlock("content", $context, $blocks), "html");
        echo " ";
        // line 18
        echo "</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 22
        $this->env->loadTemplate("footer.twig")->display(array_merge($context, (isset($context['CONFIG']) ? $context['CONFIG'] : null)));
        echo " ";
        // line 24
        echo twig_escape_filter($this->env, $this->renderBlock("script", $context, $blocks), "html");
        echo " ";
        // line 25
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "base.twig";
    }
}
