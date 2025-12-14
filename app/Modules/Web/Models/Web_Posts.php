<?php

namespace App\Modules\Web\Models;

use App\Modules\Social\Models\Database;
use App\Modules\Social\Models\type;
use Higgs\Model;
use App\Libraries\Dates;
use App\Libraries\Numbers;
use App\Libraries\Strings;
use Config\Services;

class Web_Posts extends Model
{

    protected $table = "social_posts";
    protected $primaryKey = "post";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "post",
        "semantic",
        "title",
        "content",
        "type",
        "cover",
        "cover_visible",
        "description",
        "date",
        "time",
        "country",
        "region",
        "city",
        "latitude",
        "longitude",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
        "views",
        "views_initials",
        "viewers",
        "likes",
        "loves",
        "hahas",
        "yays",
        "wows",
        "sads",
        "angrys",
        "shares",
        "comments",
        "video",
        "source",
        "source_alias",
        "status",
        "verified",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication"; //default
    protected $mattachments = false;
    protected $numbers = false;
    protected $bbc;
    protected $cache_time = 60;
    protected $version = "1.0.3";

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->mattachments = model('App\Modules\Web\Models\Web_Attachments');
        $this->numbers = new Numbers();
        $this->bbc = service("bbcode");
        $this->regenerate();
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
     * @param type $year
     * @param type $month
     */


