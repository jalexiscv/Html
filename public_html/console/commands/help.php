<?php

class help extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init($params)
    {
        $result = "\n[[;#F00;<BACKGROUND>]Estas órdenes del shell están definidas internamente.  Teclee 'help nombre' para saber más sobre la función 'nombre']\n";
        if (isset($params[1])) {
            //AYUDA EXTENDIDA DE UN COMANDO
            $pError = $this->syntaxError($params, 1);
            if (!$pError) $result .= $this->moreHelp($params[1]);
            else $result = $pError;
        } else {
            $dir = opendir("commands");

            $result .= "\n		[[ib;#FFF;<BACKGROUND>]help ->] " . $this::$info;
            while ($file = readdir($dir)) {
                if (!is_dir($file) && $file != 'help.php') {
                    include($file);
                    $file = rtrim($file, '.php');
                    $result .= "\n		[[ib;#FFF;<BACKGROUND>]" . $file . " ->] " . $file::$info;
                }
            }
        }
        $this->data = $result . "\n";
    }

    public function moreHelp($command)
    {
        $result = "";
        if (file_exists($this->folder . $command . ".php")) {
            include($this->folder . $command . ".php");
            $result .= "\n		[[ib;#FFF;<BACKGROUND>]" . $command . " ->] " . command::help();
        } else {
            $result .= "\n		[[ib;#FFF;<BACKGROUND>]" . $command . " ->] El comando introducido no existe";
        }
        return $result;
    }
}

?>