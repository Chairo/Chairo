<?php

/* footer.twig */
class __TwigTemplate_5bca378103a86789480edb3d791d9146 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<div id=\"footer\" class=\"center txt-center clearfix\">";
        echo $this->getAttribute((isset($context['CONFIG']) ? $context['CONFIG'] : null), "web_copyright", array(), "any", false, 1);
        echo "</div>
<a href=\"#top\" id=\"gototop\" class=\"title-navigation\">Top</a>
<!--
<script type=\"text/javascript\">
var _bdhmProtocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");
document.write(unescape(\"%3Cscript src='\" + _bdhmProtocol + \"hm.baidu.com/h.js%3Fd3cb699c4470284d06ac14cc81e7132c' type='text/javascript'%3E%3C/script%3E\"));
</script>
<script type=\"text/javascript\"> var cpro_id = 'u318289';</script><script src=\"http://cpro.baidu.com/cpro/ui/f.js\" type=\"text/javascript\"></script>-->";
    }

    public function getTemplateName()
    {
        return "footer.twig";
    }
}
