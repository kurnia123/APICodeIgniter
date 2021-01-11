<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_user',
        'id_produk',
        'id_pembayaran',
        'tanggal_transaksi'
    ];

    public function getTransaksi($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_transaksi' => $id])->first();
    }
}
