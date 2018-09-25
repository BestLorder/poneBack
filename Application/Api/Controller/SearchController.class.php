<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class SearchController extends CommonController {
    public function search(){
        $list=M('person')->select();
        if($list){
            echo json(0,'人物返回成功',$list);
        }else{
            echo json(1,'人物返回失败');
        }
}

}