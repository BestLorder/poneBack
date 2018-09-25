<?php
// +----------------------------------------------------------------------
// | controller :首页搜索
// +----------------------------------------------------------------------
// | Author: 刘英伟 <17732059939@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

use Think\Controller;
use Think\Cache;

class LoginController extends CommonController
{

    public function index(){
        $where['name']=I("name");
        $where['password']=I("password");
        $list = M("user")->where($where)->select();
        if($list){
            echo json(0,"登录成功",$list);
            exit;
        }else{
            echo json(1,"登录失败");
            exit;
        }
//        echo "<pre>";
//        var_dump($list);
    }
}