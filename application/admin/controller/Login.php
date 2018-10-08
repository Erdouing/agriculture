<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;

Class Login extends Controller {
    /**
     * 后台登陆
     * @author Tonny 990806808@qq.com 
     */
    public function index() {
        if (request()->isPost()) {
            $this->check(input('code'));
            $admin = new Admin();
            $result = $admin->loginAdmin(input('post.'));
            switch ($result) {
                case 'login_success':
                    $this->success('登陆成功', url('index/index'));
                    break;
                case 'error_password':
                    $this->error('密码错误');
                    break;
                case 'user_no_exist':
                    $this->error('用户不存在');
                    break;
            }
        }
        return $this->fetch('login/login');
    }
    /**
     * 后台退出
     * @author Tonny 990806808@qq.com 
     */
    public function logout() {
        session(null);
        $this->success('注销成功', url('login/index'));
    }
    /**
     * 验证码检测
     * @author Tonny 990806808@qq.com 
     */
    public function check($code = '') {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
            return true;
        }
    }
}
