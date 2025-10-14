<?php

namespace App\Controllers;

class WebSocketController extends BaseController
{
    public function index()
    {
        return view('websocket/chat');
    }

    //api para obtener informacion del servidor
    public function serverStatus(){
        $status = [
            'status' => 'active',
            'server' => 'ws://127.0.0.1:8080',
            'timestamp' => time()
        ];
        return $this->response->setJSON($status);
    }
}