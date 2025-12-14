<?php

namespace App\Modules\Organization\Models;

use Higgs\Model;
use App\Modules\Security\Models\Security_Users;

class Organization_Users extends Security_Users
{

    /**
     * Retorna un listado de usuarios con su respectivo nombre y apellido
     * @return array|false
     */
    public function get_SelectUsersByPositions(): false|array
    {
        $dusers = $this->findAll();
        if (is_array($dusers)) {
            $muf = model("App\Modules\Organization\Models\Organization_Users_Fields");
            $users = array();
            foreach ($dusers as $user) {
                $profile = $muf->get_Profile($user["user"]);
                $users[] = array("label" => $profile["name"], "value" => $user["user"]);
            }
            return ($users);
        } else {
            return (false);
        }
    }


}

?>