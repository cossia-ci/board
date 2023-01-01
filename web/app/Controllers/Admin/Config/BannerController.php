<?php
namespace App\Controllers\Admin\Config;
use App\Models\BaseModel;
class BannerController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['config', 'banner'],'config/banner-list');
        $this->setNave(['기본설정', '배너관리']);
        $model = new BaseModel('co_banner');
        $data = $model->setWhere()->orderBy('ano DESC')->getList();
        $this->setData('data', $data['data']);
        $this->setData('page', $data['page']);
        $this->setData('total', $model->countAll());
    }

    public function regist()
    {
        $this->setBody(['config', 'banner'],'config/banner-regist');
        $this->setNave(['기본설정', '배너관리']);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new \App\Models\BaseModel('co_banner');
            $data = $model->where(['ano'=>$_GET['ano']])->first();
        }
        $this->setData('data', $data);
    }

    
}