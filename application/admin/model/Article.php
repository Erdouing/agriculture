<?php
namespace app\admin\model;
use think\Model;

class Article extends Model {
    protected $insert = ['timecreated'];
    protected $update = ['timemodified'];
    protected function setTimecreatedAttr() {
        return time();
    }
    protected function setTimemodifiedAttr() {
        return time();
    }
    /**
     * 事件注册-before_insert
     */
    protected static function init() {
        Article::event('before_insert', function ($data) {
            if ($_FILES['thumb']['tmp_name']) {
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                if ($info) {
                    $data['thumb'] = '/uploads/' . $info->getSaveName();
                }
            }
        });
    }
    /**
     * 删除原图片，存入新图片，更新文章的前置操作
     * @author Tonny 990806808@qq.com 
     * @param   int       $id 文章id
     * @return  array     图片字符串数组
     */
    public function before_update($id) {
        $article_info = $this->where('status', 0)->find($id);
        $del_thumb = $_SERVER['DOCUMENT_ROOT'] . '/shop/public/static' . $article_info->thumb;
        if (file_exists($del_thumb)) {
            @unlink($del_thumb);
        }
        $file = request()->file('thumb');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
        if ($info) {
            $data['thumb'] = '/uploads/' . $info->getSaveName();
            return $data;
        }
    }
}
