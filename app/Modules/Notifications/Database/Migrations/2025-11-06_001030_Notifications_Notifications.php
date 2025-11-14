<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [2025-11-06_001030_Notifications_Notifications.php]
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

namespace App\Modules\Frontend\Database\Migrations;

use Higgs\Database\Migration;

class migration_notifications_notifications_20251106001030 extends Migration
{
    protected $table = 'notifications_notifications';
    protected $DBGroup = 'authentication';

    public function up(): void
    {
        $fields = [
            'notification' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false,],
            'user' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false, 'default' => ''],
            'recipient_email' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true,],
            'recipient_phone' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true,],
            'type' => ['type' => 'ENUM', 'constraint' => [''],],
            'category' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true,],
            'priority' => ['type' => 'ENUM', 'constraint' => [''], 'default' => 'normal'],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true,],
            'message' => ['type' => 'TEXT', 'null' => true,],
            'data' => ['type' => 'JSON', 'null' => true,],
            'is_read' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => '0'],
            'read_at' => ['type' => 'DATETIME', 'null' => true,],
            'email_sent' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => '0'],
            'email_sent_at' => ['type' => 'DATETIME', 'null' => true,],
            'email_error' => ['type' => 'TEXT', 'null' => true,],
            'sms_sent' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true, 'default' => '0'],
            'sms_sent_at' => ['type' => 'DATETIME', 'null' => true,],
            'sms_error' => ['type' => 'TEXT', 'null' => true,],
            'action_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true,],
            'action_text' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'expires_at' => ['type' => 'DATETIME', 'null' => true,],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => 'now()'],
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
        //$this->forge->dropTable($this->table);
    }
}

?>