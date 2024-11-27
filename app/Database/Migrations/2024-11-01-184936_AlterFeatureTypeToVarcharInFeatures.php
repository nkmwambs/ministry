<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFeatureTypeToVarcharInFeatures extends Migration
{
    public function up()
    {
        // Modify the column to VARCHAR(20) with a default value of "all"
        $this->forge->modifyColumn('features', [
            'feature_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'default'    => 'all',
            ],
        ]);
    }

    public function down()
    {
        // Revert back to JSON type or previous type if needed (example given here)
        $this->forge->modifyColumn('features', [
            'feature_type' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'church'],
                'null'       => true,
                'default'    => 'church',
            ],
        ]);
    }
}
