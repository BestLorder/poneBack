<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class PersonTypeController extends CommonController {
//    人物分类
    public function type(){
        $list1=M('person as a')->join('person_type as b ON b.id = a.type_id')->where('type_id=1')->select();
        $list2=M('person as a')->join('person_type as b ON b.id = a.type_id')->where('type_id=2')->select();
        $list=array();
        $key1=M('person as a')->join('person_type as b ON b.id = a.type_id')->where('type_id=1')->getField('type');
        $key2=M('person as a')->join('person_type as b ON b.id = a.type_id')->where('type_id=2')->getField('type');
        $list[$key1]=$list1;
        $list[$key2]=$list2;
        if($list){
            echo json(0,"人物分类返回成功",$list);
            exit;
        }else{
            echo json(1,"人物分类返回失败");
            exit;
        }
}
}