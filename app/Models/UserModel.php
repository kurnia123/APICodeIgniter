<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['name_user', 'username_user', 'password_user', 'is_seller'];

    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_user' => $id])->first();
    }
}
