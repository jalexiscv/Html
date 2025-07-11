<?php

class User
{
    public $logged = false;

    public function __construct()
    {
        $this->testLogin();
    }

    private function testLogin()
    {
        if (isset($_POST["command"])) {
            $part = explode(" ", $_POST["command"]);
            if ($part[0] == 'login') {
                if (count($part) == 3) {
                    $this->login($part[1], $part[2], $_POST["token"], true);
                } else {
                    $this->abort('Error de sintaxis: Para inciar sesión utilice "login <username> <password>"');
                }
            } else {
                if (isset($_SESSION["user"]["username"]) && isset($_SESSION["user"]["password"])) {
                    $this->login($_SESSION["user"]["username"], $_SESSION["user"]["password"], $_POST["token"]);
                } else {
                    $this->abort('Debe estar logueado para utilizar el terminal. Para inciar sesión utilice "login <username> <password>"');
                }
            }
        }
    }

    public function login($username, $password, $token, $post = false)
    {
        //TEMPORAL USER AND PASSWORD
        $user["username"] = "test";
        $user["password"] = "test";
        $user["token"] = "zxcasd2";

        if ($username == $user["username"] && $password == $user["password"]) {
            if ($token == $user["token"]) {
                $this->logged = true;
                if ($post) {
                    $_SESSION["user"]["username"] = $username;
                    $_SESSION["user"]["password"] = $password;
                    $_SESSION["user"]["token"] = $user["token"];

                    $this->abort('Hola ' . $username . '! Bienvenido al terminal');
                }
            } else {
                if ($post) {
                    $this->logged = true;
                    $_SESSION["user"]["username"] = $username;
                    $_SESSION["user"]["password"] = $password;
                    $_SESSION["user"]["token"] = $user["token"];
                    $this->abort('Hola ' . $username . '! Bienvenido al terminal', array("token" => $user["token"]));
                } else {
                    $this->abort('Su sesión ha caducado. Vuelva a iniciar sesión "login <username> <password>"');
                }
            }
        } else {
            $this->abort('Usuario o contraseña incorrectos. Para inciar sesión utilice "login <username> <password>"');
        }
    }

    private function abort($message, $header = array())
    {
        $result = array("data" => "\n		[[ib;#FFF;<BACKGROUND>]" . $message . "]\n",
            "header" => $header);
        echo json_encode($result);
        die();
    }

    public function logout()
    {

    }
}

?>