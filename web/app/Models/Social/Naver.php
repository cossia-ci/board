<?php
namespace App\Models\Social;
use Config\App;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Response;
use App\Models\Social\ValidatMemberInfo;
use App\Models\BaseModel;
use App\Models\AuthModel;

class Naver extends \CodeIgniter\Controller
{
    private $id = '';
    private $secret = '';
    private $tokenUrl = 'https://nid.naver.com';
    private $accessUrl = 'https://openapi.naver.com';
  

    public function __construct()
    {
        $data = get_config_data('config','social')['data'];
        $this->id = $data['naver']['id'];
        $this->secret = $data['naver']['secret'];
    }

    public function login() : void
    {
        $curl = new CURLRequest( new App, new URI, new Response(new App), ['baseURI'=>$this->tokenUrl]);
        $data = [
            'headers' => ['Content-Type'=>'application/x-www-form-urlencoded;charset=utf-8'],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->id,
                'client_secret' => $this->secret,
                'redirect_uri' => urlencode(base_url().'/social/naver'),
                'code' => $_GET['code'],
                'state' => $_GET['state'],
            ],
            'http_errors' => false
        ];
        $result = $curl->request('POST', '/oauth2.0/token', $data);
        if( $result->getStatusCode() == 200 ){
            $this->getNaverInfo( json_decode($result->getBody(), true) );
        } else {
            $this->errorAlert( '토큰' );
        }
    }

    public function getNaverInfo( $param ) : void
    {
        $curl = new CURLRequest( new App, new URI, new Response(new App), ['baseURI'=>$this->accessUrl]);
        $data = [
            'headers' => ['Authorization'=>'Bearer '.$param['access_token']],
            'http_errors' => false
        ];
        $result = $curl->request('POST', '/v1/nid/me', $data);
        if( $result->getStatusCode() == 200 ){
            $this->validateId( json_decode( $result->getBody(), true ) );
        } else {
            $this->errorAlert( '인증' );
        }
    }

    public function validateId( array $param ) : void
    {
        # 0 일경우 join 시키고 int 일경우 로그인 킨다.
        $ano = ValidatMemberInfo::validateId( ['id' => 'n_'.$param['response']['id'], 'channel' => 'naver'] );
        if( $ano ){
            if( !ValidatMemberInfo::validateApp( $ano ) ) $this->needAdminApp();
            else $this->loginComplete( $ano );
        }else{
            $this->autoJoin( $param );
        }
    }

    public function autoJoin( array $param ) : void
    {
        $cfg = get_config_data('member','join')['data'];
        $model = new BaseModel('co_member');
        $data = [
            'socialId' => 'n_'.$param['response']['id'],
            'level' => $cfg['appLv'],
            'app' => $cfg['app'],
            'channel' => 'naver',
            'info' => [
                'name' => $param['response']['name']??'',
                'phone' => $param['response']['mobile']??'',
                'email' => $param['response']['email']??'',
            ],
            'etc' => [
                'gender' => $param['kakao_account']['gender']??'',
                'birthday' => $param['kakao_account']['birthday']??'',
            ],
        ];
        $model->save( $data );
        if( $cfg['app'] == 'y' ) $this->loginComplete( $model->insertID() );
        else $this->needAdminApp( true );
    }

    public function loginComplete( $ano ) : void
    {
        if( ValidatMemberInfo::validateApp( $ano ) ) $this->loginAlert( $ano );
        else $this->needAdminApp();
    }

    public function loginAlert( $ano ) : void
    {
        AuthModel::login( $ano );
        if( ValidatMemberInfo::validateMemberInfo( $ano ) ){
            echo '<script>self.close();opener.alert("로그인 되었습니다.","/");</script>';
        }else{
            echo '<script>self.close();opener.alert("회원정보 입력이 필요합니다.","/mypage");</script>';
        }
        exit;
    }



    public function needAdminApp( $isJoin = false ) : void
    {
        $text = $isJoin ? '회원가입 되었습니다.<br>' : '';
        echo '<script>self.close();opener.alert("'.$text.'관리자 승인이 필요합니다.","/");</script>';
        exit;
    }

    public function errorAlert( string $location ) : void
    {
        echo '<script>self.close();opener.alert("'.$location.' 받는 중 오류가 발생하였습니다.<br>관리자에게 문의하세요","/");</script>';
        exit;
    }
    
}