<?php

namespace App\Models;

use App\Libraries\Server;
use App\Libraries\Strings;
use App\Modules\Nexus\Models\Database;
use App\Modules\Nexus\Models\type;
use Higgs\Cache\CacheInterface;
use Higgs\Model;

class Application_Clients extends Model
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
        "db",
        "db_host",
        "db_port",
        "db_user",
        "db_password",
        "status",
        "logo",
        "logo_portrait",
        "logo_portrait_light",
        "logo_landscape",
        "logo_landscape_light",
        "theme",
        "fb_app_id",
        "fb_app_secret",
        "fb_page",
        "date",
        "time",
        "author",
        "footer",
        "theme_color",
        "google_trackingid",
        "google_ad_client",
        "google_ad_display_square",
        "google_ad_display_rectangle",
        "google_ad_display_vertical",
        "google_ad_infeed",
        "google_ad_inarticle",
        "google_ad_matching_content",
        "google_ad_links_square",
        "google_ad_links_retangle",
        "created_at",
        "updated_at",
        "deleted_at",
        "arc_id",
        "matomo",
        "2fa",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "default";
    protected $cache_time = 120;
    protected $version = "1.0.1";


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


    /**
     * Inserta un nuevo registo y actualiza el chache
     */
    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);
        if ($result === true || $returnID && is_numeric($result)) {
            $cache_key = $this->get_CacheKey($this->db->insertID());
            $data = parent::find($this->db->insertID());
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $result;
    }

    /**
     * Retorna resultados cacheados
     */
    public function find($id = null)
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    /**
     * Actualiza un registo y actualiza el chache
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        if ($result === true) {
            $cache_key = $this->get_CacheKey($id);
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($result);
    }

    /**
     * Elimina un registo y actualiza el chache
     */
    public function delete($id = null, $purge = false)
    {
        $result = parent::delete($id, $purge);
        if ($result === true) {
            cache()->delete($this->get_CacheKey($id));
        }
        return ($result);
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
    public function regenerate()
    {
        if (!$this->tableExists($this->table)) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'client' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'rut' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => FALSE],
                'vpn' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'users' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'domain' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'default_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'db' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'db_host' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'db_port' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'db_user' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'db_password' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'status' => ['type' => 'ENUM', 'null' => FALSE],
                'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'logo_portrait' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'logo_portrait_light' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'logo_landscape' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'logo_landscape_light' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'theme' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'fb_app_id' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'fb_app_secret' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'fb_page' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'date' => ['type' => 'DATE', 'null' => FALSE],
                'time' => ['type' => 'TIME', 'null' => FALSE],
                'footer' => ['type' => 'TEXT', 'null' => FALSE],
                'theme_color' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => FALSE],
                'google_trackingid' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => FALSE],
                'google_ad_client' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => FALSE],
                'google_ad_display_square' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_display_rectangle' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_display_vertical' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_infeed' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_inarticle' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_matching_content' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_links_square' => ['type' => 'TEXT', 'null' => FALSE],
                'google_ad_links_retangle' => ['type' => 'TEXT', 'null' => FALSE],
                'arc_id' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'matomo' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
            //$forge->addKey('post');
            //$forge->addKey('profile');
            $forge->addKey('author');
            $forge->createTable($this->table);
        }
    }


    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @param $tableName
     * @return CacheInterface|bool|mixed
     */
    private function tableExists($tableName)
    {
        $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($tableName);
            cache()->save($cache_key, $data, $this->cache_time * 1000);
        }
        return ($data);
    }

}

?>