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

namespace app\common\service;


use app\common\access\Item;
use app\common\access\MyAccess;
use app\common\access\MyException;
use app\common\access\MyService;
use think\Db;
use think\Exception;

/**学生信息
 * Class Student
 * @package app\common\service
 */
class Student extends MyService {
    public static function getName($openid)
    {
        $condition=null;
        $condition['openid']=$openid;
        $data=Db::table('student')->field("isnull(name,'') name")->where($condition)->find();
        if(is_array($data))
            return $data['name'];
        else
            return '';
    }

    //设置昵称
    public static function  save($postData){
        $data['name']=$postData['name'];
        $data['openid']=session('openid');
        Db::table('student')->insert($data);
        return   $result=array('info'=>'成功','status'=>'1');
    }
} 