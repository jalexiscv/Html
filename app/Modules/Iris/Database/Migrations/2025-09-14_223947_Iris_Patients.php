<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-09-14 22:39:47
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [2025-09-14_223947_Iris_Patients.php]
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

class migration_iris_patients_20250914223947 extends Migration
	 {
		 protected $table = 'iris_patients';
		 protected $DBGroup = 'authentication';

		 public function up():void
			 {
				 $fields=[
				 'patient' => ['type' => 'VARCHAR',  'constraint' => 13,  'null' => false,],
				 'fhir_id' => ['type' => 'VARCHAR',  'constraint' => 64,  'null' => false,],
				 'active' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '1'],
				 'document_type' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'document_number' => ['type' => 'VARCHAR',  'constraint' => 20,  'null' => false,],
				 'document_issued_place' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'first_name' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => false,],
				 'middle_name' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
				 'first_surname' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => false,],
				 'second_surname' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
				 'full_name' => ['type' => 'VARCHAR',  'constraint' => 203,  'null' => true,],
				 'gender' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'birth_date' => ['type' => 'DATE',  'null' => false,],
				 'birth_place' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'marital_status' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'primary_phone' => ['type' => 'VARCHAR',  'constraint' => 15,  'null' => true,],
				 'secondary_phone' => ['type' => 'VARCHAR',  'constraint' => 15,  'null' => true,],
				 'email' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'full_address' => ['type' => 'TEXT',  'null' => true,],
				 'neighborhood' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'city' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'state' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'postal_code' => ['type' => 'VARCHAR',  'constraint' => 10,  'null' => true,],
				 'country' => ['type' => 'CHAR',  'constraint' => 3,  'null' => false,'default' => 'COL'],
				 'residence_area' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'socioeconomic_stratum' => ['type' => 'TINYINT',  'null' => true,],
				 'emergency_contact_name' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'emergency_contact_relationship' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
				 'emergency_contact_phone' => ['type' => 'VARCHAR',  'constraint' => 15,  'null' => true,],
				 'health_insurance' => ['type' => 'VARCHAR',  'constraint' => 100,  'null' => true,],
				 'health_regime' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'affiliation_type' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'ethnicity' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'special_population' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'has_diabetes' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'has_hypertension' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'family_history_glaucoma' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'family_history_diabetes' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'family_history_retinopathy' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'previous_eye_surgeries' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'blood_type' => ['type' => 'ENUM',  'constraint' =>[''],],
				 'allergies' => ['type' => 'JSON',  'null' => true,],
				 'current_medications' => ['type' => 'JSON',  'null' => true,],
				 'primary_language' => ['type' => 'VARCHAR',  'constraint' => 10,  'null' => false,'default' => 'es'],
				 'data_consent' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '0'],
				 'accepts_communications' => ['type' => 'TINYINT',  'constraint' => 1,  'null' => false,'default' => '1'],
				 'profile_photo' => ['type' => 'VARCHAR',  'constraint' => 255,  'null' => true,],
				 'observations' => ['type' => 'TEXT',  'null' => true,],
				 'created_by' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
				 'updated_by' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
				 'deleted_by' => ['type' => 'VARCHAR',  'constraint' => 50,  'null' => true,],
                 'created_at' => ['type' => 'DATETIME',  'null' => true,],
                 'updated_at' => ['type' => 'DATETIME',  'null' => true,],
                 'deleted_at' => ['type' => 'DATETIME',  'null' => true,],
			 ];

		 //$this->forge->addColumn($this->table,$fields);
		 $this->forge->addField($fields);
		 $this->forge->addKey('id', true);
		 $this->forge->createTable($this->table);
	 }

	 public function down():void
		 {
			 //$this->forge->dropTable($this->table);
		 }
	 }
?>