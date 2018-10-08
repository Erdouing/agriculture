<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use app\admin\model\AuthGroup;

Class Admin extends Common {
    /**
     * 管理员显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $Auth = new Auth();
        $admin = new AdminModel();
        $info = $admin->queryAdmin();
        foreach ($info as $k => $v) {
            $_groupTitle = $Auth->getGroups($v['id']); 
            $groupTitle = $_groupTitle[0]['title'];
            $v['groupTitle'] = $groupTitle;
        }
        $this->assign('admin_info', $info);
        return $this->fetch();
    }
    /**
     * 管理员添加
     * @author Tonny 990806808@qq.com 
     */
    public function add() {
        $AuthGroup = new AuthGroup();
        if (request()->isPost()) {
            $admin = new AdminModel();
            if ($admin->addAdmin(input('post.'))) {
                $this->success('添加管理员成功', url('admin/lst'));
            } else {
                $this->error('添加管理员失败');
            }
        }
        $authGroupRes = $AuthGroup->where('status', 0)->select();
        $this->assign('authGroupRes', $authGroupRes);
        return $this->fetch();
    }
    /**
     * 管理员编辑
     * @param  char  $id  管理员id
     * @author Tonny      990806808@qq.com 
     */
    public function edit($id) {
        $admin = new AdminModel();
        $AuthGroup = new AuthGroup();
        $query = $admin->where(['status' => 0, 'random' => $id])->find();
        if (request()->isPost()) {
            $info = $admin->editAdmin(input('post.'), $query);
            if ($info) {
                $this->success('修改管理员信息成功', url('index/index'));
            } else {
                $this->error('修改管理员信息失败');
            }
        }
        $authGroupAccess = db('auth_group_access')->where('uid', $query['id'])->find();
        $authGroupRes = $AuthGroup->where('status', 0)->select();
        $this->assign(['admin' => $query, 'authGroupRes' => $authGroupRes, 'groupId' => $authGroupAccess['group_id']]);
        return $this->fetch();
    }
    /**
     * 管理员删除
     * @param  char  $id  管理员id
     * @author Tonny      990806808@qq.com 
     */
    public function del($id) {
        $admin = new AdminModel();
        $info = $admin->delAdmin($id);
        if ($info) {
            $this->success('删除管理员信息成功', url('admin/lst'));
        } else {
            $this->error('删除管理员信息失败');
        }
    }
}
