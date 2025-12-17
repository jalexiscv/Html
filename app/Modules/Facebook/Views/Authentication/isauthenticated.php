<?php

use App\Libraries\Files;

$userData = array();
$fbUser = $facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture', $token);
// Preparing data for database insertion 
$userData['oauth_provider'] = 'facebook';
$userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : '';
$userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
$userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
$userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : '';
$userData['gender'] = !empty($fbUser['gender']) ? $fbUser['gender'] : '';
$userData['picture'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
$userData['link'] = !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/';
$data['userData'] = $userData;
$authentication->set('userData', $userData);
$data['logoutURL'] = $facebook->logout_url();

/**
 * Debo verificar si la dirección de correo electronico corresponde con la dirección
 * de correo electronico de algun usuario registrado. Si esta coincide se puede
 * asumir que dicho usuario ha iniciado sessión correctamente pues su identidad esta
 * confirmada.
 */
//if ($authentication->loginFB($userData['email'], $userData['oauth_uid'])) {
//redirect(base_url());
//} else {
/*
 * Si el usuario no existe, se puede asumir que el presente inicio de 
 * Authentication coincide con un proceso de registro, asi que se deben tomar los
 * datos y registrar al nuevo usuario en el sistema. Pero si los datos estan vacios debo 
 * de resolicitar acceso a facebook, es decir reconección.
 */
if (empty($userData['oauth_uid'])) {
    redirect($facebook->login_url());
} else {
    $users = model("App\Modules\Security\Models\Security_Users", true);
    $fields = model("App\Modules\Security\Models\Security_Users_Fields", true);
    $files = new Files();
    /** Si hay un loginFB activo * */
    if ($authentication->loginFB($userData['email'], $userData['oauth_uid'])) {
        //echo("<br>Existe un usuario que tiene el correo autenticado");
        //echo("<br>Archivo: ".$userData['picture']);
        $avatar = $fields->where("user", $authentication->get_User())->where("name", "profile_photo")->orderBy('created_at', 'DESC')->first();
        if (!isset($avatar["value"])) {
            $url = "https://graph.facebook.com/{$userData['oauth_uid']}/picture?type=large";
            $file = $files->transfer("transfers/facebook/", "{$userData['oauth_uid']}.jpg", $url);
            $fields->insert(array("user" => $authentication->get_user(), "name" => "profile_photo", "value" => $file["url"], "author" => "FACEBOOK"));
        }
        /* [redirect] */
        $url = base_url() . "?Authentication=" . $authentication->get_id();
        $html = "<html>"
            . "<head>"
            . "</head>"
            . "<body>"
            . "<script>window.location.replace('{$url}');</script>"
            . "</body>"
            . "</html>";
        echo($html);
        /* [/redirect] */
    } else {
        // La Authentication con facebook es correcta pero el usuario no esta registrado
        /* [database] */
        $user = strtoupper(uniqid());
        $vmail = explode("@", $userData['email']);
        $d = array("user" => $user, "author" => "FACEBOOK");
        $create = $users->insert($d);
        $firstname = $userData['first_name'];
        $lastname = $userData['last_name'];
        $alias = strtoupper($vmail[0]);
        $password = time();
        $email = $userData['email'];
        $token_email = md5(uniqid(rand(), true));
        $fields->insert(array("user" => $user, "name" => "alias", "value" => $alias, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "password", "value" => $password, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "firstname", "value" => $firstname, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "lastname", "value" => $lastname, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "email", "value" => $email, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "token-email", "value" => $token_email, "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "facebook_uid", "value" => $userData['oauth_uid'], "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "gender", "value" => $userData['gender'], "author" => "FACEBOOK"));
        $fields->insert(array("user" => $user, "name" => "facebook_link", "value" => $userData['link'], "author" => "FACEBOOK"));

        $url = "https://graph.facebook.com/{$userData['oauth_uid']}/picture?type=large";
        $file = $files->transfer("transfers/facebook/", "{$userData['oauth_uid']}.jpg", $url);
        $fields->insert(array("user" => $user, "name" => "profile_photo", "value" => $file["url"], "author" => "FACEBOOK"));

        /* [/database] */
        $url = base_url() . "?Authentication=" . $authentication->get_id();
        if ($authentication->loginFB($userData['email'], $userData['oauth_uid'])) {
            $html = "<html>"
                . "<head>"
                . "</head>"
                . "<body>"
                . "<script>window.location.replace('{$url}');</script>"
                . "</body>"
                . "</html>";
            echo($html);
        } else {
            echo("un error a acontesido");
        }
    }
}


//}
?>