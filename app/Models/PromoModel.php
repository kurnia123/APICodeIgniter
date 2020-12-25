<?php

namespace App\Models;

use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'id_promo';
    protected $allowedFields = [
        'id_user',
        'id_produk',
        'jumlah_promo_percent',
        'jumlah_promo_max',
        'promo_expired'
    ];

    public function getKeranjang($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_promo' => $id])->first();
    }
}
