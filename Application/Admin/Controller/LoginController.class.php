<?php
// +----------------------------------------------------------------------
// | controller :首页搜索
// +----------------------------------------------------------------------
// | Author: 刘英伟 <17732059939@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Think\Controller;
use Think\Cache;

class LoginController extends Controller
{

    public function login(){
        $datas['name'] = I("name");
        $datas['password'] = I("password");
        $where['admin_name']=$datas['name'];
        $where['password']=$datas['password'];
        $list = M("admin")->where($where)->select();
        if($list){
//            echo json(0,"登录成功",$datas);
//            $user_count = M("user")->count();
//            $this->assign('user_count',$user_count);
//            $this->display('home:index');
            $this->redirect('home/index');
            exit;
        }else{
//            echo json(1,"登录失败");
//            $this->error('登录失败');
            $this->assign('message','登录失败');
            $this->display();
//            $this->display('login');
            exit;
        }
//        echo "<pre>";
//        var_dump($list);
    }
}