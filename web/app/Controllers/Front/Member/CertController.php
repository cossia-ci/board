<?php
namespace App\Controllers\Front\Member;
use App\Models\AuthModel;
use App\Models\BaseModel;
class CertController extends \App\Controllers\Front\Controller
{
	public function logIn()
	{
		$this->setBody(['member','login']);
        $this->setData( 'bool', $this->getCfgBool() );
	}

    public function JoinUs()
    {
        $this->setBody(['member','joinus']);
        $this->setData('cfg', get_config_data('member','join')['data']);
    }

    public function postLogin()
    {
        $ano = AuthModel::getMemberAno( $_POST['id'] );
        if( !$ano ) return redirect()->to('/log-in')->with('error', '접속정보를 확인해 주세요');
        if( !AuthModel::verifyPassword( $ano, $_POST['password'] ) )
            return redirect()->to('/log-in')->with('error', '접속정보를 확인해 주세요');
        if( AuthModel::login( $ano ) )
            return redirect()->to($_POST['retur_url']??'/');
    }

    public function postJoin()
    {
        $model = new BaseModel('co_member');
        \App\Models\FileModel::fileRecursion( $_POST, $this->request->getFiles() );
        $result = $model->save($_POST);
        return ( $result ) ? '<script>parent.alert("처리되었습니다.","/join-end","success");</script>' :
        '<script>parent.alert("일시적 오류 입니다.","","error");</script>';
    }

    public function logOut()
    {
        AuthModel::logout();
        return redirect()->to('/')->with('success', '로그아웃 되었습니다.');
        exit;
    }

    public function JoinEnd()
    {
        $this->setBody(['member', 'joinEnd']);
    }

    public function postFind()
    {
        $model = new BaseModel('co_member');
        switch( $_POST['type'] ){
            case 'id' :
                $data = $model->where('JSON_EXTRACT(`info`, "$.name") = "'.$_POST['name'].'"', null, false)
                            ->where('JSON_EXTRACT(`info`, "$.phone") = "'.$_POST['phone'].'"', null, false)
                            ->first();
            break;
            case 'pw' :
                $data = $model->where('JSON_EXTRACT(`info`, "$.name") = "'.$_POST['name'].'"', null, false)
                            ->where('JSON_EXTRACT(`info`, "$.phone") = "'.$_POST['phone'].'"', null, false)
                            ->where('id', $_POST['id'])
                            ->first();
            break;
        }
        if( isset($data['ano']) && $data['ano'] ){
            return redirect()->to('/finded-'.$_POST['type'])->with('ano', $data['ano']);
        }else{
            return redirect()->to('/find-'.$_POST['type'])->with('error', '정확한 정보를 입력해 주세요');
        }
    }

    public function findedId()
    {
        if( !session('ano') ) return redirect()->to('/')->with('error', '올바른 접속 방법이 아닙니다.');
        $this->setBody(['member','findedid']);
        $model = new BaseModel('co_member');
        $this->setData('id', $model->select('id')->where('ano', session('ano'))->first()['id']);
    }

    public function findedPw()
    {
        if( !session('ano') ) return redirect()->to('/')->with('error', '올바른 접속 방법이 아닙니다.');
        $this->setBody(['member','findedpw']);
        $this->setData('ano', session('ano'));
    }

    public function findId()
    {
        if( !$this->getCfgBool() ){
            return redirect()->to('/')->with('error', '사용할 수 없는 기능입니다.');
            exit;
        }
        $this->setBody(['member', 'findid']);
    }

    public function findPw()
    {
        if( !$this->getCfgBool() ){
            return redirect()->to('/')->with('error', '사용할 수 없는 기능입니다.');
            exit;
        }
        $this->setBody(['member', 'findpw']);
    }

    public function getCfgBool( bool $bool = false ) : bool
    {
        $data = get_config_data('member','join')['data'];
        if( $data['personal']['name'] == 'm' && $data['personal']['phone'] == 'm' ) $bool = true;
        return $bool;
    }

}