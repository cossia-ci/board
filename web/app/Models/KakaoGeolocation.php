<?php
namespace App\Models;
use Config\Services;
class KakaoGeolocation
{
    public $apiKey = 'c5a274dc8f466747d6b49501ee662180';
	public $host = 'dapi.kakao.com';
	public $forward = '/v2/local/search/address.json';
	public $reverse = '/v2/local/geo/coord2regioncode.json';
	public $url = '';
	public $header = [];

    public function __construct()
	{
        $options = [
            'baseURI' => $this->host,
            'timeout' => 3,
            'headers' => [
                'Authorization' => 'KakaoAK '.$this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ];
        $this->client = Services::curlrequest($options);
	}
	
	public function getAddr( $gps )
	{
		if( $gps['lat'] && $gps['lon'] ){
            $data = [
                'form_params' => [
                    'x' => $gps['lat'],
                    'y' => $gps['lon']
                ]
            ];
            return $client->request('GET', $this->reverse, $data);
            // $data['documents'][0]['address_name']
		}
		return false;
	}
	
	public function getGps( $addr )
	{
        $data = [
                'form_params' => [
                    'query' => urlencode($addr),
                ]
            ];
        return $client->request('GET', $this->forward, $data);
		//  $result['documents'][0]['x'] 127.00 ||  $result['documents'][0]['y'] 36.00
	}
}