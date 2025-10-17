<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AveriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombres' => 'Dante',
                'problema' => 'Se rompio la pantalla',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'PENDIENTE',
            ],
            [
                'nombres' => 'Lucia',
                'problema' => 'No enciende el dispositivo',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'PENDIENTE',
            ],
            [
                'nombres' => 'Miguel',
                'problema' => 'Bateria no carga',
                'fechahora' => date('Y-m-d H:i:s'),
                'status' => 'SOLUCIONADO',
            ],
        ];

        $this->db->table('averias')->insertBatch($data);
    }
}
