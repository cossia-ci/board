<?php
namespace App\Controllers\Admin\Main;
use App\Models\BaseModel;
class IndexController extends \App\Controllers\Admin\Controller
{
	public function index()
	{
		$this->setBody(['main', 'index']);
		$this->setData('memo', get_config_data('manager', 'memo', true));
		$model = new BaseModel('co_board_list');
		$bdCd = $model->select('code')->findAll();
		$bdtotal = 0;
		if( $bdCd ){
			foreach( $bdCd as $row ) $bdtotal += get_count_table('co_bd_'.$row['code']);
		}
		$this->setData('bdtotal', $bdtotal);
	}
}