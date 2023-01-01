<?php
namespace App\Models;
use App\Models\BaseModel;
class BoardConfig
{
    private $data;
    public function __construct(string $code)
    {
        $model = new BaseModel('co_boardList');
        $this->data = $model->where('code', $code)->first();
    }

    public function getType() : string
    {
        return $this->data['type'];
    }
    
    public function getListAuth( array $value = [] ) : array
    {
        $value['bool'] = $this->authCheck( $this->data['auth']['list'], 'list' );
        if( !$value['bool'] ){
            $value = $this->getAuthMsg( $this->data['auth']['list'] );
            $value['return_url'] = $this->getReturnUrl();
        }
        return $value;
    }

    public function getWriteAuth( array $value = [] ) : array
    {
        $value['bool'] = $this->authCheck( $this->data['auth']['write'], 'write' );
        if( !$value['bool'] ){
            $value = $this->getAuthMsg( $this->data['auth']['write'] );
            $value['return_url'] = $this->getReturnUrl();
        }
        return $value;
    }
    
    public function getReplayAuth( array $value = [] ) : array
    {
        $value['bool'] = $this->authCheck( $this->data['auth']['replay'], 'replay' );
        if( !$value['bool'] ){
            $value = $this->getAuthMsg( $this->data['auth']['replay'] );
            $value['return_url'] = $this->getReturnUrl();
        }
        return $value;
    }
    
    
    public function getReadAuth( array $value = [] ) : array
    {
        $value['bool'] = $this->authCheck( $this->data['auth']['read'], 'read' );
        if( !$value['bool'] ){
            $value = $this->getAuthMsg( $this->data['auth']['read'] );
            $value['return_url'] = $this->getReturnUrl();
        }
        return $value;
    }

    public function getReturnUrl() : string
    {
        return urlencode($_SERVER['REQUEST_URI']);
    }

    public function getAuthMsg( string $auth, array $value = [] ) : array
    {
        return match( $auth ){
            'mem'   =>  ['msg'=>'로그인이 필요합니다.', 'url'=>'/log-in', 'bool' => false],
            'adm'   =>  ['msg'=>'권한이 없습니다.', 'url'=>'/', 'bool' => false],
            'sps'   =>  is_login() ? ['msg'=>'권한이 없습니다.', 'url'=>'/', 'bool' => false] : 
                        ['msg'=>'로그인이 필요합니다.', 'url'=>'/log-in', 'bool' => false],
            # 코메트, replay 등 사용하지 않을때
            'n'     =>  ['msg'=>'잘못된 접근 방법 입니다.', 'url'=>'/', 'bool' => false],
        };
    }

    public function matchSps( string $type = '' ) : bool
    {
        if( is_admin() ) return true;
        else if( is_login() ) return in_array( $this->memberLevel(), $this->data['auth'][$type.'sps'] );
    }
        
    public function authCheck( string $auth, string $type = '' ) : bool
    {
        return match( $auth ){
            'all' => true,
            'mem' => is_admin() ? true : is_login(),
            'adm', 'n' => is_admin(),
            'sps' => $this->matchSps( $type )
        };
    }

    public function memberLevel() : int
    {
        if( session('member.ano') ){
            $model = new BaseModel('co_member');
            $level = $model->select('level')->find( session('member.ano') )['level'];
        }else{
            $level = 0;
        }
        return $level??0;
    }

    public function convertBool( string $yn ) : bool
    {
        return $yn == 'y' ? true : false;
    }

    public function getBtnAuth() : array
    {
        $value = [
            'write'     => is_admin() ? true : $this->authCheck( $this->data['auth']['write'], 'write' ),
            'delete'    => is_admin() ? true : false,  // 자기가 쓴 글 지울수 있도록 해야 함
            'edit'      => is_admin() ? true : false,  // 자기가 쓴 글 수정 해야 함
            'replay'    => is_admin() ? true : $this->authCheck( $this->data['auth']['replay'], 'replay' ),
        ];
        return $value;
    }

    public function getListSet() : array
    {
        $value = [
            'auth' => $this->getListAuth(),
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'skin' => $this->data['skin'],
            'type' => $this->data['type'],
            'outline' => $this->data['outline'],
            'btn' => $this->getBtnAuth(),
            'perPage' => $this->data['list']['perPage'],
            'notice' => $this->data['list']['notice'],
            'noticeView' => $this->data['list']['noticeView'],
            'horse' => $this->data['item']['horse']??null,
            'new' => $this->data['list']['new'],
            'hot' => $this->data['list']['hot'],
        ];
        return $value;
    }

    public function getReadSet() : array
    {
        $value = [
            'auth' => $this->getReadAuth(),
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'skin' => $this->data['skin'],
            'type' => $this->data['type'],
            'outline' => $this->data['outline'],
            'btn' => $this->getBtnAuth(),
            'ip' => is_admin() ? false : $this->convertBool( $this->data['item']['ip'] ),
            'comment' => $this->authCheck( $this->data['auth']['comment'], 'comment' )
        ];
        return $value;
    }

    public function getWriteSet() : array
    {
        $return = '/bdlist/'.$this->data['code'];
        if( $this->data['type'] == 'write' ) $return = '';

        $value = [
            'auth' => $this->getReadAuth(),
            'file' => is_admin() ? true : $this->convertBool( $this->data['item']['file'] ),
            'code' => $this->data['code'],
            'basic' => $this->data['basic'],
            'skin' => $this->data['skin'],
            'type' => $this->data['type'],
            'name' => $this->data['name'],
            'horse' => $this->data['item']['horse']??null,
            'secret' => $this->data['auth']['secret'],
            'write' => $this->data['write'],
            'return' => $return,
        ];
        return $value;
    }

    public function getReplaySet() : array
    {
        $return = '/bdlist/'.$this->data['code'];
        if( $this->data['type'] == 'write' ) $return = '';
        
        $value = [
            'auth' => $this->getReplayAuth(),
            'file' => is_admin() ? true : $this->convertBool( $this->data['item']['file'] ),
            'code' => $this->data['code'],
            'basic' => $this->data['basic'],
            'skin' => $this->data['skin'],
            'type' => $this->data['type'],
            'name' => $this->data['name'],
            'horse' => $this->data['item']['horse']??null,
            'secret' => $this->data['auth']['secret'],
            'write' => $this->data['write'],
            'return' => $return,
        ];
        return $value;
    }
}