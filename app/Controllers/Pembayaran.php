<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PembayaranModel;

class Pembayaran extends ResourceController
{
    use ResponseTrait;

    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $data = $this->pembayaranModel->getPembayaran();
        return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->pembayaranModel->getPembayaran($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'jumlah_bayar' => intval($this->request->getPost('jumlah_bayar')),
            'jenis_bayar' => $this->request->getPost('jenis_bayar'),
            'id_cart' => intval($this->request->getPost('id_cart')),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->pembayaranModel->insert($data);
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
                'jumlah_bayar' => intval($json->jumlah_bayar),
                'jenis_bayar' => $json->jenis_bayar,
                'id_cart' => intval($json->id_cart),
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'jumlah_bayar' => intval($input['jumlah_bayar']),
                'jenis_bayar' => $input['jenis_bayar'],
                'id_cart' => intval($input['id_cart']),
            ];
        }

        $this->pembayaranModel->update($id, $data);
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
        $data = $this->pembayaranModel->find($id);
        if ($data) {
            $this->pembayaranModel->delete($id);
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
