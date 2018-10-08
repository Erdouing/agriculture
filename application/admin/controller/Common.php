<?php
namespace app\admin\controller;
use think\Controller;

Class Common extends Controller {
    /**
     * 判断登陆权限
     * @author Tonny 990806808@qq.com 
     */
    public function _initialize() {
        if (!session('id') || !session('username')) {
            $this->error('请先登陆系统', url('login/index'));
        }
        $Auth = new Auth();
        $controller = request()->controller();
        $action = request()->action();
        if (!$Auth->check($controller . '/' . $action, session('id'))) {
            $this->error('你没有权限访问');
        }
    }
}
