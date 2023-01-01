<?php
namespace App\Controllers\Admin\Manager;
use App\Models\AuthModel;
use App\Models\BaseModel;
class CertController extends \App\Controllers\Admin\Controller
{
	public function logIn()
	{
        echo view('Admin/manager/login.html');
        echo view('Admin/outline/footer.html');
        exit;
	}

    public function postLogIn()
    {
        # 관리자 로그인 시도 할때 어제날까 까지의 세션을 삭제한다.
        \App\Models\FileModel::oldSessionDelete();

        $ano = AuthModel::getMemberAno( $_POST['email'], 'manager' );
        if( !$ano ) return redirect()->to('/admin/login')->with('error', '접속정보를 확인해 주세요');
        if( !AuthModel::verifyPassword( $ano, $_POST['password'], 'manager' ) )
            return redirect()->to('/admin/login')->with('error', '접속정보를 확인해 주세요');
        if( AuthModel::login( $ano, 'manager' ) )
            return redirect()->to('/admin');
    }

    public function logOut()
    {
        AuthModel::logout('manager');
        return redirect()->to('/admin/login')->with('success', '로그아웃 되었습니다.');
        exit;
    }

    public function myInfo()
    {
        $this->setBody(['manager', 'myinfo']);
        $this->setNave(['관리자 정보 관리']);
        $model = new BaseModel('co_manager');
        $data = $model->find( session('manager.ano') );
        $this->setData('data', $data);
    }
}