<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSavedReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 100,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'report_id' => [
                'type'       => 'INT',
                'constraint' => 100,
                'unsigned'   => true,
            ],
            'customfields_id' => [
                'type'       => 'INT',
                'constraint' => 100,
                'unsigned'   => true,
            ],
            'field_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'report_value' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('savedreports');
    }

    public function down()
    {
        $this->forge->dropTable('savedreports');
    }
}
