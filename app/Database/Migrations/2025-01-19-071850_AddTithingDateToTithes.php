<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTithingDateToTithes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tithes', [
            'tithing_date' => [
                'type' => 'DATE',
                'null' => true, // Allow NULL if needed
                'after' => 'amount', // Replace with the actual column name or remove if adding at the end
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tithes', 'tithing_date');
    }
}
