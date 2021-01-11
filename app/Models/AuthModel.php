<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = "user";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }

    public function cek_login($username)
    {
        $query = $this->table($this->table)
            ->where('username_user', $username)
            ->countAll();

        if ($query > 0) {
            $hasil = $this->table($this->table)
                ->where('username_user', $username)
                ->limit(1)
                ->get()
                ->getRowArray();
        } else {
            $hasil = array();
        }

        return $hasil;
    }
}
