<?php

namespace App\Modules\Intelligence\Models;

use App\Models\CachedModel;
use Config\Database;

/**
 * Ej: $model = model('App\Modules\Application\Models\Application_Ia_Messages');
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Intelligence_Messages extends CachedModel
{
    protected $table = "application_ia_messages";
    protected $primaryKey = "message";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "message",
        "from",
        "to",
        "priority",
        "content",
        "date",
        "time",
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
    protected $version = '1.0.0';
    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->cacheTimeout = 60;
    }

    public function deleteMessages($user): void
    {
        echo("Borrar mensajes de y hacia: {$user}");
        $conditions = array(
            "from" => $user,
            "to" => $user,
        );
        $this->delete_CachedOrWhere($conditions);

    }


    public function getMessages($user)
    {
        $result = $this
            ->where("deleted_at", null)
            ->groupStart()
            ->where("from", $user)
            ->orWhere("to", $user)
            ->orderBy("created_at", "ASC")
            ->groupEnd()
            ->find();
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }







}

?>