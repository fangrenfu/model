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


use app\common\access\MyService;

class Schedulechange extends MyService{
    /**
     * @param int $page
     * @param int $rows
     * @return array|null
     */
    function getSummary($page=1,$rows=20,$year,$term,$status=''){
        $result=null;
        $condition=null;
        $condition['year']=$year;
        $condition['term']=$term;
        if($status!='')     $condition['schedulechange.enable']=1;
        $data=$this->query->table('schedulechange')->join('timesectors','timesectors.name=schedulechange.time')
            ->join('schools','schools.school=schedulechange.school')
            ->page($page,$rows)->where($condition)
            ->field('schedulechange.school,rtrim(schools.name) schoolname,count(*) times,sum(sxjunit) hours')
            ->group('schedulechange.school,schools.name')
            ->order('school')->select();
        $count= $this->query->table('schedulechange')->join('timesectors','timesectors.name=schedulechange.time')->where($condition)
            ->count('distinct schedulechange.school');
        if(is_array($data)&&count($data)>0)
            $result=array('total'=>$count,'rows'=>$data);
        return $result;
    }
} 