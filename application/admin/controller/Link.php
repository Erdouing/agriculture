<?php
namespace app\admin\controller;
use app\admin\model\Link as LinkModel;

Class Link extends Common {
    /**
     * 链接列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $link = new LinkModel();
        if (request()->isPost()) {
            $sort = input('post.');
            foreach ($sort as $k => $v) {
                db('link')->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功', url('link/lst'));
            return;
        }
        $link_info = $link->where('status', 0)->order('sort desc')->paginate(5);
        $this->assign('link_info', $link_info);
        return $this->fetch();
    }
    /**
     * 增加链接
     * @author Tonny 990806808@qq.com 
     */
    public function add() {
        $link = new LinkModel();
        if(request()->isPost()){
            $data = input('post.');
            $add = $link->save($data);
            if ($add) {
                $this->success('添加友情链接成功！',url('link/lst'));
            } else {
                $this->error('添加友情链接失败！');
            }
        }
        return $this->fetch();
    }
    /**
     * 编辑链接
     * @author Tonny 990806808@qq.com 
     */
    public function edit() {
        $link = new LinkModel();
        if(request()->isPost()){
            $data = input('post.');
            $update = $link->save($data, ['id' => $data['id']]);
            if($update){
                $this->success('修改链接成功！', url('link/lst'));
            }else{
                $this->error('修改链接失败！');
            }
            return;
        }
        $links = $link->where(['status' => 0, 'id' => input('id')])->find();
        $this->assign('links', $links);
        return $this->fetch();
    }
    /**
     * 删除链接
     * @author Tonny 990806808@qq.com 
     */
    public function del() {
        $link = new LinkModel();
        $del = $link->where('id', input('id'))->update(['status' => 1]);
        if ($del) {
           $this->success('删除链接成功！', url('link/lst')); 
        } else {
            $this->error('删除链接失败！');
        }
    }
}
