<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $allowedFields = [
        'nama_produk',
        'id_user',
        'filename_produk',
        'deskripsi_produk',
        'stok_produk',
        'kategori_produk',
        'harga_produk'
    ];

    public function getProduk($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_produk' => $id])->first();
    }
}
