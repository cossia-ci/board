<?php
namespace App\Controllers\Front\Mypage;
use App\Models\BaseModel;
class IndexController extends \App\Controllers\Front\Controller
{
    public function index()
    {
        return redirect()->to('/mypage/qna-list');
        // $this->setBody(['mypage','index']);
    }
}