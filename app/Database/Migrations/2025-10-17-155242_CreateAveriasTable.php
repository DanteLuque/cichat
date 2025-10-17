<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAveriasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'nombres' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'problema' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'fechahora' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['PENDIENTE', 'SOLUCIONADO'],
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('averias');
    }

    public function down()
    {
        $this->forge->dropTable('averias');
    }
}
