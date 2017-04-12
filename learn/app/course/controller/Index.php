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
namespace app\course\controller;
use app\common\access\Item;
use app\common\access\Template;
use app\common\service\Action;
class Index extends Template{
    public function index($id){
        $obj=new Action();
        $menuJson=array('menus'=>$obj->getUserAccessMenu(session('S_USER_NAME'),1008));
        $this->assign('menu',json_encode($menuJson));
        $this->assign('course',Item::getCourseItem($id));
        session('S_COURSEID', $id); //写入session
        return $this->fetch();
    }
    public function _empty($name)
    {
        $id= session('S_COURSEID');
        $this->assign('course',Item::getCourseItem($id));
        return parent::_empty($name);
    }
}