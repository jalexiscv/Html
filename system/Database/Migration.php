<?php

namespace Higgs\Database;

use Config\Database;

abstract class Migration
{
    protected $DBGroup;
    protected $db;
    protected $forge;

    public function __construct(?Forge $forge = null)
    {
        $this->forge = $forge ?? Database::forge($this->DBGroup ?? config('Database')->defaultGroup);
        $this->db = $this->forge->getConnection();
    }

    public function getDBGroup(): ?string
    {
        return $this->DBGroup;
    }

    abstract public function up();

    abstract public function down();
}