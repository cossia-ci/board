<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class MemberLoginFilter implements \CodeIgniter\Filters\FilterInterface
{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if( !( $session->has('is_member') && $session->is_member === true ) )
            return redirect()->to('/log-in');
    }
    //--------------------------------------------------------------------
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}