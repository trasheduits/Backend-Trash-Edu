<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_tipe extends Model
{
    use ResponseTrait;
    protected $table = "tipe";
    protected $primaryKey = "tipe_id";
    protected $allowedFields = [
        'tipe_nama',
        'tipe_deskripsi'
    ];

    protected $validationRules = [
        'tipe_deskripsi'    => 'required',
        'tipe_nama'         => 'required|is_unique[tipe.tipe_nama]',
    ];

    protected $validationMessages = [
        'tipe_deskripsi'  => [
            'required'  => 'Silahkan masukkan deskripsi'
        ],
        'tipe_nama'  => [
            'required'  => 'Silahkan masukkan tipe',
            'is_unique' => 'tipe tersebut sudah ada'
        ]
    ];

}
