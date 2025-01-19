<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewColumnToRevenues extends Migration
{
    public function up()
    {
        // Add the new column
        $this->forge->addColumn('revenues', [
            'revenue_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'after'      => 'name', // Add the column after the 'name' column
                'null'       => true,   // Allow NULL values
            ],
        ]);
    }

    public function down()
    {
        // Remove the new column
        $this->forge->dropColumn('revenues', 'revenue_code');
    }
}
