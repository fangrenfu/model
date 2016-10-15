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
namespace app\base\controller;

use app\common\access\Item;
use app\common\access\MyAccess;
use app\common\access\Template;
use app\common\service\Action;
use app\common\service\Classes;
use app\common\service\Classroom;
use app\common\service\RoomReserve;
use app\common\service\Schedule;
use app\common\service\Student;

class Index extends Template
{
    public function index()
    {
        $Obj = new Action();
        $menuJson = array('menus' => $Obj->getUserAccessMenu(session('S_USER_NAME'), 240));
        $this->assign('menu', json_encode($menuJson));
        return $this->fetch();
    }

    public function studentdetail($studentno = '', $op = '')
    {
        $student = null;
        if ($studentno != '' && $op != 'add') {
            MyAccess::checkStudentSchool($studentno);
            $obj = new Student();
            $student = $obj->getStudentDetail($studentno);
        }
        $this->assign('student', $student);
        return $this->fetch();


    }

    function roomtimetable($year = '', $term = '', $roomno = '')
    {
        try {
            $title['year'] = $year;
            $title['term'] = $term;
            $title['time'] = date("Y-m-d H:i:s");
            $title['roomname']=Item::getRoomItem($roomno)['name'];
            $this->assign('title', $title);
            $schedule = new Schedule();
            $time = $schedule->getRoomTimeTable($year, $term, $roomno);
            $this->assign('time', $time);

        } catch (\Exception $e) {
            MyAccess::throwException($e->getCode(), $e->getMessage());
        }
        return $this->fetch();

    }

    function roomtimetableall($year = '', $term = '', $roomno = '')
    {
        try {
            $title['year'] = $year;
            $title['term'] = $term;
            $title['time'] = date("Y-m-d H:i:s");
            $title['roomname']=Item::getRoomItem($roomno)['name'];
            $this->assign('title', $title);
            $schedule = new Schedule();
            $time = $schedule->getRoomTimeTable($year, $term, $roomno, true);
            $this->assign('time', $time);
        } catch (\Exception $e) {
            MyAccess::throwException($e->getCode(), $e->getMessage());
        }
        return $this->fetch();
    }

    function roomreservenote($recno)
    {
        try {

            $room = new RoomReserve();
            $reserve = $room->getReserveRoomInfo($recno);
            if($reserve['approved']==0) {
                echo '教室申请尚未通过审核,无法打印！';
                exit;
            }
            $reserve['printdate'] = date("Y-m-d");
            $reserve['weeks'] = implode(' ', str_split(week_dec2bin_reserve($reserve['weeks'], 18), 4));
            $this->assign('reserve', $reserve);

        } catch (\Exception $e) {
            MyAccess::throwException($e->getCode(), $e->getMessage());
        }
        return $this->fetch();
    }

    function classstudent($classno)
    {
        try {

            $class=new Classes();
            $classname = $class->getClassInfo($classno)['classname'];
            $this->assign('classname', $classname);
            $this->assign('classno', $classno);

        } catch (\Exception $e) {
            MyAccess::throwException($e->getCode(), $e->getMessage());
        }
        return $this->fetch();
    }
} 