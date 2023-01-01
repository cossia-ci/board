<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class AdminLogoutFilter implements \CodeIgniter\Filters\FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if( $session->has('is_manager') && $session->is_manager === true )
            return redirect()->to('/admin');
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}