<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article;

Class Cate extends Common {
    protected $beforeActionList = [
        'delSonCate'  =>  ['only'=>'del'],
    ];
    /**
     * 栏目列表显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $cate = new CateModel();
        if (request()->isPost()) {
            $sort = input('post.');
            foreach ($sort as $k => $v) {
                db('cate')->update(['id' => $k, 'sort' => $v]);
            }
            $this->success('更新排序成功', url('cate/lst'));
            return;
        }
        $cate_info = $cate->cateTree();
        $this->assign('cate_info', $cate_info);
        return $this->fetch();
    }
    /**
     * 栏目列表添加
     * @author Tonny 990806808@qq.com 
     */
    public function add() {
        $cate = new CateModel();
        if (request()->isPost()) {
            $add = $cate->save(input('post.'));
            if ($add) {
                $this->success('添加栏目成功');
            }
        }
        $top_cates = $cate->cateTree();
        $this->assign('top_cates', $top_cates);
        return $this->fetch();
    }
    /**
     * 栏目列表编辑
     * @author Tonny 990806808@qq.com 
     */
    public function edit() {
        $cate = new CateModel();
        if (request()->isPost()) {
            $info = $cate->save(input('post.'), ['id' => input('id')]);
            if ($info) {
                $this->success('栏目修改成功', url('cate/lst'));
            } else {
                $this->error('栏目修改失败');
            }
            return;
        }
        $query_cate = $cate->where('status', 0)->find(input('id'));
        $top_cates = $cate->cateTree();
        $this->assign([
            'top_cates' => $top_cates,
            'query_cate' => $query_cate
            ]);
        return $this->fetch();
    }
    /**
     * 栏目列表删除的前置操作
     * @author Tonny 990806808@qq.com 
     */
    public function delSonCate() {
        $cate = new CateModel();
        $article = new Article();
        $cateid = input('id');
        $son_ids = $cate->getChildrenIds($cateid);
        if ($son_ids) {
            $cate->where('id', 'in', $son_ids)->update(['status' => 1]);
            $article->where('cateid', 'in', $son_ids)->update(['status' => 1]);
        }
        //pe($son_ids);
    }
    /**
     * 栏目列表删除
     * @author Tonny 990806808@qq.com 
     */
    public function del() {
        $cate = new CateModel();
        $article = new Article();
        $info_cate = $cate->where('id', input('id'))->update(['status' => 1]);
        $info_article = $article->where('cateid', input('id'))->update(['status' => 1]);
        if ($info_cate && $info_article) {
            $this->success('栏目删除成功', url('cate/lst'));
        } else {
            $this->error('栏目删除失败');
        }
    }
}
