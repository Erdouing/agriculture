<?php
namespace app\index\model;
use think\Model;

class Conf extends Model {
    /**
     * 初始化方法
     * @author Tonny 990806808@qq.com 
     */
    public function _initialize() {
        return $this->fetch();
    }
}
