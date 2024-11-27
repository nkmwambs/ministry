<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSundayDateToCollections extends Migration
{
    public function up()
    {
        $fields = [
            'sunday_date' => [
                'type'       => 'DATE',
                'null'       => true, // Allows NULL values
                'default'    => null, // Default value set to NULL
            ],
        ];

        // Add the column to the 'collections' table
        $this->forge->addColumn('collections', $fields);
    }

    public function down()
    {
        // Remove the column if the migration is rolled back
        $this->forge->dropColumn('collections', 'sunday_date');
    }
}
