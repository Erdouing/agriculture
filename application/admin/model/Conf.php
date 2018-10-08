<?php
namespace app\admin\model;
use think\Model;

class Conf extends Model {
    protected $insert = ['timecreated'];
    protected $update = ['timemodified'];
    protected function setTimecreatedAttr() {
        return time();
    }
    protected function setTimemodifiedAttr() {
        return time();
    }

}
