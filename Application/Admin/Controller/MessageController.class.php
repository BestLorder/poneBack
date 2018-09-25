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
use Admin\Controller\HomeController;

class MessageController extends Controller
{

    public function show(){
        $this->assign('nav',S('nav'));
        $name = '留言管理';
        $this->assign('name',$name);
        $this->display();
    }
}