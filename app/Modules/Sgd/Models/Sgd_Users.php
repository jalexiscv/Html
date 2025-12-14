<?php

namespace App\Modules\Sgd\Models;

use Higgs\Model;
use App\Modules\Security\Models\Security_Users;

class Sgd_Users extends Security_Users
{

public function getUsers(){
    $users = $this->findAll();
    return($users);
}




}
?>