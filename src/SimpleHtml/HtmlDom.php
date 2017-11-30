<?php

namespace SimpleHtml;


class HtmlDom
{
    private $html;
    /**
     *  [$_dom 单例]
     *  @var null
     */
    private static $_dom = null;
    /**
     *  [getInit 单例的初始化]
     *  @author Sow
     *  @DateTime 2017-06-17T15:58:13+0800
     *  @return   [type]                   [description]
     */
    public static function getInit(){
        if(self::$_dom === null){
            self::$_dom = new self();
        }
        return self::$_dom;
    }
    /**
     *  [strHtml string]
     *  @author Sow
     *  @DateTime 2017-11-29T21:58:37+0800
     *  @param    [type]                   $str [description]
     *  @return   [type]                        [description]
     */
    public function strHtml($str)
    {
        $this->html = SimpleHtml::str_get_html($str);
        $this->removeBlanks();
        $str = $this->html->outertext;
        $this->html->clear();
        return $str;
    }
    /**
     *  [urlHtml file]
     *  @author Sow
     *  @DateTime 2017-11-29T21:59:59+0800
     *  @param    [type]                   $url [description]
     *  @return   [type]                        [description]
     */
    public function urlHtml($url)
    {
        $this->html = SimpleHtml::file_get_html($url);
        $this->removeBlanks();
        $str = $this->html->outertext;
        $this->html->clear();
        return $str;
    }
    /**
     *  [removeLabel 移除标签和去掉样式]
     *  @author Sow
     *  @DateTime 2017-11-29T21:53:00+0800
     *  @return   [type]                   [description]
     */
    public function removeLabel()
    {
        foreach ($this->html->find('p') as $e) {
            $e->style = null;
            $e->innertext = preg_replace("/<[ ]+/si","<",$e->innertext); // 去掉img前的空格
            $e->outertext = strip_tags($e->outertext, "<p> <img>"); // 去掉p标签内嵌套
        }
        $this->html->save();
    }
    /**
     *  [removeBlanks 去掉空客]
     *  @author Sow
     *  @DateTime 2017-11-29T21:55:27+0800
     *  @return   [type]                   [description]
     */
    public function removeBlanks()
    {
        $this->removeLabel();
        $this->html = SimpleHtml::str_get_html($this->html->outertext);
        foreach ($this->html->find('p') as $e) {
            if ($e->innertext == "" || ctype_space($e->innertext)) {
                $e->outertext = ''; // 去掉没有内容的怕标签
            }
        }
        $this->html->save();
    }


}