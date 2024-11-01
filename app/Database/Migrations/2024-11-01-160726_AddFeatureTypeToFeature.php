<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeatureTypeToFeature extends Migration
{
    public function up()
    {
        $this->forge->addColumn('features', [
            'feature_type' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'church'],
                'null'       => true,
                'default'    => 'church',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('features', 'feature_type');
    }
}
