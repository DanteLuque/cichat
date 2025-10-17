<?php

namespace App\Models;

use CodeIgniter\Model;

class Averia extends Model
{
  protected $table = 'averias';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nombres',
    'problema',
    'fechahora',
    'status'
  ];

  public function listar(){
    return $this->findAll();
  }

  public function crear($data){
    return $this->insert($data);
  }
}