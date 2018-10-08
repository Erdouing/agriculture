<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate;
Class Article extends Common {
    /**
     * 文章显示
     * @author Tonny 990806808@qq.com 
     */
    public function lst() {
        $articles = db('article')->alias('article')
        ->join('shop_cate cate', 'article.cateid = cate.id')
        ->field('article.*, cate.catename')
        ->where(['article.status' => 0, 'cate.status' => 0])
        ->paginate(5);
        $this->assign('articles', $articles);
        return $this->fetch();
    }
    /**
     * 文章添加
     * @author Tonny 990806808@qq.com 
     */
    public function add() {
        if (request()->isPost()) {
            $article = new ArticleModel();
            $data = input('post.');
            if ($data['cateid'] == 0) {
                $this->error('请选择所属栏目');
            }
            if ($article->save($data)) {
                $this->success('添加文章成功', url('article/lst'));
            } else {
                $this->error('添加文章失败');
            }
        }
        $cate = new Cate();
        $top_cates = $cate->cateTree();
        $this->assign('top_cates', $top_cates);
        return $this->fetch();
    }
    /**
     * 文章编辑
     * @author Tonny 990806808@qq.com 
     */
    public function edit() {
        $cate = new Cate();
        $top_cates = $cate->cateTree();
        $current_article = db('article')->where('status', 0)->find(input('id'));
        if (request()->isPost()) {
            $article = new ArticleModel();
            $data = $article->before_update(input('id'));
            $update = array_merge($data, input('post.'));
            if ($article->save($update, ['id' => input('id')])) {
                $this->success('修改文章成功', url('article/lst'));
            } else {
                $this->error('修改文章失败');
            }
            return;
        }
        $this->assign([
                'top_cates' => $top_cates,
                'current_article' => $current_article
            ]);
        return $this->fetch();
    }
    /**
     * 文章删除
     * @author Tonny 990806808@qq.com 
     */
    public function del() {
        $article = new ArticleModel();
        $result = $article->where('id', input('id'))->update(['status' => 1]);
        if ($result) {
            $this->success('删除文章成功', url('article/lst'));
        } else {
            $this->error('删除文章失败');
        }
        return $this->fetch();
    }
}
