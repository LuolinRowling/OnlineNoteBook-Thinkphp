<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Note;

class Detail extends Controller
{
    public function index($id)
    {
        if (!Session::has('user')) {
            return $this->error('请先登录', '/tp5/public/index.php/index/login/index');
        } 

        $user = Session::get('user');
        $data['title'] = '笔记详情';     
        $data['user'] = $user;
        $note = Note::get(['id'=>$id]);
        
        if ($note['author'] != $user) {
            return $this->error('您无查看权限', '/tp5/public/index.php/index/index/index');
        }

        $data['note'] = $note;
        $this->assign('data', $data);
        return $this->fetch();
    }
}