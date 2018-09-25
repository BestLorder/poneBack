<?php
// +----------------------------------------------------------------------
// | controller :首页搜索
// +----------------------------------------------------------------------
// | Author: 刘英伟 <17732059939@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

use Think\Controller;
use Think\Cache;

class HomePageController extends CommonController
{
    public function index(){
        $list = M("hp_lbt")->limit(2)->select();
        if($list){
            echo json(0,"首页轮播图返回成功",$list);
            exit;
        }else{
            echo json(1,"首页轮播图返回失败");
            exit;
        }
//        echo "<pre>";
//        var_dump($list);
    }
    public  function search(){
        $keywords=I('keywords');
        if (!empty($keywords)) {
            $where['name '] = array('like', "%$keywords%");
        }
        $count = M("person")->where($where)->count();
        $list = M("person")
            ->field('name')
            ->where($where)
            ->select();
        $data["count"] = $count;
        $data["list"] = $list;
        if($list){
            echo json(0,"查询成功",$data);
            exit;
        }else{
            echo json(1,"查询失败");
            exit;
        }
    }
}