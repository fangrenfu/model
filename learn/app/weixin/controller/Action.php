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
// | Created:2017/4/19 10:45
// +----------------------------------------------------------------------

namespace app\weixin\controller;


use app\common\service\Discuss;
use app\common\service\DiscussDetail;
use app\common\service\Learn;
use app\common\service\Student;

class Action {
    function add(){
        $result=DiscussDetail::add($_POST);
        return json($result);
    }

    function newdiscuss(){
        $result=Discuss::add($_POST);
        return json($result);
    }

    function delete(){
        $result= Learn::remove($_POST);
        return json($result);
    }
    function save(){
        $result=Student::save($_POST);
        return json($result);
    }

}