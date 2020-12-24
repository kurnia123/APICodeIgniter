<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = ['jumlah_bayar', 'jenis_bayar', 'id_cart'];

    public function getPembayaran($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_pembayaran' => $id])->first();
    }
}
