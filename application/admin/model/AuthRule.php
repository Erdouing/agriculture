<?php
namespace app\admin\model;
use think\Model;
Class AuthRule extends Model {
    protected $insert = ['timecreated'];
    protected $update = ['timemodified'];
    protected function setTimecreatedAttr() {
        return time();
    }
    protected function setTimemodifiedAttr() {
        return time();
    }
    /**
     * 数据查询，方法调用
     * @author Tonny      990806808@qq.com 
     * @return array      新格式数据
     */
    public function authRuleTree() {
        $authRuleres = $this->where('status', 0)->order('sort desc')->select();
        return $this->sort($authRuleres);
    }
    /**
     * 树形排序
     * @param  mixed  $data   数据集
     * @param  int    $pid    顶级栏目
     * @author Tonny          990806808@qq.com 
     * @return mixed          array
     */
    public function sort($data, $pid = 0) {
        static $arr = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['dataid'] = $this->getParentIdString($v['id']);
                $arr[] = $v;
                $this->sort($data, $v['id']);
            }
        }
        return $arr;
    }
    /**
     * 数据查询，方法调用
     * @param  int   $authRuleId   权限id
     * @author Tonny            990806808@qq.com 
     * @return array            子权限id数组
     */
    public function getChildrenIds($authRuleId) {
        $AuthRuleRes = $this->where('status', 0)->select();
        return $this->_getChildrenIds($AuthRuleRes, $authRuleId);
    }
    /**
     * 获取权限及子权限id
     * @param  int   $authRuleId      权限id
     * @param  int   $AuthRuleRes     查询数据
     * @author Tonny               990806808@qq.com 
     * @return array               子权限id数组
     */
    public function _getChildrenIds($AuthRuleRes, $authRuleId) {
        static $arr = array();
        foreach ($AuthRuleRes as $k => $v) {
            if ($v['pid'] == $authRuleId) {
                $arr[] = $v['id'];
                $this->_getChildrenIds($AuthRuleRes, $v['id']);
            }
        }
        return $arr;
    }

    /**
     * 数据查询，方法调用
     * @param  int   $authRuleId   权限id
     * @author Tonny               990806808@qq.com 
     * @return arrStr              排序后的本级和上级权限id字符串
     */
    public function getParentIdString($authRuleId) {
        $AuthRuleRes = $this->where('status', 0)->select();
        return $this->_getParentIdString($AuthRuleRes, $authRuleId, true);
    }
    /**
     * 获取本权限及父权限id字符串
     * @param  int   $authRuleId      权限id
     * @param  int   $AuthRuleRes     查询数据
     * @author Tonny                990806808@qq.com 
     * @return arrStr               排序后的本级和上级权限id字符串
     */
    public function _getParentIdString($AuthRuleRes, $authRuleId, $clear = false) {
        static $array = array();
        if ($clear) {
            $array = array();
        }
        foreach ($AuthRuleRes as $k => $v) {
            if ($v['id'] == $authRuleId) {
                $array[] = $v['id'];
                $this->_getParentIdString($AuthRuleRes, $v['pid'], false);
            }
        }
        asort($array);
        $arrStr = join('-', $array);
        return $arrStr;
    }
}
