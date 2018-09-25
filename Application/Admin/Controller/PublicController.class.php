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

class PublicController extends Controller
{

    public function header(){
        $this->show('666');
//        $where['parent']=0;
//        $nav = M("nav")->where($where)->select();
//        foreach($nav as $k=>$v){
//            $w['parent']=$v['id'];
//            $nav[$k]['nav1']=M("nav")->where($w)->select();
//        }
//        $this->assign('nav',$nav);
//        $this->display();
    }
}