<?php
/**
 * Created by PhpStorm.
 * User: Lorder
 * Date: 2018/3/21
 * Time: 12:25
 */
//json 封装
function json($code,$message,$data=""){
    return json_encode(array('code'=>$code,'message'=>$message,'data'=>$data));
    exit;
}

//小时前
function tranTime($time)
{
    $rtime = date("m-d H:i",$time);

    $time = time() - $time;

    if ($time < 60)
    {
        $str = '刚刚';
    }
    elseif ($time < 60 * 60)
    {
        $min = floor($time/60);
        $str = $min.'分钟前';
    }
    elseif ($time < 60 * 60 * 24)
    {
        $h = floor($time/(60*60));
        $str = $h.'小时前 ';
    }
    else
    {
        $str =$rtime;
    }
    return $str;
}

function jb_sp_pic_upload($pic){
    //图片上传
    $upload = new \Think\Upload();// 实例化上传类
    $image = new \Think\Image();// 实例化上传类
    $data = array();
    $upload->maxSize   =     22213145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','xls','xlsx','doc','txt','pdf','mp4');// 设置附件上传类型
    $upload->rootPath  =      './data/upload/jianban/'; // 设置附件上传根目录
    $upload->savePath  =      ''; // 设置附件上传（子）目录
    $upload->thumb=true;
    // 上传文件
    $info   =   $upload->upload();
//	return $info;exit;
    if(!$info) {// 上传错误提示错误信息
//        $this->error($upload->getError());
    }else{// 上传成功 获取上传文件信息
        foreach($info as $file){
            if($file['ext'] == "MP4" ||$file['ext'] == "mp4"){
                $thumb_img = 'jianban/'.$file['savepath'].$file['savename'];
            }else{
                $img = './data/upload/jianban/'.$file['savepath'].$file['savename'];
                $size = $image->open($img)->size(); // 返回图片的尺寸数组 0 图片宽度 1 图片高度
                if($size[0]<=500 && $size[1]<=500){
                    $thumb_img = "jianban/".$file['savepath'].$file['savename'];
                }else{
                    $image->open('./data/upload/jianban/'.$file['savepath'].$file['savename'])
                        ->thumb(500, 500)
                        ->save("./data/upload/jianban/".$file['savepath']."s_500".$file['savename']);
                    $thumb_img = "jianban/".$file['savepath']."s_500".$file['savename'];
                    unlink($img);
                }
            }
        }
    }
    return $thumb_img;
//return $size;

}