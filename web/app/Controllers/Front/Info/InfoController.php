<?php
namespace App\Controllers\Front\Info;
use App\Models\BaseModel;
class InfoController extends \App\Controllers\Front\Controller
{
	public function info( $code )
	{
        $skin = match( $code ){
            'agreement' => 'agreement',
            default => 'base'
        };
		$this->setBody( [ 'info', $skin ] );
        $this->setData( 'data', get_config_data('infos', $code)['data']??'' );
        $this->setData('parser', \Config\Services::parser());
        $this->setData('data_', get_change_word());
	}
}