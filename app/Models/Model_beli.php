<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_beli extends Model
{
    use ResponseTrait;
    protected $table = "beli";
    protected $primaryKey = "beli_id";
    protected $allowedFields = [
        'item_id',
        'user_id',
        'beli_kuantitas',
        'beli_norumah',
        'beli_kodepos',
        'beli_alamat'
    ];

    protected $validationRules = [
        'item_id'           => 'required|numeric',
        'user_id'           => 'required|numeric',
        'beli_kuantitas'    => 'required|numeric',
        'beli_norumah'      => 'required|numeric',
        'beli_kodepos'      => 'required',
        'beli_alamat'       => 'required'
    ];

    protected $validationMessages = [
        'item_id'  => [
            'required'  => 'Silahkan masukkan item_id',
            'numeric' => 'field ini harus diisi dengan angka'
        ],
        'user_id'  => [
            'required'  => 'Silahkan masukkan user_id',
            'numeric' => 'field ini harus diisi dengan angka'
        ],
        'beli_kuantitas'  => [
            'required'  => 'Silahkan masukkan kuantitas',
            'numeric' => 'field ini harus diisi dengan angka'
        ],
        'beli_norumah'  => [
            'required'  => 'Silahkan masukkan no_rumah',
            'numeric' => 'field ini harus diisi dengan angka'
        ],
        'beli_kodepos'  => [
            'required'  => 'Silahkan masukkan kode_pos'
        ],
        'beli_alamat'  => [
            'required'  => 'Silahkan masukkan alamat'
        ],
    ];

}
