<?php
namespace Theme\Controller;
use Think\Controller;
use Think\Cache;
include "phpqrcode.php";
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
    public function person(){
        $user_id = I("user_id");
        $where['person_id']=I("id");
        $list=M('person')
            ->field('person_id,theme')
            ->where($where)
            ->find();
        if($list){
            echo json(0,'人物返回成功',$list);
        }else{
            echo json(1,'人物返回失败');
        }
    }

    public function video(){
        $video=jb_sp_pic_upload($_FILES);
        $where['person_id']=1;
        $data['video']=$video;
        $list=M('person')
            ->where($where)
            ->save($data);
//        jb_sp_pic_upload($_FILES['mp4']);
        echo json(1,'',$list);
    }
//    点赞
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
//    生成二维码
    public function makeCode()
    {
        $id = I('id');
        $cache = Cache::getInstance(); //获取项目的url地址切换二维码生成地址
        $url = "http://localhost:8080/#/Person/" . $id;
        $sel = M("person")->where(array("person_id" => $id))->find();
        if (!$sel) {
            echo json(3, "id 不存在");
            exit;
        } else {

//            if ($sel['logo'] == "default/moren.jpg") {
//                $photo = "logo.png"; //头像
//            } else {
//                //判断是否有缩略图
//                if ($sel['thumbsimg']) {
////                    $photo = "data/upload/thumb/" . $sel['thumbsimg']; //头像
//                } else {
//                    //生成缩略图
//                    $url = $sel['person_head'];
//                    $data = "data/upload/thumb";
//
////                    $thumbsimg = caijian($url, $data, $id);
//                    $thumbsimg = $url;
//
//                    $datass['thumbsimg'] = substr($thumbsimg, 12);
//                    M("person")->where(array("id" => $id))->save($datass);
//                    $photo = "data/upload/" . $datass['thumbsimg'];
//                }
//            }
//            $data = "data/upload";
//            $url = $sel['person_head'];
//            $image = new \Think\Image();
//            $image->open($data.$url);
//            // 生成一个居中裁剪为150*150的缩略图并保存为thumb.jpg
//            $newurl = "data/upload/thumb/";
//            $image->thumb(150, 150,\Think\Image::IMAGE_THUMB_CENTER)->save($newurl.$id.'.jpg');
//            $photo = $newurl.$id.'.jpg';

            $photo = "data/upload/" . $sel['person_head'];
            $pngaddress = "data/upload/qrCode/" . $id . '.' . 'png'; //生成的二维码

            $this->qrCode($url, $photo, $id, $pngaddress);  //调用二维码生成
            $data['qrcode'] = "qrCode/" . $id . ".png";  //存入数据库
            if (strlen($data['qrcode']) > 1) {
                $datas['qrcode'] = $data['qrcode'];
//                $datas['thumbsimg'] ="thumb/".$id.".jpg";
                $ress = M("person")->where(array("person_id" => $id))->save($datas);
//                $data = "eventqrcodes/" . $id . ".png";
                //查询数据库
                $selss = M("person")->field("qrcode")->where(array("person_id" => $id))->find();
                if ($selss['qrcode']) {
                    echo json(0, "二维码修改成功", $datas);
                    exit;
                } else {
                    $this->makeCode($id);
                    exit;
                }

            } else {
                $this->makeCode($id);
                exit;
            }


        }
    }

    private function qrCode($url,$photo,$id,$pngaddress){
        $value = $url; //二维码内容
        $errorCorrectionLevel = 'H';//容错级别
        $matrixPointSize =1000;//生成图片大小
        //生成二维码图片

        \QRcode::png($value,"qrcode.png", $errorCorrectionLevel, $matrixPointSize, 2);
        $logo = $photo;//获取传来的的图片
        $QR = "qrcode.png";//已经生成的原始二维码图
        $png =$pngaddress;

        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            if (imageistruecolor($logo))
            {
                imagetruecolortopalette($logo, false, 65535);//添加这行代码来解决颜色失真问题
            }
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        //输出图片
        imagepng($QR, $png);

//        echo '<img src="/'.$png.'">'; //测试输出

    }

//二维码裁剪
    private function caijian($url,$data,$id){
        $image = new \Think\Image();
        $image->open($data.$url);
        // 生成一个居中裁剪为150*150的缩略图并保存为thumb.jpg
        $newurl = "data/upload/thumb/";
        $image->thumb(150, 150,\Think\Image::IMAGE_THUMB_CENTER)->save($newurl.$id.'.jpg');
        $new_url = $newurl.$id.'.jpg';
        return $new_url;exit;
    }
}