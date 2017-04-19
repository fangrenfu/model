<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 
// +----------------------------------------------------------------------
// | Created:2017/4/19 14:39
// +----------------------------------------------------------------------

namespace app\common\service;


use app\common\access\Item;
use app\common\access\MyService;
use think\Db;

class Learn extends MyService{
    public static function learn($videoid){
        $video=Item::getVideoItem($videoid);
        $condition=null;
        $condition['openid']=session('openid');
        $condition['courseid']=$video['courseid'];
        Db::table('learn')->where($condition)->delete();
        $data=null;
        $data['openid']=session('openid');
        $data['courseid']=$video['courseid'];
        $data['videoid']=$videoid;
        Db::table('learn')->insert($data);
    }

    public static function remove($postData){
        $condition=null;
        $condition['courseid']=$postData['courseid'];
        $condition['openid']=session('openid');
        Db::table('learn')->where($condition)->delete();
        return   $result=array('info'=>'成功','status'=>'1');
    }
}