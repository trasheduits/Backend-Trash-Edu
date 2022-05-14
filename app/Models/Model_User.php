<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_User extends Model
{
    use ResponseTrait;
    protected $table = "user";
    protected $primaryKey = "user_id";
    protected $allowedFields = [
        'user_namadepan',
        'user_namabelakang',
        'user_username',
        'user_password',
        'user_updatedat'
    ];

    protected $validationRules = [
        'user_namadepan'    => 'required',
        'user_namabelakang' => 'required',
        'user_username'     => 'required|is_unique[user.user_username]',
        'user_password'     => 'required|is_unique[user.user_password]',
    ];

    protected $validationMessages = [
        'user_namadepan'  => [
            'required'  => 'Silahkan masukkan nama depan'
        ],
        'user_namabelakang'  => [
            'required'  => 'Silahkan masukkan nama belakang',
        ],
        'user_username'  => [
            'required'  => 'Silahkan masukkan username',
            'is_unique' => 'username tersebut sudah terdaftar'
        ],
        'user_password'  => [
            'required'  => 'Silahkan masukkan password',
            'is_unique' => 'password tersebut sudah terpakai'
        ]
    ];

    function verifyLogin($username, $password)
    {
        $builder = $this->table('user');
        $builder->where('user_username', $username);
        $builder->where('user_password', $password);//password_hash($password, PASSWORD_DEFAULT ));
        $data = $builder->first();
        if (empty($data)) {
            return "username / password salah";
        }
        return $data;
    }

    /*function getDataWhere($where, $whering)
    {
        $builder = $this->table('account');
        $builder->where($where, $whering);
        $data = $builder->first();
        if (empty($data)) {
            return "data tidak ada";
        }
        return $data;
    }
    function updateData($where, $whering, $set, $seting)
    {
        $builder = $this->table('account');
        $builder->set($set, $seting);
        $builder->where($where, $whering);
        $builder->update();
    }*/
}
