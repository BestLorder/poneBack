<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class BoardController extends CommonController {
    public function index(){
        $person_id = I("person_id");
        $where['person_id']=$person_id;
        $list=M('person_msg as a')
            ->where($where)
            ->join('user as b ON b.id = a.user_id')
            ->select();

        if($list){
            echo json(0,'人物返回成功',$list);
        }else{
            echo json(1,'人物返回失败');
        }
    }
    public function msg(){
        $datas['person_id']=I('person_id');
        $datas['user_id']=I('user_id');
        $datas['content']=I('content');
        $time = date('Y-m-d H:i:s', time());
        $datas['time'] = $time;
        $result = M('person_msg')->data($datas)->add();
        if($result){
            echo json(0,'留言成功');
        }else{
            echo json(1,'留言失败');
        }
    }
    public function like(){
        $user_id = I("user_id");
        $person_id = I("person_id");
        $where['user_id']=$user_id;
        $where['person_id']=$person_id;
        $zan_status = M('user_person')->where($where)->getfield('zan_status');
        if($zan_status==1){
            echo json(1,'已点赞');
        }else{
            $zan_count = M('user_person')->where($where)->getfield('zan_count');
            $data['zan_count']=$zan_count+1;
            $data['zan_status']=1;
            $save = M('user_person')->where($where)->save($data);
            if($save){
                echo json(0,'点赞成功');
            }else{
                echo json(1,'点赞失败');
            }
        }
    }
}