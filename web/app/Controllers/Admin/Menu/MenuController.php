<?php
namespace App\Controllers\Admin\Menu;
use App\Models\Menu\FrontMenu;
use App\Models\BaseModel;
class MenuController extends \App\Controllers\Admin\Controller
{
    public function index()
    {
        $this->setBody(['menu', 'front']);
        $this->setNave(['메뉴 관리']);
        $menu = new FrontMenu( true );
		$this->setData( 'menuList', json_encode( $menu->getTreeData() ) );
        $model = new BaseModel('co_board_list');
		$model->select('code, name')->orderBy('ano DESC');
		$this->setData('boardList', json_encode( $model->findAll() ) );
    }
}