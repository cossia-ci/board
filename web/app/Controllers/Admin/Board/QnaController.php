<?php
namespace App\Controllers\Admin\Board;
use App\Models\BaseModel;
class QnaController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['board', 'qna'], 'board/qna-list');
        $this->setNave(['게시판관리', '1:1 문의']);
        $_GET['type'] = $_GET['type'] ?? ['y', 'n'];
        $model = new BaseModel('co_qna');

        if( isset($_GET['keyword']) && $_GET['keyword'] ) $model->like($_GET['key'], $_GET['keyword']);
        if( count( $_GET['type'] ) != 2 ) {
            switch( $_GET['type'][0] ){
                case 'y' : $model->where('admin_id IS NOT NULL', null, false); break;
                case 'n' : $model->where('admin_id IS NULL', null, false); break;
            }
        }
        if( isset($_GET['sDate']) && $_GET['sDate'] ) $this->where('DATE(regDt) >= ', $_GET['sDate']);
        if( isset($_GET['eDate']) && $_GET['eDate'] ) $this->where('DATE(regDt) <= ', $_GET['eDate']);
        $data = $model->orderBy('ano DESC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
    }

    public function read()
    {
        $this->setBody(['board', 'qna'], 'board/qna-read');
        $this->setNave(['게시판관리', '1:1 문의']);
        $model = new BaseModel('co_qna');
        $this->setData('data', $model->find($_GET['ano']));
    }
}