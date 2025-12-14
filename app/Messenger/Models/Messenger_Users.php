<?php

namespace app\Messenger\Models;

use Higgs\Model;
use App\Modules\Security\Models\Security_Users;

class Messenger_Users extends Security_Users
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene una lista de usuarios combinados con sus campos personalizados (alias, firstname, lastname, phone, address, email, avatar)
     * con opciones de filtrado y paginación. Los campos personalizados se obtienen de la tabla security_users_fields.
     * @param int $limit El número de registros a obtener.
     * @param int $offset El número de registros a saltar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return false|array    El número total de registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): false|array
    {
        $muf = model("App\Modules\Messenger\Models\Messenger_Users_Fields");
        $users = $this->findAll();
        if (is_array($users)) {
            for ($i = 0; $i < count($users); $i++) {
                $user = $users[$i]['user'];
                $profile = $muf->get_Profile($user);
                $users[$i]['name'] = $profile['name'];
                $users[$i]['alias'] = $profile['alias'];
                $users[$i]['avatar'] = $profile['avatar'];
            }
            return ($users);
        } else {
            return (false);
        }

    }

    public function get_OnlineUsers(int $limit, int $offset, string $search = ""): false|array
    {
        $key = $this->get_CacheKey("onlineusers-{$limit}{$offset}{$search}");
        $cache = cache($key);
        if (!parent::is_CacheValid($cache)) {
            $ou = $this->_get_OnlineUsers($limit, $offset, $search);
            $value = (count($ou) > 0) ? $ou : false;
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, 60);
        }
        return ($cache['value']);
    }


    /**
     * Obtiene una lista de usuarios en línea combinados con sus campos personalizados (alias, firstname, lastname, phone, address, email, avatar)
     * con opciones de filtrado y paginación. Los campos personalizados se obtienen de la tabla security_users_fields.
     * @param int $limit El número de registros a obtener.
     * @param int $offset El número de registros a saltar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return false|array    El número total de registros.
     */
    public function _get_OnlineUsers(int $limit, int $offset, string $search = ""): false|array
    {
        $muf = model("App\Modules\Messenger\Models\Messenger_Users_Fields");
        $mstatuses = model("App\Modules\Users\Models\Users_Statuses");
        $users = $mstatuses->where('value', 'online')->findAll();
        if (is_array($users)) {
            for ($i = 0; $i < count($users); $i++) {
                $user = $users[$i]['status'];
                $profile = $muf->get_Profile($user);
                $users[$i]['user'] = $user;
                $users[$i]['name'] = $profile['name'];
                $users[$i]['alias'] = $profile['alias'];
                $users[$i]['avatar'] = $profile['avatar'];
            }
            return ($users);
        } else {
            return (false);
        }

    }

}

?>