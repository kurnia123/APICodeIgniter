<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Controllers\Auth;
use \Firebase\JWT\JWT;

class User extends ResourceController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->protect = new Auth();
    }

    public function index()
    {
        $secret_key = $this->protect->privateKey();

        $token = null;

        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(' ', $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                // Access is granted. Add code of the operation here 
                if ($decoded) {
                    // response true

                    $output = $this->userModel->getUser();
                    return $this->respond($output, 200);
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage()
                ];
                return $this->respond($output, 401);
            }
        }

        // return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->userModel->getUser($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'name_user' => $this->request->getPost('name_user'),
            'username_user' => $this->request->getPost('username_user'),
            'password_user' => $this->request->getPost('password_user'),
            'is_seller' => $this->request->getPost('is_seller'),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->userModel->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Data berhasil di Simpan'
            ]
        ];

        return $this->respondCreated($response, 201);
    }

    public function update($id = null)
    {
        $json = $this->request->getJSON();

        if ($json) {
            $data = [
                'name_user' => $json->name_user,
                'username_user' => $json->username_user,
                'password_user' => $json->password__user,
                'is_seller' => $json->is_seller,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'name_user' => $input['name_user'],
                'username_user' => $input['username_user'],
                'password_user' => $input['password_user'],
                'is_seller' => $input['is_seller'],
            ];
        }

        $this->userModel->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Data berhasil di Update'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->userModel->find($id);
        if ($data) {
            $this->userModel->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'Data berhasil di Update'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Data dengan ID : " . $id . " tidak ditemukan");
        }
    }
}
