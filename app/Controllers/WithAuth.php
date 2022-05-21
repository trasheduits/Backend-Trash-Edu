<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Codeigniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Model_User;
use App\Models\Model_tipe;
use App\Models\Model_item;
use App\Models\Model_beli;
use App\Models\Model_keranjang;
use App\Models\Model_tipe_item;

class WithAuth extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->modelUser = new Model_User();
        $this->modelTipe = new Model_tipe();
        $this->modelBeli = new Model_beli();
        $this->modelTipeItem = new Model_tipe_item();
        $this->modelItem = new Model_item();
        $this->modelKeranjang = new Model_keranjang();
        helper('jwt');
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function addType()
    {
        $rules = [
            "tipe" => [
                'label'     => 'tipe',
                'rules'     => 'required|is_unique[tipe.tipe_nama]',
                'errors'    => [
                    'required'  => 'silahkan masukkan tipe'
                ]
            ],
            "deskripsi" => [
                'label'     => 'deskripsi',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan deskripsi'
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }

        $data = [
            'tipe_nama'         => $this->request->getPost('tipe'),
            'tipe_deskripsi'    => $this->request->getPost('deskripsi'),
        ];

        if (!$this->modelTipe->save($data)) {
            return $this->fail($this->modelTipe->errors());
        }

        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'tipe berhasil ditambahkan'
            ]
        ];
        return $this->respond($response);
    }

    public function sellItem()
    {
        //return $this->respond($this->request->getPost("tipe"));
        $rules = [
            "nama_barang"   => [
                'label'     => 'nama_barang',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan nama barang'
                ]
            ],
            "file_barang"   => [
                'label'     => 'file_barang',
                'rules'     => 'is_image[file_barang]',
                'errors'    => [
                    'is_image'  => 'field harus diisi dengan gambar'
                ]
            ],
            "harga"   => [
                'label'     => 'harga',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan harga barang',
                    'numeric'   => 'field ini diisi dengan angka'
                ]
            ],
            "alamat"   => [
                'label'     => 'alamat',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan alamat'
                ]
            ],
            "opsi_pengiriman"   => [
                'label'     => 'opsi_pengiriman',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan opsi pengiriman'
                ]
            ],
            "stok"   => [
                'label'     => 'stok',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan jumlah stok',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
            "tipe.*"   => [
                'label'     => 'tipe.*',
                'rules'     => 'numeric',
                'errors'    => [
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }

        $token_data = getJWTdata($this->request->getHeader("Authorization")->getValue());

        $data = [
            'item_name'         => $this->request->getPost('nama_barang'),
            'user_id'           => ((array)$token_data['data'])['id'],
            'item_filename'     => $this->moveFile('uploads/item', $this->request->getFile('file_barang')),
            'item_price'        => $this->request->getPost('harga'),
            'item_address'      => $this->request->getPost('alamat'),
            'item_stok'         => $this->request->getPost('stok'),
            'item_opsipengiriman'=> $this->request->getPost('opsi_pengiriman')
        ];

        //return $this->respond($data);

        if (!$this->modelItem->insert($data)) {
            return $this->fail($this->modelItem->errors());
        }
        
        $data_tipe = [
            'item_id'   => $this->modelItem->insertID()
        ];
        foreach($this->request->getPost('tipe') as $tipe){
            $data_tipe['tipe_id'] = (int)$tipe;
            //return $this->respond($data_tipe);
            if (!$this->modelTipeItem->save($data_tipe)) {
                return $this->fail($this->modelTipeItem->errors());
            }
        }
            
        

        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'item berhasil ditambahkan'
            ]
        ];
        return $this->respond($response);

        

        
        /*return $this->respond($data_tipe);*/
    }

    public function addCart()
    {
        $rules = [
            "item_id"   => [
                'label'     => 'item_id',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan item_id',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
            "kuantitas"   => [
                'label'     => 'kuantitas',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan kuantitas',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }

        $token_data = getJWTdata($this->request->getHeader("Authorization")->getValue());

        $data = [
            'item_id'           => $this->request->getPost('item_id'),
            'user_id'           => ((array)$token_data['data'])['id'],
            'keranjang_kuantitas'    => $this->request->getPost('kuantitas')
        ];

        if (!$this->modelKeranjang->save($data)) {
            return $this->fail($this->modelKeranjang->errors());
        }

        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'berhasil menambah keranjang'
            ]
        ];
        return $this->respond($response);
    }

    public function buyItem()
    {
        $rules = [
            "item_id"   => [
                'label'     => 'item_id',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan item_id',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
            "kuantitas"   => [
                'label'     => 'kuantitas',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan kuantitas',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
            "norumah"   => [
                'label'     => 'norumah',
                'rules'     => 'required|numeric',
                'errors'    => [
                    'required'  => 'silahkan masukkan nomer rumah',
                    'numeric'   => 'field ini harus diisi dengan angka'
                ]
            ],
            "kodepos"   => [
                'label'     => 'kodepos',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan kode pos'
                ]
            ],
            "alamat"   => [
                'label'     => 'alamat',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan alamat rumah'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }
        
        
        $data_item = $this->modelItem->getDataWhere('item_id', $this->request->getPost('item_id'));
        if($data_item == 'data tidak ada'){
            return $this->fail('data tidak ada');
        }

        $token_data = getJWTdata($this->request->getHeader("Authorization")->getValue());

        $data = [
            'item_id'           => $this->request->getPost('item_id'),
            'user_id'           => ((array)$token_data['data'])['id'],
            'beli_norumah'      => $this->request->getPost('norumah'),
            'beli_kodepos'      => $this->request->getPost('kodepos'),
            'beli_alamat'       => $this->request->getPost('alamat'),
            'beli_kuantitas'    => $this->request->getPost('kuantitas'),
            'beli_harga'        => $this->request->getPost('kuantitas') * $data_item['item_price']
        ];

        if (!$this->modelBeli->save($data)) {
            return $this->fail($this->modelBeli->errors());
        }

        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'berhasil membeli barang'
            ]
        ];

        return $this->respond($response);
    }

    public function all_item()
    {
        $data = $this->modelItem->orderBy('item_id', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function history_beli()
    {
        $token_data = getJWTdata($this->request->getHeader("Authorization")->getValue());
        $data = $this->modelBeli->getAllDataWhere('user_id', ((array)$token_data['data'])['id']);
        //echo ((array)$token_data['data'])['id'];
        return $this->respond($data, 200);
    }

    public function see_cart()
    {
        $token_data = getJWTdata($this->request->getHeader("Authorization")->getValue());
        $data = $this->modelKeranjang->getAllDataWhere('user_id', ((array)$token_data['data'])['id']);
        //echo ((array)$token_data['data'])['id'];
        return $this->respond($data, 200);
    }

    public function coba()
    {
        //echo getenv("JWT_SECRET_KEY");
        $token_data = getJWT($this->request->getHeader("Authorization")->getValue());
        return $this->respond($token_data);
    }
}
