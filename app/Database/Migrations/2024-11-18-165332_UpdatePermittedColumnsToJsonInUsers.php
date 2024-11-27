<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePermittedColumnsToJsonInUsers extends Migration
{
    public function up()
    {
        $fields = [
            'permitted_assemblies' => [
                'type'    => 'JSON',
                'null'    => true, // Allow NULL values
                'default' => null, // Set default to NULL
            ],
            'permitted_entities' => [
                'type'    => 'JSON',
                'null'    => true, // Allow NULL values
                'default' => null, // Set default to NULL
            ],
        ];

        // Modify the columns in the 'users' table
        $this->forge->modifyColumn('users', $fields);
    }

    public function down()
    {
        $fields = [
            'permitted_assemblies' => [
                'type'    => 'TEXT', // Assuming original type was TEXT
                'null'    => false, // Revert to NOT NULL if applicable
                'default' => '', // Set a default value to an empty string
            ],
            'permitted_entities' => [
                'type'    => 'TEXT', // Assuming original type was TEXT
                'null'    => false, // Revert to NOT NULL if applicable
                'default' => '', // Set a default value to an empty string
            ],
        ];

        // Revert the modification to the columns
        $this->forge->modifyColumn('users', $fields);
    }
}
