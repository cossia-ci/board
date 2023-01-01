<?php
namespace App\Controllers\Admin\Member;

class SocialController extends \App\Controllers\Admin\Controller
{
    public function index()
    {
        $this->setBody(['member', 'social']);
        $this->setData('data', get_config_data('config','social'));
        $this->setNave(['회원관리', '소셜 로그인 설정']);
    }
}