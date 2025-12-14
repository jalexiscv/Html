<?php

use App\Libraries\Crypt;
use App\Libraries\Dates;
use App\Libraries\Devices;
use App\Libraries\Server;
use Higgs\CLI\CLI;
use Random\RandomException;

if (!function_exists('setting')) {
    /**
     * Función setting
     * Esta función proporciona una interfaz conveniente para el servicio Settings.
     * Permite obtener, establecer y olvidar valores de configuración utilizando una sola función.
     * - Obtener un valor: $name = setting('App.siteName');
     * - Almacenar un valor: setting('App.siteName', 'My Great Site');
     * - Usar el servicio a través de la función helper:
     * -   $name = setting()->get('App.siteName');
     * -   setting()->set('App.siteName', 'My Great Site');
     * - Olvidar un valor: setting()->forget('App.siteName');
     * @param string|null $key La clave de la configuración a obtener o establecer. Si se omite, devuelve el objeto Settings.
     * @param mixed|null $value El valor a establecer para la clave especificada. Si se omite, se obtiene el valor de la clave.
     * @return array|bool|float|int|object|Settings|string|void|null Retorna el valor de la configuración si se solicita, el objeto Settings si no se proporciona una clave, o null si se establece un valor.
     * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
     * @version 1.0.0
     */
    function setting(?string $key = null, $value = null)
    {
        $setting = service('settings');
        if (empty($key)) {
            return $setting;
        }
        if (count(func_get_args()) === 1) {
            return $setting->get($key);
        }
        $setting->set($key, $value);
    }
}


if (!function_exists('html_escape')) {
    function html_escape($var, $double_encode = TRUE)
    {
        $config = config(App::class);
        if (empty($var)) {
            return $var;
        }
        if (is_array($var)) {
            foreach (array_keys($var) as $key) {
                $var[$key] = html_escape($var[$key], $double_encode);
            }
            return $var;
        }
        return htmlspecialchars($var, ENT_QUOTES, $config->charset, $double_encode);
    }
}

if (!function_exists("safe_get_date")) {
    function safe_get_date()
    {
        $dates = service('dates');
        return ($dates->get_Date());
    }
}


if (!function_exists("safe_get_time")) {
    function safe_get_time()
    {
        $dates = service('dates');
        return ($dates->get_Time());
    }
}

if (!function_exists("safe_strtolower")) {
    function safe_strtolower($string)
    {
        $s = service('strings');
        return ($s->get_Strtolower($string));
    }
}


if (!function_exists("safe_trim")) {
    function safe_trim($string)
    {
        $s = service('strings');
        return ($s->get_Trim($string));
    }
}


if (!function_exists("safe_ucfirst")) {
    /**
     * Convierte el primer carácter de una cadena a mayúscula de forma segura
     * Esta función utiliza el servicio de cadenas para manejar la conversión,
     * lo que proporciona mejor soporte para caracteres multibyte (UTF-8) y
     * casos especiales que la función nativa ucfirst() de PHP.
     * @param string $string La cadena que se procesará
     * @return string La cadena con el primer carácter convertido a mayúscula
     */
    function safe_ucfirst($string)
    {
        $s = service('strings');
        return ($s->get_Ucfirst($string));
    }
}

if (!function_exists("safe_strtoupper")) {
    function safe_strtoupper($string)
    {
        $s = service('strings');
        return ($s->get_Strtoupper($string));
    }
}


if (!function_exists("safe_urldecode")) {
    function safe_urldecode($string)
    {
        $s = service('strings');
        return ($s->get_URLDecode($string));
    }
}


if (!function_exists("safe_str_pad")) {
    function safe_str_pad($input, $pad_length, $pad_string = "0", $pad_type = STR_PAD_LEFT)
    {
        $s = service('strings');
        return ($s->get_StrPad($input, $pad_length, $pad_string, $pad_type));
    }
}

if (!function_exists("safe_urlencode")) {
    function safe_urlencode($string)
    {
        $s = service('strings');
        return ($s->get_URLEncode($string));
    }
}


if (!function_exists("component")) {
    /**
     * Verifica la exitencia de una url retornando falso o verdadero segun corresponda
     * @param type $url
     * @return boolean
     */
    function component($uri, $data)
    {
        return (array("uri" => $uri, "data" => $data));
    }
}

if (!function_exists("safe_json")) {
    function safe_json(string $json, string $property, string $default = null): mixed
    {
        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded[$property])) {
            return $decoded[$property];
        } else {
            if (isset($default)) {
                return ($default);
            }
            return (false);
        }
    }
}


