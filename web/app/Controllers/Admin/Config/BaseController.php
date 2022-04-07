<?php
namespace App\Controllers\Admin\Config;
class BaseController extends \App\Controllers\Admin\Controller
{
	public function base()
	{
		$this->setBody(['config', 'base']);
        $this->setNave(['기본설정', '기본정보']);
        $this->setData('data', get_config_data('config','info'));
	}

	public function about()
    {
        $this->setBody(['config', 'about']);
        $this->setNave(['기본설정', '회사소개-이용약관']);
        $_GET['code'] = $_GET['code'] ?? 'company';
        $this->setData('data', get_config_data('infos', $_GET['code']));
        $this->setData('view', 'Admin/config/_'.$_GET['code'].'.html');
    }

	public function meta()
    {
        $this->setBody(['config', 'meta']);
        $this->setNave(['기본설정', '메타테그']);
        $this->setData('data', get_config_data('infos', 'meta'));
    }
}