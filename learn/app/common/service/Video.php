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
// | Created:2017/4/13 15:14
// +----------------------------------------------------------------------

namespace app\common\service;


use app\common\access\MyService;
use think\Db;

class Video  extends MyService{
    //网页中读取课程的视频列表
    public static function getView($page=1,$rows=10,$courseid){
        $condition=null;
        $condition['courseid']=$courseid;
        $result=Db::table('video')->field('name,rank,path url,id')->order('rank')
            ->where($condition)
            ->page($page,$rows)
            ->select();
        return $result;
    }
    //获取上一个video，没有为写自己，和没有了。
    public static function getLastVideo($id){
        $result=null;
        $condition=null;
        $condition['video.id']=$id;
        $data=Db::table('video')
            ->join('video v','v.courseid=video.courseid')
            ->where('video.rank>v.rank')
            ->where($condition)->field('v.id,v.name,v.rank')
            ->order('rank desc')
            ->limit(1)->select();
        if(!is_array($data)||count($data)!=1) {
            $result=array("id"=>$id,"name"=>"没有了");
        }
        else
            $result=$data[0];
        return $result;
    }
    //获取下一个video
    public static function getNextVideo($id){
        $result=null;
        $condition=null;
        $condition['video.id']=$id;
        $data=Db::table('video')
            ->join('video v','v.courseid=video.courseid')
            ->where('video.rank<v.rank')
            ->where($condition)->field('v.id,v.name,v.rank')
            ->order('rank')
            ->limit(1)->select();
        if(!is_array($data)||count($data)!=1) {
            $result=array("id"=>$id,"name"=>"没有了");
        }
        else
            $result=$data[0];
        return $result;
    }
}