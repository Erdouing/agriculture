<?php
namespace app\admin\controller;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\controller\Common;
Class AuthRule extends Common {
    /**
     * 权限显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $authRule = new AuthRuleModel();
        if (request()->isPost()) {
            $sorts = input('post.');
            foreach ($sorts as $k => $v) {
                db('authRule')->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功！', url('AuthRule/lst'));
            return;
        }
        $authRuleRes = $authRule->authRuleTree();
        $this->assign('authRuleRes', $authRuleRes);
        return $this->fetch();
    }
    /**
     * 权限添加
     * @author Tonny 990806808@qq.com 
     */
    public function add(){
        if (request()->isPost()) {
            $authRule = new AuthRuleModel();
            $data = input('post.');
            $plevel = $authRule->where(['id' => $data['pid'], 'status' => 0])->field('level')->find();
            if ($plevel) {
                $data['level'] = $plevel['level'] + 1;
            } else {
               $data['level'] = 0; 
            }
            $add = $authRule->save($data);
            if ($add) {
                $this->success('添加权限成功！', url('AuthRule/lst'));
            } else {
                $this->error('添加权限失败！');
            }
            return;
        }
        $authRule = new AuthRuleModel();
        $authRuleRes = $authRule->authRuleTree();
        $this->assign('authRuleRes', $authRuleRes);
        return $this->fetch();
    }
    /**
     * 权限编辑
     * @author Tonny 990806808@qq.com 
     */
    public function edit() {
        $authRule = new AuthRuleModel();
        if (request()->isPost()) {
            $data = input('post.');
            $plevel = $authRule->where(['id' => $data['pid'], 'status' => 0])->field('level')->find();
            if ($plevel) {
                $data['level'] = $plevel['level'] + 1;
            } else {
               $data['level'] = 0; 
            }
            $update = $authRule->save($data, $data['id']);
            if ($update !== false) {
                $this->success('修改权限成功！', url('AuthRule/lst'));
            } else {
                $this->error('修改权限失败！');
            }
            return;
        }
        $authRuleRes = $authRule->authRuleTree();
        $authRules = $authRule->find(input('id'));
        $this->assign([
            'authRuleRes' => $authRuleRes,
            'authRules' => $authRules
            ]);
        return $this->fetch();
    }
    /**
     * 权限删除
     * @author Tonny 990806808@qq.com 
     */
    public function del(){
        $authRule = new AuthRuleModel();
        $a = $authRule->getParentIds(input('id'));
        $authRuleIds = $authRule->getChildrenIds(input('id'));
        $authRuleIds[] = input('id');
        $where = ['id' => ['in', $authRuleIds], 'status' => 0];
        $del = $authRule->where($where)->update(['status' => 1]);
        if ($del) {
            $this->success('删除权限成功！', url('AuthRule/lst'));
        } else {
            $this->error('删除权限失败！');
        }
    }
}
