<?php

namespace App\Libraries;


use Config\Database;

class Migrations
{

    /** @var string $module Nombre del módulo * */
    private $module;
    /** @var string $table Nombre de la tabla * */
    private $table;

    public function __construct($module, $table)
    {
        $this->module = ucfirst($module);
        $this->table = $table;
    }

    function generate(): string
    {
        // Obtener la conexión a la base de datos
        $db = Database::connect("default");
        $fields = $db->getFieldData($this->table);
        if (empty($fields)) {
            throwException("La tabla no existe.");
        }
        $code = $this->generateMigrationContent($fields);// Generar el contenido del archivo de migración
        //$filePath = $this->save($migrationContent);// Guardar el archivo de migración
        //if ($filePath) {
        //    return (['success' => 'Migración creada con éxito.', 'file' => $filePath]);
        //}
        //return (['error' => 'No se pudo crear el archivo de migración.']);
        return ($code);
    }

    /**
     * Genera el contenido de la migración basado en la estructura de la tabla.
     * @param string $table
     * @param array $afields
     * @return string
     */
    private function generateMigrationContent(array $afields): string
    {
        $class = 'migration_' . $this->table . "_" . date('YmdHis');
        $fields = '';
        foreach ($afields as $field) {
            $fields .= $this->generateFieldContent($field);
        }
        $template = "namespace App\\Modules\\{$this->module}\\Database\\Migrations;\n\n";
        $template .= "use Higgs\Database\Migration;\n\n";
        $template .= "class $class extends Migration\n";
        $template .= "\t {\n";
        $template .= "\t\t protected \$table = '$this->table';\n";
        $template .= "\t\t protected \$DBGroup = 'authentication';\n\n";
        $template .= "\t\t public function up():void\n";
        $template .= "\t\t\t {\n";
        $template .= "\t\t\t\t \$fields=[\n";
        $template .= "$fields";
        $template .= "\t\t\t ];\n\n";
        $template .= "\t\t //\$this->forge->addColumn(\$this->table,\$fields);\n";
        $template .= "\t\t \$this->forge->addField(\$fields);\n";
        $template .= "\t\t \$this->forge->addKey('id', true);\n";
        $template .= "\t\t \$this->forge->createTable(\$this->table);\n";
        $template .= "\t }\n\n";
        $template .= "\t public function down():void\n";
        $template .= "\t\t {\n";
        $template .= "\t\t\t //\$this->forge->dropTable(\$this->table);\n";
        $template .= "\t\t }\n";
        $template .= "\t }\n";
        return ($template);
    }

    /**
     * Genera el contenido de un campo basado en su estructura.
     * @param string $table
     * @param object $field
     * @return string
     */
    private function generateFieldContent(object $field): string
    {
        //print_r($field);
        $type = strtoupper($field->type);
        $constraint = isset($field->max_length) ? " 'constraint' => $field->max_length, " : '';
        $nullable = $field->nullable ? 'true' : 'false';
        $default = isset($field->default) ? "'default' => '$field->default'" : '';
        $null = " 'null' => $nullable,";
        if ($type == 'ENUM') {
            $enum = $this->get_EnumValues($this->table, $field->name);
            $constraint = " 'constraint' =>['" . implode("', '", $enum) . "'],";
            $null = "";
        }
        return "\t\t\t\t '$field->name' => ['type' => '$type', $constraint$null$default],\n";
    }

    /**
     * Ej: 'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
     * @param $columnName
     * @return array
     */
    private function get_EnumValues($columnName): array
    {
        $db = Database::connect("default");
        $query = $db->query("SHOW COLUMNS FROM `$this->table` WHERE Field = '$columnName'");
        $row = $query->getRow();
        if (isset($row->Type) && preg_match('/^enum\((.*)\)$/', $row->Type, $matches)) {
            return str_getcsv($matches[1], ",", "'");
        }
        return [];
    }

    /**
     * Guarda el archivo de migración en el directorio correspondiente.
     * @param string $migrationContent
     * @return string|bool
     */
    public function save(string $migrationContent): bool|string
    {
        $timestamp = date('Y-m-d_His');
        $fileName = "{$timestamp}_create_{$this->table}.php";
        $filePath = APPPATH . "Modules/{$this->module}/Database/Migrations/$fileName";
        if (file_put_contents($filePath, $migrationContent)) {
            return $filePath;
        }
        return false;
    }

}


?>