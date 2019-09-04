<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\User;

class AuthController extends \yii\rest\Controller
{
    protected function verbs() 
    {
        return [
            'login' => ['POST'],
        ];
    }
    
    public function actionLogin()
    {
        // tangkap data login dari client (username and password)
        $username = !empty($_POST['username']) ? $_POST['username'] : '';
        $password = !empty($_POST['password']) ? $_POST['password'] : '';
        $response = [];
        $hasil = '';
        
        // validasi jika kosong
        if (empty($username) || empty($password)) {
            $response = [
                'status' => '0',
                'message' => 'username dan password tidak boleh kosong!',
                'data' => ''
            ];
        } else {
            // cari di database, ada tidak username yang di $_POST
            $user = User::findByUsername($username);
            // if username not empty
            if (!empty($user)) {
                // check, valid tidak passwordnya, jika valid maka bikin
                if ($user->validatePassword($password)) {
                    $response = [
                        'status' => '1',
                        'message' => 'Login berhasil !',
                        'data' => [
                            // token diambil dari auth_key
                            'token' => $user->auth_key,
                        ]
                    ];
                } else {
                    $response = [
                        'status' => '0',
                        'message' => 'password salah',
                        'data' => '',
                    ];
                }
            } else {
                $response = [
                    'status' => '0',
                    'message' => 'Username tidak ditemukan dalam database',
                    'data' => '',
                ];
            }
        }
        return $response;
    }
}
