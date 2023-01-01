<?php
namespace App\Models;
use App\Models\BaseModel;
use App\Models\ImageModel;
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

    public static function makeThumb( &$post, string $code = null )
    {
        if( $code ){
            $model = new BaseModel('co_boardList');
            $list = $model->select('list')->where('code', $code)->first()['list'];
        }else{
            # 게시판이 아닐때 500*500 으로 잡아줌 2022-11-02
            $list['thumb'] = ['width'=>500, 'height'=>500];
        }
        $post = [
            'name'=> $post['name'],
            'path' => $post['path'],
            'thumb' => ImageModel::makeThumb( $post['path'], $list['thumb']['width']??100, $list['thumb']['height']??100 )
        ];
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

    public function editorUpLoad()
    {
        # ckEditor 4
        $rule = [
            'userfile' => [
                'label' => 'Image File',
                'rules' => 'uploaded[upload]|is_image[upload]|mime_in[upload,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
            ]
        ];
        if (!$this->validate($rule)) {
            $data_ = [
                'uploaded'=>0,
                'fileName'=>'',
                'url'=> '',
                'error' => ['message'=>'이미지 파일만 업로드가 가능합니다.']
            ];
        }else{
            $data = self::singleUpload( $this->request->getFiles()['upload'] );
            $data_ = [ 'filename' => $data['name'], 'url' => $data['path'], 'uploaded' => 1 ];
        }
        echo json_encode( $data_ );
        # ckEditor 5
        # $data = self::singleUpload( $this->request->getFiles()['upload'] );
        # echo json_encode( [ 'url' => $data['path'] ] );
        exit;
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
        $response = service('response');
        return $response->download( implode('/', self::pathExplode($_GET['from']) ), null )
                        ->setFileName($_GET['to']);
    }

    public static function pathExplode($path)
    {
        $path = explode('/', urldecode( $path ) );
        return array_filter($path);
    }

    public static function oldSessionDelete()
    {
        helper('filesystem');
		$map = directory_map('../writable/session/');
		foreach( $map as $val ){
			$file = WRITEPATH.'session/'.$val;
			if( filemtime( $file ) <= strtotime( date('Y-m-d', strtotime('-1 day')) ) ) @unlink($file);
		}
    }

    public static function getHeaderInfo($name)
    {
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