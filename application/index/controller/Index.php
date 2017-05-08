<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\Note;

class Index extends Controller
{
    public function index()
    {

        if (!Session::has('user')) {
            return $this->error('请先登录', '/tp5/public/index.php/index/login/index');
        } 

        $user = Session::get('user');
        $data['title'] = $user . '的日记本';     
        $data['user'] = $user;

        $notes = Note::all(['author'=>$user]);

        $data['notes'] = $notes;

        $this->assign('data', $data);
        return $this->fetch();
    }
}