<?php

/* index.tpl */
class __TwigTemplate_3b629b17c303341e7491bf2909724c70 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title><{\$CONFIG.web_name}>-<{\$CONFIG.web_author}></title>
<meta name=\"description\" content=\"<{\$CONFIG.web_description}>\">
<link rel=\"stylesheet\" href=\"<{\$CONFIG.web_css_url}>reset.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"<{\$CONFIG.web_css_url}>layout.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"<{\$CONFIG.web_css_url}>global.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"<{\$CONFIG.web_css_url}>index.css\" type=\"text/css\" />
<link rel=\"shortcut icon\" href=\"<{\$CONFIG.web_url}>favicon.ico\" />
</head>
<body><a name=\"top\"></a>
<{include 'functions.tpl'}>
<!--Header BOF-->
<{include 'header.tpl'}>
<!--Header EOF-->
<!--Main BOF-->
<div id=\"main\" class=\"center clearfix\">
  <!--Search BOF-->
   <{nocache}><{include 'search.tpl' _keyword=\"\"}><{/nocache}>
  <!--Search EOF-->
  <div id=\"articles\" class=\"txt-center clearfix border\">
      <ul>
        <{foreach \$ARTICLES as \$article}>
        <li><a href=\"<{\$CONFIG.web_url}><{call article_url data=\$article.id}>\" title=\"<{\$article.title}>-<{\$article.description}>\"><{\$article.title|truncate:18:\"...\":true}></a></li>
        <{math equation=\"x-y\" x=4 y=\$article@index%4 assign=lackLi}><{*计算循环后差几个li*}>
            <{if \$article@last && \$lackLi!=1}><{*循环补齐li*}>
               <{for \$foo=1 to \$lackLi-1}>
               <li />
               <{/for}>
           <{/if}>
           <{if !\$article@last && \$lackLi==1}><{*补足ul*}>
         </ul>
         <ul>
           <{/if}>
        <{/foreach}>
     </ul>
  </div>
</div>
<!--Main EOF-->
<!--Footer BOF-->
<{include 'footer.tpl'}>
<!--Footer EOF-->
<a href=\"#top\" id=\"gototop\" class=\"title-navigation\">Top</a>
<script src=\"https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js\" type=\"text/javascript\"></script>
<script src=\"<{\$CONFIG.web_js_url}>mootools-more.js\" type=\"text/javascript\"></script>
<script src=\"<{\$CONFIG.web_js_url}>go-top.js\" type=\"text/javascript\"></script>
<script language=\"javascript\">
<!--
document.addEvent('domready', function() {
    \$('txtKeywords').addEvent('click', function() {
        if('多个搜索条件请用英文半角逗号分开' == this.value) {
            this.value = '';
        } else {
            this.select();
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
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "index.tpl";
    }
}
