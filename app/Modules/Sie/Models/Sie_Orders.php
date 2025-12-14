<?php

namespace App\Modules\Sie\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ejemplo: $morders = model('App\Modules\Sie\Models\Sie_Orders');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Sie_Orders extends CachedModel
{
    protected $table = "sie_orders";
    protected $primaryKey = "order";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "order",
        "user",
        "program",
        "ticket",
        "description",
        "parent",
        "period",
        "cycle",
        "moment",
        "total",
        "paid",
        "status",
        "author",
        "type",
        "date",
        "time",
        "expiration",
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
            $migrations->setNamespace('App\Modules\Sie');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
    }

    public function getLastByUser($user)
    {
        $result = $this
            ->select('*')
            ->where('user', $user)
            ->orderBy('order', 'desc')
            ->first();
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
            ->like("order", "%{$search}%")
            ->orLike("user", "%{$search}%")
            ->orLike("ticket", "%{$search}%")
            ->orLike("parent", "%{$search}%")
            ->orLike("period", "%{$search}%")
            ->orLike("total", "%{$search}%")
            ->orLike("paid", "%{$search}%")
            ->orLike("status", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->orLike("type", "%{$search}%")
            ->orLike("date", "%{$search}%")
            ->orLike("time", "%{$search}%")
            ->orLike("expiration", "%{$search}%")
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
        $result = $this
            ->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")
            ->orderBy("name", "ASC")
            ->findAll();
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
    public function get_Order($order): false|array
    {
        $result = parent::getCached($order);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_ListByRegistration($registration): array|false
    {
        $result = $this
            ->where('user', $registration)
            ->orderBy("ticket", "DESC")
            ->orderBy("order", "ASC")
            ->findAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_OrderByTicket($order): false|array
    {
        $row = $this->where('ticket', $order)->first();
        if (is_array($row)) {
            return ($row);
        } else {
            return false;
        }
    }


    /**
     * Obtiene el ticket más alto existente y le suma 1 para obtener el siguiente ticket.
     * @return int
     */
    public function getNextTicketNumberOLD(): int
    {
        $maxTicket = $this->selectMax('ticket')->first();
        return $maxTicket['ticket'] + 1;
    }


    public function getNextTicketNumber(): int
    {
        $maxTicket = $this->selectMax('CAST(ticket AS UNSIGNED)', 'numeric_ticket')->first();

        // Check if there are any tickets yet or if the value is null
        if (empty($maxTicket) || $maxTicket['numeric_ticket'] === null) {
            return 1;
        }

        // Add 1 to the current maximum ticket number
        return (int)$maxTicket['numeric_ticket'] + 1;
    }


    public function getByRegistrationByPeriod($user, $period): array|false
    {
        $result = $this
            ->where("user", $user)
            ->where("period", $period)
            ->find();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Obtiene órdenes por registro de usuario, periodo y tipo de producto
     * @param string $registration Identificador del usuario
     * @param string $period Periodo académico (ej. '2025B')
     * @param string $productType Tipo de producto (default: 'ENROLLMENT')
     * @return array|false Resultados de la consulta o false si no hay resultados
     */
    public function getByRegistrationByPeriodByTypeOfProduct(string $registration, string $period, string $productType = 'ENROLLMENT'): array|false
    {
        $result = $this->select('sie_orders.*, sie_products.type, sie_orders.period')
            ->join('sie_orders_items', 'sie_orders.order = sie_orders_items.order')
            ->join('sie_products', 'sie_products.product = sie_orders_items.product')
            ->where('sie_orders.user', $registration)
            ->where('sie_products.type', $productType)
            ->where('sie_orders.period', $period)
            ->findAll();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Obtiene la primera orden por registro de usuario, periodo y tipo de producto
     *
     * @param string $registration Identificador del usuario
     * @param string $period Periodo académico (ej. '2025B')
     * @param string $productType Tipo de producto (default: 'ENROLLMENT')
     * @return array|false Resultado de la consulta o false si no hay resultados
     */
    public function getFirstByRegistrationByPeriodByTypeOfProduct(string $registration, string $period, string $productType = 'ENROLLMENT'): array|false
    {
        $result = $this->select('sie_orders.*, sie_products.type, sie_orders.period')
            ->join('sie_orders_items', 'sie_orders.order = sie_orders_items.order')
            ->join('sie_products', 'sie_products.product = sie_orders_items.product')
            ->where('sie_orders.user', $registration)
            ->where('sie_products.type', $productType)
            ->where('sie_orders.period', $period)
            ->orderBy('sie_orders.created_at', 'DESC') // Ordenar por fecha de creación descendente
            ->first();

        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


}

?>