<?php
namespace app\index\controller;
use think\Controller;

class Imglist extends Common {
    /**
     * 图片列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        return $this->fetch('imglist/imglist');
    }
}
