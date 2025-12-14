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
 * @Version 2.0.0
 * @since PHP 7, PHP 8
 */
/*
 * Params, Parameter Container - klasa obslugi parametrow metod
 */

class Params implements \ArrayAccess, \IteratorAggregate
{
    protected $initContent;
    protected $content;

    //utworzenie poprzez przekazanie tablicy zawierajacej pary: nazwa parametru=>wartosc
    public function __construct($a)
    {
        $this->content = $this->initContent = $a;
    }

    //zwraca kopie obiektu, uzupelniajac podanymi wartosciami
    public function getClone($a = array())
    {
        $clone = clone($this);
        $clone->set($a);
        return $clone;
    }

    //ustawienie domyslnych wartosci dla niezdefiniowanych parametrow

    public function set($params, $value = null)
    {
        if (is_array($params)) {
            //tablica
            foreach ($params as $pi => $p)
                $this->content[$pi] = $p;
        } else $this->content[$params] = $value;

        return $this;
    }

    //ustawienie wartosci parametrow (argumenty: para klucz-wartosc lub tablica)

    public function setParams($obligatory, $additional)
    {

        //sprawdzenie parametrow obowiazkowych
        foreach ($obligatory as $o) {
            if (!array_key_exists($o, $this->content)) {
                trigger_error('Params::setParams: Required parameters not passed (' . $o . ')', E_USER_ERROR);
            }
            $additional[$o] = $this->content[$o];
        }
        //nadpisanie parametrow domyslnych przez zdefiniowane
        foreach ($this->content as $ci => $c) {
            if (array_key_exists($ci, $additional)) {
                $additional[$ci] = $c;
            }
        }

        $this->content = $additional;

        return $this;
    }

    //ustawienie wartosci pierwszego indeksu w parametrze-tablicy

    public function setArray($key, $offset, $value)
    {
        $this->content[$key][$offset] = $value;
    }

    //zwrocenie wartosci parametru

    public function isDefault($key)
    {
        return !array_key_exists($key, $this->initContent);
    }

    public function offsetExists($offset)
    {
        return $this->get($offset) !== null;
    }

    //ArrayAccess

    public function get($i)
    {
        return isset($this->content[$i]) ? $this->content[$i] : null;
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->content[$offset]);
    }

    //IteratorAggregate
    public function getIterator()
    {
        return new \ArrayIterator($this->content);
    }

}