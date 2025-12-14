<?php

namespace App\Libraries;
/**
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
 *  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
 * -----------------------------------------------------------------------------
 * Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
 * Este archivo es parte de Higgs Bigdata Framework 7.1
 * Para obtener información completa sobre derechos de autor y licencia, consulte
 * la LICENCIA archivo que se distribuyó con este código fuente.
 * -----------------------------------------------------------------------------
 * EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER RECLAMO, DAÑOS U OTROS
 * RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO O DE OTRO MODO, QUE SURJA
 * DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE O EL USO U OTROS
 * NEGOCIACIONES EN EL SOFTWARE.
 * -----------------------------------------------------------------------------
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.Higgs.com
 * @Version 1.0.0
 * @since PHP 7, PHP 8
 */

require_once(APPPATH . 'ThirdParty/Smarty/libs/Smarty.class.php');

class Smarty extends \Smarty
{

    protected $config;

    public function __construct()
    {
        parent::__construct();
        $this->template_dir = APPPATH . 'Views/smarty/default';
        $this->compile_dir = WRITEPATH . 'smarty/compiled';
        $this->config_dir = WRITEPATH . 'smarty/caches';
        $this->cache_dir = WRITEPATH . 'smarty/configs';
        $this->force_compile = true;
        $this->caching = \Smarty::CACHING_LIFETIME_CURRENT;
        $this->cache_lifetime = 5;
    }

    /**
     * Permite seleccionar el tipo de template a usar en referencia al bootstrap o cualquier otra tecnología
     * implementada.
     * @param $bootstrap
     */
    public function set_Mode($bootstrap)
    {
        if ($bootstrap == "bs5x") {
            $this->setTemplateDir(APPPATH . 'Views/smarty/bs5');
            $this->setPluginsDir(APPPATH . 'Views/smarty/bs5/plugins');
        } elseif ($bootstrap == "webbar") {
            $this->setTemplateDir(APPPATH . 'Views/smarty/webbar');
            $this->setPluginsDir(APPPATH . 'Views/smarty/webbar/plugins');
        } elseif ($bootstrap == "fair") {
            $this->setTemplateDir(APPPATH . 'Views/smarty/fair');
            $this->setPluginsDir(APPPATH . 'Views/smarty/fair/plugins');
        } elseif ($bootstrap == "zs2022") {
            $this->setTemplateDir(APPPATH . 'Views/smarty/zs2022');
            $this->setPluginsDir(APPPATH . 'Views/smarty/zs2022/plugins');
        } else {
            //$this->setTemplateDir(APPPATH . 'Views/smarty/default');
        }
    }

    public function view(string $view, array $options = null)
    {
        $result = $this->fetch($view);
        return $result;
    }

    public function setData(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->assign($key, $value);
        }
        return ($this);
    }

}

?>