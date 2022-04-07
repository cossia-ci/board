<?php
namespace App\Controllers\Admin\Board;
use App\Models\BaseModel;
class FaqController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $this->setBody(['board', 'faq'], 'board/faq-list');
        $this->setNave(['게시판관리', 'FAQ']);
        $model = new BaseModel('co_faq');
		if( isset($_GET['question']) && $_GET['question'] ) $model->like('question', $_GET['question']);
		if( isset($_GET['sDate']) && $_GET['sDate'] ) $model->whrer( 'DATE(`regDt`) >= ', $_GET['sDate'] );
		if( isset($_GET['eDate']) && $_GET['eDate'] ) $model->whrer( 'DATE(`regDt`) <= ', $_GET['eDate'] );
		$data = $model->orderBy('`sort` ASC')->paginate($_GET['perPage']);
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
        $this->setData('total', $model->countAll());
    }

    public function regist()
    {
        $this->setBody(['board', 'faq'], 'board/faq-regist');
        $this->setNave(['게시판관리', 'FAQ']);
        $data = [];
		if( isset($_GET['ano']) && $_GET['ano'] ){
			$model = new BaseModel('co_faq');
			$data = $model->find($_GET['ano']);
		}
		$this->setData('data', $data);
    }

    
}