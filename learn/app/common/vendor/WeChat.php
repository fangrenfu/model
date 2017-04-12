<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 2016/11/13 9:15
// +----------------------------------------------------------------------

namespace app\common\vendor;


class WeChat {
    /**验证签名
     * @param string $token  服务器token
     * @param string $signature 签名
     * @param string $timestamp 时间印章
     * @param string $nonce 随机码
     * @return bool
     */
    public static function checkSignature($token,$signature='',$timestamp='',$nonce=''){
        $tmpArr = array($token,$timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }
        else
            return false;
    }

    /**文本信息格式化
     * @param $fromUsername string 发送者
     * @param $toUsername string 接受人openid
     * @param $contentStr string 内容
     * @return string 格式化后文本
     */
    public static  function textFormat($fromUsername,$toUsername,$contentStr){
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

    /**news图文信息格式化
     * @param $fromUsername string 发送者
     * @param $toUsername string 接受人openid
     * @param $contentStr string 内容
     * @return string 格式化后文本
     */
    public static  function newsFormat($fromUsername,$toUsername,$data){
        $resultStr="";
        if(count($data)>0)
        {//查找相关关键字
            $newsStr="<ArticleCount>".count($data)."</ArticleCount>
                      <Articles>";
            foreach($data as $one){
                $newsTpl="<item>
                                <Title><![CDATA[%s]]></Title>
                                <Description><![CDATA[%s]]></Description>
                                <PicUrl><![CDATA[%s]]></PicUrl>
                                <Url><![CDATA[%s]]></Url>
                          </item>";
                $newsStr =$newsStr.sprintf($newsTpl,trim($one['title']),trim($one['descrip']),trim($one['image']),trim($one['url']).'?openid='.$fromUsername);
            }
            $newsStr =$newsStr."</Articles>";
            $messageTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        %s
					</xml>";
            $msgType = "news";
            $time = time();
            $resultStr = sprintf($messageTpl, $fromUsername, $toUsername, $time, $msgType, $newsStr);
        }
        return $resultStr;
    }

    /**进入人工服务
     * @param $fromUsername
     * @param $toUsername
     * @return string
     */
    public static  function humanService( $fromUsername,$toUsername){
        $time = time();
        $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                        </xml>";
        $msgType = "transfer_customer_service";
        return sprintf($textTpl,$fromUsername,$toUsername, $time, $msgType);
    }
}