<?php

namespace App\Controllers;

class Logout extends BaseController
{

    public function index()
    {
        $this->session->logout();
        $url = base_url($this->session->get_ClientDefaultURL());
        return (redirect()->to($url));
    }

}
