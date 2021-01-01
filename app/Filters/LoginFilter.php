<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use \Firebase\JWT\JWT;
use App\Controllers\Auth;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(' ', $authHeader);
        $secret_key = Auth::privateKey();

        try {
            $token = $arr[1];
        } catch (\Throwable $th) {
            $token = "";
        }

        if ($token !== null) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
                    // return redirect()->to($)
                }
            } catch (\Exception $e) {
                return redirect()->to("http://localhost/login.html?url=");
            }
        } else {
            return redirect()->to("http://localhost/login.html?url=");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
