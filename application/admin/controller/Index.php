<?php
namespace app\admin\controller;

Class Index extends Common {
    /**
     * 后台首页显示
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        return $this->fetch();
    }
}