if (!function_exists("url_exists")) {

    /**
     * Verifica la exitencia de una url retornando falso o verdadero segun corresponda
     * @param type $url
     * @return boolean
     */
    function url_exists($url = NULL)
    {
        if (empty($url)) {
            return false;
        } else {
            $options['http'] = array(
                'method' => "HEAD",
                'ignore_errors' => 1,
                'max_redirects' => 0
            );
            $body = @file_get_contents($url, false, stream_context_create($options));
            if (isset($http_response_header)) {
                sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode);
                $accepted_response = array(200, 301, 302);
                if (in_array($httpcode, $accepted_response)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

}


if (!function_exists("get_ago")) {

    /**
     * Permite establecer si es tipo de dispositivo que se esta utilizando es un
     * PC tratese de computador de escritorio o portatil.
     * @return type
     */
    function get_ago($date, $time)
    {
        $dates = new Dates();
        return ($dates::get_LiveTimestamp($date, $time, $pref = lang("App.Ago")));
    }

}


if (!function_exists("is_desktop")) {

    /**
     * Permite establecer si es tipo de dispositivo que se esta utilizando es un
     * PC tratese de computador de escritorio o portatil.
     * @return type
     */
    function is_desktop()
    {
        $device = new Devices();
        if ($device->isMobile()) {
            return (false);
        } else {
            return (true);
        }
    }

}


/**
 * Retorna el usuario activo
 */
if (!function_exists("safe_get_user")) {

    function safe_get_user()
    {
        $authentication = service('authentication');
        $user = $authentication->get_User();
        return ($user ?? "anonymous");
    }

}


if (!function_exists("safe_encrypt")) {
    /**
     * Este método permite encriptar un texto de manera segura, para ello se requiere de una clave de encriptación
     * que se obtiene mediante el método safe_get_keyBase64, el texto encriptado es retornado en formato base64
     * @param $data
     * @return string
     */
    function safe_encrypt($text): string
    {
        $crypt = new Crypt();
        return ($crypt->encrypt($text));
    }

}

if (!function_exists("safe_decrypt")) {
    /**
     * Este método permite desencriptar un texto de manera segura, para ello se requiere de una clave de encriptación
     * que se obtiene mediante el método safe_get_keyBase64, el texto encriptado es retornado en formato base64
     * @param $data
     * @return string
     */
    function safe_decrypt($text): string
    {
        $crypt = new Crypt();
        return ($crypt->decrypt($text));
    }

}


if (!function_exists("safe_get_encrypt_user")) {
    /**
     * Este método permite encriptar la identidad del usuario
     * @param $data
     * @return string
     * @throws RandomException
     */
    function safe_get_encrypt_user(): string
    {
        return (safe_encrypt(safe_get_user()));
    }
}

if (!function_exists("safe_get_encrypt_instance")) {
    /**
     * Este método permite encriptar la identidad del sitio
     * @param $data
     * @return string
     * @throws RandomException
     */
    function safe_get_encrypt_instance(): string
    {
        $instance = safe_get_instance();
        return (safe_encrypt($instance));
    }
}


if (!function_exists("safe_get_user_fullname")) {
    /**
     * Este método retorna el nombre completo del usuario activo
     * @return mixed
     */
    function safe_get_user_fullname()
    {
        $authentication = service('authentication');
        return ($authentication->get_FullUserName());
    }

}

if (!function_exists("safe_get_user_alias")) {

    function safe_get_user_alias()
    {
        $authentication = service('authentication');
        return ($authentication->get_Alias());
    }

}

/**
 * Este método retorna falso o verdadero si el usuario es un usuario registrado con una sesión activa
 * en esta version para definir tal estado se basa en el hecho de su el valor de user es o no es anónimo.
 * @return bool
 */

if (!function_exists("safe_get_client")) {

    function safe_get_client()
    {
        $authentication = service('authentication');
        return ($authentication->get_Client());
    }

}


/**
 * Este método retorna falso o verdadero si el usuario es un usuario registrado con una sesión activa
 * en esta version para definir tal estado se basa en el hecho de su el valor de user es o no es anónimo.
 * @return bool
 */

if (!function_exists("get_LoggedIn")) {

    function get_LoggedIn()
    {
        $authentication = service('authentication');
        return ($authentication->get_LoggedIn());
    }

}

if (!function_exists("gpt_translate")) {

    function gpt_translate($string)
    {
        $api_key = "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";
        $url = "https://api.openai.com/v1/chat/completions";
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $api_key"
        );
        $data = array(
            "model" => "gpt-3.5-turbo",
            "messages" => array(
                array("role" => "system", "content" => "Actuaras como traductor experto y convertiras el texto recibido al idioma español, sin preguntas ni interacción con el usuario"),
                array("role" => "user", "content" => "traduce: " . $string)
            )
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'];

    }

}


if (!function_exists("safe_get_alias")) {

    function safe_get_alias()
    {
        $authentication = service('authentication');
        return ($authentication->get_Alias());
    }

}


if (!function_exists("get_logo")) {

    /**
     * Retorna el logo de la aplicacion
     * @param $type
     * @return false|string
     */
    function get_logo($type): false|string
    {
        $authentication = service('authentication');
        $logo = $authentication->get_Value($type);
        return (!empty($logo) ? cdn_url($logo) : false);
    }

}


if (!function_exists("get_theme_mode")) {

    function get_theme_mode()
    {
        $authentication = service('authentication');
        $mode = $authentication->get_ThemeMode();
        return (empty($mode) ? "theme-light" : $mode);
    }

}

if (!function_exists("get_rsignup")) {
    /**
     * Permite verificar si el actual inicio de sesion deriva del
     * acceso mediante un token de reset, en el tal caso la UI
     * emitira una advetencia visible mediante el uso del tpl
     * app/Views/smarty/bs5/assets/alerts/reset-access.tpl
     * en caso de ser positivo retornara true y automaticamente
     * eliminara de la sesion el estado del rsignup
     * por tal motivo el mensaje de advertencia se mostrara
     * una unica vez durante el proceso de reingreso a la app
     * en estado logueado.     *
     **/
    function get_rsignup()
    {
        $authentication = service('authentication');
        $rsignup = $authentication->get_Value("rsignup");
        if ($rsignup == "access") {
            $authentication->set("rsignup", false);
            return ("access");
        } elseif ($rsignup == "expired") {
            $authentication->set("rsignup", false);
            return ("expired");
        } else {
            return (false);
        }
    }

}


if (!function_exists("safe_get_user_avatar")) {

    function safe_get_user_avatar()
    {
        $authentication = service('authentication');
        return ($authentication->get_Avatar());
    }

}

if (!function_exists("get_domain")) {

    function get_domain()
    {
        $server = new Server();
        return ($server->get_FullName());
    }

}


if (!function_exists("safe_get_instance")) {

    function safe_get_instance()
    {
        $authentication = service('authentication');
        return ($authentication->get_Client());
    }

}

/**
 * Retorna el id de matomo del sitio
 */
if (!function_exists("get_matomo")) {

    function get_matomo()
    {
        $authentication = service('authentication');
        return ($authentication->get_Matomo());
    }

}


if (!function_exists("is_mobile")) {

    /**
     * Permite establecer si es tipo de dispositivo que se esta utilizando es un
     * PC tratese de computador de escritorio o portatil.
     * @return type
     */
    function is_mobile()
    {
        $device = new Devices();
        if ($device->isMobile()) {
            return (true);
        } else {
            return (false);
        }
    }

}

if (!function_exists("cdn_url")) {

    /**
     * Permite establecer si es tipo de dispositivo que se esta utilizando es un
     * PC tratese de computador de escritorio o portatil.
     *
     * @return type
     */
    function cdn_url($url)
    {
        $server = service('server');
        $cdn = "https://storage.googleapis.com/cloud-engine";
        //$cdn="https://cdn.alterplex.net";
        if ($server::is_Localhost()) {
            $url = "{$cdn}{$url}";
        } else {
            $url = "{$cdn}{$url}";
        }
        return ($url);
    }

}


if (!function_exists("is_tablet")) {

    /**
     * Permite establecer si es tipo de dispositivo que se esta utilizando es un
     * PC tratese de computador de escritorio o portatil.
     * @return type
     */
    function is_tablet()
    {
        $device = new Devices();
        if ($device->isTablet()) {
            return (true);
        } else {
            return (false);
        }
    }

}


if (!function_exists("generate_permissions")) {

    /**
     * El método "generate_permissions" es una función en PHP que genera permisos para un módulo específico. La función
     * toma dos argumentos, "$permissions" y "$module". En primer lugar, se crea un modelo de "Security_Permissions" en \
     * la carpeta "Models" dentro del módulo de seguridad. Luego, la función recorre el array "$permissions" y verifica si
     * el alias ya existe en la base de datos. Si el alias no existe, la función crea un nuevo registro en la base de datos
     * con los valores especificados en el array "$d". Todos los valores son convertidos a mayúsculas antes de ser insertados.
     * @method generate_permissions
     * @param array $permissions Log type
     * @param string $module
     * @return void
     * @throws ReflectionException
     */
    function generate_permissions($permissions, $module): void
    {
        $mpermissions = model("App\Modules\Security\Models\Security_Permissions", true);
        foreach ($permissions as $permission) {
            $dpermission = $mpermissions->get_PermissionByAlias($permission);
            if (!$dpermission) {
                $rpermission = $mpermissions->where("alias", $permission)->first();
                if (!is_array($rpermission)) {
                    $d = array(
                        "permission" => strtoupper(uniqid()),
                        "alias" => strtoupper($permission),
                        "module" => strtoupper($module),
                        "description" => "{$permission}_description",
                    );
                    $mpermissions->insert($d);
                    cache()->delete($mpermissions->get_CacheKey("permissions-{$d['alias']}"));
                }
            }
        }
    }

}

if (!function_exists("pk")) {

    function pk($len = 13)
    {
        if ($len == 13) {
            return (strtoupper(uniqid()));
        } else {
            return (strtoupper(substr(uniqid(), -$len)));
        }
    }

}

if (!function_exists("lpk")) {

    function lpk()
    {
        return (strtolower(pk()));
    }

}


/*
 * Registra en el historial las actividades de los Usuarios
 *
 *         $mhistory= model("App\Modules\History\Models\History_Logs", true);
        history_logger(array(
            "log" => $f->get_Value("log"),
            "module" => $f->get_Value("module"),
            "author" => $authentication->get_User(),
            "description" => $f->get_Value("description"),
            "code" => $f->get_Value("code"),
        ));
 *
 * */
if (!function_exists("history_logger")) {
    function history_logger($data)
    {
        $dates = service('Dates');
        $authentication = service('authentication');
        $server = service('Server');
        $data['stat'] = pk();
        $data['instance'] = $authentication->get_Client();
        $data['ip'] = $server->get_IPClient();
        $data['date'] = $dates->get_Date();
        $data['time'] = $dates->get_Time();
        $data['user'] = $authentication->get_User();
        $data['author'] = "SYSTEM";
        $mstats = model("App\Modules\History\Models\History_Stats", true);
        $create = $mstats->insert($data);
    }
}


if (!function_exists("get_application_copyright")) {

    function get_application_copyright()
    {
        $bootstrap = service('bootstrap');
        $code = "<p class=\"copyright m-0 p-0\"><b>Copyright 2018 - 2038</b> Todos los derechos reservados, se prohíbe su reproducción total o "
            . "parcial, así como su traducción a cualquier idioma sin la autorización escrita de su titular. "
            . "<a href=\"/policies/conditions\" class=\"link \">Términos y condiciones</a> | "
            . "<a href=\"/policies/privacy\" class=\"link \">Políticas de privacidad</a> | "
            . "<a href=\"/policies/advertising\" class=\"link \">Publicidad</a> | "
            . "<a href=\"/policies/cookies\" class=\"link \">Cookies</a> | "
            . "<a href=\"/policies/more\" class=\"link \">Más</a>"
            . "</p>";

        $card = $bootstrap->get_Card("card-view-service", array(
            "content" => $code,
        ));
        return ($card);
    }

}


if (!function_exists("get_application_badge_iso27000")) {

    function get_application_badge_iso27000()
    {
        $gridter = "";
        $c = "";
        $c .= ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-body\">"
            . "<img src=\"/themes/assets/logos/iso27000.png\" width=\"100%\">"
            . "</div>"
            . "</div>";
        return ($c);
    }

}

if (!function_exists("safe_has_permission")) {
    /**
     * Verifica si el usuario activo tiene el permiso indicado y considera este
     * resultado como valido durante 5 minutos por el cache.
     * Nota: La implementación de granted y denied se debe a que si se utilizan los
     * valores TRUE o FALSE, para almacenar en el cache y el resultado es FALSE
     * !$$xvar = cache($xvar) por defecto siempre se reconsultara la base datos
     * @param string $permission
     * @return bool
     */
    function safe_has_permission($permission)
    {
        $authentication = service('authentication');
        return ($authentication->has_Permission($permission));
    }

}


if (!function_exists("get_application_custom_sidebar")) {
    /**
     * Note: Para que un itm del menu sea visible con solo usuarios que tengan Authenticationa ctiva basta con ingresar
     * el parametro loggedin
     * @param $options
     * @param false $active_url
     * @return mixed
     */
    function get_application_custom_sidebar($options, $active_url = false)
    {
        $authentication = service('authentication');
        foreach ($options as $key => $value) {
            $options[$key]["href"] .= "";
            $options[$key]["target"] = isset($value["target"]) ? $value["target"] : "_self";
            $options[$key]["class"] = ($value["href"] == $active_url) ? "active" : "normal";
            if (isset($value["permission"]) && !empty($value["permission"])) {
                $permission = $authentication->has_Permission($value["permission"]);
                if ($permission == false) {
                    unset($options[$key]);
                }
            }
            if (isset($value["loggedin"]) && $value["loggedin"] === true) {
                $loggedin = $authentication->get_LoggedIn();
                if (!$loggedin) {
                    unset($options[$key]);
                }
            }
        }
        return ($options);
    }

}


if (!function_exists("get_application_sidebar")) {

    function get_application_sidebar($active_url = false)
    {
        $authentication = service('authentication');
        $mmodules = model('App\Models\Application_Modules');
        $mclientsxmodules = model('App\Models\Application_Clients_Modules');
        $client = $authentication->get_Client();

        $ioptions = array(
            "sgd" => array("text" => "SGD", "href" => "/sgd/", "permission" => "SGD-ACCESS", "icon" => ICON_ISO),
            "c4isr" => array("text" => "C4ISR", "href" => "/c4isr/", "permission" => "C4ISR-ACCESS", "svg" => "hacker.svg"),
            "databreaches" => array("text" => "Brechas de Seguridad", "href" => "/databreaches/", "permission" => "DATABREACHES-ACCESS", "svg" => "hacker.svg"),
            "characterize" => array("text" => "Caracteriza", "href" => "/characterize/", "permission" => "CHARACTERIZE-ACCESS", "icon" => "fa-solid fa-poll-people"),
            "crm" => array("text" => "Atención al público", "href" => "/crm/", "permission" => "CRM-ACCESS", "icon" => "fa-solid fa-poll-people"),
            "cadastre" => array("text" => "Catastro", "href" => "/cadastre/", "permission" => "CADASTRE-ACCESS", "icon" => "fa-solid fa-poll-people"),
            "development" => array("text" => "Desarrollo", "href" => "/development/", "permission" => "DEVELOPMENT-ACCESS", "icon" => "fas fa-code"),
            "helpdesk" => array("text" => "HelpDesk", "href" => "/helpdesk/home/index/" . lpk(), "permission" => "HELPDESK-ACCESS", "icon" => ICON_HELPDESK),
            "mipg" => array("text" => "MiPG", "href" => "/mipg/", "permission" => "MIPG-ACCESS", "icon" => ICON_ISO),
            "disa" => array("text" => "DISA(OLD)", "href" => "/disa/", "permission" => "MIPG-ACCESS", "icon" => ICON_ISO),
            "iso9001" => array("text" => "ISO9001:2015", "href" => "/iso9001/", "permission" => "ISO9001-ACCESS", "icon" => ICON_ISO),
            "iso14001" => array("text" => "ISO14001:2015", "href" => "/iso14001/", "permission" => "ISO14001-ACCESS", "icon" => ICON_ISO),
            "iso27001" => array("text" => "ISO/IEC27001:2013", "href" => "/iso27001/", "permission" => "ISO27001-ACCESS", "icon" => ICON_ISO),
            "iso45001" => array("text" => "ISO45001:2018", "href" => "/iso45001/", "permission" => "ISO45001-ACCESS", "icon" => ICON_ISO),
            "tdp" => array("text" => "Desarrollo Territorial", "href" => "/tdp/", "permission" => "TDP-ACCESS", "icon" => ICON_ISO),
            //"siac" => array("text" => "SiAC", "href" => "/siac/", "permission" => "DISA-ACCESS", "icon" => "fas fa-university"),
            "nexus" => array("text" => Lang("App.Nexus"), "href" => "/nexus/", "permission" => "NEXUS-ACCESS", "icon" => "far fa-location"),
            "networks" => array("text" => Lang("App.Networks"), "href" => "/networks/", "permission" => "NETWORKS-ACCESS", "icon" => "far fa-location"),
            "messenger" => array("text" => "Mensajería", "href" => "/messenger", "icon" => "far fa-badge-dollar", "permission" => "MESSENGER-ACCESS"),
            "organization" => array("text" => Lang("App.Organization"), "href" => "/organization/", "permission" => "ORGANIZATION-ACCESS", "icon" => ICON_ORGANIZATION),
            //"orders" => array("text" => Lang("App.Orders"), "href" => "/orders/", "permission" => "ORDERS-ACCESS", "icon" => "fal fa-clipboard-list-check"),
            "plans" => array("text" => Lang("App.Plans"), "href" => "/plans/", "permission" => "PLANS-ACCESS", "icon" => ICON_PLANS),
            //"pqrs" => array("text" => Lang("App.PQRS"), "href" => "/pqrs/", "permission" => "PQRS-ACCESS", "icon" => "far fa-user-headset"),
            "social" => array("text" => Lang("App.Social"), "href" => "/social/", "permission" => "SOCIAL-ACCESS", "icon" => "far fa-home"),
            "spa" => array("text" => Lang("App.Spa"), "href" => "/spa/", "permission" => "SPA-ACCESS", "icon" => "far fa-home"),
            //"acredit" => array("text" => Lang("App.Acredit"), "href" => "/acredit/", "permission" => "ACREDIT-ACCESS", "icon" => "far fa-badge-dollar"),
            //"concerts" => array("text" => Lang("App.Concerts"), "href" => "/concerts/", "permission" => "CONCERTS-ACCESS", "icon" => "far fa-ticket-alt"),
            "history" => array("text" => Lang('App.History'), "href" => "/history", "icon" => "far fa-history", "permission" => "HISTORY-ACCESS"),
            "wallet" => array("text" => "Billetera", "href" => "/wallet", "icon" => "far fa-badge-dollar", "permission" => "WALLET-ACCESS"),
            "sedux" => array("text" => "Edux", "href" => "/edux", "icon" => "far fa-badge-dollar", "permission" => ""),
            "sie" => array("text" => "Plataforma SIE", "href" => "/sie", "icon" => "fa-regular fa-graduation-cap", "permission" => "SIE-ACCESS"),
            "screens" => array("text" => Lang("App.Screens"), "href" => "/screens/home/index/" . lpk(), "permission" => "SCREENS-ACCESS", "icon" => ICON_SCREENS),
            "manager" => array("text" => Lang("App.Manager"), "href" => "/manager/home/index/" . lpk(), "permission" => "MANAGER-ACCESS", "icon" => ICON_MANAGER),
            "security" => array("text" => Lang("App.Security"), "href" => "/security/home/" . lpk(), "permission" => "SECURITY-ACCESS", "icon" => "far fa-shield-check"),
            "firewall" => array("text" => Lang("App.Firewall"), "href" => "/firewall", "permission" => "FIREWALL-ACCESS", "icon" => ICON_FIREWALL),
            "storage" => array("text" => Lang("App.Storage"), "href" => "/storage/home/index/" . lpk(), "permission" => "STORAGE-ACCESS", "icon" => ICON_STORAGE),
            "plex" => array("text" => Lang("App.Plex"), "href" => "/plex", "permission" => "PLEX-ACCESS", "icon" => ICON_PLEX),
            "intelligence" => array("text" => Lang("App.Intelligence"), "href" => "/intelligence", "permission" => "INTELLIGENCE-ACCESS", "icon" => ICON_INTELLIGENCE),
            "settings" => array("text" => Lang("App.Settings"), "href" => "/settings", "permission" => "SETTINGS-ACCESS", "icon" => ICON_SETTINGS),
        );

        $options = array();
        foreach ($ioptions as $key => $value) {
            $module = $mmodules->get_ModuleByAlias($key);
            if ($module != 'unknown') {
                $cxm = $mclientsxmodules->get_CachedAuthorizedClientByModule($client, $module);
                if ($cxm == "authorized") {
                    $options[$key] = $value;
                }
            }
        }
        $return = get_application_custom_sidebar($options, $active_url);
        return ($return);
    }

}


if (!function_exists("safe_dump")) {

    function safe_dump($mixed = null, $format = true)
    {
        ob_start();
        var_dump($mixed);
        $content = ob_get_clean();
        if ($format) {
            $content = "<pre>" . htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE) . "</pre>";
        }
        return $content;
    }

}


/**
 * Check JSON validity
 * @method valid_json
 * @param mixed $var Variable to check
 * @return bool
 */

if (!function_exists("safe_dump")) {
    function valid_json($var)
    {
        return (is_string($var)) && (is_array(json_decode($var,
            true))) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}

if (!function_exists('valid_jwt')) {

    /**
     * Check JWT validity
     * @method valid_jwt
     * @param mixed $token Variable to check
     * @return Object/false
     */
    function valid_jwt($token)
    {
        return AUTHORIZATION::validateToken($token);
    }
}

/**
 * Codeigniter Websocket Library: helper file
 */
if (!function_exists('output')) {

    /**
     * Output valid or invalid logs
     * @method output
     * @param string $type Log type
     * @param string $var String
     * @return string
     */
    function output($type = 'success', $output = null)
    {
        if ($type == 'success') {
            CLI::write($output, 'green');
        } elseif ($type == 'error') {
            CLI::write($output, 'red');
        } elseif ($type == 'fatal') {
            CLI::write($output, 'red');
            exit(EXIT_ERROR);
        } else {
            CLI::write($output, 'green');
        }
    }
}


if (!function_exists('base64_url_encode')) {
    /**
     * El metodo base64_url_encode es una función personalizada que codifica una cadena de entrada utilizando el
     * algoritmo base64 y luego sustituye algunos caracteres para hacer la salida compatible con las URL. La función
     * toma una entrada $input y realiza los siguientes pasos:
     * 1) Codifica la entrada en base64 usando la función base64_encode().
     * 2) Sustituye el caracter + por - y el caracter / por _ usando la función strtr().
     * 3) Elimina cualquier caracter de padding = al final de la cadena utilizando la función rtrim().
     * 4) Devuelve la cadena codificada resultante.
     * La razón detrás de la sustitución de caracteres es que algunos caracteres en la codificación base64 pueden no
     * ser seguros para su uso en una URL. Al cambiar estos caracteres a otros más seguros, se asegura que la cadena
     * codificada resultante sea compatible con la URL.
     * @param $input
     * @return string
     */
    function base64_url_encode($input)
    {
        return (rtrim(strtr(base64_encode($input), '+/', '-_'), '='));
    }
}

if (!function_exists('base64_url_decode')) {
    /**
     * La función base64_url_decode se utiliza para decodificar una cadena de texto que ha sido codificada previamente
     * mediante el método base64_url_encode. Esta función realiza los siguientes pasos:
     * 1) Reemplaza los caracteres especiales -_ por los caracteres +/ que son utilizados por el método base64_encode.
     * 2) Agrega padding (=) al final de la cadena de entrada para que su longitud sea divisible por 4.
     * 3) Utiliza la función base64_decode para decodificar la cadena de entrada.
     * La función devuelve la cadena decodificada en su forma original.
     * @param $input
     * @return false|string
     */
    function base64_url_decode($input)
    {
        return base64_decode(str_pad(strtr($input, '-_', '+/'), strlen($input) % 4, '=', STR_PAD_RIGHT));
    }
}

if (!function_exists('safe_send-email')) {
    /**
     * Este método permite enviar un correo electrónico de manera segura utilizando la librería.
     *
     */
    function safe_send_email($args)
    {
        $mmessages = model("App\Modules\Messenger\Models\Messenger_Messages");
        $d = array(
            "message" => pk(),
            "type" => $args["type"],
            "from" => $args["from"],
            "to" => $args["to"],
            "subject" => $args["subject"],
            "content" => $args["content"],
            "priority" => $args["priority"],
            "date" => safe_get_date(),
            "time" => safe_get_time(),
            "author" => safe_get_user(),
        );
        $create = $mmessages->insert($d);
    }

    if (!function_exists('safe_substr')) {
        function safe_substr($string, $start, $length = null)
        {
            if (is_null($string)) {
                return '';
            }
            return substr($string, $start, $length);
        }
    }


    if (!function_exists('safe_js_title')) {
        /**
         * Pone titulo a la pagina de manera segura usando javascript
         * @param $string
         * @return void
         */
        function safe_js_title($string)
        {
            $code = "<script>";
            $code .= "document.addEventListener('DOMContentLoaded', function () {document.title =\"$string\";});";
            $code .= "</script>";
            echo($code);
        }
    }
}

if (!function_exists('safe_round')) {
    /**
     * Redondea un valor de forma segura y devuelve siempre una cadena
     *
     * Esta función es una versión robusta de round() que maneja múltiples tipos de entrada
     * y garantiza que siempre devuelve una cadena sin generar errores.
     *
     * @param float|int|string|null $num El valor a redondear
     * @param int $precision Número de dígitos decimales (puede ser negativo)
     * @param int $mode Modo de redondeo (PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, etc.)
     * @return string El valor redondeado como cadena, o cadena vacía si hay error
     *
     * @example
     * // Redondeo básico con precisión positiva
     * safe_round(12.345, 2);              // "12.35"
     * safe_round(12.345, 1);              // "12.3"
     * safe_round(12.345, 0);              // "12"
     *
     * @example
     * // Redondeo con precisión negativa (decenas, centenas, etc.)
     * safe_round(1234.5, -1);             // "1230"
     * safe_round(1234.5, -2);             // "1200"
     * safe_round(1234.5, -3);             // "1000"
     *
     * @example
     * // Manejo de strings con formato numérico
     * safe_round("12.345", 2);            // "12.35"
     * safe_round("12,345", 2);            // "12.35" (convierte coma a punto)
     * safe_round("  12.345  ", 2);        // "12.35" (elimina espacios)
     * safe_round("$12.345", 2);           // "12.35" (elimina símbolos)
     *
     * @example
     * // Diferentes modos de redondeo
     * safe_round(12.5, 0, PHP_ROUND_HALF_UP);    // "13" (redondea hacia arriba)
     * safe_round(12.5, 0, PHP_ROUND_HALF_DOWN);  // "12" (redondea hacia abajo)
     * safe_round(12.5, 0, PHP_ROUND_HALF_EVEN);  // "12" (redondea al par más cercano)
     * safe_round(12.5, 0, PHP_ROUND_HALF_ODD);   // "13" (redondea al impar más cercano)
     *
     * @example
     * // Manejo seguro de valores inválidos (devuelve cadena vacía)
     * safe_round(null, 2);                // ""
     * safe_round("", 2);                  // ""
     * safe_round("texto", 2);             // ""
     * safe_round("abc123", 2);            // ""
     * safe_round(INF, 2);                 // "" (infinito)
     * safe_round(NAN, 2);                 // "" (no es un número)
     *
     * @example
     * // Casos especiales
     * safe_round(0, 2);                   // "0.00"
     * safe_round(-12.345, 2);             // "-12.35"
     * safe_round(12, 2);                  // "12.00" (añade decimales)
     */
    function safe_round($num, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): string
    {
        // Validar que $num no sea null o vacío
        if ($num === null || $num === '') {
            return '';
        }

        // Si es string, intentar convertir a float
        if (is_string($num)) {
            // Limpiar el string: remover espacios y convertir coma a punto
            $num = str_replace(',', '.', trim($num));
            $num = preg_replace('/[^\d.-]/', '', $num);

            // Validar que sea un número válido
            if (!is_numeric($num)) {
                return '';
            }

            $num = (float)$num;
        }

        // Validar que sea un número (int o float)
        if (!is_numeric($num)) {
            return '';
        }

        // Convertir a float si es int
        $num = (float)$num;

        // Validar que no sea infinito o NaN
        if (!is_finite($num)) {
            return '';
        }

        // Validar modo de redondeo
        $valid_modes = [
            PHP_ROUND_HALF_UP,
            PHP_ROUND_HALF_DOWN,
            PHP_ROUND_HALF_EVEN,
            PHP_ROUND_HALF_ODD
        ];

        if (!in_array($mode, $valid_modes, true)) {
            $mode = PHP_ROUND_HALF_UP;
        }

        // Intentar redondear con manejo de errores
        try {
            $rounded = round($num, $precision, $mode);

            // Formatear según la precisión solicitada
            if ($precision >= 0) {
                return number_format($rounded, $precision, '.', '');
            } else {
                // Para precisión negativa, simplemente convertir a string
                return (string)$rounded;
            }
        } catch (\Throwable $e) {
            // En caso de cualquier error, devolver cadena vacía
            return '';
        }
    }
}


if (!function_exists('safe_module_modal')) {
    function safe_module_modal()
    {
        $mmodules = model("App\\Models\\Application_Modules");
        $mclientmodules = model("App\\Models\\Application_Clients_Modules");
        $client = safe_get_client();

        $modules = $mclientmodules->getCachedAuthorizedModulesByClient($client);

        $code = "<!-- Modal de Módulos -->\n";
        $code .= "<div class=\"modal fade\" id=\"higgs-options-modules\" tabindex=\"-1\" aria-labelledby=\"higgs-options-modules-label\" aria-hidden=\"true\">\n";
        $code .= "\t\t<div class=\"modal-dialog modal-xl modal-dialog-centered\">\n";
        $code .= "\t\t\t\t<div class=\"modal-content\">\n";
        $code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
        $code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"modulesModalLabel\">\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-cubes me-2\"></i> Módulos Disponibles\n";
        $code .= "\t\t\t\t\t\t\t\t</h5>\n";
        $code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
        $code .= "\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
        $code .= "\t\t\t\t\t\t\t\t<div class=\"container-fluid p-0\">\n";

        $code .= "<div class=\"input-group mb-4\">\n";
        $code .= "\t <span class=\"input-group-text bg-secondary text-white\">\n";
        $code .= "\t\t <i class=\"fas fa-search\"></i>\n";
        $code .= "\t </span>\n";
        $code .= "\t <input type=\"text\" id=\"higgs-input-module-search\" class=\"form-control\" placeholder=\"Buscar módulos...\">\n";
        $code .= "</div>\n";


        $code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"row g-6\">\n";
        foreach ($modules as $module) {
            if (!empty($module["module"])) {
                if (safe_has_permission("{$module['alias']}-ACCESS")) {
                    $title = lang("Modules." . $module["title"]);
                    $alias = safe_strtolower($module["alias"]);

                    $iconPath = "/themes/assets/icons/png/" . strtolower(@$module['alias']) . "-128x128.png";
                    $icon = file_exists($_SERVER['DOCUMENT_ROOT'] . $iconPath) ? $iconPath : "/themes/assets/icons/application.svg";

                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<!-- Módulo 1 -->\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-sm-2 mb-3 module-item\">\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"card module-card shadow-sm\">\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"card-body p-2\">\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<img src=\"{$icon}?v54\" class=\"img-responsive opacity-10\" style=\"width:86px;height:86px;\">\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t <a href=\"/{$alias}\" class=\"mt-1 stretched-link text-decoration-none\">";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"card-title\">{$title}</h5>\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t </a>\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
                    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
                }
            }
        }
        //Mensaje cuando no hay resultados
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div id=\"noResults\" class=\"text-center p-4 hidden\">\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-search fa-3x text-muted mb-3\"></i>\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<h4 class=\"text-muted\">No se encontraron módulos</h4>\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"text-muted\">Intenta con otra palabra clave</p>\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";

        $code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t<div class=\"modal-footer justify-content-between\">\n";
        $code .= "\t\t\t\t\t\t\t\t<div>\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-outline-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>\n";
        $code .= "\t\t\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t\t\t<div>\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t<button id=\"btn-modal-modules-refresh\" type=\"button\" class=\"btn btn-primary\" >\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-sync-alt me-1\"></i> Actualizar\n";
        $code .= "\t\t\t\t\t\t\t\t\t\t</button>\n";
        $code .= "\t\t\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t\t\t</div>\n";
        $code .= "\t\t\t\t</div>\n";
        $code .= "\t\t</div>\n";
        $code .= "</div>\n";
        return ($code);
    }
}


if (!function_exists('theme_asset')) {
    /**
     * Genera la URL de un asset de un theme
     *
     * @param string $themeName Nombre del theme
     * @param string $assetPath Ruta del asset
     * @return string URL completa
     */
    function theme_asset(string $themeName, string $assetPath): string
    {
        return base_url("ui/themes/{$themeName}/{$assetPath}");
    }
}

if (!function_exists('current_theme_asset')) {
    /**
     * Genera la URL de un asset del theme actual
     *
     * @param string $assetPath Ruta del asset
     * @return string URL completa
     */
    function current_theme_asset(string $assetPath): string
    {
        // Aquí puedes obtener el theme actual desde la configuración
        $currentTheme = config('App')->theme ?? 'gamma';
        return theme_asset($currentTheme, $assetPath);
    }
}

?>