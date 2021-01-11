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

    public function getProdukMultipleCondtion($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        $keyId = explode('|',$id);
        
        //return $this->where($arr)->findAll();
	// Index 0 = Kategori 
        // Index 1 = Harga

        if($keyId[0] == "" && $keyId[1] != "") {
            return $this->where('harga_produk <', (int)$keyId[1])
                        ->findAll();
        } else if($keyId[1] == "" && $keyId[0] != "") {
            return $this->where('kategori_produk',$keyId[0])
                        ->findAll();
        } else {
            return $this->where('kategori_produk', $keyId[0])
                        ->where('harga_produk <=', (int)$keyId[1])
                        ->findAll();
        }
    }

    public function getProdukByIdUser($id = false) {
        if ($id == false) {
            return $this->findAll();
        }

        $arr = array(
            'id_user' => $id
        );

        return $this->where($arr)->findAll();
    }

}
