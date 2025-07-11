<?php


class Products
{
    public function __construct()
    {

    }

    /**
     * Este metodo se encarga de listar los productos vendibles
     * @param $typo string representa el tipo de productos que deseo listar
     * @return array de productos
     */
    public function get_Products($typo)
    {
        $products = array();
        echo("Listado de productos vendibles tipo {$typo}...<br>");
        return ($products);
    }


    public function get_Color($string)
    {
        echo("Color de un producto {$string}...<br>");
    }


    public function get_Price($string)
    {
        echo("Precio de un producto {$string}...<br>");
    }


    public function set_Price($string)
    {
        echo("Establecer precio de un producto {$string}...<br>");
    }


}

?>