<?php
namespace App\Controllers\Admin;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Menu\AdminMenu;
class Controller extends \CodeIgniter\Controller
{
    protected $helpers = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->menu['menu'] = new AdminMenu;
    }

    public function setBody( array $code = [], string $body = '' ) : void
    {
        $this->menu['menu']->code = $code;
        $this->body = $body ? 'Admin/'.$body.'.html' : 'Admin/'.implode('/', $code).'.html';
    }

    public function setNave( array $nav ) : void
    {
        $this->menu['nav'] = $nav;
    }

    public function __destruct()
    {
        if( isset($this->body) ){
            echo view('Admin/outline/header.html', $this->header??[])
            . view('Admin/outline/menu.html', $this->menu??[])
            . view($this->body, $this->var_??[])
            . view('Admin/outline/footer.html', $this->footer??[]);
        }
        exit;
    }
    
}