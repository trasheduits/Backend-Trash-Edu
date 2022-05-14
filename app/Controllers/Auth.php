<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Codeigniter\API\ResponseTrait;
use App\Models\Model_User;

class Auth extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->modelUser = new Model_User();
        //helper('jwt');
    }

    public function Register()
    {
        $rules = [
            "nama_depan" => [
                'label'     => 'nama_depan',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan nama depan'
                ]
            ],
            "nama_belakang" => [
                'label'     => 'nama_belakang',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan nama belakang'
                ]
            ],
            "username" => [
                'label'     => 'username',
                'rules'     => 'required|is_unique[user.user_username]',
                'errors'    => [
                    'required'  => 'silahkan masukkan username',
                    'is_unique' => 'username tersebut sudah terdaftar'
                ]
            ],
            "password" => [
                'label'     => 'password',
                'rules'     => 'required|is_unique[user.user_password]',
                'errors'    => [
                    'required'  => 'silahkan masukkan password',
                    'is_unique' => 'password tersebut sudah terpakai'
                ]
            ],
            "confirm_password" => [
                'label'     => 'confirm_password',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'tolong isi konfirmasi password'
                ]
            ],
        ];

        //$_POST['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }

        if($this->request->getPost('password') != $this->request->getPost('confirm_password'))
        {
            return $this->fail("konfirmasi password tidak sama");
        }

        $data = [
            'user_namadepan'    => $this->request->getPost('nama_depan'),
            'user_namabelakang' => $this->request->getPost('nama_belakang'),
            'user_username'     => $this->request->getPost('username'),
            'user_password'     => $this->request->getPost('password')//password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        if (!$this->modelUser->save($data)) {
            return $this->fail($this->modelUser->errors());
        }

        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'user berhasil terdaftar'
            ]
        ];
        return $this->respond($response);
    }

    public function Login()
    {
        $rules = [
            "username" => [
                'label'     => 'username',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan username'
                ]
            ],
            "password" => [
                'label'     => 'password',
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'silahkan masukkan password'
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->fail($validation->getErrors());
        }

        $data = [
            'user_username'     => $this->request->getPost('username'),
            'user_password'     => $this->request->getPost('password'),
        ];

        $data_full = $this->modelUser->verifyLogin($data['user_username'], $data['user_password']);
        $id['id'] = $data_full['user_id'];

        if ($data_full == "username / password salah")
            return $this->fail($data_full);
        
        helper('jwt');
        $response = [
            'status'    => 201,
            'message'   => [
                'success'   => 'berhasil login',
                'token'     => createJWT($id)
            ]
        ];
        return $this->respond($response);
    }
}
