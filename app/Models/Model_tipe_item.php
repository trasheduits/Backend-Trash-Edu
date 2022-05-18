<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_tipe_item extends Model
{
    use ResponseTrait;
    protected $table = "tipe_item";
    protected $primaryKey = "tipe_item_id";
    protected $allowedFields = [
        'tipe_id',
        'item_id'
    ];

    protected $validationRules = [
        'tipe_id'           => 'required|numeric',
        'item_id'           => 'required|numeric'
    ];

    protected $validationMessages = [
        'tipe_id'  => [
            'required'  => 'Silahkan masukkan tipe_id',
            'numeric' => 'field ini harus diisi dengan angka'
        ],
        'item_id'  => [
            'required'  => 'Silahkan masukkan item_id',
            'numeric' => 'field ini harus diisi dengan angka'
        ]
    ];

}
