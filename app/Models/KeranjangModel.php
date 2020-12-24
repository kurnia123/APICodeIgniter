<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_cart';
    protected $allowedFields = ['id_produk', 'jumlah_pesan', 'harga_total'];

    public function getKeranjang($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_cart' => $id])->first();
    }
}
