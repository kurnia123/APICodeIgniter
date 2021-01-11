<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AuthModel;
use \Firebase\JWT\JWT;
use App\Models\UserModel;

class Auth extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->auth = new AuthModel();
        $this->userModel = new UserModel();
    }

    public function image($name="") 
    {
        try {
            if($name != "")
            {
                return $this->response->download('./img/'.$name);
            } else {
                return $this->response->download('./img/default.jpg');
            }
        } catch (\Throwable $th) {
            return $this->respond($th, 400);
        }

    }
}
