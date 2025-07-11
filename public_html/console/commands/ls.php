<?php

class ls extends Command
{
    private $home = "home/";

    public function __construct()
    {
        parent::__construct();
    }

    public function init($params)
    {
        if (count($params) > 0) {
            $this->listFiles($params);
        } else {
            $r = $this->home . $_SESSION["user"]["username"];
            if ($d = opendir($r)) {
                $this->data .= "\n";
                while (false !== ($e = readdir($d))) {
                    if ($e != '.' && ($e != '..')) {
                        if (is_dir($r . '/' . $e)) {
                            $this->data .= "			d	[[b;#88F;]" . $e . "]\n";
                        } else {
                            $this->data .= "			f	" . $e . "\n";
                        }
                    }
                }
                closedir($d);
            }
        }
    }

    private function listFiles($params)
    {
        $result = null;

        $pError = $this->syntaxError($params, 1);
        if (!$pError) $result .= "";
        else $result = $pError . "\n";

        $this->data = $result;
    }
}

?>