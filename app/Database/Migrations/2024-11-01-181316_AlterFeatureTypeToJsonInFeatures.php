<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFeatureTypeToJsonInFeatures extends Migration
{
    public function up()
    {
        // Modify the column to JSON type without a default value
        $this->forge->modifyColumn('features', [
            'feature_type' => [
                'type' => 'JSON',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        // Revert back to ENUM type with options 'admin' and 'church'
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
