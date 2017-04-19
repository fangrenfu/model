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
// | Created:2017/4/18 11:14
// +----------------------------------------------------------------------

namespace app\common\service;


use app\common\access\MyAccess;
use think\Db;

class Discuss extends MyAccess {
    public static function getView($page=1,$rows=10,$videoid){
        $condition=null;
        $condition['map']=$videoid;
        $result=Db::table('discuss')->field('title name,date,id')->order('date desc')
            ->where($condition)
            ->page($page,$rows)
            ->select();
        return $result;
    }
}