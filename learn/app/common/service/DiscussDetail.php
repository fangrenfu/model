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
// | Created:2017/4/18 14:48
// +----------------------------------------------------------------------

namespace app\common\service;


use app\common\access\MyService;
use think\Db;

class DiscussDetail extends MyService{
    public static function getView($page=1,$rows=10,$discussid){
        $condition=null;
        $condition['map']=$discussid;
        $result=Db::table('discussdetail')
            ->join('student','student.openid=discussdetail.openid')
            ->field('content,CONVERT(varchar(100),discussdetail.date, 120) date,id,student.name author')->order('date')
            ->where($condition)
            ->page($page,$rows)
            ->select();
        return $result;
    }
}