<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRemittanceAmountBuilderToReportTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('reporttypes', [
            'remittance_amount_builder' => [
                'type'       => 'LONGTEXT',
                'null'       => true,
                'after'      => 'requires_mobile_money',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reporttypes', 'remittance_amount_builder');
    }
}
