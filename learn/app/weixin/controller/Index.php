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

class Index {
    private function checkSignature($signature='',$timestamp='',$nonce=''){
        $token = 'weixin123456';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }
        else
            return false;
    }
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
                $this->getNewVideo($postObj);

                break;
            case 'V1_2'://新开课程
                $this->getNewCourse($postObj);
                break;
            default:
                $msg='菜单未定义！';
                $msg=WeChat::textFormat($postObj,$msg);
                break;
        }
        return $msg;
    }
    //获取最新视频
    private function getNewVideo($postObj){

    }
//    获取最新课程
    private function getNewCourse($postObj){
        $fromUsername = $postObj->FromUserName;
        $data=Db::table('')->field('')
            ->order('date desc')->limit(8)->select();

        return;
    }
}