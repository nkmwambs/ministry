<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsMenuItemToFeatures extends Migration
{
    public function up()
    {
        $this->forge->addColumn('features', [
            'is_menu_item' => [
                'type'       => 'ENUM',
                'constraint' => ['yes', 'no'],
                'null'       => false,
                'default'    => 'no',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('features', 'is_menu_item');
    }
}
