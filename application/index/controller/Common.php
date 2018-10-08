<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Conf;

class Common extends Controller {
    /**
     * 初始化方法
     * @author Tonny 990806808@qq.com 
     */
    public function _initialize() {
        $conf = new Conf();
        $_confres = collection($conf->getAllConf())->toArray();
        $confres = array();
        foreach ($_confres as $k => $v) {
            $confres[$v['enname']] = $v['value'];
        }
        $this->assign('confres', $confres);
        return $this->fetch();
    }
}
