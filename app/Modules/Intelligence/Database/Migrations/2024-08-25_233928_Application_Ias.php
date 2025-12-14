<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-06-16 23:53:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [2024-06-16_235309_Frontend_Shortcuts.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

namespace App\Modules\Intelligence\Database\Migrations;

use Higgs\Database\Migration;

class migration_application_ias_20240825233928 extends Migration
{
    protected $table = 'application_ias';
    protected $DBGroup = 'default';

    public function up(): void
    {
        $fields = [
            'ia' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false,],
            'tech' => ['type' => 'ENUM', 'constraint' => [''],],
            'name' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'description' => ['type' => 'TINYTEXT', 'null' => true,],
            'avatar' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => true,],
            'video' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => true,],
            'sound' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => true,],
            'prompt' => ['type' => 'TEXT', 'null' => true,],
            'user' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => true,],
            'identification' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true,],
            'author' => ['type' => 'TINYTEXT', 'null' => true,],
            'created_at' => ['type' => 'DATETIME', 'null' => true,],
            'updated_at' => ['type' => 'DATETIME', 'null' => true,],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true,],
        ];
        //$this->forge->addColumn($this->table,$fields);
        $this->forge->addField($fields);
        $this->forge->addKey('ia', true);
        $this->forge->createTable($this->table);
    }

    public function down(): void
    {
        //$this->forge->dropTable($this->table);
    }
}

?>