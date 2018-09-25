<?php
// +----------------------------------------------------------------------
// | controller :首页搜索
// +----------------------------------------------------------------------
// | Author: 刘英伟 <17732059939@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

use Think\Controller;
use Think\Cache;

class RegisterController extends CommonController
{

    public function index(){
        $datas['name'] = I("name");
        $datas['password'] = I("password");
        $time = date('Y-m-d H:i:s', time());
        $datas['create_time'] = $time;
//        $where['name']=$datas['name'];
        $name=M('User')->where('name='.$datas['name'])->select();
        if($name){
            echo json(2,"注册失败，用户名已存在");
            exit;
        }else{
            $result = M('User')->data($datas)->add();
        }
        if($result){
            echo json(0,"注册成功",$datas);
            exit;
        }else{
            echo json(1,"注册失败");
            exit;
        }
//        $where['id']=1;
//        $list = M("user")->where($where)->select();
//        echo "<pre>";
//        var_dump($list);
    }
}