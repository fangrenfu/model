<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 2016/11/13 9:21
// +----------------------------------------------------------------------
namespace app\wechat\controller;

use app\common\vendor\WeChat;

class Index {
    public function index($echostr='',$signature='',$timestamp='',$nonce=''){
        $token=config('token');
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
}