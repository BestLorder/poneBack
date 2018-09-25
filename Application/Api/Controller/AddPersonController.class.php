<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class AddPersonController extends CommonController {
    public function index(){
        $data['user_id'] = I("user_id");
        $data['person_name'] = I("name");
        $data['person_intro'] = I("intro");
        $base64_image = I("head");

        //上传图片
        if(I("head")){
            $time = date('YmdHis', time());
            $url2 = "data/upload/hp/" . $data['user_id'] . '_' . $time . '.jpg';
            $photo = I("head");
            $base64_string = explode(',', $photo); //截取data:image/png;base64, 这个逗号后的字符
            $pic = base64_decode($base64_string[1]);//对截取后的字符使用base64_decode进行解码
            file_put_contents($url2, $pic); //写入
            $data['person_head'] = substr($url2,12);
        }
        $data['type_id'] = 0;
        $data['add_time'] = $time;
        $list=M('person')
            ->add($data);

        if($list){
            echo json(1,'人物创建成功');
        }else{
            echo json(0,'人物创建失败');
        }
}

}