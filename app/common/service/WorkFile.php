<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/7
 * Time: 14:17
 */

namespace app\common\service;


use app\common\access\MyService;

/**工作量存档
 * Class WorkFile
 * @package app\common\service
 */
class WorkFile extends  MyService {
    /**获取教师工作量详细表
     * @param int $page
     * @param int $rows
     * @param $teacherno
     * @return array|null
     */
    function getList($page=1,$rows=20,$teacherno){
        $result=['total'=>0,'rows'=>[]];
        $condition=null;
        $condition['teacherno']=$teacherno;
        $count= $this->query->table('workfile')->where($condition)->count();// 查询满足要求的总记录数
        $data=$this->query->table('workfile')->where($condition)->page($page,$rows)->order('year desc,term desc')->select();
        if(is_array($data)&&count($data)>0)
            $result=array('total'=>$count,'rows'=>$data);
        return $result;
    }

}