<?php

namespace App\Libraries;

if (!class_exists("App\Libraries\Server")) {

    class Server
    {

        /**
         * Retorna la IP del cliente visitante.
         * @return mixed
         */
        public function get_IPClient()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
            }
            return ($ip);
        }

        /**
         * Dirección de la pagina (si la hay) que emplea el agente de usuario para la pagina actual. Es definido
         * por el agente de usuario. No todos los agentes de usuarios lo definen y algunos permiten modificar
         * HTTP_REFERER como parte de su funcionalidad. En resumen, es un valor del que no se puede
         * confiar realmente.
         * @return type
         */
        public static function get_Referer()
        {
            if (isset($_SERVER["HTTP_REFERER"])) {
                return ($_SERVER["HTTP_REFERER"]);
            } else {
                return ("/");
            }
        }

        /**
         * Retorna el nombre del host del servidor donde se está ejecutando actualmente el script. Si el script se
         * ejecuta en un host virtual se obtendrá el valor del nombre definido para dicho host virtual.
         * @return type
         */
        private static function _get_ServerName()
        {
            // Fallo al usar server name al cambiar de php55 a 72
            //return($_SERVER['SERVER_NAME']);
            if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
                $r = (strtolower($_SERVER['HTTP_HOST']));
            } else {
                $r = (strtolower($_SERVER['SERVER_NAME']));
            }
            if ($r == "127.0.0.1") {
                $r = "localhost.com";
            }
            return ($r);
        }

        /**
         * Retorna el nombre completo del servidor es decir sin www .
         * @return type
         */
        public static function get_FullName()
        {
            $server = self::_get_ServerName();
            return ($server);
        }


        /**
         * Retorna el nombre simple del servidor es decir sin www .
         * @return type
         */
        public static function get_Name()
        {
            $servername = self::_get_ServerName();
            $server = str_replace("www.", "", $servername);
            return ($server);
        }


        /**
         * Retorna el nombre simple del servidor es decir sin www ni extencion comercial
         * @return type
         */
        public static function get_Named()
        {
            $servername = self::_get_ServerName();
            $server = str_replace("www.", "", $servername);
            $e = explode(".", $server);
            return ($e[0]);
        }

        /**
         * Retorna el entorno en el cual se encuentra el servidor que esta ejecutando la aplicacion
         * Puede cargar distintos archivos de configuración en el entorno actual. La constante ENVIRONMENT
         * está definida en  index.php, y se describe en detalle en la sección Manejar Varios Entornos.
         * @return type
         */
        public static function get_Environment()
        {
            if (self::_get_ServerName() == "localhost") {
                return ("development");
            } else {
                return ("production");
            }
        }

        /**
         * Verifica si el script PHP se está ejecutando en un entorno local (localhost).
         * Este método comprueba el nombre del servidor en la superglobal $_SERVER para determinar si el script
         * se está ejecutando en localhost.
         * @return bool Devuelve true si el script se está ejecutando en localhost, o false si se está ejecutando
         * en un servidor remoto.
         */
        public static function is_Localhost()
        {
            $serverName = $_SERVER['SERVER_NAME'];
            if (strpos($serverName, 'localhost') !== false || $serverName == '127.0.0.1') {
                return (true);
            } else {
                return (false);
            }
        }


        public function get_DirectorySize($directory):float
        {
            $size = 0;

            // Open the directory
            if ($handler = opendir($directory)) {
                // Iterate over files and sub-directories
                while (false !== ($file = readdir($handler))) {
                    // Exclude directory entries "." and ".."
                    if ($file != "." && $file != "..") {
                        $filePath = $directory . '/' . $file;

                        // If it's a directory, calculate its size recursively
                        if (is_dir($filePath)) {
                            $size += $this->get_DirectorySize($filePath);
                        } else {
                            // If it's a file, add its size
                            $size += filesize($filePath);
                        }
                    }
                }
                closedir($handler);
            }

            return $size;
        }

        public function getURL(){
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
            $host = urlencode($_SERVER['HTTP_HOST']);
            return $protocol . $host;
        }


    }

}
?>