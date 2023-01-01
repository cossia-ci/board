<?php
namespace App\Controllers\Front\Main;
use App\Models\AuthModel;
class IndexController extends \App\Controllers\Front\Controller
{
	public function index()
	{
		$this->setBody(['main','index']);
		
	}
}