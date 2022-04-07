<?php
namespace App\Controllers\Admin;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Menu\AdminMenu;
class Controller extends \CodeIgniter\Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->menu['menu'] = new AdminMenu;
    }

    public function setBody( array $code = [], string $body = '' )
    {
        $this->menu['menu']->code = $code;
        $this->body = $body ? 'Admin/'.$body.'.html' : 'Admin/'.implode('/', $code).'.html';
    }

    public function setNave( array $nav )
    {
        $this->menu['nav'] = $nav;
    }

    public function __destruct()
    {
        if( isset($this->body) ){
            echo view('Admin/outline/header.html', $this->header??[]);
            echo view('Admin/outline/menu.html', $this->menu??[]);
            echo view($this->body, $this->var_??[]);
            echo view('Admin/outline/footer.html', $this->footer??[]);
        }
    }
    
}