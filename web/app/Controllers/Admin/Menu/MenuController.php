<?php
namespace App\Controllers\Admin\Menu;
use App\Models\Menu\FrontMenu;
use App\Models\BaseModel;
class MenuController extends \App\Controllers\Admin\Controller
{
    public function index()
    {
        $this->setBody(['menu', 'front']);
        $this->setNave(['최고관리자', '메뉴 관리']);
        $menu = new FrontMenu( true );
		$this->setData( 'menuList', json_encode( $menu->getTreeData() ) );
        $model = new BaseModel('co_boardList');
		$model->select('code, name')->orderBy('ano DESC');
		$this->setData('boardList', json_encode( $model->findAll() ) );
    }
}