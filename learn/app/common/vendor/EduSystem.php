<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 2016/11/13 9:44
// +----------------------------------------------------------------------

namespace app\common\vendor;


class EduSystem {
    /**对文本信息的响应
     * @param $postObj
     * @return string
     */
    public static function responseText($postObj){
        $toUsername = $postObj->FromUserName;
        $fromUsername = $postObj->ToUserName;
        $studentno='';
        $content = strtolower(trim($postObj->Content));
        //如果描述字符超过10个，转人工服务
        if(mb_strlen($content,'UTF8')>10)
            return WeChat::humanService($fromUsername,$toUsername);
        else {
            $keywords = explode(' ',$content);
            switch($keywords[0]){
                //成绩查询
                case 'cj':

                    return self::score($studentno);
                //课表
                case 'kb':
                    return self::table($studentno);
                default:
                    return "";
            }
        }
    }
    //回应事件
    public static function responseEvent($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $event=$postObj->Event;
        $resultStr='';
        switch($event){
            case 'subscribe': //关注事件
                $contentStr="欢迎关注宁波城市学院微教务!作为学生您可以绑定个人学号，获取本人各类成绩、课表、学分认定、考试安排等信息，并查询最新教务办事流程。\r\n使用前请绑定学号。";
                $resultStr=WeChat::textFormat($fromUsername,$toUsername,$contentStr);
                break;
            case 'CLICK': //按钮事件
                $resultStr=self::clickButton($postObj);
                break;
            default:break;
        }
        return $resultStr;
    }

    /**点击按钮事件
     * @param $postObj
     * @return string
     */
    private static function clickButton($postObj){
        return '';
    }
    private static function score($postObj){
        return '';
    }

    private static function table($postObj){
        return '';
    }
}