<?php
namespace App\Controllers\Front;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\Front\Widget\Widget;
use App\Models\Menu\FrontMenu;
class Controller extends \CodeIgniter\Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->setGlobalClass();
    }

    public function setGlobalClass()
    {
        $set = [
            'widget' => Widget::class,
            'menu' => new FrontMenu,
            'siteinfo' => get_config_data('config', 'info')['data']??[]
        ];
        $this->header = $this->menu = $this->footer = $this->var_ = $set;
        $meta_info = get_config_data('infos', 'meta');
        if( isset($meta_info['data']) && is_array($meta_info['data']) ){
            $this->header['meta'] = $meta_info['data']['meta']??'';
            $this->header['script'] = $meta_info['data']['script']??'';
        }
    }

    public function setBody( array $code = [], string $body = '' )
    {
        $this->body = $body ? 'Front/'.$body.'.html' : 'Front/'.implode('/', $code).'.html';
    }

    public function __destruct()
    {
        if( isset($this->body) ){
            echo view('Front/outline/header.html', $this->header);
            echo view('Front/outline/menu.html', $this->menu);
            echo view($this->body, $this->var_??[]);
            echo view('Front/outline/footer.html', $this->footer);
        }
    }
    
}