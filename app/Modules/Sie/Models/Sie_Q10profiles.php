<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Higgs\Model;
use Config\Database;

/**
 * Ejemplo: $mq10profiles = model('App\Modules\Sie\Models\Sie_Q10profiles');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Q10profiles extends CachedModel
{
    protected $table = "sie_q10profiles";
    protected $primaryKey = "profile";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "profile",
        "reference",
        "first_name",
        "last_name",
        "id_number",
        "phone",
        "mobile_phone",
        "email",
        "residence_location",
        "birth_date",
        "blood_type",
        "campus_shift",
        "address",
        "neighborhood",
        "birth_place",
        "registration_date",
        "program",
        "health_provider",
        "ars_provider",
        "insurance_provider",
        "civil_status",
        "education_level",
        "institution",
        "municipality",
        "academic_level",
        "graduated",
        "degree_earned",
        "graduation_date",
        "family_member_full_name",
        "family_member_id_number",
        "family_member_phone",
        "family_member_mobile_phone",
        "family_member_email",
        "family_relationship",
        "company",
        "company_municipality",
        "job_position",
        "company_phone",
        "company_address",
        "job_start_date",
        "job_end_date",
        "source",
        "print_date",
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
        $migrations = \Config\Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Sie');// Set the namespace for the current module
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
        $row = parent::getCachedFirst([$this->primaryKey => $id]);
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
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->groupStart()
            ->like("profile", "%{$search}%")
            ->orLike("first_name", "%{$search}%")
            ->orLike("last_name", "%{$search}%")
            ->orLike("id_number", "%{$search}%")
            ->orLike("phone", "%{$search}%")
            ->orLike("mobile_phone", "%{$search}%")
            ->orLike("email", "%{$search}%")
            ->orLike("residence_location", "%{$search}%")
            ->orLike("birth_date", "%{$search}%")
            ->orLike("blood_type", "%{$search}%")
            ->orLike("campus_shift", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("birth_place", "%{$search}%")
            ->orLike("registration_date", "%{$search}%")
            ->orLike("program", "%{$search}%")
            ->orLike("health_provider", "%{$search}%")
            ->orLike("ars_provider", "%{$search}%")
            ->orLike("insurance_provider", "%{$search}%")
            ->orLike("civil_status", "%{$search}%")
            ->orLike("education_level", "%{$search}%")
            ->orLike("institution", "%{$search}%")
            ->orLike("municipality", "%{$search}%")
            ->orLike("academic_level", "%{$search}%")
            ->orLike("graduated", "%{$search}%")
            ->orLike("degree_earned", "%{$search}%")
            ->orLike("graduation_date", "%{$search}%")
            ->orLike("family_member_full_name", "%{$search}%")
            ->orLike("family_member_id_number", "%{$search}%")
            ->orLike("family_member_phone", "%{$search}%")
            ->orLike("family_member_mobile_phone", "%{$search}%")
            ->orLike("family_member_email", "%{$search}%")
            ->orLike("family_relationship", "%{$search}%")
            ->orLike("company", "%{$search}%")
            ->orLike("company_municipality", "%{$search}%")
            ->orLike("job_position", "%{$search}%")
            ->orLike("company_phone", "%{$search}%")
            ->orLike("company_address", "%{$search}%")
            ->orLike("job_start_date", "%{$search}%")
            ->orLike("job_end_date", "%{$search}%")
            ->orLike("source", "%{$search}%")
            ->orLike("print_date", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
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
     * @param $product
     * @return array|false
     */
    public function get_Profile($profile): false|array
    {
        $result = parent::getCached($profile);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }
}

?>