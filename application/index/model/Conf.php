<?php
namespace app\index\model;
use think\Model;

class Conf extends Model {
    /**
     * 获取所有配置项
     * @author Tonny 990806808@qq.com 
     */
    public function getAllConf() {
        $conf_result = $this->where('status', 0)->field('cnname, enname, value')->select();
        return $conf_result;
    }
}
