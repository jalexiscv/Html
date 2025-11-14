<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:23
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [2025-08-26_004423_Sogt_Devices.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

namespace App\Modules\Sogt\Database\Migrations;

use Higgs\Database\Migration;

class migration_sogt_devices_20250826004423 extends Migration
{
    protected $table = 'sogt_devices';
    protected $DBGroup = 'authentication';

    public function up(): void
    {
        $fields = [
            'device' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false,],
            'user' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false,],
            'tenant' => ['type' => 'BIGINT', 'null' => false,],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false,],
            'alias' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'device_type' => ['type' => 'ENUM', 'constraint' => ['tracker', 'mobile', 'other'], 'default' => 'tracker'],
            'asset_type' => ['type' => 'ENUM', 'constraint' => ['vehicle', 'person', 'pet', 'object'], 'default' => 'vehicle'],
            'asset_ref' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true,],
            'imei' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true,],
            'serial' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true,],
            'iccid' => ['type' => 'VARCHAR', 'constraint' => 22, 'null' => true,],
            'imsi' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true,],
            'mac_address' => ['type' => 'VARCHAR', 'constraint' => 17, 'null' => true,],
            'vendor' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'model' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'firmware_version' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true,],
            'protocol' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true,],
            'transport' => ['type' => 'ENUM', 'constraint' => ['tcp', 'udp'], 'default' => 'tcp'],
            'server_host' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true,],
            'server_port' => ['type' => 'INT', 'null' => true,],
            'apn' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'carrier' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true,],
            'sim_phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true,],
            'auth_key' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => true,],
            'ip_whitelist' => ['type' => 'JSON', 'null' => true,],
            'has_ignition' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => 0],
            'has_sos' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => 0],
            'has_temp' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => 0],
            'has_fuel' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => 0],
            'supports_ble' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => 0],
            'report_interval_moving_s' => ['type' => 'INT', 'null' => true, 'default' => '30'],
            'report_interval_idle_s' => ['type' => 'INT', 'null' => true, 'default' => '300'],
            'overspeed_kmh' => ['type' => 'DECIMAL', 'constraint' => 6, 'null' => true,],
            'timezone_offset_min' => ['type' => 'SMALLINT', 'null' => true, 'default' => '0'],
            'status' => ['type' => 'ENUM', 'constraint' => ['active', 'inactive', 'suspended'], 'default' => 'active'],
            'activation_date' => ['type' => 'DATE', 'null' => true,],
            'installed_on' => ['type' => 'DATETIME', 'null' => true,],
            'installed_by' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true,],
            'warranty_until' => ['type' => 'DATE', 'null' => true,],
            'tags' => ['type' => 'JSON', 'null' => true,],
            'notes' => ['type' => 'TEXT', 'null' => true,],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'created_at' => ['type' => 'DATETIME', 'null' => true,],
            'updated_at' => ['type' => 'DATETIME', 'null' => true,],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true,],
        ];

        //$this->forge->addColumn($this->table,$fields);
        $this->forge->addField($fields);
        $this->forge->addKey('device', true);
        $this->forge->createTable($this->table);
    }

    public function down(): void
    {
        $this->forge->dropTable($this->table);
    }
}

?>