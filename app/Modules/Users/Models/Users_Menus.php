<?php

defined("BASEPATH") or exit("No direct script access allowed");

if (!class_exists("Users_Menus")) {

    class Users_Menus extends MX_Model
    {

        private $table;
        private $pk;
        private $cache_time;
        private $instance;

        function __construct()
        {
            parent::__construct();
            $this->instance =& get_instance();
            $this->table = "security_menus";
            $this->pk = "menu";
            $this->cache_time = 60 * 60;
            $this->install();
        }

        function db()
        {
            $db = $this->load->database(Router::getClientConexion(), TRUE);
            return ($db);
        }

        /**
         * * Example:
         * * $this->Application_Menus->create(array(
         * *     "menu"=>$frm->getValue("menu"),
         * *     "module"=>$frm->getValue("module"),
         * *     "parent"=>$frm->getValue("parent"),
         * *     "weight"=>$frm->getValue("weight"),
         * *     "text"=>$frm->getValue("text"),
         * *     "link"=>$frm->getValue("link"),
         * *     "target"=>$frm->getValue("target"),
         * *     "icon"=>$frm->getValue("icon"),
         * *     "permission"=>$frm->getValue("permission"),
         * *     "date"=>$frm->getValue("date"),
         * *     "time"=>$frm->getValue("time"),
         * *     "author"=>$frm->getValue("author"),
         * * ));
         * */
        public function create($datos = array())
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            if (is_array($datos)) {
                $db = $this->db();
                if ($db != null) {
                    $db->insert($this->table, $datos);
                    return ($db->insert_id());
                } else {
                    return (false);
                }
            } else {
                return (false);
            }
        }

        public function update($pid, $field, $value)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            if (!empty($db)) {
                $data = array($field => $value);
                $db->where($this->pk, $pid);
                $db->update($this->table, $data);
            } else {
                return (false);
            }
        }

        public function delete($pid)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            if ($db->delete($this->table, array($this->pk => $pid))) {
                return (true);
            } else {
                return (false);
            }
        }

        public function query($pkid)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            if (!empty($db)) {
                $db->select("*");
                $db->from($this->table);
                $db->where($this->pk, $pkid);
                $query = $db->get();
                return ($query->row_array());
            } else {
                return (false);
            }
        }

        /**
         * Retorna os datos de una publicación incororando
         * manejo avanzado del cache.
         * @param type $limit
         * @return type
         */
        public function get_CachedMenus($pid)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . ": " . json_encode($pid));
            $cache = get_cache();
            $token = Authentication_token();
            $server = Server::getNamed();
            $mid = implode("", $pid);
            $xvar = "{$server}_{$token}_app_menu_{$mid}";
            if (!$$xvar = $cache->get($xvar)) {
                log_message("debug", "---> " . txt_cblue(__METHOD__) . ": Nombre del Cache " . $xvar);
                $$xvar = $this->_get_ArrayList($pid);
                $cache->save($xvar, $$xvar, $this->cache_time, true);
            }
            return ($$xvar);
        }

        /**
         * Retorna os datos de una publicación incororando
         * manejo avanzado del cache.
         * @param type $limit
         * @return type
         */
        public function get_CachedQuery($pid)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $cache = get_cache();
            $xvar = "social_menus_query_Authentication_" . Authentication_token();
            if (!$$xvar = $cache->get($xvar)) {
                $$xvar = $this->query($pid);
                $cache->save($xvar, $$xvar, $this->cache_time, true);
            }
            return ($$xvar);
        }

        /**
         * Retorna una lista de objetos donde cada objeto corresponde a caracteristicas MySQL de
         * una tabla especifica. Este metodo fue creado teniendo en consideración una posible consulta
         * de criterio extendido que abarcara los datos almacenados como campos en la tabla
         * security_users_fields
         * Nota: Asegurece de que no haya un valor previo de consulta, tipo preId
         * ,         *       el cual pueda alterar el orden de los argumentos del método
         * @return type
         */
        private function _get_ArrayList($attr = array())
        {
            log_message("debug", "---> " . txt_cblue(__METHOD__) . "");
            $module = isset($attr["module"]) ? $attr["module"] : null;
            $search = isset($attr["search"]) ? $attr["search"] : null;
            $db = $this->db();
            $db->select("*");
            $db->from($this->table);
            if (isset($attr["parent"])) {
                $db->where("parent", $attr["parent"]);
            }
            if (!empty($search)) {
                $db->like("{$this->table}.{$this->pk}", $search);
                $db->or_like("{$this->table}.date", $search);
                $db->or_like("{$this->table}.time", $search);
            }
            $db->order_by("weight", "ASC");
            $db->order_by("parent", "ASC");
            if (isset($attr["start"]) && isset($attr["limit"])) {
                $db->limit($attr["limit"], $attr["start"]);
            }
            $query = $db->get();
            //echo($db->last_query());
            return ($query->result_array());
        }

        public function getArrayParentListAsOptions($attr = array())
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");

            $items = $this->getArrayList();
            array_push($items, array("menu" => null, "module" => null, "parent" => null, "text" => lng("none")));
            $return = array();
            foreach ($items as $item) {
                $parent = $this->query($item["parent"]);
                $return[$item[$this->pk]] = lng($parent["text"]) . "/" . lng($item["text"]);
            }
            return ($return);
        }

        /**
         * Retorna el numero total de registros existentes en la tabla
         * @param type $attr
         * @return type
         */
        public function getTotalCount($attr = array())
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            if (!empty($db)) {
                $db->select("Count(*) AS `count`");
                $db->from($this->table);
                $consulta = $db->get();
                $resultado = $consulta->row();
                return ($resultado->count);
            } else {
                return (0);
            }
        }

        /**
         * Retorna el numero total filtrados en la tabla
         * @param type $attr
         * @return type
         */
        public function getTotalCountFiltered($search = null)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            if (!empty($db)) {
                $db->select("Count(*) AS `count`");
                $db->from($this->table);
                if (!empty($search)) {
                    $db->like("{$this->table}.{$this->pk}", $search);
                    $db->or_like("{$this->table}.date", $search);
                    $db->or_like("{$this->table}.time", $search);
                }
                $consulta = $db->get();
                $resultado = $consulta->row();
                return ($resultado->count);
            } else {
                return (0);
            }
        }

        /**
         * Este metodo retorna una lista de objetos compatible con un DropDown
         * como cuando por ejemplo se retorna una lista de paises u opciones.
         * Ejemplo:
         *      $list=$this->Application_Menus->getArrayListAsOptions();
         *      $f->fields["list"] =$f->getDropdown("list", array("options" =>$list, "selected" => $r["selected"], "proportion" => "md-4"));
         * @return type array listado de objetos
         */
        public function getArrayListAsOptions()
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $items = $this->getArrayList();
            $return = array();
            foreach ($items as $item) {
                $return[$item[$this->pk]] = urldecode($item["name"]);
            }
            return ($return);
        }

        /**
         * Retorna falso o verdadero si el usuario activo ne la sesión es el
         * autor del regsitro que se desea acceder, editar o eliminar.
         * @param type $id codigo primario del registro a consultar
         * @param type $author codigo del usuario del cual se pretende establecer la autoria
         * @return boolean falso o verdadero segun sea el caso
         */
        public function getAuthority($id, $author)
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $row = $this->query($id);
            if ($row["author"] == $author) {
                return (true);
            } else {
                return (false);
            }
        }

        /**
         * Este metodo regenera la tabla si esta no existe en la base de datos
         * seleccionada, incluye la clausula SQL TABLE IF NOT EXIST, para evitar.
         * que se generen mensajes de error o excepciones no deseadas.
         * */
        public function install()
        {
            log_message("debug", "" . txt_cblue(__METHOD__) . "");
            $db = $this->db();
            $c = "CREATE TABLE IF NOT EXISTS `{$this->table}` (";
            $c .= "  `menu` varchar(13) NOT NULL DEFAULT '',\n";
            $c .= "  `module` varchar(255) NOT NULL DEFAULT '',\n";
            $c .= "  `parent` varchar(13) DEFAULT NULL COMMENT 'elemento padre',\n";
            $c .= "  `weight` int(3) DEFAULT '0' COMMENT 'peso',\n";
            $c .= "  `text` varchar(255) NOT NULL DEFAULT '',\n";
            $c .= "  `link` varchar(255) DEFAULT NULL,\n";
            $c .= "  `target` varchar(128) DEFAULT '_parent',\n";
            $c .= "  `icon` varchar(255) DEFAULT NULL,\n";
            $c .= "  `permission` varchar(255) DEFAULT NULL,\n";
            $c .= "  `date` date DEFAULT NULL,\n";
            $c .= "  `time` time DEFAULT NULL,\n";
            $c .= "  `author` varchar(13) DEFAULT NULL,\n";
            $c .= "  PRIMARY KEY (`menu`)\n";
            $c .= ");";
            return ($db->query($c));
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
        private function tableExists($tableName)
        {
            $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
            if (!$data = cache($cache_key)) {
                $data = $this->db->tableExists($tableName);
                cache()->save($cache_key, $data, $this->cache_time * 10);
            }
            return ($data);
        }

    }

}
?>