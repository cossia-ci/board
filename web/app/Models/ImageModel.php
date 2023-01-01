<?php
namespace App\Models;
class ImageModel extends \CodeIgniter\Model
{
    public static function makeThumb( string $path, int $width, int $height )
    {
        $arr = explode('/', $path);
        $arr[0] = 'thumbnail';
        $name = array_pop($arr);
        $path_ = implode('/', $arr);
        self::makeDir( $path_ );
        $thumbnail = '/'.$path_.'/'.$name;
        $image = \Config\Services::image();
        $image->withFile( FCPATH.$path )
              ->fit($width, $height, 'center')
# resize 일 경우 비율때문에 의도에 맞지 않음
#              ->resize($width, $height, true, 'height')
              ->save(FCPATH.$thumbnail);
        return $thumbnail;
    }

    public static function makeDir( string $path ) : void
    {
        if( !is_dir(FCPATH.$path) ) mkdir(FCPATH.$path, 0777, true);
    }

    # 아직 작동 안함
    public static function watermarking( string $path, string $text = '' )
    {
        $image = \Config\Services::image();
        $image->withFile( FCPATH.$path )
                ->text($text, [
                    'color'      => '#fff',
                    'opacity'    => 0.5,
                    'withShadow' => true,
                    'hAlign'     => 'center',
                    'vAlign'     => 'bottom',
                    'fontSize'   => 20,
                ])
                ->save(FCPATH.$path);
    }
}