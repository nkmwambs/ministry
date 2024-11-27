<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDeletedByDefaultInCollections extends Migration
{
    public function up()
    {
        $fields = [
            'deleted_by' => [
                'type'    => 'INT',
                'null'    => true, // Allow NULL values
                'default' => null, // Set default to NULL
            ],
        ];

        // Modify the 'deleted_by' column in the 'collections' table
        $this->forge->modifyColumn('collections', $fields);
    }

    public function down()
    {
        $fields = [
            'deleted_by' => [
                'type'    => 'INT',
                'null'    => false, // Revert to NOT NULL
                'default' => 0, // Set a default value
            ],
        ];

        // Revert the modification to the 'deleted_by' column
        $this->forge->modifyColumn('collections', $fields);
    }
}
