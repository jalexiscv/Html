<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-03-27 06:56:41
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [2025-03-27_065641_Sgd_Locations.php]
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

class migration_sgd_locations_20250327065641 extends Migration
{
    protected $table = 'sgd_locations';
    protected $DBGroup = 'authentication';

    public function up(): void
    {
        $fields = [
            'location' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'registration' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'center' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'shelve' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'box' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'folder' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'date' => ['type' => 'DATE', 'null' => true,],
            'time' => ['type' => 'TIME', 'null' => true,],
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
        //$this->forge->dropTable($this->table);
    }
}

?>