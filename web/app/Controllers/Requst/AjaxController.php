<?php
namespace App\Controllers\Requst;
use App\Models\BaseModel;
use App\Models\BoardModel;
class AjaxController extends \CodeIgniter\Controller
{
    protected $helpers = ['inflector'];
    public function adminMenu()
    {
        $result = '';
        switch($_POST['type']){
            case 'sort' :
                $model = new BaseModel('co_adminMenu');
                foreach( $_POST['data'] as $key => $row ){
                    if( is_numeric($row['id']) && $row['id'] != 0 ){
                        $parent = is_numeric($row['parent']) ? $row['parent'] : 0;
                        $result = $model->save(['parent'=>$parent, 'sort'=>$key, 'isView'=>$row['isView'], 'ano'=>$row['id']]);
                    }
                }
            break;
            case 'frontsort' :
                $model = new BaseModel('co_frontMenu');
                foreach( $_POST['data'] as $key => $row ){
                    if( is_numeric($row['id']) && $row['id'] != 0 ){
                        $parent = is_numeric($row['parent']) ? $row['parent'] : 0;
                        $result = $model->save(['parent'=>$parent, 'sort'=>$key, 'isView'=>$row['isView'], 'ano'=>$row['id']]);
                    }
                }
            break;
        }
        return json_encode( $result );
    }

    public function editorUpload()
    {
        $file = new \App\Models\CossiaFile;
        $result = $file->singleUpload( $this->request->getFile('upload'), true);
        $data = [
            'uploaded'=>0,
            'fileName'=>'',
            'url'=> ''
        ];
        if( $result )
            $data = [
                'uploaded'=>1,
                'fileName'=>$result['name'],
                'url'=> $result['path']
            ];
        echo json_encode( $data , JSON_NUMERIC_CHECK );
        // return 으로 하면 안먹힘
        exit;
    }

    public function delete()
    {
        $model = new BaseModel('co_'.camelize($_POST['table']));
        $result = $model->whereIn('ano', $_POST['ano'])->delete();
        return json_encode( $result );
    }

    public function overlapCustom()
    {
        $model = new BaseModel('co_'.camelize($_POST['table']));
		$cnt = $model->selectCount('ano')->where($_POST['filde'], $_POST[$_POST['filde']])->first()['ano'];
        return json_encode( $cnt == 0 ? true : false );
    }

    public function bdpwValidat()
    {
        $model = new BoardModel( $_POST['code'] );
        $data = $model->find($_POST['ano']);
        $bool = false;
        if( is_admin() || $data['user_id'] == session('member.ano') || $data['pw'] == $_POST['pw'] ){
            session()->setFlashdata($_POST['code'].$_POST['ano'], true);
            $bool = true;
        }
        return json_encode( $bool );
    }

    public function deleteBoard()
    {
        $db = db_connect();
        foreach( $_POST['ano'] as $row ){
            $sql = 'SELECT `code` FROM `co_boardList` WHERE `ano` = '.$row;
            $code = $db->query($sql)->getResult('array')[0]['code'];
            $db->query('DROP TABLE co_bd_'.$code);
            $db->query('DROP TABLE co_cmt_'.$code);
            $db->query('DELETE FROM `co_boardList` WHERE `ano` = '.$row);
        }
        return json_encode( true );
    }

    public function deleteContent()
    {
        $model = new BoardModel($_POST['code']);
		$result = $model->whereIn('ano', $_POST['ano'])->delete();
        return json_encode( $result );
    }

    public function tableUpdate()
    {
        $model = new BaseModel('co_'.camelize($_POST['table']));
        $result = $model->set( $_POST['field'], $_POST['value'] )->whereIn('ano', $_POST['ano'])->update();
        return json_encode( $result );
    }

    public function overlapFmenu()
    {
        $model = new BaseModel('co_frontMenu');
        if( isset($_POST['ano']) && $_POST['ano'] ){
            $param = [ 'ano != '=>$_POST['ano'], 'type' => $_POST['type'], 'link' => $_POST['link'] ];
        }else{
            $param = [ 'type' => $_POST['type'], 'link' => $_POST['link'] ];
        }
        $cnt = $model->selectCount('*', 'cnt')->where($param)->first()['cnt'];
        return json_encode( $cnt == 0 ? true : false );
    }
}