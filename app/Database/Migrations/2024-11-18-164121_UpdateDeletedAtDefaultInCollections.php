<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDeletedAtDefaultInCollections extends Migration
{
    public function up()
    {
        $fields = [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true, // Allow NULL values
                'default' => null, // Set default to NULL
            ],
        ];

        // Modify the 'deleted_at' column in the 'collections' table
        $this->forge->modifyColumn('collections', $fields);
    }

    public function down()
    {
        $fields = [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => false, // Revert back to NOT NULL (default behavior)
                'default' => '0000-00-00 00:00:00', // Set a default date value
            ],
        ];

        // Revert the modification to the 'deleted_at' column
        $this->forge->modifyColumn('collections', $fields);
    }
}
