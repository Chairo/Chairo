<?php

/* style.twig */
class __TwigTemplate_1915b932bada9ffd96d29119077b1e4d extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_css_url", array(), "any", false, 1), "html");
        echo "reset.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_css_url", array(), "any", false, 2), "html");
        echo "layout.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_css_url", array(), "any", false, 3), "html");
        echo "global.css\" type=\"text/css\" />
<link rel=\"shortcut icon\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_url", array(), "any", false, 4), "html");
        echo "favicon.ico\" />";
    }

    public function getTemplateName()
    {
        return "style.twig";
    }
}
