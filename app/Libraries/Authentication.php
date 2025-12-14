<?php

namespace App\Libraries;

use Config\Database;
use Higgs\I18n\Time;

class Authentication
{
    private $session;
    private $client;
    private mixed $user = false;
    private $avatar;
    private $avatar_default;
    private $host;
    private $anonymous = "anonymous";
    private $theme_color;
    private $default_url;
    private $logo;
    private $logo_portrait;
    private $logo_portrait_light;
    private $logo_landscape;
    private $logo_landscape_light;
    private $fb_app_id;
    private $fb_app_secret;
    private $fb_page;
    private $server;
    private $loggedin;
    private $sdb; // Base de datos de la session activa
    private $arc_id;
    private $matomo;
    private $session_update;
    private $session_ago;

    /**
     *  $this->host: Se recibe y se consulta sin él www en caso de que use un subdominio este se respetara, pero si es
     *  directamente un www esta será eliminada
     */

    public function __construct()
    {
        /** inicializando */
        $now = Time::now();
        $this->server = new Server();
        $this->session = session();
        $this->user = !is_null($this->session->get("user")) ? $this->session->get("user") : false;
        $this->client = $this->session->get("client");
        $this->avatar = $this->session->get("avatar");
        $this->avatar_default = "/themes/bs5/img/avatars/avatar-neutral.png";
        $this->host = $this->session->get("host");
        $this->theme_color = $this->session->get("theme_color");
        $this->default_url = $this->session->get("default_url");
        $this->logo = $this->session->get("logo");
        $this->logo_portrait = $this->session->get("logo_portrait");
        $this->logo_portrait_light = $this->session->get("logo_portrait_light");
        $this->logo_landscape = $this->session->get("logo_landscape");
        $this->logo_landscape_light = $this->session->get("logo_landscape_light");
        $this->arc_id = $this->session->get("arc_id");
        $this->matomo = $this->session->get("matomo");
        $this->loggedin = $this->session->get("loggedin");
        $this->sdb = $this->session->get("sdb");
        $this->session_update = $this->session->get("session-update");
        $this->session_ago = 0;
        if (!empty($this->session_update)) {
            $ago = $now->difference(Time::parse($this->session_update));
            $this->session_ago = $ago->getMinutes();
        }
        /** Evaluando **/
        $this->session->set("host", empty($this->host) ? $this->server->get_Name() : $this->host);
        $this->session->set("user", empty($this->user) ? $this->anonymous : $this->user);
        $this->session->set("avatar", empty($this->avatar) ? $this->avatar_default : $this->avatar);
        $this->session->set("loggedin", empty($this->loggedin) || !$this->loggedin ? false : true);
        /** consultando **/
        if (empty($this->client) || empty($this->session_update) || $this->session_ago < -5) {
            $mclients = model("App\Models\Application_Clients");
            $client = $mclients->get_ClientFromThisDomain();
            /** Reasignación */
            $this->client = @$client["client"];
            $this->sdb = @$client["db"];
            $this->logo = @$client["logo"];
            $this->logo_portrait = @$client["logo_portrait"];
            $this->logo_portrait_light = @$client["logo_portrait_light"];
            $this->logo_landscape = @$client["logo_landscape"];
            $this->logo_landscape_light = @$client["logo_landscape_light"];
            $this->theme_color = @$client["theme_color"];
            $this->default_url = @$client["default_url"];
            $this->fb_app_id = @$client["fab_app_id"];
            $this->fb_app_secret = @$client["fab_app_secret"];
            $this->fb_page = @$client["fab_page"];
            $this->arc_id = @$client["arc_id"];
            $this->matomo = @$client["matomo"];
            /** Recarga **/
            $this->session->set("logo", $this->logo);
            $this->session->set("client", $this->client);
            $this->session->set("logo_portrait", $this->logo_portrait);
            $this->session->set("logo_portrait_light", $this->logo_portrait_light);
            $this->session->set("logo_landscape", $this->logo_landscape);
            $this->session->set("logo_landscape_light", $this->logo_landscape_light);
            $this->session->set("sdb", $this->sdb);
            $this->session->set("theme_color", $this->theme_color);
            $this->session->set("default_url", $this->default_url);
            $this->session->set("fb_app_id", $this->fb_app_id);
            $this->session->set("fb_app_secret", $this->fb_app_secret);
            $this->session->set("fb_page", $this->fb_page);
            $this->session->set("arc_id", $this->arc_id);
            $this->session->set("matomo", $this->matomo);
            $this->session->set("session-update", $now->toDateTimeString());
        }
        $this->session->set("session-ago", $this->session_ago);
    }

