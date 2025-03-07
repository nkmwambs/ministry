<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeatureTableNameToFeatures extends Migration
{
    public function up()
    {
        $this->forge->addColumn('features', [
            'feature_table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100, // Adjust length as needed
                'null'       => true, // Allow NULL if required
                'after'      => 'description', // Replace with the actual column after which this should be added
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('features', 'feature_table_name');
    }
}
