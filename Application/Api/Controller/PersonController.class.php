<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class PersonController extends CommonController {
    public function index(){
        $user_id = I("user_id");
        $list=M('person as a')
            ->join('user as b ON b.id = a.user_id')
//            ->join('user_person as c ON c.user_id = '.$user_id.' and c.person_id = a.person_id')
            ->field('a.*,b.name as user_name,b.head as user_head')
            ->select();
        foreach($list as $k=>$v) {
            $list[$k]['time'] = tranTime(strtotime($v['add_time']));
            $zan_status=M('user_person')->where(array('person_id'=>$v['person_id'],'user_id'=>$user_id))->select();
            if($zan_status){
                $list[$k]['zan_status']=1;
            }else{
                $list[$k]['zan_status']=0;
            }
    }
        if($list){
            echo json(0,'人物返回成功',$list);
        }else{
            echo json(1,'人物返回失败');
        }
    }
    public function like(){
        $where['user_id']=I("user_id");
        $where['person_id']=I("person_id");
        $zan_status = M('user_person')->where($where)->getfield('zan_status');
        if($zan_status==1){
            echo json(1,'已点赞');
        }else{
            $zan_count = M('person')->where('person_id='.I("person_id"))->getfield('person_zan_count');
            $data1['person_zan_count']=$zan_count+1;
            $save1 = M('person')->where('person_id='.I("person_id"))->save($data1);
            $list['person_zan_count']=$data1['person_zan_count'];

            $data['user_id']=I("user_id");
            $data['person_id']=I("person_id");
            $data['zan_status']=1;
            $save2 = M('user_person')->add($data);
            $list['zan_status']=$data['zan_status'];
            if($save1&&$save2){
                echo json(0,'点赞成功',$list);
            }else{
                echo json(1,'点赞失败');
            }
        }
    }
}