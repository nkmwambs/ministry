<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddChurchFields extends Migration
{

    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
            'denomination_id' => ['type' => 'INT','unsigned' => true, 'constraint' => '20', 'null' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'biography' => ['type' => 'LONGTEXT', 'null' => true],
            'date_of_birth' => ['type' => 'DATE', 'null' => true],
            'gender' => ['type' => 'ENUM', 'constraint' => ['male','female'], 'null' => false],
            'phone' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'roles' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'is_system_admin' => ['type' => 'ENUM', 'constraint' => ['yes', 'no'], 'default' => 'no', 'null' => false],
            'access_count' => ['type' => 'INT', 'constraint' => '20', 'null' => true],
            'associated_member_id' => ['type' => 'INT', 'constraint' => '20', 'null' => true],
            'permitted_entities' => ['type' => 'LONGTEXT', 'null' => true],
            'permitted_assemblies' => ['type' => 'LONGTEXT', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => '20', 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => '20', 'null' => true],
            'deleted_by' => ['type' => 'INT', 'constraint' => '20', 'null' => true],
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'denomination_id',
            'first_name',
            'last_name',
            'biography',
            'date_of_birth',
            'gender',
            'phone',
            'roles',
            'is_system_admin',
            'access_count',
            'associated_member_id',
            'permitted_entities',
            'permitted_assemblies',
            'created_by',
            'updated_by',
            'deleted_by'
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
