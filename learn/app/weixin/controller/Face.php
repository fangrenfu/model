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
// | Created:2017/4/12 14:50
// +----------------------------------------------------------------------
namespace app\weixin\controller;
use app\common\vendor\WeChat;
use think\Db;

class Face {
    public function dispatch($echostr='',$signature='',$timestamp='',$nonce=''){
        $token = 'weixin123456';
        if(WeChat::checkSignature($token,$signature,$timestamp,$nonce)){ //校验信息合法性
            if($echostr!=''){
                echo $echostr;
                exit;
            }
            else
            {
                $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
                if (!empty($postStr)){
                    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $msgType=$postObj->MsgType;
                    switch($msgType){
                        case 'text':$this->responseText($postObj);break;
                        case 'event':$this->responseEvent($postObj);break;
                        default:break;
                    }
                }else {
                    exit;
                }
            }
        }
    }

    private function responseText($postObj){
        echo WeChat::textFormat($postObj,'正在测试，尽请期待！');
    }
    //回应事件
    private function responseEvent($postObj){
        $event=$postObj->Event;
        $resultStr='';
        switch($event){
            case 'subscribe':
                $contentStr="欢迎关注宁城院自主学习平台，在这里可以利用碎片化时间开展学习。";
                $resultStr=WeChat::textFormat($postObj,$contentStr);
                break;
            case 'CLICK':
                $resultStr=$this->clickButton($postObj);
                break;
            default:break;
        }
        echo $resultStr;
    }
    //点击按钮绑定的事件。
    private  function  clickButton($postObj){
        $eventKey=$postObj->EventKey;
        $msg='';
        switch($eventKey){
            case 'V1_1'://最新视频
                $msg=$this->getNewVideo($postObj);
                break;
            case 'V1_2'://新开课程
                $msg=$this->getNewCourse($postObj);
                break;
            case 'V2_1'://全部课程
                $msg=$this->getAllCourse($postObj);
                break;
            case 'V2_2'://我的课程
                $msg=$this->getMyCourse($postObj);
                break;
            case 'V3_1'://我的问题
                $msg=$this->getMyDiscuss($postObj);
                break;
            case 'V3_2'://我的参与
                $msg=$this->getMyAttend($postObj);
                break;
            default:
                $msg='菜单未定义！';
                $msg=WeChat::textFormat($postObj,$msg);
                break;
        }
        if($msg=="")
            $msg=WeChat::textFormat($postObj,'没有找到记录！');
        return $msg;
    }
    //获取最新视频
    private function getNewVideo($postObj){
        $data=Db::table('video')
            ->join('course','course.id=video.courseid')->field("course.name+'-'+video.name title,'' descrip,'http://weixin.nbcc.cn/learn/cover/'+course.image image,
            'http://weixin.nbcc.cn/learn/weixin/index/video?id='+convert(varchar(20),video.id) url,video.date")
            ->order('date desc')->limit(8)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }
//    获取最新课程
// $newsStr =$newsStr.sprintf($newsTpl,trim($one['title']),trim($one['descrip']),trim($one['image']),trim($one['url']).'?openid='.$fromUsername);
    private function getNewCourse($postObj){
        $data=Db::table('course')->field("name+'-'+teacher title,rem descrip,'http://weixin.nbcc.cn/learn/cover/'+image image,
         'http://weixin.nbcc.cn/learn/weixin/index/course?id='+convert(varchar(20),id) url,date")
            ->order('date desc')->limit(4)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }

    // $newsStr =$newsStr.sprintf($newsTpl,trim($one['title']),trim($one['descrip']),trim($one['image']),trim($one['url']).'?openid='.$fromUsername);
    private function getAllCourse($postObj){

        $data=Db::table('course')->field("name+'-'+teacher title,rem descrip,'http://weixin.nbcc.cn/learn/cover/'+image image,
        'http://weixin.nbcc.cn/learn/weixin/index/course?id='+convert(varchar(20),id) url,date")
            ->order('date desc')->limit(8)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }

    private function getMyCourse($postObj){
        $condition=null;
        $openid=$postObj->FromUserName.'';
        $condition['learn.openid']=$openid;
        $data=Db::table('course')
            ->join('learn','learn.courseid=course.id')
            ->field("name+'-'+teacher title,rem descrip,'http://weixin.nbcc.cn/learn/cover/'+image image,
        'http://weixin.nbcc.cn/learn/weixin/index/course?id='+convert(varchar(20),id) url,learn.date")
            ->where($condition)
            ->order('date desc')->limit(8)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }
    // $newsStr =$newsStr.sprintf($newsTpl,trim($one['title']),trim($one['descrip']),trim($one['image']),trim($one['url']).'?openid='.$fromUsername);
    private function getMyDiscuss($postObj){
        $condition=null;
        $openid=$postObj->FromUserName.'';
        $condition['openid']=$openid;
        $data=Db::table('discuss')
            ->field("title,content descrip,'http://weixin.nbcc.cn/learn/cover/topic.jpg' image,
        'http://weixin.nbcc.cn/learn/weixin/index/discuss?id='+convert(varchar(20),id) url,date")
            ->where($condition)
            ->order('date desc')->limit(8)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }

    private function getMyAttend($postObj){
        $condition=null;
        $openid=$postObj->FromUserName.'';
        $condition['discussdetail.openid']=$openid;
        $data=Db::table('discussdetail')
            ->join('discuss','discuss.id=discussdetail.map')
            ->field("discuss.title,discuss.content descrip,'http://weixin.nbcc.cn/learn/cover/topic.jpg' image,
        'http://weixin.nbcc.cn/learn/weixin/index/discuss?id='+convert(varchar(20),discuss.id) url,discussdetail.date")
            ->where($condition)
            ->order('date desc')->limit(8)->select();
        $result=WeChat::newsFormat($postObj,$data);
        return $result;
    }
}