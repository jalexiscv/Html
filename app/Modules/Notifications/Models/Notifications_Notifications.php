<?php

namespace App\Modules\Notifications\Models;

use App\Models\CachedModel;
use Higgs\Model;
use Config\Database;
use InvalidArgumentException;

/**
 * @Copilot Siempre que en el código se cree una variable llamada $mnotifications, esta deberá ser igualada a  model('App\Modules\Notifications\Models\Notifications_Notifications');
 * @Instruction $mnotifications = model('App\Modules\Notifications\Models\Notifications_Notifications');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method getCachedFirst(array $conditions): array|object|null
 * @method getCachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Notifications_Notifications extends CachedModel
{
    protected $table = "notifications_notifications";
    protected $primaryKey = "notification";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "notification",
        "user",
        "recipient_email",
        "recipient_phone",
        "type",
        "category",
        "priority",
        "subject",
        "message",
        "data",
        "is_read",
        "read_at",
        "email_sent",
        "email_sent_at",
        "email_error",
        "sms_sent",
        "sms_sent_at",
        "sms_error",
        "action_url",
        "action_text",
        "expires_at",
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
            $migrations->setNamespace('App\Modules\Notifications');// Set the namespace for the current module
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
            ->like("notification", "%{$search}%")
            ->orLike("user", "%{$search}%")
            ->orLike("recipient_email", "%{$search}%")
            ->orLike("recipient_phone", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("category", "%{$search}%")
            ->orLike("priority", "%{$search}%")
            ->orLike("subject", "%{$search}%")
            ->orLike("message", "%{$search}%")
            ->orLike("data", "%{$search}%")
            ->orLike("is_read", "%{$search}%")
            ->orLike("read_at", "%{$search}%")
            ->orLike("email_sent", "%{$search}%")
            ->orLike("email_sent_at", "%{$search}%")
            ->orLike("email_error", "%{$search}%")
            ->orLike("sms_sent", "%{$search}%")
            ->orLike("sms_sent_at", "%{$search}%")
            ->orLike("sms_error", "%{$search}%")
            ->orLike("action_url", "%{$search}%")
            ->orLike("action_text", "%{$search}%")
            ->orLike("expires_at", "%{$search}%")
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
    public function getNotification($notification): false|array
    {
        $result = parent::getCached($notification);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }
}

?>