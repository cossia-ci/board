<?php
namespace App\Models\Social;
use Config\App;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Response;
use App\Models\Social\ValidatMemberInfo;
use App\Models\BaseModel;
use App\Models\AuthModel;

class Kakao extends \CodeIgniter\Controller
{
    private $tokenUrl = 'https://kauth.kakao.com';
    private $accessUrl = 'https://kapi.kakao.com';
    private $api = '';
    
    public function __construct()
    {
        $data = get_config_data('config','social')['data'];
        $this->api = $data['kakao']['api'];
    }
    
    public function login() : void
    {
        $this->getToken( $_GET['code'] );
    }

    public function getToken( $code ) : void
    {
        $curl = new CURLRequest( new App, new URI, new Response(new App), ['baseURI'=>$this->tokenUrl]);
        $data = [
            'headers' => ['Content-Type'=>'application/x-www-form-urlencoded;charset=utf-8'],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->api,
                'redirect_uri' => base_url().'/social/kakao',
                'code' => $code,
            ],
            'http_errors' => false
        ];
        $result = $curl->request('POST', '/oauth/token', $data);
        if( $result->getStatusCode() == 200 ){
            $this->getKakaoInfo( json_decode($result->getBody(), true) );
        } else {
            $this->errorAlert( '토큰' );
        }
    }

    public function getKakaoInfo( $param ) : void
    {
        $curl = new CURLRequest( new App, new URI, new Response(new App), ['baseURI'=>$this->accessUrl]);
        $data = [
            'headers' => [
                'Authorization' => 'Bearer '.$param['access_token'],
            ],
            'http_errors' => false
        ];
        $result = $curl->request('POST', '/v2/user/me', $data);
        $this->arrangementData( json_decode( $result->getBody(), true ) );
        if( $result->getStatusCode() == 200 ){
            $this->validateId( $this->arrangementData( json_decode( $result->getBody(), true ) ) );
        } else {
            $this->errorAlert( '인증' );
        }
    }

    public function arrangementData( array $param ) : array
    {
        $data = [
            'id' => $param['id'],
            'nickname' => $param['properties']['nickname']??$param['kakao_account']['nickname']??'',
            'phone_number' => $param['properties']['kakao_account']['phone_number']??$param['kakao_account']['phone_number']??'',
            'email' => $param['properties']['kakao_account']['email']??$param['kakao_account']['email']??'',
            'gender' => $param['properties']['kakao_account']['gender']??$param['kakao_account']['gender']??'',
            'birthday' => $param['properties']['kakao_account']['birthday']??$param['kakao_account']['birthday']??'',
        ];
        return $data;
    }

    public function validateId( array $param ) : void
    {
        # 0 일경우 join 시키고 int 일경우 로그인 킨다.
        $ano = ValidatMemberInfo::validateId( ['id' => 'k_'.$param['id'], 'channel' => 'kakao'] );
        if( $ano ){
            if( !ValidatMemberInfo::validateApp( $ano ) ) $this->needAdminApp();
            else $this->loginComplete( $ano );
        }else{
            $this->autoJoin( $param );
        }
    }

    public function autoJoin( $param ) : void
    {
        $cfg = get_config_data('member','join')['data'];
        $model = new BaseModel('co_member');
        $data = [
            'socialId' => 'k_'.$param['id'],
            'level' => $cfg['appLv'],
            'app' => $cfg['app'],
            'channel' => 'kakao',
            'info' => [
                'nick' => $param['nickname']??'',
                'phone' => $param['phone_number']??'',
                'email' => $param['email']??'',
            ],
            'etc' => [
                'gender' => $param['gender']??'',
                'birthday' => $param['birthday']??'',
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