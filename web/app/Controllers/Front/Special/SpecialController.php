<?php
namespace App\Controllers\Front\Special;
use App\Models\BaseModel;
class SpecialController extends \App\Controllers\Front\Controller
{
    public function info( $code )
    {
        $this->setBody(['special', $code]);
        $model = new BaseModel('co_faq');
        $data = $model->orderBy('sort ASC')->findAll();
        $this->setData('data', $data);
        
    }
}