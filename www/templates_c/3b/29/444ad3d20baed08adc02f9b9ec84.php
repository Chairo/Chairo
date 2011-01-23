<?php

/* search.twig */
class __TwigTemplate_3b29444ad3d20baed08adc02f9b9ec84 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "  <div id=\"search\" class=\"txt-center border\">
    <div id=\"search-title\" class=\"clearfix\">搜索<strong class=\"strong\">药酒配方</strong></div>
    <form name=\"frmSearch\" id=\"frmSearch\" action=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_url", array(), "any", false, 3), "html");
        echo "search.php\" method=\"get\" class=\"seach-form\">
     <div id=\"seach-input\"><input type=\"text\" name=\"txtKeywords\" id=\"txtKeywords\" size=\"80\" class=\"search-input\" value=\"";
        // line 4
        if ((((isset($context['_keyword']) ? $context['_keyword'] : null) != "") && ((isset($context['_keyword']) ? $context['_keyword'] : null) != "全部酒方"))) {
            echo twig_escape_filter($this->env, (isset($context['_keyword']) ? $context['_keyword'] : null), "html");
        } else {
            echo "多个搜索条件请用英文半角逗号分开";
        }
        echo "\" />
    <input type=\"submit\" name=\"btnSearch\" id=\"btnSearch\" class=\"search-button\" value=\"搜索\" /></div>
    <div id=\"search-hot\">热门药酒配方：";
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['HOTSEARCHS']) ? $context['HOTSEARCHS'] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['key'] => $context['value']) {
            echo "<a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_url", array(), "any", false, 6), "html");
            echo "search.php?txtKeywords=";
            echo twig_escape_filter($this->env, (isset($context['value']) ? $context['value'] : null), "html");
            echo "\" title=\"";
            echo twig_escape_filter($this->env, (isset($context['value']) ? $context['value'] : null), "html");
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context['value']) ? $context['value'] : null), "html");
            echo "</a> ";
            if ((!$this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "last", array(), "any", false, 6))) {
                echo "、";
            }
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        echo "</div>
    </form>
  </div>";
    }

    public function getTemplateName()
    {
        return "search.twig";
    }
}
