<?php

namespace App\Modules\Sogt\Database\Migrations;

use Higgs\Database\Migration;

class migration_sogt_telemetry_20250826004434 extends Migration
{
    protected $table = 'sogt_telemetry';
    protected $DBGroup = 'authentication';

    public function up(): void
    {
        $fields = [
            'telemetry' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false,],
            'device' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false,],
            'user' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true,],
            'latitude' => ['type' => 'DECIMAL', 'constraint' => 10, 'null' => false,],
            'longitude' => ['type' => 'DECIMAL', 'constraint' => 10, 'null' => false,],
            'altitude' => ['type' => 'DECIMAL', 'constraint' => 8, 'null' => true,],
            'speed' => ['type' => 'DECIMAL', 'constraint' => 6, 'null' => true,],
            'heading' => ['type' => 'DECIMAL', 'constraint' => 5, 'null' => true,],
            'gps_valid' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => '1'],
            'satellites' => ['type' => 'INT', 'null' => true,],
            'network' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true,],
            'battery' => ['type' => 'TINYINT', 'null' => true,],
            'ignition' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true,],
            'event' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true,],
            'motion' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true,],
            'timestamp' => ['type' => 'DATETIME', 'null' => false,],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'created_at' => ['type' => 'DATETIME', 'null' => true,],
            'updated_at' => ['type' => 'DATETIME', 'null' => true,],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true,],
        ];

        //$this->forge->addColumn($this->table,$fields);
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->table);
    }

    public function down(): void
    {
        $this->forge->dropTable($this->table);
    }
}

?>