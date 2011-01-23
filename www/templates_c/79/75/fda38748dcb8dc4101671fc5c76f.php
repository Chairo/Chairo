<?php

/* index.twig */
class __TwigTemplate_7975fda38748dcb8dc4101671fc5c76f extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'web_title' => array($this, 'block_web_title'),
            'meta' => array($this, 'block_meta'),
            'content' => array($this, 'block_content'),
            'style' => array($this, 'block_style'),
            'script' => array($this, 'block_script'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("base.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_web_title($context, array $blocks = array())
    {
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_name", array(), "any", false, 4), "html");
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_author", array(), "any", false, 4), "html");
        echo "
";
    }

    // line 7
    public function block_meta($context, array $blocks = array())
    {
        // line 8
        echo "<meta name=\"description\" content=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_description", array(), "any", false, 8), "html");
        echo "\">
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        $this->env->loadTemplate("search.twig")->display(array_merge($context, array("_keyword" => "", "CONFIG" => (isset($context['CONFIG']) ? $context['CONFIG'] : null), "HOTSEARCHS" => (isset($context['HOTSEARCHS']) ? $context['HOTSEARCHS'] : null))));
        // line 14
        echo "    <div id=\"articles\" class=\"txt-center clearfix border\">
        <ul>
        ";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['ARTICLES']) ? $context['ARTICLES'] : null));
        $context['_iterated'] = false;
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
        foreach ($context['_seq'] as $context['_key'] => $context['article']) {
            // line 17
            echo "            <li><a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_url", array(), "any", false, 17), "html");
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['funcs']) ? $context['funcs'] : null), "url", array($this->getAttribute((isset($context['article']) ? $context['article'] : null), "id", array(), "any", false, 17), ), "method", false, 17), "html");
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['article']) ? $context['article'] : null), "title", array(), "any", false, 17), "html");
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['article']) ? $context['article'] : null), "description", array(), "any", false, 17), "html");
            echo "\">";
            echo twig_escape_filter($this->env, twig_truncate_filter($this->env, $this->getAttribute((isset($context['article']) ? $context['article'] : null), "title", array(), "any", false, 17), 18, false, ""), "html");
            echo "</a></li>
            ";
            // line 18
            if (((!$this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "last", array(), "any", false, 18)) && twig_test_divisibleby($this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "index", array(), "any", false, 18), 4))) {
                echo " ";
                // line 19
                echo "                </ul>
                <ul>
            ";
            }
            // line 22
            echo "            ";
            if (($this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "last", array(), "any", false, 22) && (!twig_test_divisibleby($this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "index", array(), "any", false, 22), 4)))) {
                echo " ";
                // line 23
                echo "                ";
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable(range(1, (4 - ($this->getAttribute((isset($context['loop']) ? $context['loop'] : null), "index", array(), "any", false, 23) % 4))));
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
                foreach ($context['_seq'] as $context['_key'] => $context['i']) {
                    // line 24
                    echo "                    <li/>
                ";
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_merge($_parent, array_intersect_key($context, $_parent));
                // line 26
                echo "            ";
            }
            // line 27
            echo "        ";
            $context['_iterated'] = true;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        if (!$context['_iterated']) {
            // line 28
            echo "            <li>暂无记录，反馈给";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_author", array(), "any", false, 28), "html");
            echo "<a href=\"mailto:102xing@gmail.com?subject=Null\">Via Email</a> <a href=\"http://sighttp.qq.com/authd?IDKEY=c99a301c8a0362d539261e9cfa418e3ef8e93539f972a1a7\">Via QQ</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 30
        echo "        </ul>
    </div>
";
    }

    // line 34
    public function block_style($context, array $blocks = array())
    {
        // line 35
        $this->env->loadTemplate("style.twig")->display(array_merge($context, (isset($context['CONFIG']) ? $context['CONFIG'] : null)));
        echo " ";
        // line 36
        echo "<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_css_url", array(), "any", false, 36), "html");
        echo "index.css\" type=\"text/css\" />
";
    }

    // line 39
    public function block_script($context, array $blocks = array())
    {
        // line 40
        echo "<script src=\"https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js\" type=\"text/javascript\"></script>
<script src=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_js_url", array(), "any", false, 41), "html");
        echo "mootools-more.js\" type=\"text/javascript\"></script>
<script src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_js_url", array(), "any", false, 42), "html");
        echo "go-top.js\" type=\"text/javascript\"></script>
<script language=\"javascript\">
<!--
document.addEvent('domready', function() {
    \$('txtKeywords').addEvent('click', function() {
        if('多个搜索条件请用英文半角逗号分开' == this.value) {
            this.value = '';
        }
    });
    \$('txtKeywords').addEvent('blur', function() {
        if('' == this.value) {
            this.value = '多个搜索条件请用英文半角逗号分开';
        }
    });
    \$('frmSearch').addEvent('submit', function() {
        if('多个搜索条件请用英文半角逗号分开' == \$('txtKeywords').value) {
            \$('txtKeywords').value = '';
        }
    });
    var t = new Top({s:50});
});
-->
</script>
";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }
}
