<?php
namespace App\Controllers\Front\Widget;
use App\Models\BaseModel;
use App\Models\BoardModel;
class Widget
{
    public static function getBoradSome( string $code, int $limit = 5, string $skin = 'default' )
    {
        $model = new BoardModel($code);
        $data = $model->setLimt($limit)->getList();
        echo view('Front/widget/board_'.$skin.'.html', ['data'=>$data['data'], 'code'=>$code]);
    }

    public static function bannerView( string $code, string $skin = 'default'  )
    {
        $model = new BaseModel('co_banner');
        $data = $model->where(['code' => $code ])->first();
        if( $data ) echo view('Front/widget/banner_'.$skin.'.html', ['data'=>$data]);
    }
    
    public static function popups()
    {
        $uri = explode('?', uri_string(true));
        $model = new BaseModel('co_popup');
        $model->where(['isView' => 'y'])
            ->groupStart()
                ->where(['sDate' => '0000-00-00'])
                ->orWhere('DATE(`sDate`) <= ', date('Y-m-d'))
            ->groupEnd()
            ->groupStart()
                ->where(['eDate' => '0000-00-00'])
                ->orWhere('DATE(`eDate`) >= ', date('Y-m-d'))
            ->groupEnd()
            ->groupStart()
                ->where(['sTime' => '00:00:00'])
                ->orWhere('TIME(`sTime`) <= ', date('H:i:s'))
            ->groupEnd()
            ->groupStart()
                ->where(['eTime' => '00:00:00'])
                ->orWhere('TIME(`eTime`) >= ', date('H:i:s'))
            ->groupEnd()
            ->groupStart()
                ->where(['page' => ''])
                ->orWhere(['page' => $uri[0] ?? '' ])
            ->groupEnd()
            ->groupStart()
                ->where(['param' => ''])
                ->orWhere(['param' => $uri[0] ?? ''])
            ->groupEnd();
        $popup = $model->findAll();
        helper('cookie');
        if( $popup ){
            foreach( $popup as $row ){
                if( !get_cookie( 'popup-'.$row['ano'] ) ){
                    $skin = ($row['type'] == 'l') ? 'pop_layer' : 'pop_header';
                    echo view('Front/widget/'.$skin.'.html', ['data'=>$row]);
                }
            }
        }
        
    }
}