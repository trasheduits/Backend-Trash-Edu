<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_keranjang extends Model
{
    use ResponseTrait;
    protected $table = "keranjang";
    protected $primaryKey = "keranjang_id";
    protected $allowedFields = [
        'item_id',
        'user_id',
        'keranjang_kuantitas'
    ];

    protected $validationRules = [
        'item_id'    => 'required',
        'user_id'    => 'required',
        'keranjang_kuantitas'   => 'required|numeric'
    ];

    protected $validationMessages = [
        'item_id'  => [
            'required'  => 'Silahkan masukkan item_id'
        ],
        'user_id'  => [
            'required'  => 'Silahkan masukkan user_id'
        ],
        'keranjang_kuantitas'  => [
            'required'  => 'Silahkan masukkan kuantitas',
            'numeric' => 'field ini harus diisi dengan angka'
        ]
    ];

}
