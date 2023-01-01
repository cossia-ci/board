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

        if( isset($_GET['keyword']) && $_GET['keyword'] ) {
            match( $_GET['key'] ){
                'user_ano' => $model->groupStart()->like('co_member.id', $_GET['keyword'])->orLike('co_member.socialId', $_GET['keyword'])->groupEnd(),
                default => $model->like('co_qna.'.$_GET['key'], $_GET['keyword'])
            };
        }
        if( count( $_GET['type'] ) != 2 ) {
            match( $_GET['type'][0] ){
                'y' => $model->where('co_qna.admin_id IS NOT NULL', null, false),
                'n' => $model->where('co_qna.admin_id IS NULL', null, false),
            };
        }
        if( isset($_GET['sDate']) && $_GET['sDate'] ) $this->where('DATE(co_qna.regDt) >= ', $_GET['sDate']);
        if( isset($_GET['eDate']) && $_GET['eDate'] ) $this->where('DATE(co_qna.regDt) <= ', $_GET['eDate']);
        $data = $model->select('co_qna.*')->join('co_member', 'co_member.ano = co_qna.user_ano')->orderBy('co_qna.ano DESC')->paginate($_GET['perPage']);
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