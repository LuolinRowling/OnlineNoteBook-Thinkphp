<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;

class Register extends Controller
{
    public function index()
    {
        $data['title'] = '注册';
        $data['user'] = null;
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function register() 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];

        if (strlen(trim($username)) == 0) {
            return $this->error('用户名不能为空！', '/tp5/public/index.php/index/register/index');
        }
        
        if (strlen(trim($password)) == 0 || strlen(trim($passwordRepeat)) == 0) {
            return $this->error('密码不能为空！', '/tp5/public/index.php/index/register/index');
        }
        
        if ($password != $passwordRepeat) {
            return $this->error('两次输入的密码不一致！', '/tp5/public/index.php/index/register/index');
        }

        $user = User::get([
            'username' => $username,
        ]);
 
        if (count($user) > 0) {      
            return $this->error('用户名已存在');
        }

        $new_user = new User;
        if ($new_user->save([
            'username' => $username,
            'password' => md5($password)      
        ])) {
            return $this->success('注册成功', '/tp5/public/index.php/index/login/index');
        } else {
            return $this->error('注册失败，请重试', '/tp5/public/index.php/index/register/index');
        }
    }
}