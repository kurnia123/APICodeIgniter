<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KeranjangModel;

class Keranjang extends ResourceController
{
    use ResponseTrait;

    protected $keranjangModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
    }

    public function index()
    {
        $data = $this->keranjangModel->getKeranjang();
        return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->keranjangModel->getKeranjang($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'id_produk' => intval($this->request->getPost('id_produk')),
            'jumlah_pesan' => intval($this->request->getPost('jumlah_pesan')),
            'harga_total' => intval($this->request->getPost('harga_total')),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->keranjangModel->insert($data);
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
                'id_produk' => intval($json->id_produk),
                'jumlah_pesan' => intval($json->jumlah_pesan),
                'harga_total' => intval($json->harga_total),
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'id_produk' => intval($input['id_produk']),
                'jumlah_pesan' => intval($input['jumlah_pesan']),
                'harga_total' => intval($input['harga_total']),
            ];
        }

        $this->keranjangModel->update($id, $data);
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
        $data = $this->keranjangModel->find($id);
        if ($data) {
            $this->keranjangModel->delete($id);
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
