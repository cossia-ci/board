<?php
# super 전용
namespace App\Controllers\Admin\Config;
use App\Models\BaseModel;
use App\Models\Push;
class AppConfigController extends \App\Controllers\Admin\Controller
{
    public function config()
    {
        $this->setBody(['menu', 'app']);
        $this->setData('data', get_config_data('config','app'));

        
        # $push = new Push;
        # $push->setMsgCode('test')
        #      ->setSendUsrs(1)
        #      ->setLink('/bdlist/notice')
        #      ->setMsg()->send();
        # $result = $push->setMsgCode('test2')->setMsg()->send();
        # print_r( $result );
        # Array ( [name] => projects/carrypro-aab4a/messages/0:1662424522512050%24e570ed24e570ed )
        
    }
}