<?php

namespace App\Models;

use CodeIgniter\Model;
use Codeigniter\API\ResponseTrait;
use Exception;

class Model_item extends Model
{
    use ResponseTrait;
    protected $table = "item";
    protected $primaryKey = "item_id";
    protected $allowedFields = [
        'user_id',
        'item_name',
        'item_filename',
        'item_price',
        'item_address',
        'item_stok',
        'item_opsipengiriman',
        'item_updatedat',
    ];

    protected $validationRules = [
        'user_id'               => 'required',
        'item_name'             => 'required',
        'item_price'            => 'required|numeric',
        'item_address'          => 'required',
        'item_stok'             => 'required|numeric',
        'item_opsipengiriman'   => 'required',
        'item_filename'         => 'required'
    ];

    protected $validationMessages = [
        'user_id'       => [
            'required'  => 'Silahkan masukkan id user'
        ],
        'item_name'  => [
            'required'  => 'Silahkan masukkan nama barang'
        ],
        'item_price'  => [
            'required'  => 'Silahkan masukkan harga barang',
            'numeric'   => 'harus diisi dengan integer'
        ],
        'item_address'  => [
            'required'  => 'Silahkan masukkan alamat'
        ],
        'item_stok'  => [
            'required'  => 'Silahkan masukkan jumlah stok barang',
            'numeric'   => 'harus diisi dengan integer'
        ],
        'item_opsipengiriman'  => [
            'required'  => 'Silahkan masukkan opsi pengiriman'
        ],
        'item_filename'  => [
            'required'  => 'Silahkan masukkan nama file'
        ]
    ];

    function coba()
    {
        return "data tidak ada";
    }

    function getDataWhere($where, $whering)
    {
        $builder = $this->table('item');
        $builder->where($where, $whering);
        $data = $builder->first();
        if (empty($data)) {
            return "data tidak ada";
        }
        return $data;
    }
}
