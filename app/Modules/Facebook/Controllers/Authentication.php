<?php

namespace App\Modules\Facebook\Controllers;

use App\Controllers\BaseController;


class Authentication extends BaseController
{

    private $facebook;

    function __construct()
    {
        parent::__construct();
        $this->Authentication = service('authentication');
        $this->facebook = new \App\Libraries\Facebook();
    }

    public function index()
    {
        $data = array(
            "facebook" => $this->facebook,
            "authentication" => $this->authentication,
            "token" => $this->facebook->is_authenticated()
        );
        if ($data["token"]) {
            $c = view('App\Modules\Facebook\Views\Authentication\isauthenticated', $data);
        } else {
            $c = view('App\Modules\Facebook\Views\Authentication\connect', $data);
        }
        echo($c);
    }

    public function fblogout()
    {
        $this->facebook->destroy_Authentication();
        $this->Authentication->logout();
        redirect('/facebook/authentication/');
    }

    public function logout()
    {
        // Remove local Facebook Authentication
        $this->facebook->destroy_Authentication();
        // Remove user data from Authentication
        $this->Authentication->logout();
        // Redirect to login page
        redirect('/');
    }

}

?>