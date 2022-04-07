<?php
namespace App\Models;
class AuthModel
{
    public static function make_hash( string $password ) : string
    {
        return password_hash( $password, PASSWORD_BCRYPT, ['cost'=>12] );
    }

    public static function getMemberAno( string $id, string $type = 'member' ) : int
    {
        $model = new BaseModel('co_'.$type);
        $param = $type == 'member' ? ['id' => $id] : ['email' => $id];
        $data = $model->select('ano')->where($param)->first();
        return $data['ano']??0;
    }

    public static function verifyPassword( int $ano, string $pass, string $type='member', bool $data=false ) : bool
    {
        $model = new BaseModel('co_'.$type);
        $password = $model->select('password')->where(['ano'=>$ano])->first()['password'];
        if( password_verify( $pass, $password ) ) $data = true;
        return $data;
    }

    public static function logout( string $type = 'member' ) : bool
    {
        $session = session();
        $session->remove('is_'.$type);
        $session->remove($type);
        return true;
    }
    
    public static function login( int $ano, string $type = 'member' ) : bool
    {
        $session = session();
        $model = new BaseModel('co_'.$type);
        $data = $model->where(['ano'=>$ano])->first();
        $member_data['is_'.$type] = true;
        foreach( $data as $key => $val )
            if( $key != 'pw' ) $member_data[$type][$key] = $val;
        $session->set($member_data);
        return true;
    }
}