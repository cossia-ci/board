<?php
namespace App\Models;
use App\Models\BaseModel;
class BoardConfig
{
    private $data;
    public function __construct(string $code)
    {
        $model = new BaseModel('co_board_list');
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
            $value['retur_url'] = urlencode($_SERVER['REQUEST_URI']);
        }
        return $value;
    }
    
    public function getReadAuth( array $value = [] ) : array
    {
        $value['bool'] = $this->authCheck( $this->data['auth']['read'], 'read' );
        if( !$value['bool'] ){
            $value = $this->getAuthMsg( $this->data['auth']['read'] );
            $value['retur_url'] = urlencode($_SERVER['REQUEST_URI']);
        }
        return $value;
    }

    public function getAuthMsg( string $auth, array $value = [] ) : array
    {
        switch($auth){
            case 'mem' :
                $value = ['msg'=>'로그인이 필요합니다.', 'url'=>'/log-in'];
            break;
            case 'adm' : case 'n' :
                $value = ['msg'=>'권한이 없습니다.', 'url'=>'/'];
            break;
            case 'sps' :
                $value = is_login() ? ['msg'=>'권한이 없습니다.', 'url'=>'/'] : ['msg'=>'로그인이 필요합니다.', 'url'=>'/log-in'];
            break;
        }
        $value['bool'] = false;
        return $value;
    }

    public function authCheck( string $auth, string $type = '', bool $bool = false ) : bool
    {
        switch($auth){
            case 'all' : $bool = true;  break;
            case 'mem' :
                $bool = is_admin() ? true : is_login();
            break;
            case 'adm' : case 'n' :
                $bool = is_admin();
            break;
            case 'sps' :
                if( is_admin() ) $bool = true;
                else if( is_login() )
                    $bool = in_array( $this->memberLevel(), $this->data['auth'][$type.'sps'] );
            break;
        }
        return $bool;
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
            'file' => is_admin() ? true : $this->convertBool( $this->data['item']['file'] ),
            'edtimg' => is_admin() ? true : $this->convertBool( $this->data['item']['edtimg'] ),
            'code' => $this->data['code'],
            'basic' => $this->data['basic'],
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