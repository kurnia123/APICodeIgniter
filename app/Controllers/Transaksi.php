<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TransaksiModel;

class Transaksi extends ResourceController
{
    use ResponseTrait;

    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $data = $this->transaksiModel->getTransaksi();
        return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->transaksiModel->getTransaksi($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'tanggal_transaksi' => $this->request->getPost('tanggal_transaksi'),
            'id_user' => intval($this->request->getPost('id_user')),
            'id_produk' => intval($this->request->getPost('id_produk')),
            'id_pembayaran' => intval($this->request->getPost('id_pembayaran')),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->transaksiModel->insert($data);
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
                'tanggal_transaksi' => $json->tanggal_transaksi,
                'id_user' => intval($json->id_user),
                'id_produk' => intval($json->id_produk),
                'id_pembayaran' => intval($json->id_pembayaran),
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'id_user' => intval($input['id_user']),
                'id_produk' => intval($input['id_produk']),
                'id_pembayaran' => intval($input['id_pembayaran']),
                'tanggal_transaksi' => $input['tanggal_transaksi'],
            ];
        }

        $this->transaksiModel->update($id, $data);
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
        $data = $this->transaksiModel->find($id);
        if ($data) {
            $this->transaksiModel->delete($id);
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
