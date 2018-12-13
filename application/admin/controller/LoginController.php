<?php

/**
 *  登陆页
 * @file   Login.php  
 */

namespace app\admin\controller;

use think\Controller;
use think\Loader;
use think\captcha;


class LoginController extends Controller {

    /**
     * 登入
     */
    public function index() 
    {
        if (isset($_POST["dosubmit"]) && $_POST['dosubmit']) {
            $username = input('post.username');
            $password = input('post.password');
            // $verify = input('post.verify');
            // if($this->checkCode($verify) == false){
            //     $this->error('验证码错误');
            // }
            //加盐方法
            // $salt = base64_encode(createSalt());
            // $password = sha1($password.$salt);
            
            if (!$username) {
                $this->error('用户名不能为空');
            }
            if (!$password) {
                $this->error('密码不能为空');
            }
            $info = db('admin')->field('id,username,password,salt')->where('username', $username)->find();
            if (!$info) {
                $this->error('用户不存在');
            }
            if (sha1($password.$info['salt']) != $info['password']) {
                $this->error('密码不正确');
            } else {
                $CustomerService = db("Customer_service")->field("id,name,is_online")->where("uid",$info['id'])->find();
                if($CustomerService != false || !empty($CustomerService)){
                    $data = ["is_online" => 1];
                    //修改客服管理员登录在线状态
                    Loader::model('CustomerService')->editInfo($CustomerService['id'], $data);
                }
                session('user_name', $info['username']);
                session('user_id', $info['id']);
                session('CustomerServiceId', $CustomerService['id']);
                session('CustomerServiceName', $CustomerService['name']);

                if (input('post.islogin')) {
                    cookie('user_name', encry_code($info['username']));
                    cookie('user_id', encry_code($info['id']));
                }

                //记录登录信息
                Loader::model('Admin')->editInfo(1, $info['id']);
                $this->success('登入成功', 'index/index');
            }
        } else {
            if (session('user_name')) {
                $this->success('您已登入', 'index/index');
            }

            if (cookie('user_name')) {
                $username = encry_code(cookie('user_name'),'DECODE');
                $info = db('admin')->field('id,username,password')->where('username', $username)->find();
                if ($info) {
                    //记录
                    session('user_name', $info['username']);
                    session('user_id', $info['id']);
                    Loader::model('Admin')->editInfo(1, $info['id']);
                    $this->success('登入成功', 'index/index');
                }
            }

            $this->view->engine->layout(false);
            return $this->fetch('login_1');
        }
    }


    /**
     * 登出
     */
    public function logout() 
    {
        session_start();
        //修改客服管理员登录在线状态
        $data = ["is_online" => 0];
        Loader::model('CustomerService')->editInfo(session("CustomerServiceId"), $data);

        session('user_name', null);
        session('user_id', null);
        session('CustomerServiceId', null);
        session('CustomerServiceName', null);
        cookie('user_name', null);
        cookie('user_id', null);
        session_destroy();
        $this->success('退出成功', 'login/index');
    }


    // 验证码输出
    public function generateCode() 
    {
        $captcha = new captcha\Captcha();
        $captcha->fontSize = 14;
        $captcha->length   = 4;
        $captcha->imageH   = 30;
        $captcha->imageW   = 125;
        $captcha->useNoise = true;
        return $captcha->entry();
    }

    // 验证码检验
    public function checkCode($code)
    {
        $captcha = new captcha\Captcha();
        return $captcha->check($code);
    }

}
