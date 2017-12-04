<?php
namespace app\index\controller;
use think\Db;
use think\Session;

class Login extends Base
{
    public function login()
    {
        return $this->fetch();
    }
   ///登录验证
    public function check()
    {
        if (request()->isPost()) {
            $data = input('post.');
          /* $ret =  model('user')->gidet([''=>$data['id']]);
           if(!$ret)
           {
               $this->error('该用户不存在');
           }
           if($ret->password != $data['password'])
           {
               $this->error('密码不正确');
           }
           session('login',$ret,'index');
           return $this->success('登陆成功','login/loginSuccess');*/
            //进行验证码验证
            //if (!captcha_check($data['verifycode'])) {
              //  $this->error('验证码不正确');
            //} else {
                //$username = $data['username'];
                $id = $data['id'];
                //$identity = $data['identity'];
                //根据姓名获取登陆者的信息
                $result = Db::query("select * from cop_user WHERE id = '$id'");
                //$_SESSION['identity'] = $data['identity'];
                //$_SESSION['username'] = $data['username'];
                if ($result) {
                    foreach ($result as $ret) {
                        $_SESSION['username']=$ret['username'];
                        $_SESSION['identity']=$ret['identity'];
                        session('id',$ret['id']);
                    }
                    //session('userinfo', $result, 'index');
                    //进行密码验证
                    if ($ret['password'] == $data['password']) {
                        $this->success('登陆成功！','login/loginSuccess',1,1);

                    } else {
                        return $this->error('密码不正确！');
                    }
                } else {
                    return $this->error('该用户不存在');
                }
            }
        }
    //}
    //登录成功后进行跳转
    public function loginSuccess(){
        return $this->fetch();
    }

    //欢迎界面的
    public function welcome(){
        //return $this->fetch();
        return '欢迎来到校企合作';
    }
    public function logout()
    {
        //清空session
       Session::start();

       Session::destroy();
        //跳转
        $this->redirect('login/login');
    }

}