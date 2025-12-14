<?php

class Smarty_Internal_Method_ClearConfig
{
    public $objMap = 7;

    public function clearConfig(Smarty_Internal_Data $data, $name = null)
    {
        if (isset($name)) {
            unset($data->config_vars[$name]);
        } else {
            $data->config_vars = array();
        }
        return $data;
    }
}