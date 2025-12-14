<?php

namespace App\Modules\Iris\Models;

use App\Models\CachedModel;
use Config\Services;

/**
* @Copilot Siempre que en el código se cree una variable llamada $mpatients, esta deberá ser igualada a  model('App\Modules\Iris\Models\Iris_Patients');
* @Instruction $mpatients = model('App\Modules\Iris\Models\Iris_Patients');
* @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
* @method update(string $id, array $data) : bool
* @method delete(string $id, bool $purge = false) : bool
 * @method getCachedFirst(array $conditions): array|object|null
 * @method getCachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
*/
class Iris_Patients extends CachedModel
	 {
		 protected $table = "iris_patients";
		 protected $primaryKey = "patient";
		 protected $returnType = "array";
		 protected $useSoftDeletes = true;
		 protected $allowedFields = [
			 "patient",
             "fhir_id",
             "active",
			 "document_type",
			 "document_number",
             "document_issued_place",
             "first_name",
             "middle_name",
             "first_surname",
             "second_surname",
             "full_name",
			 "gender",
             "birth_date",
             "birth_place",
             "marital_status",
             "primary_phone",
             "secondary_phone",
             "email",
             "full_address",
             "neighborhood",
             "city",
             "state",
             "postal_code",
             "country",
             "residence_area",
             "socioeconomic_stratum",
             "emergency_contact_name",
             "emergency_contact_relationship",
             "emergency_contact_phone",
             "health_insurance",
             "health_regime",
             "affiliation_type",
             "ethnicity",
             "special_population",
             "has_diabetes",
             "has_hypertension",
             "family_history_glaucoma",
             "family_history_diabetes",
             "family_history_retinopathy",
             "previous_eye_surgeries",
             "blood_type",
             "allergies",
             "current_medications",
             "primary_language",
             "data_consent",
             "accepts_communications",
             "profile_photo",
             "observations",
             "created_by",
             "updated_by",
             "deleted_by",
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
		private function exec_Migrate():void
		{
            $migrations = Services::migrations();
				try {
						$migrations->setNamespace('App\Modules\Iris');// Set the namespace for the current module
						$migrations->latest();// Run the migrations for the current module
						$all = $migrations->findMigrations();// Find all migrations for the current module
				}catch(Throwable $e){
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
		 * @return array|false		Un arreglo de registros combinados o false si no se encuentran registros.
		 */
		public function get_List(int $limit, int $offset, string $search = ""): array|false
		{
				$result = $this
						->groupStart()
						->like("patient", "%{$search}%")
                    ->orLike("fhir_id", "%{$search}%")
                    ->orLike("active", "%{$search}%")
						->orLike("document_type", "%{$search}%")
						->orLike("document_number", "%{$search}%")
                    ->orLike("document_issued_place", "%{$search}%")
                    ->orLike("first_name", "%{$search}%")
                    ->orLike("middle_name", "%{$search}%")
                    ->orLike("first_surname", "%{$search}%")
                    ->orLike("second_surname", "%{$search}%")
                    ->orLike("full_name", "%{$search}%")
						->orLike("gender", "%{$search}%")
                    ->orLike("birth_date", "%{$search}%")
                    ->orLike("birth_place", "%{$search}%")
                    ->orLike("marital_status", "%{$search}%")
                    ->orLike("primary_phone", "%{$search}%")
                    ->orLike("secondary_phone", "%{$search}%")
                    ->orLike("email", "%{$search}%")
                    ->orLike("full_address", "%{$search}%")
                    ->orLike("neighborhood", "%{$search}%")
                    ->orLike("city", "%{$search}%")
                    ->orLike("state", "%{$search}%")
                    ->orLike("postal_code", "%{$search}%")
                    ->orLike("country", "%{$search}%")
                    ->orLike("residence_area", "%{$search}%")
                    ->orLike("socioeconomic_stratum", "%{$search}%")
                    ->orLike("emergency_contact_name", "%{$search}%")
                    ->orLike("emergency_contact_relationship", "%{$search}%")
                    ->orLike("emergency_contact_phone", "%{$search}%")
                    ->orLike("health_insurance", "%{$search}%")
                    ->orLike("health_regime", "%{$search}%")
                    ->orLike("affiliation_type", "%{$search}%")
                    ->orLike("ethnicity", "%{$search}%")
                    ->orLike("special_population", "%{$search}%")
                    ->orLike("has_diabetes", "%{$search}%")
                    ->orLike("has_hypertension", "%{$search}%")
                    ->orLike("family_history_glaucoma", "%{$search}%")
                    ->orLike("family_history_diabetes", "%{$search}%")
                    ->orLike("family_history_retinopathy", "%{$search}%")
                    ->orLike("previous_eye_surgeries", "%{$search}%")
                    ->orLike("blood_type", "%{$search}%")
                    ->orLike("allergies", "%{$search}%")
                    ->orLike("current_medications", "%{$search}%")
                    ->orLike("primary_language", "%{$search}%")
                    ->orLike("data_consent", "%{$search}%")
                    ->orLike("accepts_communications", "%{$search}%")
                    ->orLike("profile_photo", "%{$search}%")
                    ->orLike("observations", "%{$search}%")
                    ->orLike("created_by", "%{$search}%")
                    ->orLike("updated_by", "%{$search}%")
                    ->orLike("deleted_by", "%{$search}%")
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
    public function getSelectData()
			 {
                 $result = $this->select("`{$this->primaryKey}` AS `value`,`full_name` AS `label`")->findAll();
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
		 public function getPatient($patient):false|array
		{
				$result = parent::getCached($patient);
				if (is_array($result)) {
						return ($result);
				} else {
						return (false);
				}
		}
}

?>