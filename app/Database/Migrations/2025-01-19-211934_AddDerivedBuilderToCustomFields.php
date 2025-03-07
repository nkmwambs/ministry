<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDerivedBuilderToCustomFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('customfields', [
            'derived_value_builder' => [
                'type'       => 'LONGTEXT',
                'null'       => true,
                'after'      => 'code_builder',
            ],
            'field_linked_to' => [
                'type'       => 'LONGTEXT',
                'null'       => true,
                'after'      => 'derived_value_builder',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('customfields', 'derived_value_builder');
        $this->forge->dropColumn('customfields', 'field_linked_to');
    }
}
