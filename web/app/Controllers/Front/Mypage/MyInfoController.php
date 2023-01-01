<?php
namespace App\Controllers\Front\Mypage;
use App\Models\BaseModel;
class MyInfoController extends \App\Controllers\Front\Controller
{
    public function index()
    {
        $this->setBody(['mypage','my-info']);
        $this->setData('cfg', get_config_data('member','join')['data']);
        $model = new BaseModel('co_member');
        $this->setData('data', $model->find( session('member.ano') ) );
    }
}