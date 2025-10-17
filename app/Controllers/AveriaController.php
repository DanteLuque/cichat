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

  public function crear(): string
  {
    return view('averias/registrar');
  }

  public function save()
  {
    $data = $this->request->getJSON(true);
    if (!$data) return $this->response->setJSON(['success' => false, 'msg' => 'Datos inválidos']);

    $model = new Averia();
    $id = $model->crear([
      'nombres' => $data['nombres'],
      'problema' => $data['problema'],
      'fechahora' => $data['fechahora'],
      'status' => 'PENDIENTE',
    ]);

    if ($id) {
      $nuevaAveria = $model->find($id);
      return $this->response->setJSON(['success' => true, 'averia' => $nuevaAveria]);
    }

    redirect()->to('/averias');
    return $this->response->setJSON(['success' => false]);
  }
}