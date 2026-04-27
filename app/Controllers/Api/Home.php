<?php 

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return $this->response->setStatusCode(201)->setJSON(['message' => 'API LMS berhasil dibuat']);
    }
    
    public function stresstest()
    {
        $enc = 'g-' . random_char(15);

        return $this->response->setStatusCode(201)->setJSON([
            'message' => 'Stress Test LMS Ready',
            'string' => $enc,
            'encrypt' => encryptabe($enc),
            'decrypt' => decryptabe(encryptabe($enc)),
            'length' => strlen(encryptabe($enc))
        ]);
    }
}
