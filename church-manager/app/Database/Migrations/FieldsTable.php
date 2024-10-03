<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FieldsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'options' => [
                'type'       => 'JSON',
                'constraint' => '255',
            ],
            'feature_id' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'field_order' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
            'visible' => [
                'type' => 'DATETIME',
                'constraint' => '255',
            ],
            'table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',  // To store the target table name (e.g., 'users', 'meetings')
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('customfields');
    }

    public function down()
    {
        $this->forge->dropTable('customfields');
    }
}
