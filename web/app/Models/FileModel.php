<?php
namespace App\Models;
class FileModel extends \CodeIgniter\Controller
{
    public static function singleUpload($file, bool $isBoard = false) : array
    {
        $path = self::makeDir($isBoard);
        $name_ = $file->getName();
        $name = $file->getRandomName();
        $file->move($path['url'], $name);
        return ['name'=> $name_, 'path' => $path['path'].$name ];
    }

    public static function fileRecursion( &$post, $files, bool $isBorad = false ) : void
    {
        if( is_array($files) && count($files) ){
            foreach( $files as $key => $file ){
                if( is_array($file) ) self::fileRecursion( $post[$key], $file, $isBorad );
                else if( $file->isValid() ) $post[$key] = self::singleUpload( $file, $isBorad );
            }
        }
    }

    public static function makeDir(bool $isBoard = false ) : array
    {
        $path = $isBoard ? 'board/'.date('Y/m/d/') : 'uploads/'.date('Y/m/d/');
        if( !is_dir(FCPATH.$path) ){
            mkdir(FCPATH.$path, 0777, true);
        }
        return ['path' => '/'.$path, 'url' => FCPATH.$path];
    }

    // <a href="/file-down?from=00&&to=ooo.png">다운로드</a>
    public static function fileDownLoad()
    {
        $url = self::pathExplode($_GET['from']);
        if( !$_GET['to'] ) $_GET['to'] = end( $url );
        $url = implode('/', $url);
        $ori = FCPATH.$url;
        $headers = self::getHeaderInfo( urldecode( $_GET['to'] ) );
        $ContentType = \Config\Mimes::guessTypeFromExtension( substr( strrchr( $_GET['to'] , '.' ) , 1 ) );
        header('Pragma: '. $headers['headerPragma']);
        header('Expires: 0');
        header('Cache-Control: ' . $headers['headerCachecontrol']);
        header("Cache-Control: private",false);
        header('Content-Type: '.$ContentType);
        header('Content-Disposition: attachment; filename="'.$headers['filename'].'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.(string)filesize($ori));
        ob_clean();
        flush();
        readfile($ori);
        exit;
    }

    public static function pathExplode($path)
    {
        $path = explode('/', urldecode( $path ) );
        return array_filter($path);
    }

    public static function getHeaderInfo($name){
        $ie = isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false);
        $edge = isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== false);
        if ($edge){ 
            $filename = rawurlencode($name);     
            $filename = preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1);
            $header_cachecontrol = 'private, no-transform, no-store, must-revalidate';
            $header_pragma='no-cache';
        } else {
            if($ie) {
                $filename = iconv('utf-8', 'euc-kr', $name);
                $header_cachecontrol = 'must-revalidate, post-check=0, pre-check=0';
                $header_pragma='public';
            }else{
                $filename = $name;
                $header_cachecontrol = 'private, no-transform, no-store, must-revalidate';
                $header_pragma='no-cache';
            }
        }
        return ['filename'=>$filename, 'headerCachecontrol'=>$header_cachecontrol, 'headerPragma'=>$header_pragma];
    }
}