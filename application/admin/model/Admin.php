<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model {
    protected $insert = ['timecreated'];
    protected $auto = ['random'];
    protected function setTimecreatedAttr() {
        return time();
    }
    protected function setRandomAttr($val) {
        return $val ? $val : createGuid();
    }
    /**
     * 模型管理员添加
     * @param  mixed  $data  POST提交数据
     * @author Tonny         990806808@qq.com 
     * @return bool          true|false
     */
    public function addAdmin($data) {
        if (empty($data) || !is_array($data)) {
            return false;
        }
        if ($data['password']) {
            $data['password'] = md5($data['password']);
        }
        $adminData = array();
        $adminData['username'] = $data['username'];
        $adminData['password'] = $data['password'];
        if ($this->save($adminData)) {
            $groupAccess['uid'] = $this->id;
            $groupAccess['group_id'] = $data['group_id'];
            db('auth_group_access')->insert($groupAccess);
            return true;
        } else {
            return false;
        }
    }
    /**
     * 模型管理员查询
     * @author Tonny     990806808@qq.com 
     * @return array     查询数据集
     */
    public function queryAdmin() {
        return $this->where('status', 0)->paginate(5);
    }
    /**
     * 模型管理员编辑
     * @param  mixed  $data  POST提交数据
     * @param  mixed  $query 根据管理员id查询到的具体一条数据
     * @author Tonny         990806808@qq.com 
     * @return bool          true|false
     */
    public function editAdmin($data, $query) {
        if (empty($data) || !is_array($data)) {
            return false;
        }
        if (empty($data['password'])) {
            $data['password'] = $query['password'];
        } else {
            $data['password'] = md5($data['password']);
        }
        db('auth_group_access')->where('uid', $query['id'])->update(['group_id' => $data['group_id']]);
        $update_info = ['username' => $data['username'], 'password' => $data['password'], 'timemodified' => time()];
        $result = $this->where(['random' => $data['id'], 'status' => 0])->update($update_info);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 模型管理员删除
     * @param  char  $id  管理员id
     * @author Tonny      990806808@qq.com 
     * @return bool       true|false
     */
    public function delAdmin($id) {
        if (!empty($id)) {
            $result = $this->where(['random' => $id, 'status' => 0])->update(['status' => 1, 'timemodified' => time()]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * 模型管理员登陆
     * @param  mixed  $data  POST提交数据
     * @author Tonny         990806808@qq.com 
     * @return string        返回控制器字符串
     */
    public function loginAdmin($data) {
        $admin = $this->where(['username' => $data['username'], 'status' => 0])->find();
        if ($admin) {
            if ($admin['password'] == md5($data['password'])) {
                $query = $this->where(['username' => $data['username'], 'status' => 0, 'password' => md5($data['password'])])->field('id, random')->find();

                session('id', $query['id']);
                session('random', $query['random']);
                session('username', $admin['username']);
                return 'login_success';//登陆成功
            } else {
                return 'error_password';//密码错误
            }
        } else {
            return 'user_no_exist';//用户不存在
        }
    }
}
