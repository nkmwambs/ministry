<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleTypeToRoles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('roles', [
            'role_type' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'church'],
                'null'       => true,
                'default'    => 'church',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('roles', 'role_type');
    }
}
