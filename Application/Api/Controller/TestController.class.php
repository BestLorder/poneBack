<?php
namespace Api\Controller;
use Think\Controller;
use Think\Cache;
class TestController extends CommonController {
    public function index(){
//        $this->display('index');
        $a='http://tmp/wx53bc7341927fb5ea.o6zAJs71TzPubGBWxUw_….VkcSwFDb2nRrda1ad822b2b7af53727015c620fb0b25.jpg';
//        $a='wxfile://tmp_wx53bc7341927fb5ea.o6zAJs71TzPubGBWxUw_….VkcSwFDb2nRrda1ad822b2b7af53727015c620fb0b25.jpg';
        $array=explode('//tmp', $a);
        $b=substr($array[1],1);
        echo json(0,"test成功",$b);
}
public  function arr(){
        $a='a,b,c';
        $b=explode(',',$a);
        echo json(0,'数组成功',$b);
}
}