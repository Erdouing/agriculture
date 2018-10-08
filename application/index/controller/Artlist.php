<?php
namespace app\index\controller;
use think\Controller;

class Artlist extends Common {
    /**
     * 分类列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        return $this->fetch('artlist/artlist');
    }
}
