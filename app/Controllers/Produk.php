<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProdukModel;

class Produk extends ResourceController
{
    use ResponseTrait;

    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = $this->produkModel->getProduk();
        return $this->respond($data, 200);
    }

    public function show($id = false)
    {
        $data = $this->produkModel->getProduk($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("tidak ditemukan data dengan ID : " . $id);
        }
    }

    public function create()
    {
        $data = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'filename_produk' => $this->request->getPost('filename_produk'),
            'deskripsi_produk' => $this->request->getPost('deskripsi_produk'),
            'kategori_produk' => $this->request->getPost('kategori_produk'),
            'id_user' => intval($this->request->getPost('id_user')),
            'harga_produk' => intval($this->request->getPost('harga_produk')),
            'stok_produk' => intval($this->request->getPost('stok_produk')),
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->produkModel->insert($data);
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
                'nama_produk' => $json->nama_produk,
                'filename_produk' => $json->filename_produk,
                'deskripsi_produk' => $json->deskripsi_produk,
                'kategori_produk' => $json->kategori_produk,
                'id_user' => intval($json->id_user),
                'stok_produk' => intval($json->stok_produk),
                'harga_produk' => intval($json->harga_produk),
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'id_user' => intval($input['id_user']),
                'stok_produk' => intval($input['stok_produk']),
                'harga_produk' => intval($input['harga_produk']),
                'nama_produk' => $input['nama_produk'],
                'kategori_produk' => $input['kategori_produk'],
                'filename_produk' => $input['filename_produk'],
                'deskripsi_produk' => $input['deskripsi_produk'],
            ];
        }

        $this->produkModel->update($id, $data);
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
        $data = $this->produkModel->find($id);
        if ($data) {
            $this->produkModel->delete($id);
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
