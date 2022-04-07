<?php
namespace App\Models;
class MailModel
{

    public static $title = [
        '게시글이 등록 되었습니다.',
        '문의글이 등록 되었습니다.',
        '답변이 등록 되었습니다.',
    ];

    public static function sortMailAdd( string $mail ) : array
    {
        helper('text');
        $mail_ = reduce_multiples(preg_replace("/\s+/", "", $mail), ",", true);
        return explode(',', $mail_);
    }

    public static function getMainMail() : array
    {
        $data = get_config_data('config', 'info')['data']['company']??[];
        return ['name' => $data['name']??'', 'email'=> $data['email']??'' ];
    }

    public static function send(array $to, int $key, string $content) : bool
    {
        $data = self::getMainMail();
        $head = '['.$data['name'].']';
        $email = \Config\Services::email();
        $email->setFrom( $data['email'], $data['name']) ;
        $email->setTo( $to );
        $email->setSubject( $head.' '.self::$title[ $key ] );
        $email->setMessage( $content );
        return $email->send();
    }
}