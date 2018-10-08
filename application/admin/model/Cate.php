<?php
namespace app\admin\model;
use think\Model;

class Cate extends Model {
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
    public function cateTree() {
        $cateResult = $this->where('status', 0)->order('sort desc')->select();
        $info = $this->sort($cateResult);
        return $info;
    }
    /**
     * 树形排序
     * @param  mixed  $data   数据集
     * @param  int    $pid    顶级栏目
     * @param  int    $level  层级
     * @author Tonny          990806808@qq.com 
     * @return mixed          array
     */
    public function sort($data, $pid = 0, $level = 0) {
        static $array = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $array[] = $v;
                $this->sort($data, $v['id'], $level+1);
            }
        }
        return $array;
    }
    /**
     * 数据查询，方法调用
     * @param  int   $cate_id   栏目id
     * @author Tonny            990806808@qq.com 
     * @return array            子栏目id数组
     */
    public function getChildrenIds($cate_id) {
        $cateResult = $this->where('status', 0)->select();
        return $this->_getChildrenIds($cateResult, $cate_id);
    }
    /**
     * 获取栏目及子栏目id
     * @param  int   $cate_id      栏目id
     * @param  int   $cateResult   查询数据
     * @author Tonny               990806808@qq.com 
     * @return array               子栏目id数组
     */
    public function _getChildrenIds($cateResult, $cate_id) {
        static $array = array();
        foreach ($cateResult as $k => $v) {
            if ($v['pid'] == $cate_id) {
                $array[] = $v['id'];
                $this->_getChildrenIds($cateResult, $v['id']);
            }
        }
        return $array;
    }
}
