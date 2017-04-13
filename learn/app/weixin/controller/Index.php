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
// | Created:2017/4/13 13:14
// +----------------------------------------------------------------------

namespace app\weixin\controller;


use app\common\access\Item;
use think\Controller;
use think\Request;

class Index extends Controller {
    public function _initialize(){

        $request = Request::instance();
        $openid= $request->param('openid');
        session('openid',$openid);
        $root=$request->root();
        $action=$root.'/'.$request->module().'/'.$request->controller().'/'.$request->action();
        $this->assign("ROOT", $root);
        $this->assign("ACTION",strtolower($action));

        $this->assign("TITLE",config('site.title'));
        $this->assign("COPYRIGHT",config('site.copyright'));
    }
    public function index(){

        echo session('openid');
    }
    //课程信息
    public function course($id=0){
        $course=Item::getCourseItem($id);
        $this->assign("course", $course);
        return $this->fetch();
    }
    //我的课程
    public function mycourse(){

        return $this->fetch();
    }
    //视频播放
    public function play($id){

        return $this->fetch();
    }
}