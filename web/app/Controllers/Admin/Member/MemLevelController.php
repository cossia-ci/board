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
        if( isset($_GET['keyword']) && $_GET['keyword'] ) $model->like( $_GET['key'], $_GET['keyword'] );
        if( isset($_GET['sDate']) && $_GET['sDate'] ) $model->where('DATE(regDt) >= ', $_GET['sDate']);
        if( isset($_GET['eDate']) && $_GET['eDate'] ) $model->where('DATE(regDt) <= ', $_GET['eDate']);

        $data = $model->orderBy('level ASC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
    }

    public function regist()
    {
        $this->setBody(['member', 'level'], 'member/levelregist');
        $this->setNave(['회원관리', '등급관리']);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new BaseModel('co_memberLevel');
            $data = $model->find($_GET['ano']);
        }
        $this->setData('data', $data);
    }
}