    public function get($var)
    {
        return ($this->session->get($var));
    }

    public function set($var, $value)
    {
        $this->session->set($var, $value);
    }

    /**
     * Este método retorna falso o verdadero si el usuario es un usuario registrado con una sesión activa
     * en esta version para definir tal estado se basa en el hecho de su el valor de user es o no es anónimo.
     * @return bool
     */
    public function get_LoggedIn()
    {
        if (!empty($this->user) && $this->user !== $this->anonymous) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * @return array|bool|float|int|object|string|null
     */
    public function get_Theme(): string
    {
        $theme = $this->session->get("theme");
        if (empty($theme)) {
            $theme = "default";
        }
        return ($theme);
    }

    /**
     * @param $theme
     * @return void
     */
    public function set_Theme($theme)
    {
        $this->session->set("theme", $theme);
    }

    public function get_ThemeMode(): string
    {
        $mode = $this->session->get("theme-mode");
        if (empty($mode)) {
            $mode = "theme-light";
        }
        return ($mode);
    }

    public function set_ThemeMode($mode)
    {
        $this->session->set("theme-mode", $mode);
    }

    public function get_Id()
    {
        return (session_id());
    }

    public function get_Alias()
    {
        $fields = model("\App\Modules\Security\Models\Security_Users_Fields");
        $user = $this->get_User();
        $alias = $fields->get_AliasByUser($user);
        return ($alias);
    }

    public function get_User()
    {
        return ($this->user);
    }

    public function get_Avatar()
    {
        $mfields = model("\App\Modules\Security\Models\Security_Users_Fields");
        $profile = $mfields->get_Profile($this->get_User());
        return ($profile["avatar"]);
    }


    public function get_FullUserName()
    {
        $mfields = model("\App\Modules\Security\Models\Security_Users_Fields");
        $user = $this->get_User();
        $profile = $mfields->get_Profile($user);
        $fullname = $profile["name"];
        return ($fullname);
    }

    /**
     * código OTP (One-Time Password).
     * @return mixe
     *
     */
    public function validateOtp($otp)
    {
        $return = false;
        if (!empty($otp)) {
            $fields = model("\App\Modules\Security\Models\Security_Users_Fields");
            $field = $fields
                ->where("value", $otp)
                ->orderBy("created_at", "DESC")
                ->first();
            $return = isset($field["user"]) ? $field["user"] : false;
        }
        return ($return);
    }


    public function destroy_AllOtps($user)
    {
        $fields = model("\App\Modules\Security\Models\Security_Users_Fields");
        $fields->where('user', $user)->where('name', 'otp')->delete();
    }

    public function generate_Otp($user, $password)
    {
        $strings = service('strings');
        $return = false;
        if (!empty($user) && !empty($password)) {
            $fields = model("App\Modules\Security\Models\Security_Users_Fields", true);
            $row_user = $fields->where("(name='alias' AND value='{$user}')OR(name='email' AND value='{$user}')")
                ->orderBy('created_at', 'DESC')
                ->first();
            if (isset($row_user["user"])) {
                $f_user = $row_user["user"];
                $row_password = $fields->where("user", $f_user)
                    ->where("name", "password")
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $f_password = $row_password["value"];
                if (strtoupper($password) === strtoupper($f_password)) {
                    $otp = $strings->get_OTP(6);
                    $fields->insert(array(
                            "field" => pk(),
                            "user" => $f_user,
                            "name" => "otp",
                            "value" => $otp)
                    );
                    $return = $otp;
                }
            }
        }
        return ($return);
    }


    public function get_Value($key)
    {
        return ($this->session->get($key));
    }

    /**
     * Este método permite a un usuario que envía sus datos iniciar session, en el caso de que por nombre de usuario
     * se utilice el correo electrónico del usuario este debera ser único, o se produciría un error.
     * @param type $user
     * @param type $password
     */

    public function login($user, $password)
    {
        $return = false;
        if (!empty($user) && !empty($password)) {
            $fields = model("App\Modules\Security\Models\Security_Users_Fields", true);
            $row_user = $fields->where("(name='alias' AND value='{$user}')OR(name='email' AND value='{$user}')")
                ->orderBy('created_at', 'DESC')
                ->first();
            if (isset($row_user["user"])) {
                $f_user = $row_user["user"];
                $row_password = $fields->where("user", $f_user)
                    ->where("name", "password")
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $f_password = $row_password["value"];
                if (strtoupper($password) === strtoupper($f_password)) {
                    $this->user = $f_user;
                    $row_alias = $fields->where("user", $f_user)->where("name", "alias")->orderBy('created_at', 'DESC')->first();
                    $row_avatar = $fields->where("user", $f_user)->where("name", "profile_photo")->orderBy('created_at', 'DESC')->first();
                    $avatar = isset($row_avatar["value"]) ? $row_avatar["value"] : "/themes/bs5/img/avatars/avatar-neutral.png";
                    $this->session->set("user", $this->user);
                    $this->session->set("alias", strtolower($row_alias["value"]));
                    $this->session->set("avatar", $avatar);
                    $this->session->set("loggedin", true);
                    $return = (true);
                }
            }
        }
        return ($return);
    }


    /**
     * Inicio de session con correo proviniente de un facebook login.
     * @param type $user
     * @param type $password
     * @return type
     */
    public function loginFB($email, $fbid)
    {
        $return = false;
        $fields = model("App\Modules\Security\Models\Security_Users_Fields", true);
        $row_user = $fields->where("(name='email' AND value='{$email}')OR(name='fbid' AND value='{$fbid}')")
            ->orderBy('created_at', 'DESC')
            ->first();
        if (isset($row_user["user"])) {
            $f_user = $row_user["user"];
            $this->user = $f_user;
            $row_alias = $fields
                ->where("user", $f_user)
                ->where("name", "alias")
                ->orderBy('created_at', 'DESC')
                ->first();
            $row_avatar = $fields->where("user", $f_user)->where("name", "profile_photo")->orderBy('created_at', 'DESC')->first();
            $avatar = isset($row_avatar["value"]) ? $row_avatar["value"] : "/themes/bs5/img/avatars/avatar-neutral.png";
            $this->session->set("user", $this->user);
            $this->session->set("alias", safe_strtolower(@$row_alias["value"]));
            $this->session->set("avatar", $avatar);
            $this->session->set("loggedin", true);
            $return = (true);
        }
        return ($return);
    }

    /**
     * Permite iniciar session solo proporsionando el id del usuario.
     * @param type $uid
     * @return type
     */
    public function loginOnlyUser($uid)
    {
        $return = false;
        $fields = model("App\Modules\Security\Models\Security_Users_Fields", true);
        if (!empty($uid)) {
            $this->user = $uid;
            $row_alias = $fields->where("user", $uid)->where("name", "alias")->orderBy('created_at', 'DESC')->first();
            $row_avatar = $fields->where("user", $uid)->where("name", "profile_photo")->orderBy('created_at', 'DESC')->first();
            $avatar = isset($row_avatar["value"]) ? $row_avatar["value"] : "/themes/bs5/img/avatars/avatar-neutral.png";
            $this->session->set("user", $this->user);
            $this->session->set("alias", safe_strtolower(@$row_alias["value"]));
            $this->session->set("avatar", $avatar);
            $this->session->set("loggedin", true);
            $return = (true);
        }
        return ($return);
    }

    public function logout()
    {
        $this->session->set("user", $this->anonymous);
        $this->session->set("client", "");
        $this->session->destroy();
        $this->set("sdb", "");
    }

    /**
     * Verifica si el usuario activo tiene el permiso indicado y considera este
     * resultado como valido durante 5 minutos por el cache.
     * Nota: La implementación de granted y denied se debe a que si se utilizan los
     * valores TRUE o FALSE, para almacenar en el cache y el resultado es FALSE
     * !$$xvar = cache($xvar) por defecto siempre se reconsultara la base datos
     * @param string $permission
     * @return bool
     */
    public function has_Permission(string $permission): bool
    {
        $musers = model("\App\Modules\Security\Models\Security_Users");
        return ($musers->has_Permission($this->user, $permission));
    }


    public function get_FBAppID()
    {
        return ($this->fb_app_id);
    }

    public function get_FBAppSecret()
    {
        return ($this->fb_app_secret);
    }

    public function get_FBPage()
    {
        return ($this->fb_page);
    }

    public function get_ArcID()
    {
        return ($this->arc_id);
    }

    public function get_Matomo()
    {
        return ($this->matomo);
    }


    public function get_Client()
    {
        return ($this->client);
    }

    public function get_ClientDefaultURL()
    {
        return ($this->default_url);
    }

    public function get_ClientThemeColor()
    {
        return ($this->theme_color);
    }

    public function csrf_token()
    {
        return (csrf_token());
    }

    public function csrf_hash()
    {
        return (csrf_hash());
    }

}
