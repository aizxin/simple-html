<?php

namespace SimpleHtml;



/*******************************************************************************
Version: 1.11 ($Rev: 175 $)
Website: http://sourceforge.net/projects/simplehtmldom/
Author: S.C. Chen <me578022@gmail.com>
Acknowledge: Jose Solorzano (https://sourceforge.net/projects/php-html/)
Contributions by:
    Yousuke Kumakura (Attribute filters)
    Vadim Voituk (Negative indexes supports of "find" method)
    Antcs (Constructor with automatically load contents either text or file/url)
Licensed under The MIT License
Redistributions of files must retain the above copyright notice.
*******************************************************************************/

define('HDOM_TYPE_ELEMENT', 1);
define('HDOM_TYPE_COMMENT', 2);
define('HDOM_TYPE_TEXT',    3);
define('HDOM_TYPE_ENDTAG',  4);
define('HDOM_TYPE_ROOT',    5);
define('HDOM_TYPE_UNKNOWN', 6);
define('HDOM_QUOTE_DOUBLE', 0);
define('HDOM_QUOTE_SINGLE', 1);
define('HDOM_QUOTE_NO',     3);
define('HDOM_INFO_BEGIN',   0);
define('HDOM_INFO_END',     1);
define('HDOM_INFO_QUOTE',   2);
define('HDOM_INFO_SPACE',   3);
define('HDOM_INFO_TEXT',    4);
define('HDOM_INFO_INNER',   5);
define('HDOM_INFO_OUTER',   6);
define('HDOM_INFO_ENDSPACE',7);


class SimpleHtml
{

    // helper functions
    // -----------------------------------------------------------------------------
    // get html dom form file
    public static function file_get_html() {
        $dom = new SimpleHtmlDom;
        $args = func_get_args();
        $dom->load(call_user_func_array('file_get_contents', $args), true);
        return $dom;
    }

    // get html dom form string
    public static function str_get_html($str, $lowercase=true) {
        $dom = new SimpleHtmlDom;
        $dom->load($str, $lowercase);
        return $dom;
    }

    // dump html dom tree
    public static function dump_html_tree($node, $show_attr=true, $deep=0) {
        $lead = str_repeat('    ', $deep);
        echo $lead.$node->tag;
        if ($show_attr && count($node->attr)>0) {
            echo '(';
            foreach($node->attr as $k=>$v)
                echo "[$k]=>\"".$node->$k.'", ';
            echo ')';
        }
        echo "\n";

        foreach($node->nodes as $c)
            dump_html_tree($c, $show_attr, $deep+1);
    }

    // get dom form file (deprecated)
    public static function file_get_dom() {
        $dom = new SimpleHtmlDom;
        $args = func_get_args();
        $dom->load(call_user_func_array('file_get_contents', $args), true);
        return $dom;
    }

    // get dom form string (deprecated)
    public static function str_get_dom($str, $lowercase=true) {
        $dom = new SimpleHtmlDom;
        $dom->load($str, $lowercase);
        return $dom;
    }

}