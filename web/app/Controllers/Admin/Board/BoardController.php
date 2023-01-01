<?php
namespace App\Controllers\Admin\Board;
use App\Models\BaseModel;
class BoardController extends \App\Controllers\Admin\Controller
{
	public function list()
    {
        $this->setBody(['board', 'list']);
        $this->setNave(['게시판관리', '게시판목록']);
        $_GET['type'] = $_GET['type'] ?? array_keys( get_board_type() );
        $model = new BaseModel('co_boardList');
        if( count( $_GET['type'] ) != count( get_board_type() ) ) $model->whereIn( 'type' , $_GET['type'] );
        $data = $model->setWhere()->orderBy('ano DESC')->getList();
        $this->setData('data', $data['data']);
        $this->setData('page', $data['page']);
    }

    public function regist()
    {
        helper('filesystem');
        $model = new BaseModel('co_memberLevel');
        $level = $model->orderBy('level ASC')->findAll();
        if( !$level ) return redirect()->to('/admin/member/memlevel-list')->with('error', '회원 등급이 없습니다.');
        $this->setBody(['board', 'list'],'board/regist');
        $this->setNave(['게시판관리', '게시판등록']);
        $this->setData('level', $level);
        $data = [];
        if( isset( $_GET['ano'] ) && $_GET['ano'] ){
            $model = new BaseModel('co_boardList');
            $data = $model->find( $_GET['ano'] );
        }
        $this->setData('data', $data);
        $this->setData('skinList', directory_map('../Views/Front/board/list/', false, true) );
        $this->setData('skinRead', directory_map('../Views/Front/board/read/', false, true) );
        $this->setData('skinWrite', directory_map('../Views/Front/board/write/', false, true) );
    }
}