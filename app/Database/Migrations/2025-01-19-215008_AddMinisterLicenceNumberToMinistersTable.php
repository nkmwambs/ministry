<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMinisterLicenceNumberToMinistersTable extends Migration
{
    public function up()
    {
        // Add the new column
        $this->forge->addColumn('ministers', [
            'license_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'after'      => 'member_id', // Add the column after the 'name' column
                'null'       => true,   // Allow NULL values
            ],
        ]);
    }

    public function down()
    {
        // Remove the new column
        $this->forge->dropColumn('ministers', 'license_number');
    }
}
