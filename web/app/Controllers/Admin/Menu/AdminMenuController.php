<?php
namespace App\Controllers\Admin\Menu;
use App\Models\Menu\AdminMenu;
class AdminMenuController extends \App\Controllers\Admin\Controller
{
    public function index()
    {
        $this->setBody(['menu', 'admin']);
        $this->setNave(['관리자 메뉴 관리']);
        $menu = new AdminMenu( true );
        $this->setData('menuList', json_encode($menu->getTreeData()));
    }
}