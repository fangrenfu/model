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
use app\common\service\Course;
use app\common\service\Discuss;
use app\common\service\DiscussDetail;
use app\common\service\Learn;
use app\common\service\Student;
use app\common\service\Video;
use think\Controller;
use think\Request;

class Index extends Controller {
    public function _initialize(){

        $request = Request::instance();
        $openid= $request->param('openid');
        if($openid!='') {
            session('openid', $openid);
        }
        $root=$request->root();
        $action=$root.'/'.$request->module().'/'.$request->controller().'/'.$request->action();
        $this->assign("ROOT", $root);
        $this->assign("ACTION",strtolower($action));
        $this->assign("TITLE",config('site.title'));
        $this->assign("COPYRIGHT",config('site.copyright'));
    }
    public function _empty($name)
    {
        return $this->fetch($name);
    }
    public function index($page=1){
        $course=Course::getView($page,5);
        $lastpage=$page<=1?1:$page-1;
        $nextpage=$page+1;
        $nav['lastpage']='?page='.$lastpage;
        $nav['nextpage']='?page='.$nextpage;
        $this->assign("course", $course);
        $this->assign("nav", $nav);
        return $this->fetch();
    }
    //课程信息
    public function course($id,$page=1){
        $course=Item::getCourseItem($id);
        $video=Video::getView($page,10,$id);

        $lastpage=$page<=1?1:$page-1;
        $nextpage=$page+1;
        $course['lastpage']='?id='.$id.'&page='.$lastpage;
        $course['nextpage']='?id='.$id.'&page='.$nextpage;
        $this->assign("course", $course);
        $this->assign("video", $video);
        return $this->fetch();
    }
    //我的课程
    public function my($page=1){
        $course=Course::getMyView($page,5);
        $lastpage=$page<=1?1:$page-1;
        $nextpage=$page+1;
        $nav['lastpage']='?page='.$lastpage;
        $nav['nextpage']='?page='.$nextpage;
        $this->assign("course", $course);
        $this->assign("nav", $nav);
        return $this->fetch();
    }
    //视频播放
    public function video($id,$page=1){
        Learn::learn($id); //加入学习列表
        $video=Item::getVideoItem($id);
        $lastvideo=Video::getLastVideo($id);
        $nextvideo=Video::getNextVideo($id);
        $discuss=Discuss::getView($page,5,$id);
        $this->assign("video", $video);
        $this->assign("lastvideo", $lastvideo);
        $this->assign("nextvideo", $nextvideo);
        $this->assign("discuss", $discuss);
        $lastpage=$page<=1?1:$page-1;
        $nextpage=$page+1;
        $nav['lastpage']=$lastpage;
        $nav['nextpage']=$nextpage;
        $nav['page']=$page;
        $this->assign("nav", $nav);
        return $this->fetch();
    }
    //讨论内容
    public function discuss($id,$page=1){
        //检查是否有昵称，没有设置的话，开始设置昵称。
        $openid=session('openid');
        if(Student::getName($openid)=='')
            return $this->fetch('newname');
        $lastpage=$page<=1?1:$page-1;
        $nextpage=$page+1;
        $nav['lastpage']=$lastpage;
        $nav['nextpage']=$nextpage;
        $nav['page']=$page;
        $discuss=Item::getDiscussItem($id);
        $discussdetail=DiscussDetail::getView($page,5,$id);
        $this->assign("discuss", $discuss);
        $this->assign("discussdetail", $discussdetail);
        $this->assign("nav", $nav);
        return $this->fetch();
    }
    public function newdiscuss($id){
        $discuss=Item::getDiscussItem($id);
        $this->assign("discuss", $discuss);
        return $this->fetch();
    }
    public function test($id=0){
        $course=Item::getCourseItem($id);
        $video=Video::getView(1,10,$id);
        $this->assign("course", $course);
        $this->assign("video", $video);
        return $this->fetch();
    }
}