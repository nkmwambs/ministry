<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserTypeToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'user_type' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'church'],
                'null'       => true,
                'default'    => 'church',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'user_type');
    }
}
