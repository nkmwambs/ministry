<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStartReportingMonthInAssemblyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('assemblies', [
            'start_reporting_date' => [
                'type' => 'DATE',
                'null' => true, // Allow NULL if needed
                'after' => 'location', // Replace with the actual column name or remove if adding at the end
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('assemblies', 'start_reporting_date');
    }
}
