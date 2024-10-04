<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValuesTable extends Migration
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
            'record_id' => [
                'type'       => 'INT',
                'constraint' => 11,  // ID of the record in the target table
            ],
            'customfield_id' => [
                'type'       => 'INT',
                'constraint' => 11,  // Links to custom_fields.id
                'unsigned'   => true,
            ],
            'value' => [
                'type'       => 'TEXT', // Custom field value
                'null'       => true,
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
        $this->forge->addForeignKey('customfield_id', 'customfields', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('customvalues');
    }

    public function down()
    {
        $this->forge->dropTable('customvalues');
    }
}
