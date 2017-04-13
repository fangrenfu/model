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

/**课程
 * Class Courses
 * @package app\common\service
 */
class Course extends MyService {
    /**获取
     * @param int $page
     * @param int $rows
     * @return array|null
     */
    public function getList($page=1,$rows=20){
        $result=['total'=>0,'rows'=>[]];
        $condition=null;
        $data=$this->query->table('courses')->field('id,rtrim(name) name,video,student,convert(varchar,date, 120) date')->order('name')->page($page,$rows)->where($condition)->select();
        $count=$this->query->table('courses')->where($condition)->count();
        if(is_array($data)&&count($data)>0){ //小于0的话就不返回内容，防止IE下无法解析rows为NULL时的错误。
            $result=array('total'=>$count,'rows'=>$data);
        }
        return $result;
    }

    /**更新课程信息
     * @param $postData
     * @return array
     * @throws \Exception
     */
    public function  update($postData)
    {
        $updateRow = 0;
        $deleteRow = 0;
        $insertRow = 0;
        //更新部分
        //开始事务
        $this->query->startTrans();
        try {
            if (isset($postData["updated"])) {
                $updated = $postData["updated"];
                $listUpdated = json_decode($updated);
                foreach ($listUpdated as $one) {
                    $condition = null;
                    $data=null;
                    $condition['id'] = $one->id;
                    $data['name'] = $one->name;
                    $updateRow += $this->query->table('courses')->where($condition)->update($data);
                }
            }
            //删除部分
            if (isset($postData["deleted"])) {
                $updated = $postData["deleted"];
                $listUpdated = json_decode($updated);
                foreach ($listUpdated as $one) {
                    $condition = null;
                    $data=null;
                    $condition['id'] = $one->id;
                    $deleteRow += $this->query->table('courses')->where($condition)->delete();
                }
            }
            if (isset($postData["inserted"])) {
                $updated = $postData["inserted"];
                $listUpdated = json_decode($updated);
                $data = null;
                foreach ($listUpdated as $one) {
                    $data['name'] = $one->name;
                    $row = $this->query->table('courses')->insert($data);
                    if ($row > 0)
                        $insertRow++;
                }
            }
        } catch (\Exception $e) {
            $this->query->rollback();
            throw $e;
        }
        $this->query->commit();
        $info = '';
        if ($updateRow > 0) $info .= $updateRow . '条更新！</br>';
        if ($deleteRow > 0) $info .= $deleteRow . '条删除！</br>';
        if ($insertRow > 0) $info .= $insertRow . '条添加！</br>';
        $status = 1;
        if($info=='') {
            $info="没有数据被更新";
            $status=0;
        }
        $result = array('info' => $info, 'status' => $status);
        return $result;
    }
} 