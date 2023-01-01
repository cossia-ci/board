<?php
namespace App\Controllers\Requst;
use App\Models\BoardModel;
use App\Models\BaseModel;
use App\Models\FileModel;
use App\Models\MailModel;
class BoardController extends \CodeIgniter\Controller
{
    public function regist()
    {
        $model = new BaseModel('co_boardList');
        $result = $model->save( $this->request->getPost() );
        if( !$_POST['ano'] && $result ){
            new BoardModel($_POST['code']);
            new BoardModel($_POST['code'], 'cmd');
        }
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","/admin/board/board-list","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }

    public function index()
    {
        $model = new BoardModel($this->request->getPost('code'));
        if( isset($_POST['return']) && $_POST['return'] ){
            $return = $_POST['return'];
        } else $return = 'reload';

        $files = $this->request->getFiles();
        FileModel::fileRecursion( $_POST, $files, true );
        # 썸네일 자동변환 추가 2022-10-11
        if( isset($_POST['thumbnail']) && is_array($_POST['thumbnail']) && isset($files['thumbnail']) && $files['thumbnail']->getTempName() ){
            FileModel::makeThumb( $_POST['thumbnail'], $_POST['code'] );
        }
       $result = $model->save( $_POST );

        # if( isset($_POST['sendmail']) && $_POST['sendmail'] ){
        #     $mail = MailModel::sortMailAdd($_POST['sendmail']);
        #     if( isset($_POST['etc']['email']) && $_POST['etc']['email'] ) $mail[] = $_POST['etc']['email'];
        #     MailModel::send( $mail , 0, $_POST['content']);
        # }
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","'.$return.'","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }

    public function comment()
    {
        $model = new BoardModel($this->request->getPost('code'), 'comment');
        $result = $model->save( $this->request->getPost() );
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","reload","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }

    public function delete()
    {
        $model = new BoardModel( $this->request->getPost('code') );
        $data = $model->find( $this->request->getPost('ano') );
        $result = false;
        if( is_admin() || $data['user_id'] == session('member.ano') ){
            $result = $model->where('ano', $this->request->getPost('ano'))->delete();
        }
        return json_encode( $result );
    }
}