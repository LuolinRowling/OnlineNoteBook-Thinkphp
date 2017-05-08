<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Note;

class Post extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return $this->error('请先登录', '/tp5/public/index.php/index/login/index');
        } 

        $user = Session::get('user');
        $data['title'] = '发布';     
        $data['user'] = $user;

        $this->assign('data', $data);
        return $this->fetch();
    }

    public function post() {
        $title = $_POST['title'];
        $tag = $_POST['tag'];
        $content = $_POST['content'];

        if (strlen(trim($title)) == 0) {
            return $this->error('标题不能为空');
        }

        if (strlen(trim($tag)) == 0) {
            return $this->error('标签不能为空');
        }

        if (strlen(trim($content)) == 0) {
            return $this->error('内容不能为空');
        }

        $new_note = new Note;
        if ($new_note->save([
            'title' => $title,
            'tag' => $tag,
            'content' => $content,
            'author' => Session::get('user')
        ])) {
            return $this->success('发布成功', '/tp5/public/index.php/index/index/index');
        } else {
            return $this->error('发布失败，请重试', '/tp5/public/index.php/index/post/index');
        }
    }
}