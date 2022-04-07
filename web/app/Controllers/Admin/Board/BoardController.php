<?php
namespace App\Controllers\Admin\Board;
use App\Models\BaseModel;
class BoardController extends \App\Controllers\Admin\Controller
{
	public function list()
    {
        $this->setBody(['board', 'list']);
        $this->setNave(['게시판관리', '게시판목록']);
        $_GET['type'] = $_GET['type'] ?? ['default','gallery','event','youtube','write'];
        $model = new BaseModel('co_board_list');
        if( isset($_GET['keyword']) && $_GET['keyword'] ) $model->like($_GET['key'], $_GET['keyword']);
        if( count( $_GET['type'] ) != 5 ) $model->whereIn( 'type' , $_GET['type'] );
        if( isset($_GET['sDate']) && $_GET['sDate'] ) $this->where('DATE(regDt) >= ', $_GET['sDate']);
        if( isset($_GET['eDate']) && $_GET['eDate'] ) $this->where('DATE(regDt) <= ', $_GET['eDate']);

        $data = $model->orderBy('ano DESC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
    }

    public function regist()
    {
        $model = new BaseModel('co_memberLevel');
        $level = $model->orderBy('level ASC')->findAll();
        if( !$level ) return redirect()->to('/admin/member/memlevel-list')->with('error', '회원 등급이 없습니다.');
        $this->setBody(['board', 'list'],'board/regist');
        $this->setNave(['게시판관리', '게시판등록']);
        $this->setData('level', $level);
        $data = [];
        if( isset( $_GET['ano'] ) && $_GET['ano'] ){
            $model = new BaseModel('co_board_list');
            $data = $model->find( $_GET['ano'] );
        }
        $this->setData('data', $data);
    }

}