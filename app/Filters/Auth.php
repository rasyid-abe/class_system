<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $db = \Config\Database::connect();
        
        if ($request->uri->getSegment(1) == 'email-verified') {
            return redirect()->to(site_url('/email-verified'));
        } else {
            if (!session()->get('c_id')) {
                return redirect()->to(site_url('/'));
            } else {
                $role = session()->get('c_role');
                
                $uri = '';
                for ($i=1; $i <= $request->uri->getTotalSegments(); $i++) { 
                    if(!is_numeric($request->uri->getSegment($i)) && !str_contains($request->uri->getSegment($i), '@') && strlen($request->uri->getSegment($i)) < 32) {
                        $uri .= '/'.$request->uri->getSegment($i);
                    }
                }

                if ($role == 12) {
                    if (!str_contains($uri, 'student')) {
                        return redirect()->to("/blocked");
                    }
                } else if ($role == 11) {
                    if (!str_contains($uri, 'teacher')) {
                        return redirect()->to("/blocked");
                    }
                } else {
                    return redirect()->to("/blocked");
                }
    
                // $menu_id = $db->query("SELECT menu_id FROM account_menu WHERE menu_url = '". $uri."'")->getRow('menu_id');
                // if ($menu_id == null) {
                //     return redirect()->to("/blocked");
                // } else {
                //     $access = $db->query("SELECT * FROM account_access WHERE access_role_id = $role AND access_menu_id = $menu_id")->getNumRows();
                //     if ($access < 1) {
                //         return redirect()->to("/blocked");
                //     }
                // }
            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}