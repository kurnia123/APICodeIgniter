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

    protected $auth;
    protected $userModel;

    public function __construct()
    {
        $this->auth = new AuthModel();
        $this->userModel = new UserModel();
    }

    public static function privateKey()
    {
        $privateKey = <<<EOD
        -----BEGIN RSA PRIVATE KEY-----
        MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
        vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
        5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
        AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
        bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
        Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
        cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
        5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
        ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
        k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
        qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
        eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
        B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
        -----END RSA PRIVATE KEY-----
        EOD;
        return $privateKey;
    }

    public function register()
    {
        $firstname_user  = $this->request->getPost('firstname_user');
        $lastname_user  = $this->request->getPost('lastname_user');
        $username      = $this->request->getPost('username_user');
        $password   = $this->request->getPost('password_user');
        $alamat   = $this->request->getPost('alamat');
        $provinsi   = $this->request->getPost('provinsi');
        $kabupaten   = $this->request->getPost('kabupaten');
        $kecamatan   = $this->request->getPost('kecamatan');
        $no_telephone   = $this->request->getPost('no_telephone');

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $data = json_decode(file_get_contents("php://input"));

        $dataRegister = [
            'firstname_user' => $firstname_user,
            'lastname_user' => $lastname_user,
            'username_user' => $username,
            'password_user' => $password_hash,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
            'kecamatan' => $kecamatan,
            'no_telephone' => $no_telephone,
        ];

        $register = $this->auth->register($dataRegister);

        if ($register == true) {
            $output = [
                'status' => 200,
                'message' => 'Berhasil register'
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Gagal register'
            ];
            return $this->respond($output, 400);
        }
    }

    public function login()
    {
        $username  = $this->request->getPost('username_user');
        $password  = $this->request->getPost('password_user');
        $url = $this->request->getPost("url_redirect");

        $cek_login = $this->auth->cek_login($username);
        $user = $this->userModel->getUserByEmailName($username);

        // var_dump($cek_login['password']);

        if (password_verify($password, $cek_login['password_user'])) {
            $secret_key = $this->privateKey();
            $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 4000; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $cek_login['id_user'],
                    "name_user" => $cek_login['firstname_user'],
                    "username_user" => $cek_login['username_user']
                )
            );

            $token = JWT::encode($token, $secret_key);
            date_default_timezone_set("Asia/Jakarta");

            $arr_cookie_options = array(
                'expires' => time() + 5000,
                'path' => '/',
                'domain' => false, // leading dot for compatibility or use subdomain
                'secure' => false,     // or false
                'httponly' => false,    // or false
                'samesite' => 'Lax' // None || Lax  || Strict
            );

            setcookie('id_user', $username, $arr_cookie_options);
            setcookie('token', $token, $arr_cookie_options);

            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token . "|" . $username . "|" . $url,
                "username_user" => $username,
                "url" => $url,
                "expireAt" => date('D, d M Y h:i:s', $expire_claim) . " GMT",
                "default Time zone" => date_default_timezone_get(),
                "id_user" => $user
            ];


            return $this->respond($output, 200);
            // return redirect()->to($url);
            // return redirect()->to('http://localhost:8080/login.html');
        } else {
            $output = [
                'status' => 401,
                'message' => 'Login failed'
            ];
            return $this->respond($output, 401);
        }
    }
}
