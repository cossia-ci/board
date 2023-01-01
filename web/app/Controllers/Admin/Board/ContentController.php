<?php
namespace App\Controllers\Admin\Board;
use App\Models\BaseModel;
use App\Models\BoardModel;
use App\Models\BoardConfig;
class ContentController extends \App\Controllers\Admin\Controller
{
    public function list()
	{
        $model = new BaseModel('co_boardList');
        $codes = $model->select('code, name')->findAll();
        if( !$codes ) return redirect()->to('/admin/board/board-list')->with('error', '게시판 목록이 없습니다.');
        $_GET['code'] = $_GET['code'] ?? $codes[0]['code'];
        
        $this->setBody(['board', 'content'],'board/content-list');
        $this->setNave(['게시판관리', '게시글관리']);
        $this->setData('codes', $codes);
        $horse_ = $model->select('item')->where('code', $_GET['code'])->first()['item'];
        $this->setData('horse', $horse_['horse']??[]);
        $model = new BoardModel($_GET['code']);
        $data = $model->setWhere($_GET)->setLimt()->getList();
        $this->setData('data', $data['data']);
        $this->setData('page', $data['page']);
	}

    public function read()
    {
        $this->setBody(['board', 'content'], 'board/content-read');
        $this->setNave(['게시판관리', '게시글관리']);
        $cfg_ = new BoardConfig($_GET['code']);
        $cfg = $cfg_->getReadSet();
        $this->setData('cfg', $cfg);
        $model = new BoardModel( $_GET['code'] );
        $data = $model->find( $_GET['ano'] );
        $this->setData('data', $data);
    }

    public function regist()
    {
        $this->setBody(['board', 'content'], 'board/content-regist');
        $this->setNave(['게시판관리', '게시글관리']);
        $cfg_ = new BoardConfig($_GET['code']);
        $cfg = $cfg_->getWriteSet();
        $this->setData('cfg', $cfg);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new BoardModel( $_GET['code'] );
            $data = $model->find( $_GET['ano'] );
        }
        $this->setData('data', $data);
    }
}