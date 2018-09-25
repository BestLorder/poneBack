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
use Admin\Controller\BootController;

class PersonController extends BootController
{

    public function show(){
//        $this->assign('nav',S('nav'));
        $this->load();
        $result=M('person')->select();
//        echo json(0,"返回成功",$result);
        $this->assign('person',$result);
//        $this->assign('nav',S('nav'));
//        $name = '人物管理';
//        $this->assign('name',$name);
        $this->display();
    }
    public function add(){
//        $where['parent']=0;
//        $nav = M("nav")->where($where)->select();
//        foreach($nav as $k=>$v){
//            $w['parent']=$v['id'];
//            $nav[$k]['nav1']=M("nav")->where($w)->select();
//        }
        $this->assign('nav',S('nav'));
        $name = '人物管理';
        $this->assign('name',$name);
        $this->display();
    }
}