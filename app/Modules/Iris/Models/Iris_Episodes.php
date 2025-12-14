<?php

namespace App\Modules\Iris\Models;

use App\Models\CachedModel;
use Config\Services;
use Throwable;

/**
* @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
* @method update(string $id, array $data) : bool
* @method delete(string $id, bool $purge = false) : bool
* @method get_CachedFirst(array $conditions): array|object|null
* @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
*/
class Iris_Episodes extends CachedModel
{
    protected $table = "iris_episodes";
    protected $primaryKey = "episode";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "episode",
        "patient",
        "start_date",
        "end_date",
        "reason_for_visit",
        "general_notes",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.1';
    protected $cache_time = 60;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_Migrate();
    }

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Iris');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_Authority($id, $author): bool
    {
        $row = parent::get_CachedFirst([$this->primaryKey => $id]);
        if (isset($row["author"]) && $row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @param string $order La columna por la cual ordenar los resultados.
     * @return array|false Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = "", string $order = 'iris_episodes.start_date DESC'): array|false
    {
        $builder = $this->db->table('iris_patients');
        $builder->select('
            iris_episodes.patient AS episode_patient,
            iris_patients.patient AS patient,
            iris_patients.document_number AS document_number,
            iris_patients.first_name AS first_name,
            iris_patients.middle_name AS middle_name,
            iris_patients.first_surname AS first_surname,
            iris_patients.second_surname AS second_surname,
            iris_patients.full_name AS full_name,
            iris_patients.fhir_id AS fhir_id,
            iris_episodes.episode AS episode,
            iris_episodes.reason_for_visit,
            iris_episodes.general_notes,
            iris_episodes.start_date AS start_date,
            iris_episodes.end_date AS end_date
        ');
        $builder->join('iris_episodes', 'iris_episodes.patient = iris_patients.patient', 'inner');

        if (!empty($search)) {
            $fieldsToSearch = [
                'iris_patients.patient',
                'iris_patients.document_number',
                'iris_patients.full_name',
                'iris_episodes.reason_for_visit'
            ];
            $builder->groupStart();
            foreach ($fieldsToSearch as $field) {
                $builder->orLike($field, $search);
            }
            $builder->groupEnd();
        }

        // Clonar el builder para obtener el total de resultados sin la paginación
        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults();

        // Aplicar orden y paginación a la consulta principal
        $builder->orderBy($order);
        $builder->limit($limit, $offset);
        $results = $builder->get()->getResultArray();

        if ($results) {
            return ['data' => $results, 'total' => $total];
        }

        return false;
    }

    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
     * Ejemplo de uso:
     * $model = model("App\Modules\Sie\Models\Sie_Modules");
     * $list = $model->get_SelectData();
     * $f->get_FieldSelect("list", array("selected" => $r["list"], "data" => $list, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
     */
    public function get_SelectData()
    {
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $episode
     * @return array|false
     */
    public function getEpisode($episode): false|array
    {
        $result = parent::getCached($episode);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }
}

?>
