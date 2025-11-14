<?php

namespace App\Modules\Sogt\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mdevices, esta deberá ser igualada a  model('App\Modules\Sogt\Models\Sogt_Devices');
 * @Instruction $mdevices = model('App\Modules\Sogt\Models\Sogt_Devices');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method getCachedFirst(array $conditions): array|object|null
 * @method getCachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sogt_Devices extends CachedModel
{
    protected $table = "sogt_devices";
    protected $primaryKey = "device";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "device",
        "user",
        "tenant",
        "name",
        "alias",
        "device_type",
        "asset_type",
        "asset_ref",
        "imei",
        "serial",
        "iccid",
        "imsi",
        "mac_address",
        "vendor",
        "model",
        "firmware_version",
        "protocol",
        "transport",
        "server_host",
        "server_port",
        "apn",
        "carrier",
        "sim_phone",
        "auth_key",
        "ip_whitelist",
        "has_ignition",
        "has_sos",
        "has_temp",
        "has_fuel",
        "supports_ble",
        "report_interval_moving_s",
        "report_interval_idle_s",
        "overspeed_kmh",
        "timezone_offset_min",
        "status",
        "activation_date",
        "installed_on",
        "installed_by",
        "warranty_until",
        "tags",
        "notes",
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
            $migrations->setNamespace('App\Modules\Sogt');// Set the namespace for the current module
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
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->groupStart()
            ->like("device", "%{$search}%")
            ->orLike("user", "%{$search}%")
            ->orLike("tenant", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("alias", "%{$search}%")
            ->orLike("device_type", "%{$search}%")
            ->orLike("asset_type", "%{$search}%")
            ->orLike("asset_ref", "%{$search}%")
            ->orLike("imei", "%{$search}%")
            ->orLike("serial", "%{$search}%")
            ->orLike("iccid", "%{$search}%")
            ->orLike("imsi", "%{$search}%")
            ->orLike("mac_address", "%{$search}%")
            ->orLike("vendor", "%{$search}%")
            ->orLike("model", "%{$search}%")
            ->orLike("firmware_version", "%{$search}%")
            ->orLike("protocol", "%{$search}%")
            ->orLike("transport", "%{$search}%")
            ->orLike("server_host", "%{$search}%")
            ->orLike("server_port", "%{$search}%")
            ->orLike("apn", "%{$search}%")
            ->orLike("carrier", "%{$search}%")
            ->orLike("sim_phone", "%{$search}%")
            ->orLike("auth_key", "%{$search}%")
            ->orLike("ip_whitelist", "%{$search}%")
            ->orLike("has_ignition", "%{$search}%")
            ->orLike("has_sos", "%{$search}%")
            ->orLike("has_temp", "%{$search}%")
            ->orLike("has_fuel", "%{$search}%")
            ->orLike("supports_ble", "%{$search}%")
            ->orLike("report_interval_moving_s", "%{$search}%")
            ->orLike("report_interval_idle_s", "%{$search}%")
            ->orLike("overspeed_kmh", "%{$search}%")
            ->orLike("timezone_offset_min", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("activation_date", "%{$search}%")
            ->orLike("installed_on", "%{$search}%")
            ->orLike("installed_by", "%{$search}%")
            ->orLike("warranty_until", "%{$search}%")
            ->orLike("tags", "%{$search}%")
            ->orLike("notes", "%{$search}%")
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
    public function getDevice($device): false|array
    {
        $result = parent::getCached($device);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }
}

?>