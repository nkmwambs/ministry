<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSundayCountToCollections extends Migration
{
    public function up()
    {
        $this->forge->addColumn('collections', [
            'sunday_count' => [
                'type'       => 'ENUM',
                'constraint' => ['1', '2', '3', '4', '5'],
                'default'    => '1',
                'null'       => false, // Ensure this column cannot be null
                'after'      => 'return_date', // Add the column after 'return_date'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('collections', 'sunday_count');
    }
}
