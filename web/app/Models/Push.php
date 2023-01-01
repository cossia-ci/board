<?php
namespace App\Models;
use Google\Client;
use Config\Services;
use App\Models\FileModel;
use App\Models\BaseModel;
class Push
{
    public $url = 'https://fcm.googleapis.com';
    public $id;
	public $head;
	public $data;
	public $title;
	public $msg;
	public $link;
	public $uuid = [];
	public $token;
	public $titleTpl = [];
    public $parserData = [];
    
    public function __construct()
    {
        $data = get_config_data('config','app');
        $this->setTitleTpl( $data['data']['msg'] );
        $this->id = $data['data']['id'];
        $client = new Client;
        $json = FCPATH . implode('/', FileModel::pathExplode( $data['data']['file']['path'] ) );
        $client->setAuthConfigFile( $json );
		$client->addScope('https://www.googleapis.com/auth/firebase.messaging');
		$client->refreshTokenWithAssertion();
		$this->head = [
			'Authorization'=>'Bearer '.$client->getAccessToken()['access_token'],
			'Content-Type'=>'application/json'
		];
    }

    public function setTitleTpl( array $arr = [] )
    {
        foreach( $arr as $row ){
            $this->titleTpl[$row['code']] = ['title' => $row['title'], 'msg' => $row['msg']];
        }
    }

    public function changeText( string $text = '' ) : string
    {
        $parser = \Config\Services::parser();
        return $parser->setData($this->parserData)->renderString($text);
    }

    public function setMsgCode( string $code )
    {
        $this->title = $this->changeText( $this->titleTpl[ $code ]['title'] );
        $this->msg = $this->changeText( $this->titleTpl[ $code ]['msg'] );
        return $this;
    }

    public function setLink( string $link = '' )  // FULL url 붙혀줌
    {
        $this->link = base_url() . $link;
        return $this;
    }

    public function setSendUsrs( int $ano )
    {
        $model = new BaseModel('co_member');
        $this->uuid = $model->select( 'uuid' )->find( $ano )['uuid'];
        return $this;
    }

    public function setMsg()
    {
        $this->data = [
			'message' => [
				'token' => $this->uuid,
				'name' => 'my_notification',
				'notification' => [
					'title' => $this->title,
					'body' => $this->msg,
				],
				'apns' => [
					'payload' => [
						'aps' => [
							'sound' => 'default',
							'badge' => 1,
							'content-available' => 1
						]
					]
				],
				'data' => [
					'notification_foreground' => 'true',
					'title' => $this->title,
					'link_url' => $this->link?:'',
					'notification_android_sound' => 'mysound',
					'notification_android_channel_id' => 'my_channel_id',
					'message' => $this->msg
				]
			]
		];
        return $this;
    }

    public function send()
    {
        $data = [
            'headers' => $this->head,
            'json' => $this->data,
        ];
        $curl = Services::curlrequest( [ 'baseURI' => $this->url ] );
        $result = $curl->request( 'POST', '/v1/projects/'.$this->id.'/messages:send', $data );
        return json_decode($result->getBody(), true);
    }
}