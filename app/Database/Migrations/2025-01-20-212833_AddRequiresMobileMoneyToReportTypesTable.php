<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRequiresMobileMoneyToReportTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('reporttypes', [
            'requires_mobile_money' => [
                'type'       => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default'    => 'no',
                'null'       => false,
                'after'      => 'report_layout',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reporttypes', 'requires_mobile_money');
    }
}
