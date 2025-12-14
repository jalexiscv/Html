<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ejemplo: $mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Registrations extends CachedModel
{
    protected $table = "sie_registrations";
    protected $primaryKey = "registration";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "registration",
        "country",
        "region",
        "city",
        "agreement",
        "agreement_country",
        "agreement_region",
        "agreement_city",
        "agreement_institution",
        "agreement_group",
        "campus",
        "shifts",
        "group",
        "period",
        "journey",
        "program",
        "first_name",
        "second_name",
        "first_surname",
        "second_surname",
        "identification_type",
        "identification_number",
        "identification_place",
        "identification_date",
        "identification_country",
        "identification_region",
        "identification_city",
        "gender",
        "email_address",
        "email_institutional",
        "phone",
        "mobile",
        "birth_date",
        "birth_country",
        "birth_region",
        "birth_city",
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
        "saber11_value",
        "saber11_date",
        "graduation_certificate",
        "military_id",
        "diploma",
        "icfes_certificate",
        "utility_bill",
        "sisben_certificate",
        "address_certificate",
        "electoral_certificate",
        "photo_card",
        "observations",
        "status",
        "author",
        "ticket",
        "interview",
        "linkage_type",
        "ethnic_group",
        "indigenous_people",
        "afro_descendant",
        "disability",
        "disability_type",
        "exceptional_ability",
        "responsible",
        "responsible_relationship",
        "identified_population_group",
        "highlighted_population",
        "responsible_phone",
        "border_population",
        "observations_academic",
        "import",
        "moment",
        "snies_updated_at",
        "photo",
        "college",
        "college_year",
        "ac",
        "ac_score",
        "ac_date",
        "ac_document_type",
        "ac_document_number",
        "ek",
        "ek_score",
        "snies_id_validation_requisite",
        "created_at",
        "updated_at",
        "deleted_at",
        //3.1. Información familiar
        "num_people_living_with_you",
        "num_people_contributing_economically",
        "num_people_depending_on_you",
        "education_level_father",
        "education_level_mother",
        "type_of_housing",
        //4. Información Laboral
        "economic_dependency",
        "type_of_funding",
        "current_occupation",
        "type_of_work",
        "weekly_hours_worked",
        "monthly_income",
        "company_name",
        "company_position",
        "productive_sector",
        //5. Información adicional
        "first_in_family_to_study_university",
        "moodle_student_id",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.3';
    protected $cache_time = 5;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        //$this->exec_Migrate();
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
            ->like("registration", "%{$search}%")
            ->orLike("country", "%{$search}%")
            ->orLike("region", "%{$search}%")
            ->orLike("city", "%{$search}%")
            ->orLike("agreement", "%{$search}%")
            ->orLike("agreement_country", "%{$search}%")
            ->orLike("agreement_region", "%{$search}%")
            ->orLike("agreement_city", "%{$search}%")
            ->orLike("agreement_institution", "%{$search}%")
            ->orLike("campus", "%{$search}%")
            ->orLike("shifts", "%{$search}%")
            ->orLike("group", "%{$search}%")
            ->orLike("period", "%{$search}%")
            ->orLike("journey", "%{$search}%")
            ->orLike("program", "%{$search}%")
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
            ->orLike("birth_country", "%{$search}%")
            ->orLike("birth_region", "%{$search}%")
            ->orLike("birth_city", "%{$search}%")
            ->orLike("address", "%{$search}%")
            ->orLike("residence_country", "%{$search}%")
            ->orLike("residence_region", "%{$search}%")
            ->orLike("residence_city", "%{$search}%")
            ->orLike("neighborhood", "%{$search}%")
            ->orLike("area", "%{$search}%")
            ->orLike("stratum", "%{$search}%")
            ->orLike("transport_method", "%{$search}%")
            ->orLike("sisben_group", "%{$search}%")
            ->orLike("sisben_subgroup", "%{$search}%")
            ->orLike("document_issue_place", "%{$search}%")
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
            ->orLike("graduation_certificate", "%{$search}%")
            ->orLike("military_id", "%{$search}%")
            ->orLike("diploma", "%{$search}%")
            ->orLike("icfes_certificate", "%{$search}%")
            ->orLike("utility_bill", "%{$search}%")
            ->orLike("sisben_certificate", "%{$search}%")
            ->orLike("address_certificate", "%{$search}%")
            ->orLike("electoral_certificate", "%{$search}%")
            ->orLike("photo_card", "%{$search}%")
            ->orLike("observations", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->orLike("ticket", "%{$search}%")
            ->orLike("interview", "%{$search}%")
            ->orLike("linkage_type", "%{$search}%")
            ->orLike("ethnic_group", "%{$search}%")
            ->orLike("indigenous_people", "%{$search}%")
            ->orLike("afro_descendant", "%{$search}%")
            ->orLike("disability", "%{$search}%")
            ->orLike("disability_type", "%{$search}%")
            ->orLike("exceptional_ability", "%{$search}%")
            ->orLike("responsible", "%{$search}%")
            ->orLike("responsible_relationship", "%{$search}%")
            ->orLike("identified_population_group", "%{$search}%")
            ->orLike("highlighted_population", "%{$search}%")
            ->orLike("num_people_depending_on_you", "%{$search}%")
            ->orLike("num_people_living_with_you", "%{$search}%")
            ->orLike("responsible_phone", "%{$search}%")
            ->orLike("num_people_contributing_economically", "%{$search}%")
            ->orLike("first_in_family_to_study_university", "%{$search}%")
            ->orLike("border_population", "%{$search}%")
            ->orLike("observations_academic", "%{$search}%")
            ->orLike("import", "%{$search}%")
            ->orLike("moment", "%{$search}%")
            ->orLike("snies_updated_at", "%{$search}%")
            ->orLike("photo", "%{$search}%")
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
    public function getRegistration($registration): false|array
    {
        $result = $this->where("registration", $registration)->first();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene un registro por número de registro utilizando caché.
     * Si el registro se encuentra en la caché, se devuelve directamente.
     * Si no, se busca en la base de datos, se almacena en la caché y se devuelve.
     * @param string $registration El número de registro a buscar
     * @return array|false El registro encontrado o false si no existe
     */
    public function get_CachedRegistration($registration): false|array
    {
        $conditions = ['registration' => $registration];
        $result = $this->getCachedFirst($conditions);

        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_Grid(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        return ($this->getGrid($limit, $offset, $field, $search));
    }

    public function getGrid(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        // Si hay término de búsqueda
        if (!empty($search)) {
            // Dividir los términos de búsqueda en palabras individuales
            $searchTerms = explode(' ', trim($search));

            $this->groupStart();

            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("registration", "%{$term}%")
                    ->orLike("first_name", "%{$term}%")
                    ->orLike("second_name", "%{$term}%")
                    ->orLike("first_surname", "%{$term}%")
                    ->orLike("second_surname", "%{$term}%")
                    ->orLike("identification_type", "%{$term}%")
                    ->orLike("identification_number", "%{$term}%")
                    ->orLike("gender", "%{$term}%")
                    ->orLike("email_address", "%{$term}%")
                    ->orLike("phone", "%{$term}%")
                    ->orLike("mobile", "%{$term}%")
                    ->orLike("birth_date", "%{$term}%")
                    ->orLike("address", "%{$term}%")
                    ->orLike("residence_city", "%{$term}%")
                    ->orLike("neighborhood", "%{$term}%")
                    ->orLike("area", "%{$term}%")
                    ->orLike("stratum", "%{$term}%")
                    ->orLike("transport_method", "%{$term}%")
                    ->orLike("sisben_group", "%{$term}%")
                    ->orLike("sisben_subgroup", "%{$term}%")
                    ->orLike("document_issue_place", "%{$term}%")
                    ->orLike("birth_city", "%{$term}%")
                    ->orLike("blood_type", "%{$term}%")
                    ->orLike("marital_status", "%{$term}%")
                    ->orLike("number_children", "%{$term}%")
                    ->orLike("military_card", "%{$term}%")
                    ->orLike("ars", "%{$term}%")
                    ->orLike("insurer", "%{$term}%")
                    ->orLike("eps", "%{$term}%")
                    ->orLike("education_level", "%{$term}%")
                    ->orLike("occupation", "%{$term}%")
                    ->orLike("health_regime", "%{$term}%")
                    ->orLike("document_issue_date", "%{$term}%")
                    ->orLike("saber11", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->groupEnd();
            }

            $this->groupEnd();
        }

        $result = $this->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);

        return is_array($result) ? $result : false;
    }

    public function getGridCount(string $search = ""): int
    {
        // Si hay término de búsqueda
        if (!empty($search)) {
            // Dividir los términos de búsqueda en palabras individuales
            $searchTerms = explode(' ', trim($search));

            $this->groupStart();

            foreach ($searchTerms as $term) {
                // Para cada término, crear un grupo de condiciones
                $this->groupStart()
                    ->like("registration", "%{$term}%")
                    ->orLike("first_name", "%{$term}%")
                    ->orLike("second_name", "%{$term}%")
                    ->orLike("first_surname", "%{$term}%")
                    ->orLike("second_surname", "%{$term}%")
                    ->orLike("identification_type", "%{$term}%")
                    ->orLike("identification_number", "%{$term}%")
                    ->orLike("gender", "%{$term}%")
                    ->orLike("email_address", "%{$term}%")
                    ->orLike("phone", "%{$term}%")
                    ->orLike("mobile", "%{$term}%")
                    ->orLike("birth_date", "%{$term}%")
                    ->orLike("address", "%{$term}%")
                    ->orLike("residence_city", "%{$term}%")
                    ->orLike("neighborhood", "%{$term}%")
                    ->orLike("area", "%{$term}%")
                    ->orLike("stratum", "%{$term}%")
                    ->orLike("transport_method", "%{$term}%")
                    ->orLike("sisben_group", "%{$term}%")
                    ->orLike("sisben_subgroup", "%{$term}%")
                    ->orLike("document_issue_place", "%{$term}%")
                    ->orLike("birth_city", "%{$term}%")
                    ->orLike("blood_type", "%{$term}%")
                    ->orLike("marital_status", "%{$term}%")
                    ->orLike("number_children", "%{$term}%")
                    ->orLike("military_card", "%{$term}%")
                    ->orLike("ars", "%{$term}%")
                    ->orLike("insurer", "%{$term}%")
                    ->orLike("eps", "%{$term}%")
                    ->orLike("education_level", "%{$term}%")
                    ->orLike("occupation", "%{$term}%")
                    ->orLike("health_regime", "%{$term}%")
                    ->orLike("document_issue_date", "%{$term}%")
                    ->orLike("saber11", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->groupEnd();
            }

            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    public function get_GridPeriod(int $limit, int $offset, string $field, string $search = ""): array|false
    {
        // Si hay término de búsqueda
        if (!empty($search)) {
            // Dividir los términos de búsqueda en palabras individuales
            $searchTerms = explode(' ', trim($search));
            $this->where("period", "2025A");
            $this->groupStart();
            foreach ($searchTerms as $term) {
                $this->groupStart()
                    ->like("registration", "%{$term}%")
                    ->orLike("first_name", "%{$term}%")
                    ->orLike("second_name", "%{$term}%")
                    ->orLike("first_surname", "%{$term}%")
                    ->orLike("second_surname", "%{$term}%")
                    ->orLike("identification_type", "%{$term}%")
                    ->orLike("identification_number", "%{$term}%")
                    ->orLike("gender", "%{$term}%")
                    ->orLike("email_address", "%{$term}%")
                    ->orLike("phone", "%{$term}%")
                    ->orLike("mobile", "%{$term}%")
                    ->orLike("birth_date", "%{$term}%")
                    ->orLike("address", "%{$term}%")
                    ->orLike("residence_city", "%{$term}%")
                    ->orLike("neighborhood", "%{$term}%")
                    ->orLike("area", "%{$term}%")
                    ->orLike("stratum", "%{$term}%")
                    ->orLike("transport_method", "%{$term}%")
                    ->orLike("sisben_group", "%{$term}%")
                    ->orLike("sisben_subgroup", "%{$term}%")
                    ->orLike("document_issue_place", "%{$term}%")
                    ->orLike("birth_city", "%{$term}%")
                    ->orLike("blood_type", "%{$term}%")
                    ->orLike("marital_status", "%{$term}%")
                    ->orLike("number_children", "%{$term}%")
                    ->orLike("military_card", "%{$term}%")
                    ->orLike("ars", "%{$term}%")
                    ->orLike("insurer", "%{$term}%")
                    ->orLike("eps", "%{$term}%")
                    ->orLike("education_level", "%{$term}%")
                    ->orLike("occupation", "%{$term}%")
                    ->orLike("health_regime", "%{$term}%")
                    ->orLike("document_issue_date", "%{$term}%")
                    ->orLike("saber11", "%{$term}%")
                    ->orLike("status", "%{$term}%")
                    ->groupEnd();
            }

            $this->groupEnd();
        }

        $result = $this->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);

        return is_array($result) ? $result : false;
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

    public function getRegistrationByIdentification($identification_number): false|array
    {
        $row = $this
            ->withDeleted()
            ->where("identification_number", $identification_number)
            ->first();
        if (isset($row['identification_number'])) {
            return ($row);
        } else {
            return (false);
        }

    }

    public function getRegistrationsByName($name): false|array
    {
        $row = $this
            ->like("first_name", $name)
            ->orLike("second_name", $name)
            ->orLike("first_surname", $name)
            ->orLike("second_surname", $name)
            ->findAll();
        if (isset($row['first_name'])) {
            return ($row);
        } else {
            return (false);
        }
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

    /**
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
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

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Sie');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
    }


}

?>