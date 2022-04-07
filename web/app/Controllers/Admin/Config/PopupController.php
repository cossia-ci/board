<?php
namespace App\Controllers\Admin\Config;
use App\Models\BaseModel;
class PopupController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['config', 'popup'],'config/popup-list');
        $this->setNave(['기본설정', '팝업관리']);
        $model = new \App\Models\BaseModel('co_popup');
        if(isset($_GET['title'])&&$_GET['title']) $model->like('title',$_GET['title']);
        if(isset($_GET['type'])&&$_GET['type']&&$_GET['type']!='all')$model->where('type',$_GET['type']);
        if(isset($_GET['isView'])&&$_GET['isView']&&$_GET['isView']!='all')$model->where('isView',$_GET['isView']);
        if(isset($_GET['sDate'])&&$_GET['sDate']) {
            switch($_GET['key']){
                case 'regDt' : $model->where('DATE(regDt) >= ', $_GET['sDate']); break;
                case 'viewDt' : $model->where('DATE(sDate) <= ', $_GET['sDate']); break;
            }
        }
        if(isset($_GET['eDate'])&&$_GET['eDate']) {
            switch($_GET['key']){
                case 'regDt' : $model->where('DATE(regDt) <= ', $_GET['eDate']); break;
                case 'viewDt' : $model->where('DATE(eDate) >= ', $_GET['eDate']); break;
            }
        }
        $data = $model->orderBy('ano','DESC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
        $this->setData('total', $model->countAll());
    }

    public function regist()
    {
        $this->setBody(['config', 'popup'],'config/popup-regist');
        $this->setNave(['기본설정', '팝업관리']);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new \App\Models\BaseModel('co_popup');
            $data = $model->where(['ano'=>$_GET['ano']])->first();
        }
        $this->setData('data', $data);
    }

    
}