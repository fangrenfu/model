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
// | Created:2017/4/13 15:14
// +----------------------------------------------------------------------

namespace app\common\service;


use app\common\access\MyService;
use think\Db;

class Video  extends MyService{
    //网页中读取课程的视频列表
    public static function getView($page=1,$rows=10,$courseid){
        $condition=null;
        $condition['courseid']=$courseid;
        $result=Db::table('video')->field('name,rank,path url')->order('rank')
            ->where($condition)
            ->page($page,$rows)
            ->select();
        return $result;
    }
}