<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'firstname_user',
        'lastname_user',
        'username_user',
        'password_user',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'no_telephone',
        'bio',
        'is_seller'
    ];

    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_user' => $id])->first();
    }

    public function getUserByEmailName($emailName = false)
    {
        if ($emailName == false) {
            return "data kosong";
        }

        return $this->where(['username_user' => $emailName])->first();
    }
}
