<?php
namespace App\Controllers\Front\Mypage;
use App\Models\BaseModel;
class QnaController extends \App\Controllers\Front\Controller
{
    public function list()
    {
        $this->setBody(['mypage','qna-list']);
        $_GET['answer'] = $_GET['answer']??['y','n'];
        $model = new BaseModel('co_qna');
        $model->where('user_ano', session('member.ano'));
        if( count($_GET['answer']) != 2 ){
            match( $_GET['answer'][0] ){
                'y' => $model->where('answer IS NOT NULL', null, false),
                'n' => $model->where('answer IS NULL', null, false),
            };
            # switch( $_GET['answer'][0] ){
            #     case 'y' :  $model->where('answer IS NOT NULL', null, false);    break;
            #     case 'n' :  $model->where('answer IS NULL', null, false);        break;
            # }
        }
        if( isset($_GET['title']) && $_GET['title'] ) $model->like('title', $_GET['title'] );
        if( isset($_GET['sDate']) && $_GET['sDate'] ) $model->where('DATE( regDt ) >= ', $_GET['sDate'] );
        if( isset($_GET['eDate']) && $_GET['eDate'] ) $model->where('DATE( regDt ) <= ', $_GET['eDate'] );
        $data = $model->orderBy('ano DESC')->paginate( $_GET['perPage'] );
        $this->setData('data', $data);
        $this->setData('page', $model->pager);
    }

    public function read()
    {
        $model = new BaseModel( 'co_qna' );
        $data = $model->where(['ano'=>$_GET['ano'], 'user_ano'=>session('member.ano')])->first();
        if( !$data ) return redirect()->to('/mypage/qna-list')->with('error', '올바른 접속방법이 아닙니다.');
        $this->setBody(['mypage','qna-read']);
        $this->setData('data', $data);
    }

    public function write()
    {
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new BaseModel( 'co_qna' );
            $data = $model->where(['ano'=>$_GET['ano'], 'user_id'=>session('member.id')])->first();
            if( !$data ) return redirect()->to('/mypage/qna-list')->with('error', '올바른 접속방법이 아닙니다.');
        }
        $this->setBody(['mypage','qna-write']);
        $this->setData('data', $data);

        $email[] = \App\Models\MailModel::getMainMail()['email'];
        $email[] = get_member_email( session('member.ano') );
        $this->setData('sendmail', implode( ',', $email ) );
    }
}