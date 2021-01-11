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
            'id_produk' => intval($this->request->getPost('id_produk')),
	    'id_user' => intval($this->request->getPost('id_user')),
            'tanggal_pembayaran' => $this->request->getPost('tanggal_pembayaran'),
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
                'id_produk' => intval($json->id_produk),
		'id_user' => intval($json->id_user),
                'tanggal_pembayaran' => $json->tanggal_pembayaran,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'jumlah_bayar' => intval($input['jumlah_bayar']),
                'id_produk' => intval($input['id_produk']),
		'id_user' => intval($json->id_user),
                'tanggal_pembayaran' => $input['tanggal_pembayaran'],
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
