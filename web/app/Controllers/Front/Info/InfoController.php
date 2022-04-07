<?php
namespace App\Controllers\Front\Info;
use App\Models\BaseModel;
class InfoController extends \App\Controllers\Front\Controller
{
	public function info( $code )
	{
        $skin = $code == 'agreement' ? 'agreement' : 'base';
		$this->setBody( [ 'info', $skin ] );
        $this->setData( 'data', get_config_data('infos', $code)['data'] );
	}
}