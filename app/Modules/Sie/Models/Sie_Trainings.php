<?php

namespace App\Modules\Sie\Models;

use Config\Database;
use Higgs\Model;

/**
 * @Syntax: $mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Sie_Trainings extends Model
{
    protected $table = "sie_registrations";
    protected $primaryKey = "registration";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "registration",
        "agreement",
        "agreement_country",
        "agreement_region",
        "agreement_city",
        "agreement_institution",
        "period",
        "journey",
        "program",
        "first_name",
        "second_name",
        "first_surname",
        "second_surname",
        "identification_type",
        "identification_number",
        "gender",
        "email_address",
        "phone",
        "mobile",
        "address",
        "residence_country",
        "residence_region",
        "residence_city",
        "neighborhood",
        "area",
        "stratum",
        "transport_method",
        "sisben_group",
        "sisben_subgroup",
        "document_issue_place",
        "birth_date",
        "birth_country",
        "birth_region",
        "birth_city",
        "blood_type",
        "marital_status",
        "number_children",
        "military_card",
        "ars",
        "insurer",
        "eps",
        "education_level",
        "occupation",
        "health_regime",
        "document_issue_date",
        "saber11",
        "ticket",
        "observations",
        "status",
        "interview",
        "linkage_type",
        "ethnic_group",
        "indigenous_people",
        "afro_descendant",
        "disability",
        "disability_type",
        "exceptional_ability",
        "responsible",                            // Responsable legal
        "responsible_relationship",               // Relación con el responsable legal
        "responsible_phone",                      // Teléfono del responsable legal
        "num_people_living_with_you",             // Número de personas que viven con usted
        "num_people_contributing_economically",   // Número de personas que aportan económicamente al hogar
        "num_people_depending_on_you",            // Personas que dependen económicamente de usted
        "first_in_family_to_study_university",    // Es usted la primera persona de su familia en estudiar en Universidad
        "border_population",                      // Pertenece a Población Frontera (Población que habita en los departamentos y municipios de frontera)
        "identified_population_group",            // Grupo poblacional con el que se identifica (permitir seleccionar varias casillas)
        "highlighted_population",                 // Pertenece a alguna de las siguientes poblaciones destacadas
        "observations_academic",
        "snies_updated_at",
        "photo",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $beforeFind = ['_exec_BeforeFind'];
    protected $afterFind = ['_exec_FindCache'];
    protected $afterInsert = ['_exec_UpdateCache'];
    protected $afterUpdate = ['_exec_UpdateCache'];
    protected $afterDelete = ['_exec_DeleteCache'];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.0';
    protected $cache_time = 60;
    protected $cache;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_TableRegenerate();
    }

    /**
     * Regenera o recrea la tabla de la base de datos en caso de que esta no exista
     * Ejemplo de campos
     * $fields = [
     *      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],
     *      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],
     *      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],
     *      'description'=>['type'=>'TEXT','null'=>true,],
     *      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
     *   ];
     */
    private function exec_TableRegenerate()
    {
        if (!$this->get_TableExist()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'registration' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'period' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'journey' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'program' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'first_name' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'second_name' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'first_surname' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'second_surname' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'identification_type' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'identification_number' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'gender' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'email_address' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'phone' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'mobile' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'birth_date' => ['type' => 'DATE', 'null' => FALSE],
                'address' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'residence_city' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'neighborhood' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'area' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'stratum' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'transport_method' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'sisben_group' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'sisben_subgroup' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'document_issue_place' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'birth_city' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'blood_type' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'marital_status' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'number_children' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'military_card' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'ars' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'insurer' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'eps' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'education_level' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'occupation' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'health_regime' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'document_issue_date' => ['type' => 'DATE', 'null' => FALSE],
                'saber11' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'ticket' => ['type' => 'INT', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'observations' => ['type' => 'TEXT', 'null' => TRUE],
                'status' => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
                'interview' => ['type' => 'TEXT', 'null' => TRUE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
//$forge->addKey('post');
//$forge->addKey('profile');
            $forge->addKey('author');
            $forge->createTable($this->table, TRUE);
        }
    }

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de Higgs. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @return bool Devuelve true si la tabla existe, false en caso contrario.
     */
    private function get_TableExist(): bool
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param mixed $id Identificador único para el objeto en caché.
     * @return string Clave de caché generada para el identificador.
     **/
    protected function get_CacheKey($id)
    {
        $id = is_array($id) ? implode("", $id) : $id;
        $node = APPNODE;
        $table = $this->table;
        $class = urlencode(get_class($this));
        $version = $this->version;
        $key = "{$node}-{$table}-{$class}-{$version}-{$id}";
        return md5($key);
    }

    public function get_CountAllResults($search = "")
    {
        if (!empty($search)) {
            $result = $this
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->groupStart()
                ->like("cadastre_customers.customer", "%{$search}%")
                ->orLike("cadastre_customers.registration", "%{$search}%")
                ->groupEnd()
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        } else {
            $result = $this
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        }
        return ($result);
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del registro que se desea acceder, editar o eliminar.
     * @param string $id código primario del registro a consultar
     * @param string $author código del usuario del cual se pretende establecer la autoría
     * @return boolean falso o verdadero según sea el caso
     */
    public function get_Authority(string $id, string $author): bool
    {
        $key = $this->get_CacheKey("{$id}{$author}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $row = $this->where($this->primaryKey, $id)->first();
            if (isset($row["author"]) && $row["author"] == $author) {
                $value = true;
            } else {
                $value = false;
            }
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, $this->cache_time);
        }
        return ($cache['value']);
    }

    /**
     * Método is_CacheValid
     * Este método verifica si los datos recuperados de la caché son válidos.
     * @param mixed $cache - Los datos recuperados de la caché.
     * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
     */
    private function is_CacheValid(mixed $cache): bool
    {
        return is_array($cache) && array_key_exists('retrieved', $cache) && $cache['retrieved'] === true;
    }

    /**
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * SELECT
     * `sie_enrollments`.`grid`,
     * `sie_registrations`.*
     * FROM
     * `sie_registrations`
     * INNER JOIN `sie_enrollments` ON `sie_registrations`.`registration` =
     * `sie_enrollments`.`registration`
     * WHERE
     * `sie_enrollments`.`grid` = '66F329E3A147F'
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.student')
            ->select('sie_enrollments.grid, sie_registrations.*')
            ->where('sie_enrollments.grid', '66F329E3A147F')
            ->groupStart()
            ->like("sie_registrations.registration", "%{$search}%")
            ->orLike("sie_registrations.first_name", "%{$search}%")
            ->orLike("sie_registrations.second_name", "%{$search}%")
            ->orLike("sie_registrations.first_surname", "%{$search}%")
            ->orLike("sie_registrations.second_surname", "%{$search}%")
            ->orLike("sie_registrations.identification_number", "%{$search}%")
            ->groupEnd()
            ->orderBy("sie_registrations.created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    function get_TotalAgreements(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->where("agreement", "6664494D42F46")
            ->orWhere("status", "HOMOLOGATION")
            ->groupEnd()
            ->groupStart()
            ->orLike("first_name", "%{$search}%")
            ->orLike("second_name", "%{$search}%")
            ->orLike("first_surname", "%{$search}%")
            ->orLike("second_surname", "%{$search}%")
            ->orLike("identification_type", "%{$search}%")
            ->orLike("identification_number", "%{$search}%")
            ->orLike("gender", "%{$search}%")
            ->orLike("email_address", "%{$search}%")
            ->orLike("phone", "%{$search}%")
            ->orLike("mobile", "%{$search}%")
            ->orLike("birth_date", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("residence_city", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("area", "%{$search}%")
            ->orLike("stratum", "%{$search}%")
            ->orLike("transport_method", "%{$search}%")
            ->orLike("sisben_group", "%{$search}%")
            ->orLike("sisben_subgroup", "%{$search}%")
            ->orLike("document_issue_place", "%{$search}%")
            ->orLike("birth_city", "%{$search}%")
            ->orLike("blood_type", "%{$search}%")
            ->orLike("marital_status", "%{$search}%")
            ->orLike("number_children", "%{$search}%")
            ->orLike("military_card", "%{$search}%")
            ->orLike("ars", "%{$search}%")
            ->orLike("insurer", "%{$search}%")
            ->orLike("eps", "%{$search}%")
            ->orLike("education_level", "%{$search}%")
            ->orLike("occupation", "%{$search}%")
            ->orLike("health_regime", "%{$search}%")
            ->orLike("document_issue_date", "%{$search}%")
            ->orLike("saber11", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }

    public function get_ListAgreements(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->where("agreement", "6664494D42F46")
            ->groupStart()
            ->like("registration", "%{$search}%")
            ->orLike("first_name", "%{$search}%")
            ->orLike("second_name", "%{$search}%")
            ->orLike("first_surname", "%{$search}%")
            ->orLike("second_surname", "%{$search}%")
            ->orLike("identification_type", "%{$search}%")
            ->orLike("identification_number", "%{$search}%")
            ->orLike("gender", "%{$search}%")
            ->orLike("email_address", "%{$search}%")
            ->orLike("phone", "%{$search}%")
            ->orLike("mobile", "%{$search}%")
            ->orLike("birth_date", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("residence_city", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("area", "%{$search}%")
            ->orLike("stratum", "%{$search}%")
            ->orLike("transport_method", "%{$search}%")
            ->orLike("sisben_group", "%{$search}%")
            ->orLike("sisben_subgroup", "%{$search}%")
            ->orLike("document_issue_place", "%{$search}%")
            ->orLike("birth_city", "%{$search}%")
            ->orLike("blood_type", "%{$search}%")
            ->orLike("marital_status", "%{$search}%")
            ->orLike("number_children", "%{$search}%")
            ->orLike("military_card", "%{$search}%")
            ->orLike("ars", "%{$search}%")
            ->orLike("insurer", "%{$search}%")
            ->orLike("eps", "%{$search}%")
            ->orLike("education_level", "%{$search}%")
            ->orLike("occupation", "%{$search}%")
            ->orLike("health_regime", "%{$search}%")
            ->orLike("document_issue_date", "%{$search}%")
            ->orLike("saber11", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function get_ListAdmitted(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->groupStart()
            ->where("status", "ADMITTED")
            ->orWhere("status", "HOMOLOGATION")
            ->orWhere("status", "RE-ENTRY")
            ->groupEnd()
            ->groupStart()
            ->like("registration", "%{$search}%")
            ->orLike("first_name", "%{$search}%")
            ->orLike("second_name", "%{$search}%")
            ->orLike("first_surname", "%{$search}%")
            ->orLike("second_surname", "%{$search}%")
            ->orLike("identification_type", "%{$search}%")
            ->orLike("identification_number", "%{$search}%")
            ->orLike("gender", "%{$search}%")
            ->orLike("email_address", "%{$search}%")
            ->orLike("phone", "%{$search}%")
            ->orLike("mobile", "%{$search}%")
            ->orLike("birth_date", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("residence_city", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("area", "%{$search}%")
            ->orLike("stratum", "%{$search}%")
            ->orLike("transport_method", "%{$search}%")
            ->orLike("sisben_group", "%{$search}%")
            ->orLike("sisben_subgroup", "%{$search}%")
            ->orLike("document_issue_place", "%{$search}%")
            ->orLike("birth_city", "%{$search}%")
            ->orLike("blood_type", "%{$search}%")
            ->orLike("marital_status", "%{$search}%")
            ->orLike("number_children", "%{$search}%")
            ->orLike("military_card", "%{$search}%")
            ->orLike("ars", "%{$search}%")
            ->orLike("insurer", "%{$search}%")
            ->orLike("eps", "%{$search}%")
            ->orLike("education_level", "%{$search}%")
            ->orLike("occupation", "%{$search}%")
            ->orLike("health_regime", "%{$search}%")
            ->orLike("document_issue_date", "%{$search}%")
            ->orLike("saber11", "%{$search}%")
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
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
            ->join('sie_enrollments', 'sie_registrations.registration = sie_enrollments.student')
            ->select('sie_enrollments.grid, sie_registrations.*')
            ->where('sie_enrollments.grid', '66F329E3A147F')
            ->groupStart()
            ->like("sie_registrations.registration", "%{$search}%")
            ->orLike("sie_registrations.first_name", "%{$search}%")
            ->orLike("sie_registrations.second_name", "%{$search}%")
            ->orLike("sie_registrations.first_surname", "%{$search}%")
            ->orLike("sie_registrations.second_surname", "%{$search}%")
            ->orLike("sie_registrations.identification_number", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }


    function get_TotalWithoutAgreements(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->where("agreement", "")
            ->orWhere("agreement", null)
            ->groupEnd()
            ->orWhere("agreement", null)
            ->countAllResults();
        return ($result);
    }


    function get_TotalAdmitted(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->where("status", "ADMITTED")
            ->orWhere("status", "HOMOLOGATION")
            ->orWhere("status", "RE-ENTRY")
            ->groupEnd()
            ->groupStart()
            ->orLike("first_name", "%{$search}%")
            ->orLike("second_name", "%{$search}%")
            ->orLike("first_surname", "%{$search}%")
            ->orLike("second_surname", "%{$search}%")
            ->orLike("identification_type", "%{$search}%")
            ->orLike("identification_number", "%{$search}%")
            ->orLike("gender", "%{$search}%")
            ->orLike("email_address", "%{$search}%")
            ->orLike("phone", "%{$search}%")
            ->orLike("mobile", "%{$search}%")
            ->orLike("birth_date", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("residence_city", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("area", "%{$search}%")
            ->orLike("stratum", "%{$search}%")
            ->orLike("transport_method", "%{$search}%")
            ->orLike("sisben_group", "%{$search}%")
            ->orLike("sisben_subgroup", "%{$search}%")
            ->orLike("document_issue_place", "%{$search}%")
            ->orLike("birth_city", "%{$search}%")
            ->orLike("blood_type", "%{$search}%")
            ->orLike("marital_status", "%{$search}%")
            ->orLike("number_children", "%{$search}%")
            ->orLike("military_card", "%{$search}%")
            ->orLike("ars", "%{$search}%")
            ->orLike("insurer", "%{$search}%")
            ->orLike("eps", "%{$search}%")
            ->orLike("education_level", "%{$search}%")
            ->orLike("occupation", "%{$search}%")
            ->orLike("health_regime", "%{$search}%")
            ->orLike("document_issue_date", "%{$search}%")
            ->orLike("saber11", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
    }


    public function getRegistrationByTicket($ticket): false|array
    {
        $row = $this->where("ticket", $ticket)->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }
        return ($value);
    }


    public function getRegistrationByName($name): false|array
    {
        return (false);
    }


    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function getRegistration($registration): false|array
    {

        $row = $this->where($this->primaryKey, $registration)->first();
        if (is_array($row)) {
            $value = $row;
        } else {
            $value = false;
        }


        return ($value);
    }

    public function getRegistrationByIdentification($identification_number): false|array
    {
        $key = $this->get_CacheKey("registration-{$identification_number}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $row = $this
                ->where("identification_number", $identification_number)
                ->first();
            if (is_array($row)) {
                $value = $row;
            } else {
                $value = false;
            }
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, $this->cache_time);
        }
        return ($cache['value']);
    }

    protected function _exec_BeforeFind(array $data)
    {
        if (isset($data['id']) && $item = $this->get_CachedItem($data['id'])) {
            $data['data'] = $item;
            $data['returnData'] = true;
            return $data;
        }
    }

    private function get_CachedItem($id)
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        return $cachedData !== null ? $cachedData : false;
    }

    protected function _exec_FindCache(array $data)
    {
        $id = $data['id'] ?? null;
        cache()->save($this->get_CacheKey($id), $data['data'], $this->cache_time);
        return ($data);
    }

    /**
     * Implementa la lógica para actualizar la caché después de insertar o actualizar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * y guardar los datos en la caché usando cache().
     * @param array $data
     * @return void
     */

    protected function _exec_UpdateCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $updatedData = $this->find($id);
            if ($updatedData) {
                cache()->save($this->get_CacheKey($id), $updatedData, $this->cache_time);
            }
        }
    }

    /**
     * Implementa la lógica para eliminar la caché después de eliminar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * para invalidar la caché.
     * @param array $data
     * @return void
     */
    protected function _exec_DeleteCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $deletedData = $this->find($id);
            if ($deletedData) {
                cache()->delete($this->get_CacheKey($id));
            }
        }
    }
}

?>