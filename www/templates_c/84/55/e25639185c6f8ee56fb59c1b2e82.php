<?php

/* header.twig */
class __TwigTemplate_8455e25639185c6f8ee56fb59c1b2e82 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<a name=\"top\"></a>
<div id=\"header\" class=\"center clearfix\">
  <h1 class=\"txt-shadow\"><a href=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_url", array(), "any", false, 3), "html");
        echo "\" title=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_name", array(), "any", false, 3), "html");
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_name", array(), "any", false, 3), "html");
        echo "</a></h1>
  <div id=\"description\" class=\"center clearfix\">
    <h3 class=\"txt-shadow\">";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_description", array(), "any", false, 5), "html");
        echo "</h3>
  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "header.twig";
    }
}
