<?php
/*
 * Copyright (c) 2021-2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\Web\Controllers;

use App\Controllers\ModuleController;

class Seo extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        helper('App\Modules\Web\Helpers\Web');
        $this->prefix = 'web';
        $this->module = 'App\Modules\Web';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Home';
    }

    /**
     * https://www.bing.com/indexnow?url=https://wikiverso.com/web/semantic/drama-llegar-europa-64f64d614d0fa.html&key=87da8f6428e4486591d10c241046c919
     * @param string $oid
     * @return array|false|mixed|string
     */
    public function indexnow(string $oid)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.bing.com/indexnow?url=https://wikiverso.com/web/semantic/drama-llegar-europa-64f64d614d0fa.html&key=87da8f6428e4486591d10c241046c919');
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $resultado = curl_exec($curl);
        curl_close($curl);
        $resultado_json = json_decode($resultado, true);
        echo $resultado_json;
    }


}

?>