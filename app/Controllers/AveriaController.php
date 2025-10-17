<?php

namespace App\Controllers;

use App\Models\Averia;

class AveriaController extends BaseController
{
  public function index(): string
  {
    $averiasModel = new Averia();
    $data['averias'] = $averiasModel->listar();
    return view('averias/index', $data);
  }

  public function crear():string
  {
    return view('averias/registrar');
  }

  public function save(){
    $model = new Averia();

    $data = [
      'nombres' => $this->request->getPost('nombres'),
      'problema' => $this->request->getPost('problema'),
      'fechahora' => $this->request->getPost('fechahora'),
      'status' => 'PENDIENTE',
    ];

    $model->crear($data);

    return redirect()->to('/averias');
  }
}