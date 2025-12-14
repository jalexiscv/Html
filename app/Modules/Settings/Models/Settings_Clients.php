<?php

namespace App\Modules\Settings\Models;

use App\Libraries\Server;
use App\Libraries\Strings;
use App\Models\CachedModel;
use Higgs\Model;
use Config\Database;

/**
 * Ejemplo: $mclients = model('App\Modules\Settings\Models\Settings_Clients');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Settings_Clients extends CachedModel
{
    protected $table = "application_clients";
    protected $primaryKey = "client";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "client",
        "name",
        "rut",
        "vpn",
        "users",
        "domain",
        "default_url",
        "db_host",
        "db_port",
        "db",
        "db_user",
        "db_password",
        "status",
        "logo",
        "logo_portrait",
        "logo_portrait_light",
        "logo_landscape",
        "logo_landscape_light",
        "theme",
        "theme_color",
        "fb_app_id",
        "fb_app_secret",
        "fb_page",
        "footer",
        "google_trackingid",
        "google_ad_client",
        "google_ad_display_square",
        "google_ad_display_rectangle",
        "google_ad_links_retangle",
        "google_ad_display_vertical",
        "google_ad_infeed",
        "google_ad_inarticle",
        "google_ad_matching_content",
        "google_ad_links_square",
        "arc_id",
        "matomo",
        "2fa",
        "smtp_host",
        "smtp_port",
        "smtp_smtpsecure",
        "smtp_smtpauth",
        "smtp_username",
        "smtp_password",
        "smtp_from_email",
        "smtp_from_name",
        "smtp_charset",
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
    protected $DBGroup = "default";
    protected $version = '1.0.1';
    protected $cache_time = 60;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        //$this->exec_Migrate();
    }

    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = \Config\Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Application');// Set the namespace for the current module
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
            ->like("client", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("rut", "%{$search}%")
            ->orLike("vpn", "%{$search}%")
            ->orLike("users", "%{$search}%")
            ->orLike("domain", "%{$search}%")
            ->orLike("default_url", "%{$search}%")
            ->orLike("db_host", "%{$search}%")
            ->orLike("db_port", "%{$search}%")
            ->orLike("db", "%{$search}%")
            ->orLike("db_user", "%{$search}%")
            ->orLike("db_password", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("logo", "%{$search}%")
            ->orLike("logo_portrait", "%{$search}%")
            ->orLike("logo_portrait_light", "%{$search}%")
            ->orLike("logo_landscape", "%{$search}%")
            ->orLike("logo_landscape_light", "%{$search}%")
            ->orLike("theme", "%{$search}%")
            ->orLike("theme_color", "%{$search}%")
            ->orLike("fb_app_id", "%{$search}%")
            ->orLike("fb_app_secret", "%{$search}%")
            ->orLike("fb_page", "%{$search}%")
            ->orLike("footer", "%{$search}%")
            ->orLike("google_trackingid", "%{$search}%")
            ->orLike("google_ad_client", "%{$search}%")
            ->orLike("google_ad_display_square", "%{$search}%")
            ->orLike("google_ad_display_rectangle", "%{$search}%")
            ->orLike("google_ad_links_retangle", "%{$search}%")
            ->orLike("google_ad_display_vertical", "%{$search}%")
            ->orLike("google_ad_infeed", "%{$search}%")
            ->orLike("google_ad_inarticle", "%{$search}%")
            ->orLike("google_ad_matching_content", "%{$search}%")
            ->orLike("google_ad_links_square", "%{$search}%")
            ->orLike("arc_id", "%{$search}%")
            ->orLike("matomo", "%{$search}%")
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
    public function get_Client($client): false|array
    {
        $result = parent::get_Cached($client);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_ClientByDomain($domain)
    {
        $domain = str_replace("www.", "", $domain);
        $row = $this->where("domain", safe_strtolower($domain))->first();
        if (!empty($row["client"])) {
            return ($row);
        } else {
            return (false);
        }
    }


    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * @return false|mixed
     */
    public function get_ClientFromThisDomain()
    {
        $server = new Server();
        $strings = new Strings();
        $servername = $strings->get_Strtolower($server->get_Name());
        $cache_key = $this->get_CacheKey($servername);
        if (!$data = cache($cache_key)) {
            $data = $this->where("domain", $servername)->first();
            cache()->save($cache_key, $data, $this->cache_time);
        }
        if (!empty($data["client"])) {
            return ($data);
        } else {
            return (false);
        }
    }



}

?>