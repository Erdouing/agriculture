<?php
namespace app\admin\model;
use think\Model;

class AuthGroup extends Model {
    protected $insert = ['timecreated'];
    protected $update = ['timemodified'];
    protected function setTimecreatedAttr() {
        return time();
    }
    protected function setTimemodifiedAttr() {
        return time();
    }

}
