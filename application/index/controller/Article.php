<?php
namespace app\index\controller;
use think\Controller;

class Article extends Common {
    /**
     * 文章页显示
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        return $this->fetch('article/article');
    }
}
