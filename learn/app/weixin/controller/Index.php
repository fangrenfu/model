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
        if($this->checkSignature($signature,$timestamp,$nonce)){ //校验信息合法性
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
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $keyword=str_replace(' ','',$keyword);
        $Obj=D();
        //从关键词库里面检索，如果有关键字，返回相关信息，找不到的才发给客服
        $data=$Obj->query("select * from keyword where keyword like '%".$keyword."%'");
        if(count($data)>0)
        {//查找相关关键字
            $newsStr="<ArticleCount>".count($data)."</ArticleCount>
                      <Articles>";
            $site=C('WEBSITE_CONFIG.host');
            foreach($data as $one){
                $newsTpl="<item>
                                <Title><![CDATA[%s]]></Title>
                                <Description><![CDATA[%s]]></Description>
                                <PicUrl><![CDATA[%s]]></PicUrl>
                                <Url><![CDATA[%s]]></Url>
                          </item>";
                $newsStr =$newsStr.sprintf($newsTpl,trim($one['title']),trim($one['descrip']),$site.trim($one['image']),$site.trim($one['url']).'?openid='.$fromUsername);
            }
            $newsStr =$newsStr."</Articles>";
            $resultStr=$this->newsFormat($postObj,$newsStr);
        }
        else if(mb_strlen($keyword,'UTF8')<10){
            $resultStr=$this->textFormat($postObj,'没有找到相关信息，如需人工服务请描述问题信息，不能少于10个字符。');
        }
        else{
            $time = time();
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                        </xml>";
            $msgType = "transfer_customer_service";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
        }
        echo $resultStr;
    }
    //回应事件
    private function responseEvent($postObj){
        $event=$postObj->Event;
        $resultStr='';
        switch($event){
            case 'subscribe':
                $contentStr="欢迎关注宁城院自主学习平台，在这里可以利用碎片化时间开展学习。";
                $resultStr=$this->textFormat($postObj,$contentStr);
                break;
            case 'CLICK':
                $resultStr=$this->clickButton($postObj);
                break;
            default:break;
        }
        echo $resultStr;
    }
    //text文本格式化
    private  function textFormat($postObj,$contentStr){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
					</xml>";
        $msgType = "text";
        $time = time();
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        return $resultStr;
    }
    //news图文信息格式化
    private  function newsFormat($postObj,$contentStr){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        %s
					</xml>";
        $msgType = "news";
        $time = time();
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        return $resultStr;
    }
    //点击按钮绑定的事件。
    private  function  clickButton($postObj){
        $eventKey=$postObj->EventKey;
        switch($eventKey){
            case 'V1_1'://最新视频
                $this->getNewVideo($postObj);

                break;
            case 'V1_2'://新开课程
                $this->getNewCourse($postObj);
                break;
            default:
                $msg='菜单未定义！';
                $msg=$this->textFormat($postObj,$msg);
                break;
        }
        return $msg;
    }
    //获取最新视频
    private function getNewVideo($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $keyword=str_replace(' ','',$keyword);
        $Obj=D();
        //从关键词库里面检索，如果有关键字，返回相关信息，找不到的才发给客服
        $data=$Obj->query("select top 8 * from courses order by date desc" );
        if(count($data)>0)
        {//查找相关关键字
            $newsStr="<ArticleCount>".count($data)."</ArticleCount>
                      <Articles>";
            $site=C('WEBSITE_CONFIG.host');
            foreach($data as $one){
                $newsTpl="<item>
                                <Title><![CDATA[%s]]></Title>
                                <Description><![CDATA[%s]]></Description>
                                <PicUrl><![CDATA[%s]]></PicUrl>
                                <Url><![CDATA[%s]]></Url>
                          </item>";
                $newsStr =$newsStr.sprintf($newsTpl,trim($one['name']),trim($one['rem']),$site.trim($one['image']),$site.'/Learn/Course/detail?id='.trim($one['id']).'&openid='.$fromUsername);
            }
            $newsStr =$newsStr."</Articles>";
            $resultStr=$this->newsFormat($postObj,$newsStr);
        }
        else{
            $resultStr="没有找到课程";
        }
        echo $resultStr;
    }
//    获取最新课程
    private function getNewCourse($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $keyword=str_replace(' ','',$keyword);
        $Obj=D();
        //从关键词库里面检索，如果有关键字，返回相关信息，找不到的才发给客服
        $data=$Obj->query("select top 8 * from courses order by date desc" );
        if(count($data)>0)
        {//查找相关关键字
            $newsStr="<ArticleCount>".count($data)."</ArticleCount>
                      <Articles>";
            $site=C('WEBSITE_CONFIG.host');
            foreach($data as $one){
                $newsTpl="<item>
                                <Title><![CDATA[%s]]></Title>
                                <Description><![CDATA[%s]]></Description>
                                <PicUrl><![CDATA[%s]]></PicUrl>
                                <Url><![CDATA[%s]]></Url>
                          </item>";
                $newsStr =$newsStr.sprintf($newsTpl,trim($one['name']),trim($one['rem']),$site.trim($one['image']),$site.'/Learn/Course/detail?id='.trim($one['id']).'&openid='.$fromUsername);
            }
            $newsStr =$newsStr."</Articles>";
            $resultStr=$this->newsFormat($postObj,$newsStr);
        }
        else{
            $resultStr="没有找到课程";
        }
        echo $resultStr;
    }
}