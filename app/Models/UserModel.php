<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['username', 'password', 'nama', 'email', 'role', 'is_active'];
    protected $useTimestamps = true;

    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->where('is_active', 1)->first();
    }
}
