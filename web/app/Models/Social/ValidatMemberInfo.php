<?php
namespace App\Models\Social;
use App\Models\BaseModel;
class ValidatMemberInfo
{  
    public static function validateId( array $param ) : int
    {
        $model = new BaseModel('co_member');
        $ano = $model->select('ano')
                ->where(['socialId'=>$param['id'],'channel'=>$param['channel']])
                ->first();
        return $ano['ano']??0;
    }

    public static function validateApp( $ano ) : bool
    {
        $model = new BaseModel('co_member');
        $app = $model->select('app')->find( $ano );
        return $app == 'y' ? false : true;
    }

    public static function validateFilde( array $data = [], string $filed = '' ) : bool
    {
        helper('array');
        $filed .= ( strpos($filed, 'add', -3) !== false ) ? '.post' : '';
        return dot_array_search($filed, $data) != '' ? true : false;
    }

    public static function foreachInfors( array $data, array $arr, string $key_ ) : bool
    {
        $bool = true;
        foreach( $arr as $key => $val ){
            if( $key != 'use' && $val != 'n' ){
                $bool = self::validateFilde( $data, $key_.'.'.$key );
                if( $bool === false ) break;
            }
        }
        return $bool;
    }
    
    public static function validateMemberInfo( int $ano ) : bool
    {
        $model = new BaseModel('co_member');
        $data = $model->find( $ano );
        $cfg = get_config_data('member','join')['data'];
        $bool = [true, true, true];
        $bool[0] = self::foreachInfors( $data, $cfg['personal'], 'info' );
        if( $cfg['biz']['use'] == 'y' ) $bool[1] = self::foreachInfors( $data, $cfg['biz'], 'biz' );
        if( $cfg['etc']['use'] == 'y' ) $bool[2] = self::foreachInfors( $data, $cfg['etc'], 'etc' );
        if( in_array(false, $bool) ){
            return false;
        }else{
            return true;
        }
    }
}