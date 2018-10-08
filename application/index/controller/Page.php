<?php
namespace app\index\controller;
use think\Controller;

class Page extends Common {
    /**
     * 前端首页显示
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        return $this->fetch('page/page');
    }
}
