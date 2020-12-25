<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PromoModel;

class Promo extends ResourceController
{
    use ResponseTrait;

    protected $promoModel;

    public function __construct()
    {
        $this->promoModel = new PromoModel();
    }

    public function index()
    {
        $data = $this->promoModel->getPromo();
        return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->promoModel->getPromo($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'id_promo' => intval($this->request->getPost('id_promo')),
            'id_user' => intval($this->request->getPost('id_user')),
            'id_produk' => intval($this->request->getPost('id_produk')),
            'jumlah_promo_percent' => intval($this->request->getPost('jumlah_promo_percent')),
            'jumlah_promo_max' => intval($this->request->getPost('jumlah_promo_max')),
            'promo_expired' => intval($this->request->getPost('promo_expired')),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->promoModel->insert($data);
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
                'id_promo' => intval($json->id_promo),
                'id_user' => intval($json->id_user),
                'id_produk' => intval($json->id_produk),
                'jumlah_promo_percent' => intval($json->jumlah_promo_percent),
                'jumlah_promo_max' => intval($json->jumlah_promo_max),
                'promo_expired' => intval($json->promo_expired),
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'id_promo' => intval($input['id_promo']),
                'id_user' => intval($input['id_user']),
                'id_produk' => intval($input['id_produk']),
                'jumlah_promo_percent' => intval($input['jumlah_promo_percent']),
                'jumlah_promo_max' => intval($input['jumlah_promo_max']),
                'promo_expired' => intval($input['promo_expired']),
            ];
        }

        $this->promoModel->update($id, $data);
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
        $data = $this->promoModel->find($id);
        if ($data) {
            $this->promoModel->delete($id);
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
