<?php
namespace App\Controllers\Requst;
use App\Models\MailModel;
use App\Models\FileModel;
class PostController extends \CodeIgniter\Controller
{
    public function sendMail($mail, $key, $content)
    {
        $mail = MailModel::sortMailAdd($mail);
        MailModel::send( $mail , $key, $content );
    }
    public function index()
    {
        $model = new \App\Models\BaseModel('co_'.$_POST['table']);
        if( isset($_POST['return']) && $_POST['return'] ){
            $return = $_POST['return'];
        } else $return = 'reload';
        FileModel::fileRecursion( $_POST, $this->request->getFiles() );
        $result = $model->save($_POST);
        if( isset($_POST['sendmail']) && $_POST['sendmail'] ){
            $key = ( isset($_POST['question']) && $_POST['question'] ) ? 1 : 2;
            $this->sendMail( $_POST['sendmail'], $key, $_POST['question']??$_POST['answer'] );
        }
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","'.$return.'","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
        exit;
    }
}