    public function regenerate()
    {
        if (!$this->tableExists()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'post' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'semantic' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'title' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'content' => ['type' => 'TEXT', 'null' => FALSE],
                'type' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'cover' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'cover_visible' => ['type' => 'TINYINT', 'null' => FALSE],
                'description' => ['type' => 'VARCHAR', 'constraint' => 155, 'null' => FALSE],
                'date' => ['type' => 'DATE', 'null' => FALSE],
                'time' => ['type' => 'TIME', 'null' => FALSE],
                'country' => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => FALSE],
                'region' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'city' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'latitude' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => FALSE],
                'longitude' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => FALSE],
                'views' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'views_initials' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'viewers' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'likes' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'shares' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'comments' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'video' => ['type' => 'TEXT', 'null' => FALSE],
                'source' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'source_alias' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => FALSE],
                'verified' => ['type' => 'ENUM', 'constraint' => ['verified', 'pending'], 'default' => 'pending',],
                'status' => ['type' => 'ENUM', 'constraint' => ['publish', 'pending', 'draft'], 'default' => 'pending',],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
            $forge->addKey('author');
            $forge->createTable($this->table, TRUE);
        }
    }

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @param $tableName
     * @return \Higgs\Cache\CacheInterface|bool|mixed
     */
    private function tableExists()
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time * 10);
        }
        return ($data);
    }

    protected function get_CacheKey($id)
    {
        $key = array(
            'app-node' => APPNODE,
            'table' => $this->table,
            'class' => urlencode(get_class($this)),
            'version' => $this->version,
            'id' => $id
        );
        return md5(implode('-', $key));
    }

    /**
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_List()
    {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `post` ASC;";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna las publicaciones de un autor en especifico
     * @param type $limit
     * @param type $offset
     * @param type $search
     * @return type
     */
    public function get_PostsByAuthor($author, $limit = 10, $offset = 0, $search = "")
    {
        $xvar = APPNODE . "posts_author_{$author}limit{$limit}_offset{$offset}_search{$search}";
        if (!$value = cache($xvar)) {
            if (!empty($search)) {
                $posts = $this
                    ->where("author", $author)
                    ->like("content", "%{$search}%")
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            } else {
                $posts = $this
                    ->where("author", $author)
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            }
            if (is_array($posts)) {
                $rposts = array();
                foreach ($posts as $p) {
                    $post = $this->get_Post($p["post"]);
                    array_push($rposts, $post);
                }
                cache()->save($xvar, $rposts, $this->cache_time);
                return ($rposts);
            } else {
                return (false);
            }
        } else {
            return ($value);
        }
    }

    /**
     * Antes: //$data['cover'] = cdn_url($attachment);
     * @param $post
     * @return false|mixed
     */
    public function get_Post($post)
    {
        $strings = service("strings");
        $dates = service('dates');
        $pid = (strlen($post) > 13) ? $this->_get_PostIdBySemantic($post) : $post;

        $post = $this->find($pid);
        if (!is_array($post) || !isset($post['post'])) {
            return (false);
        } else {
            $key = $this->get_CacheKey($pid . "v1");
            if (!$data = cache($key)) {
                $attachment = $this->mattachments->get_ByReference($post["post"], 'COVER');
                $title = $strings->get_URLDecode($post["title"]);
                $content = $strings->get_URLDecode($post["content"]);
                $html = $this->bbc->getHTML($content);
                $description = $strings->get_URLDecode($post["description"]);
                $data['post'] = $post['post'];
                $data['semantic'] = $post["semantic"];
                $data["link"] = "/social/semantic/{$data["semantic"]}.html";
                $data['title'] = $post["title"];
                $data['content'] = $post["content"];
                $data['html'] = $strings->get_URLEncode($html);
                $data['description'] = $post["description"];
                $data["keywords"] = "";
                $data['type'] = $post["type"];;
                $data['cover'] = cdn_url($attachment);
                $data['cover_visible'] = $post["cover_visible"];
                $data['thumbnail'] = $data['cover'];
                $data['date'] = $post["date"];
                $data['time'] = $post["time"];
                $data['author'] = $post["author"];
                $data["author_alias"] = $strings->get_Strtolower($this->get_AuthorAlias($post["author"]));
                $data["source"] = $strings->get_URLDecode($post["source"]);
                $data["source_alias"] = $strings->get_URLDecode($post["source_alias"]);
                $data["views"] = $this->numbers::get_Short($post["views"]);
                $data["views_initials"] = $post["views_initials"];
                $data["likes"] = $this->numbers::get_Short($post["likes"]);
                $data["shares"] = $this->numbers::get_Short($post["shares"]);
                $data["comments"] = $this->numbers::get_Short($post["comments"]);
                //[Extra]-----------------------------------------------------------------------------------------------
                $data["date_textual"] = $dates->get_TextualDateFromDate($post["date"]);
                cache()->save($key, $data, $this->cache_time);
            }
            //$this->update($pid,array('views'=>$post['views']++));
            return ($data);
        }
    }

    /**
     * Retorna el ID de un post proporsionado su url semantica.
     * @param $semantic
     * @return false|mixed
     */
    private function _get_PostIdBySemantic($semantic)
    {
        $semantic = preg_replace("/\.html$/", "", $semantic);
        $cache_key = $this->get_CacheKey($semantic);
        if (!$data = cache($cache_key)) {
            $data = $this->where("semantic", $semantic)->first();
            cache()->save($cache_key, $data, $this->cache_time);
        }
        if (is_array($data)) {
            return ($data['post']);
        } else {
            return (false);
        }
    }

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
     * Retorna los datos del author de un post
     * @return type
     */
    public function get_AuthorAlias($uid)
    {
        $sql = "SELECT * FROM `security_users_fields` WHERE(`user`='{$uid}' AND `name`='alias' ) ORDER BY `created_at` DESC;";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
        if (is_array($result)) {
            return ($result["value"]);
        } else {
            return (false);
        }
    }

    /**
     * Retorna articulos principales o patrocinados.
     * @param $id
     * @return mixed
     */
    public function get_Sponsoreds($id = 'sponsoreds')
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $posts = $this->OrderBy('created_at', 'DESC')->findAll(2, 2);
            $data = array();
            foreach ($posts as $post) {
                $cover = $this->mattachments->get_ByReference($post["post"], 'COVER');
                $post['cover'] =cdn_url($cover);
                array_push($data, $post);
            }
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return (count($data) > 0) ? $data : false;
    }

    public function get_Featureds($id = 'featureds')
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $posts = $this->OrderBy('created_at', 'DESC')->findAll(1, 0);
            $data = array();
            foreach ($posts as $post) {
                $cover = $this->mattachments->get_ByReference($post["post"], 'COVER');
                $post['cover'] = cdn_url($cover);
                array_push($data, $post);
            }
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return (count($data) > 0) ? $data : false;
    }

    public function update_Post($pid, $data)
    {
        $this->update($pid, $data);
        //Debo Borrar el post cacheado de forma personalizada

    }

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
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public
    function get_Authority($id, $author)
    {
        $row = $this->where("author", $id)->first();
        if (@$row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }

    public function get_TopRecent($limit = 10, $offset = 0)
    {
        $cache_key = $this->get_CacheKey("toprecent_limit{$limit}_offset{$offset}");
        if (!$data = cache($cache_key)) {
            $data = $this->_get_TopRecent($limit, $offset);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    private function _get_TopRecent($limit = 10, $offset = 0)
    {
        $posts = $this->orderBy('views', 'DESC')->findAll($limit, $offset);
        if (is_array($posts)) {
            $rposts = array();
            foreach ($posts as $p) {
                $post = $this->get_Post($p["post"]);
                array_push($rposts, $post);
            }
            return ($rposts);
        } else {
            return (false);
        }
    }

    public function get_Nationals($limit = 10, $offset = 0)
    {
        $xvar = APPNODE . "xnationals_limit{$limit}_offset{$offset}";
        if (!$value = cache($xvar)) {
            $sql = "SELECT *
                    FROM `social_posts` 
                    WHERE(created_at>=CURDATE()-3 AND `content` LIKE '%colombia%')
                    ORDER BY `views` DESC
                    LIMIT {$offset},{$limit};";
            $query = $this->db->query($sql);
            $posts = $query->getResultArray();
            if (is_array($posts)) {
                $rposts = array();
                foreach ($posts as $p) {
                    $post = $this->get_Post($p["post"]);
                    array_push($rposts, $post);
                }
                cache()->save($xvar, $rposts, $this->cache_time);
                return ($rposts);
            } else {
                return (false);
            }
        } else {
            return ($value);
        }
    }

    public function get_Recents($limit = 10, $offset = 0)
    {
        $strings = service('strings');
        $posts = $this->orderBy('date,time', 'DESC')->findAll($limit, $offset);
        if (is_array($posts)) {
            $recents = array();
            foreach ($posts as $post) {
                $attachment = $this->mattachments->get_ByReference($post["post"], 'COVER');
                $p = array();
                $p['post'] = $post['post'];
                $p["cover"] = cdn_url($attachment);
                $p["title"] = $strings->get_URLDecode($post["title"]);
                $p["link"] = "/social/semantic/{$post["semantic"]}.html";
                array_push($recents, $p);
            }
            return ($recents);
        } else {
            return (false);
        }
    }

    public function get_Locals($limit = 10, $offset = 0)
    {
        $posts = $this->findAll($limit, $offset);
        if (is_array($posts)) {
            return ($posts);
        } else {
            return (false);
        }
    }

    public function get_Regionals($limit = 10, $offset = 0)
    {
        $cache_key = $this->get_CacheKey("regionals_{$limit}_{$offset}");
        if (!$data = cache($cache_key)) {
            $posts = $this
                ->select("post")
                ->where("created_at>=CURDATE()-3 AND `content` LIKE '%Valle del Cauca%'")
                ->findAll($limit, $offset);
            if (is_array($posts)) {
                $data = array();
                foreach ($posts as $p) {
                    $post = $this->get_Post($p["post"]);
                    array_push($data, $post);
                }
            } else {
                return (false);
            }
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    /**
     * Retorna el rango de publicaciones indicado en el offeset y el limite
     * implmentando el control de cache para los valores retornados.
     * - Cached
     * @param type $limit
     * @param type $offset
     * @return type
     */

    public function get_Posts($limit = 10, $offset = 0, $search = "")
    {
        $cache_key = $this->get_CacheKey("p-l{$limit}_o{$offset}_{$search}");
        if (!$data = cache($cache_key)) {
            if (!empty($search)) {
                $posts = $this
                    ->like("content", "%{$search}%")
                    ->orLike("post", "%{$search}%")
                    ->orLike("title", "%{$search}%")
                    ->orLike("description", "%{$search}%")
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            } else {
                $posts = $this
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            }
            if (is_array($posts)) {
                $data = array();
                foreach ($posts as $p) {
                    $post = $this->get_Post($p["post"]);
                    array_push($data, $post);
                }
                cache()->save($cache_key, $data, $this->cache_time);
                return ($data);
            } else {
                return (false);
            }
        }
        return ($data);
    }

    public function get_Themostseens($limit = 10, $offset = 0, $search = "")
    {
        $cache_key = $this->get_CacheKey("themostseen-l{$limit}_o{$offset}_{$search}");
        if (!$data = cache($cache_key)) {
            if (!empty($search)) {
                $posts = $this
                    ->like("content", "%{$search}%")
                    ->orLike("post", "%{$search}%")
                    ->orLike("title", "%{$search}%")
                    ->orLike("description", "%{$search}%")
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            } else {
                $posts = $this
                    ->orderBy('date', 'DESC')
                    ->orderBy('time', 'DESC')
                    ->findAll($limit, $offset);
            }
            if (is_array($posts)) {
                $data = array();
                foreach ($posts as $p) {
                    $post = $this->get_Post($p["post"]);
                    array_push($data, $post);
                }
                cache()->save($cache_key, $data, $this->cache_time);
                return ($data);
            } else {
                return (false);
            }
        }
        return ($data);
    }


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

    public function delete($id = null, $purge = false)
    {
        $result = parent::delete($id, $purge);
        if ($result === true) {
            cache()->delete($this->get_CacheKey($id));
        }
        return ($result);
    }

    /**
     * Articula la estructura de una publicación, obteniedo todos los datos asociados a la misma
     * incluyendo todos aquellos datos que son resultado de la consulta de atributos adicionales.
     **/
    private function _get_FullPost($pid)
    {
        $strings = service("strings");
        $post = $this->find($pid);
        if (is_array($post)) {

            $dates = service('dates');
            $mkeywords = model('App\Modules\Social\Models\Social_Keywords');
            $title = $strings->get_URLDecode($post["title"]);
            $description = $strings->get_Clear($strings->get_URLDecode($post["description"]));
            $content = $strings->get_URLDecode($post["content"]);
            $keywords = '';
            //$content = $mkeywords->auto_Keywords($post["post"], urldecode($post["content"]));
            //$keywords = implode("", $content["keywords"]);
            $attachment = $this->mattachments->get_ByReference($post["post"], 'COVER');


            $post["title"] = $strings->get_URLDecode($title);
            $post["description"] = $strings->get_URLDecode($description);
            $post["keywords"] = $keywords;
            $post["content"] = $content;
            $post["html"] = $this->bbc->getHTML($content);
            $post["type"] = $post["type"];
            //$post["cover"] = $this->get_Cover($pid, $post["semantic"], $attachment);
            if (!empty($attachment)) {
                $post["cover"] = $attachment;
                $post["thumbnail"] = $attachment;
            } else {
                $post["cover"] = false;
                $post["thumbnail"] = false;
            }
            //$post["thumbnail"] = $this->get_Thumbnail($pid, $post["semantic"], $attachment);
            $post["author_alias"] = safe_strtolower($this->get_AuthorAlias(@$post["author"]));
            $post["source"] = $strings->get_URLDecode($post["source"]);
            $post["source_alias"] = $strings->get_URLDecode($post["source_alias"]);
            $post["short_views"] = $this->numbers::get_Short(@$post["views"]);
            $post["short_likes"] = $this->numbers::get_Short(@$post["likes"]);
            $post["short_shares"] = $this->numbers::get_Short(@$post["shares"]);
            $post["short_comments"] = $this->numbers::get_Short(@$post["comments"]);
            //$post["ago"] = $dates::get_LiveTimestamp($post["date"], $post["time"], $pref = lang("App.Ago"));
            $post["link"] = "/social/semantic/{$post["semantic"]}.html";
            if (!empty($post["city"])) {
                $mcities = model("App\Modules\Nexus\Models\Nexus_Cities");
                $city = $mcities->where("city", @$post["city"])->first();
                $post["city_name"] = $strings->get_URLDecode(@$city["name"]);
            }
            return ($post);
        } else {
            return (false);
        }
    }

    /**
     * Retorna la ruta a la imagen de portada de un articulo reprocesando la imagen original.
     * Nota: Sie el directorio donde se alamcenara la imagen no existe el framework dira que la imagen no se pudo
     * almacenar este mensaje se repetira hasta que manualmente se cree el directorio que almacenara la imagen.
     * @param $pid
     */
    private
    function get_Cover($pid, $semantic, $attachment)
    {
        if (is_array($attachment)) {
            if (isset($attachment["file"]) && !empty($attachment["file"])) {
                $uri = PUBLICPATH . $attachment["file"];
                $coverage = "{$semantic}.jpg";
                $uricover = PUBLICPATH . "storages/images/covers/{$coverage}";
                if (!file_exists($uricover) && file_exists($uri)) {
                    //echo("no existe!");
                    $image = Services::image()->withFile($uri)->fit(720, 480, 'center')->save($uricover, 85);
                    $image = Services::image()->withFile($uricover)
                        ->text(strtoupper("" . DOMAIN) . ' 2021 ', [
                            'color' => '#ffffff',
                            'opacity' => 0.5,
                            'withShadow' => false,
                            'fontSize' => 11,
                            'hAlign' => 'right',
                            'vAlign' => 'bottom',
                            'hOffset' => 0,
                            'vOffset' => 0,
                        ])
                        ->save($uricover, 90);
                }
                return ("/storages/images/covers/{$coverage}?created={$attachment["attachment"]}");
            }
        } else {
            return ("/themes/assets/images/empty-720x480.png");
        }

    }

    /**
     * Retorna la ruta a la imagen miniatura de un articulo reprocesando la imagen original
     * @param $pid
     */
    private
    function get_Thumbnail($pid, $semantic, $attachment)
    {
        if (is_array($attachment)) {
            $thumbnailname = false;
            if (isset($attachment["file"]) && !empty($attachment["file"])) {
                $path = "";
                $uri = PUBLICPATH . $attachment["file"];
                $thumbnailname = "{$semantic}.jpg";
                $urithumbnail = PUBLICPATH . "storages/images/thumbnails/{$thumbnailname}";
                if (!file_exists($urithumbnail) && file_exists($uri)) {
                    $image = Services::image()
                        ->withFile($uri)
                        ->fit(100, 75, 'center')
                        ->save($urithumbnail, 90);
                }
            }
            return ("/storages/images/thumbnails/{$thumbnailname}?created={$attachment["attachment"]}");
        } else {
            return ("/themes/assets/images/empty-720x480.png");
        }
    }

}

?>