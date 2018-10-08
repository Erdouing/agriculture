<?php
namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule;

Class AuthGroup extends Common {
    /**
     * 用户权限组列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $AuthGroup = new AuthGroupModel();
        $authGroupRes = $AuthGroup->where('status', 0)->paginate(10);
        $this->assign('authGroupRes', $authGroupRes);
        return $this->fetch();
    }
    /**
     * 用户权限组添加
     * @author Tonny 990806808@qq.com 
     */
    public function add() {
        if (request()->isPost()) {
            $AuthGroup = new AuthGroupModel();
            $data = input('post.');
            if (!isset($data['statement'])) {
                $data['statement'] = 1;
            } else {
                $data['statement'] = 0;
            }
            if ($data['rules']) {
                $data['rules'] = join(',', $data['rules']);
            }
            $add = $AuthGroup->save($data);
            if ($add) {
                $this->success('添加用户组成功！', url('AuthGroup/lst'));
            } else {
                $this->error('添加用户组失败！');
            }
        }
        $authRule = new AuthRule();
        $authRuleRes = $authRule->authRuleTree();
        $this->assign('authRuleRes', $authRuleRes);
        return $this->fetch();
    }
    /**
     * 用户权限组编辑
     * @author Tonny 990806808@qq.com 
     */
    public function edit() {
        $AuthGroup = new AuthGroupModel();
        $authRule = new AuthRule();
        if (request()->isPost()) {
            $data = input('post.');
            if (!isset($data['statement'])) {
                $data['statement'] = 1;
            } else {
                $data['statement'] = 0;
            }
            if ($data['rules']) {
                $data['rules'] = join(',', $data['rules']);
            }
            $update = $AuthGroup->save($data, ['id' => $data['id']]);
            if ($update) {
                $this->success('修改用户组成功！', url('AuthGroup/lst'));
            } else {
                $this->error('修改用户组失败！');
            }
        }
        $authRuleRes = $authRule->authRuleTree();
        $authGroups = $AuthGroup->where(['id' => input('id'), 'status' => 0])->find();
        $this->assign(['authGroups' => $authGroups, 'authRuleRes' => $authRuleRes]);
        return $this->fetch();
    }
    /**
     * 用户权限组删除
     * @author Tonny 990806808@qq.com 2
     */
    public function del() {
        $AuthGroup = new AuthGroupModel();
        $del = $AuthGroup->save(['status' => 1], ['id' => input('id'), 'status' => 0]);
        if ($del) {
            $this->success('删除用户组成功！', url('AuthGroup/lst'));
        } else {
            $this->error('删除用户组失败！');
        }
    }
}
