<?php
// +----------------------------------------------------------------------
// | controller :首页搜索
// +----------------------------------------------------------------------
// | Author: 刘英伟 <17732059939@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Think\Controller;
use Think\Cache;
use Think\View;

class IndexController extends Controller
{

    public function index(){
//        $this->show('666');
//        $this->display('login:login');
        $where['parent']=0;
        $nav = M("nav")->where($where)->select();
        foreach($nav as $k=>$v){
            $w['parent']=$v['id'];
            $nav[$k]['nav1']=M("nav")->where($w)->select();
        }
//        S(array('type'=>'xcache','expire'=>60));
        // 设置缓存
        S('nav',$nav);
        $this->assign('nav',$nav);
//        $name = '人物管理';
//        $this->assign('name',$name);
        $this->display();
    }

}