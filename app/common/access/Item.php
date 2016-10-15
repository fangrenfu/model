<?php
// +----------------------------------------------------------------------
// |  [ MAKE YOUR WORK EASIER]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2016 http://www.nbcc.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangrenfu <fangrenfu@126.com> 2016/6/19 10:20
// +----------------------------------------------------------------------

namespace app\common\access;

use think\Db;
use think\Exception;

/**获取各种对象的关键属性
 * Class Item
 * @package app\common\access
 */
class Item {
    /**根据教室号获取教室信息
     * @param $roomno
     * @param bool $alert
     * @return null
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public static function  getRoomItem($roomno,$alert=true){
        $condition=null;
        $result=null;
        $condition['roomno']=$roomno;
        $data=Db::table('classrooms')->where($condition)->field('rtrim(jsn) name,status,reserved')->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('roomno:' . $roomno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }

    /**根据课号获取课程
     * @param string $courseno
     * @param bool $alert
     * @return null
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public static function getCourseItem($courseno,$alert=true){
        $result=null;
        $condition=null;
        $condition['courseno']=$courseno;
        $data=Db::table('courses')->where($condition)->field('rtrim(coursename) as coursename,courseno')->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('courseno:' . $courseno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }

    /**获取教学计划
     * @param $programno
     * @param bool $alert
     * @return null
     * @throws Exception
     */
    public static function getProgramItem($programno,$alert=true){
        $result=null;
        $condition=null;
        $condition['programno']=$programno;
        $data=Db::table('programs')->where($condition)->field('rtrim(progname) as progname')->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('programno:' . $programno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }

    /**获取开课计划
     * @param $year
     * @param $term
     * @param $courseno
     * @param bool $alert
     * @return null
     * @throws Exception
     */
    public static function getSchedulePlanItem($year,$term,$courseno,$alert=true){
        $result=null;
        $condition=null;
        $condition['scheduleplan.year']=$year;
        $condition['scheduleplan.term']=$term;
        $condition['scheduleplan.courseno+scheduleplan.[group]']=$courseno;
        $data=Db::table('scheduleplan')
            ->join('courses','courses.courseno=scheduleplan.courseno')->where($condition)
            ->field('rtrim(coursename) as coursename,scheduleplan.courseno+scheduleplan.[group] courseno,
            scheduleplan.estimate,scheduleplan.attendents,scheduleplan.year,scheduleplan.term')
            ->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('year:' . $year.',term:'.$term.',courseno'.$courseno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }

    /**获取教师
     * @param $teacherno
     * @param bool $alert
     * @return null
     * @throws Exception
     */
    public static function getTeacherItem($teacherno,$alert=true){
        $result=null;
        $condition=null;
        $condition['teacherno']=$teacherno;
        $data=Db::table('teachers')->where($condition)->field('rtrim(name) as teachername,teacherno')->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('teacherno:' . $teacherno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }

    /**获取班级信息
     * @param $classno
     * @param bool $alert
     * @return null
     * @throws Exception
     */
    public static function getClassItem($classno,$alert=true){
        $result=null;
        $condition=null;
        $condition['classno']=$classno;
        $data=Db::table('classes')->where($condition)->field('rtrim(classname) as classname,classno,school')->select();
        if(!is_array($data)||count($data)!=1) {
            if($alert)
                throw new Exception('classno:' . $classno, MyException::ITEM_NOT_EXISTS);
        }
        else
            $result=$data[0];
        return $result;
    }
} 