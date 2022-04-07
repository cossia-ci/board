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
        $model = new BaseModel('co_board_list');
        $result = $model->save( $_POST );
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
        $model = new BoardModel($_POST['code']);
        if( isset($_POST['return']) && $_POST['return'] ){
            $return = $_POST['return'];
        } else $return = 'reload';

        FileModel::fileRecursion( $_POST, $this->request->getFiles() );
        $result = $model->save($_POST);

        if( isset($_POST['sendmail']) && $_POST['sendmail'] ){
            $mail = MailModel::sortMailAdd($_POST['sendmail']);
            if( isset($_POST['etc']['email']) && $_POST['etc']['email'] ) $mail[] = $_POST['etc']['email'];
            MailModel::send( $mail , 0, $_POST['content']);
        }

        return ( $result ) ? '<script>parent.alert("처리되었습니다.","'.$return.'","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }

    public function comment()
    {
        $model = new BoardModel($_POST['code'], 'comment');
        $result = $model->save($_POST);
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","reload","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }

    public function delete()
    {
        $model = new BoardModel($_POST['code']);
        $data = $model->find( $_POST['ano'] );
        $result = false;
        if( is_admin() || $data['user_id'] == session('member.ano') ){
            $result = $model->where('ano', $_POST['ano'])->delete();
        }
        return json_encode( $result );
    }
}