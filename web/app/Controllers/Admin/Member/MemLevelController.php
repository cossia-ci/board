<?php
namespace App\Controllers\Admin\Member;
use App\Models\BaseModel;
class MemLevelController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['member', 'level']);
        $this->setNave(['회원관리', '등급관리']);
        $model = new BaseModel('co_memberLevel');
        $data = $model->setWhere()->orderBy('level ASC')->getList();
        $this->setData('data', $data['data']);
        $this->setData('page', $data['page']);
    }

    public function regist()
    {
        $this->setBody(['member', 'level'], 'member/levelregist');
        $this->setNave(['회원관리', '등급관리']);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new BaseModel('co_memberLevel');
            $data = $model->getData($_GET['ano']);
        }
        $this->setData('data', $data);
    }
}