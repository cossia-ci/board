<?php
namespace App\Controllers\Admin\Config;
use App\Models\BaseModel;
class BannerController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['config', 'banner'],'config/banner-list');
        $this->setNave(['기본설정', '배너관리']);
        $model = new \App\Models\BaseModel('co_banner');

        if(isset($_GET['keyword'])&&$_GET['keyword']) $model->like($_GET['key'],$_GET['keyword']);

        $data = $model->orderBy('ano','DESC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
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