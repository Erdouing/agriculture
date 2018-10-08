<?php
namespace app\admin\controller;
use app\admin\model\Conf as ConfModel;
use app\admin\controller\Common;

Class Conf extends Common {
    /**
     * 配置列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst () {
        $conf = new ConfModel();
        if (request()->isPost()) {
            $sorts = input('post.');
            foreach ($sorts as $k => $v) {
                db('conf')->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功', url('conf/lst'));
            return;
        }
        $confres = $conf->where('status', 0)->order('sort desc')->paginate(8);
        $this->assign('confres', $confres);
        return $this->fetch();
    }
    /**
     * 增加配置
     * @author Tonny 990806808@qq.com 
     */
    public function add () {
        if (request()->isPost()) {
            $conf = new ConfModel();
            $data = input('post.');
            if ($data['values']) {
                $data['values'] = str_replace('，', ',', $data['values']);
            }
            if ($conf->save($data)) {
                $this->success('添加配置成功', url('conf/lst'));
            }else{
                $this->error('添加配置失败');
            }
        }
        return $this->fetch();
    }
    /**
     * 编辑配置
     * @author Tonny 990806808@qq.com 
     */
    public function edit () {
        $conf = new ConfModel();
        if (request()->isPost()) {
            $data = input('post.');
            if ($data['values']) {
                $data['values'] = str_replace('，', ',', $data['values']);
            }
            $save = $conf->save($data, ['id' => $data['id']]);
            if ($save !== false) {
                $this->success('修改配置成功！', url('conf/lst'));
            } else {
                $this->error('修改配置失败！');
            }
        }
        $confs = $conf->where(['status' => 0, 'id' => input('id')])->find();
        $this->assign('confs', $confs);
        return $this->fetch();
    }
    /**
     * 删除配置
     * @author Tonny 990806808@qq.com 
     */
    public function del () {
        $conf = new ConfModel();
        $del = $conf->where(['status' => 0, 'id' => input('id')])->update(['status' => 1]);
        if ($del) {
            $this->success('删除配置成功！', url('conf/lst'));
        } else {
            $this->error('删除配置失败！');
        }
        return $this->fetch();
    }
    /**
     * 显示所有配置项
     * @author Tonny 990806808@qq.com 
     */
    public function conf() {
        $conf = new ConfModel();
        if (request()->isPost()) {
            $data = input('post.');
            foreach ($data as $k => $v) {
                $form_keys[] = $k;
            }
            $query_data = collection($conf->where('status', 0)->field('enname')->select())->toArray();
            foreach ($query_data as $k => $v) {
                $query_data_keys[] = $v['enname'];
            }
            $checkBox_data = array_diff($query_data_keys, $form_keys);
            if ($checkBox_data) {
                $conf->where('enname', 'in', $checkBox_data)->where('status', 0)->update(['value' => '']);
            }
            if ($data) {
                foreach ($data as $k => $v) {
                    $conf->where(['enname' => $k, 'status' => 0])->update(['value' => $v]);
                }
                $this->success('修改配置成功！');
            }
            return;
        }
        $confres = $conf->where('status', 0)->order('sort desc')->select();
        $this->assign('confres', $confres);
        return $this->fetch();
    }
}
