<?php
/**
 *分页类
 *Create@2011-01-18Vpc:
 */

class Twig_Extensions_Extension_Page extends Twig_Extension {
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'page' => new Twig_Function_Function('page', array('is_safe' => array('html'))),
        );
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'Page';
    }
}


/**
 *Action: 分页
 *Input: array $v 页面显示样式
 *       array $page 分页相关参数
 *       string $first 首页
 *       string $prev 上一页
 *       string $next 下一页
 *       string $last 末页
 *       string $select 当前第几页
 *Output: string
 *Create@2011-01-13Vpc
 */
function page($v, array $page, $first, $prev, $next, $last, $select) {
    $_page = $page['page'];    //当前页
    $_pageSize = $page['page_size'];    //每页数量
    $_dataCount = $page['data_count'];    //总数据量
    $_pageCount = $page['page_count'];    //总页数
    $list = $page['list'];    //显示数字数量
    $_pagelink = $page['page_link'];    //页面链接

    $ps = '';
    $pl = '';

    if($list>0) {
		$pageStart = $_page>$list ? $_page-$list : 1;
		$pageEnd = $_page+$list>$_pageCount ? $_pageCount : $_page+$list;
	} else {
		$pageStart = 1;
		$pageEnd = $_pageCount;
	}

	for($p=$pageStart; $p<=$pageEnd; $p++) {
		if($_page==$p) {
		    $pl=$pl."<span>$p</span>&nbsp;";
		} else {
		    $pl=$pl."<a href=\"$_pagelink$p\">$p</a>&nbsp;";
		}
	}

	if($_pageCount>1) {
		if($_page==1) {
			$pt=array($first, $prev, "<a href=\"$_pagelink".intval($_page+1)."\">$next</a>","<a href=\"$_pagelink$_pageCount\">$last</a>");
		} elseif($_page==$_pageCount) {
			$pt=array("<a href=\"$_pagelink"."1&\">$first</a>", "<a href=\"$_pagelink".intval($_page-1)."\">$prev</a> ", $next, $last);
		} else {
			$pt=array("<a href=\"$_pagelink"."1\">$first</a>", "<a href=\"$_pagelink".intval($_page-1)."\">$prev</a>", "<a href=\"$_pagelink".intval($_page+1)."\">$next</a>", "<a href=\"$_pagelink$_pageCount\">$last</a>");
		}
	} else {
		$pt=array($first, $prev, $next, $last);
	}

    $out=str_replace("%recordcount", $_dataCount, $v);
	$out=str_replace("%pagesize", $_pageSize, $out);
	$out=str_replace("%pagenum", $_page, $out);
	$out=str_replace("%pagecount", $_pageCount, $out);
	$out=str_replace("%first", $pt[0], $out);
	$out=str_replace("%prev", $pt[1], $out);
	$out=str_replace("%next", $pt[2], $out);
	$out=str_replace("%last", $pt[3], $out);
	$out=str_replace("%select", $ps, $out);
	$out=str_replace("%list",$pl,$out);
    return $out;
}