<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 2016/6/19 9:57
// +----------------------------------------------------------------------

namespace app\all\controller;


use app\common\access\Item;
use app\common\access\MyAccess;

class Info
{
    //获取课名
    public function  getcourseinfo($id)
    {
        $result = null;
        $status = 1;
        $coursename= null;
        $credits=null;
        $hours=null;
        try {
            $result = Item::getCourseItem($id, false);
            if ($result != null) {
                $coursename= $result['coursename'];
                $credits=$result['credits'];
                $hours=$result['hours'];
                $status = 1;
            } else {
                $coursename = '该课程不存在!';
                $status = 0;
            }
        } catch (\Exception $e) {
            MyAccess::throwException($e->getCode(), $e->getMessage());
        }
        return json(["status" => $status, 'coursename' => $coursename,'hours'=>$hours,'credits'=>$credits]);
    }
}
