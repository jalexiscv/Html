<?php

namespace App\Libraries;

if (!class_exists("App\Libraries\Grid")) {
    /**
     * Class Grid
     * @package App\Libraries
     *
     * https://examples.bootstrap-table.com/
     * $grid = new \App\Libraries\Grid(array(
     *      "id" => "table-" . pk(),
     *      "side_pagination" => "server",
     *      "ajax" => "/security/policies/ajax/list/{$id}/" . lpk(),
     *      "create" => "/security/users/create/",
     *      "cols" => array(
     *      "status" => array("text"=>lang("App.Status"),"align" =>"center"),
     *      "permission" => array("text"=>lang("App.Permission"),"align" =>"center"),
     *      "alias" => array("text"=>lang("App.Alias"),"align" =>"center"),
     *      "module" => array("text"=>lang("App.Module"),"align" =>"center"),
     *      )
     * ));
     */
    class Grid
    {
        private $attributes;
        private $id;
        private $ajax;
        private $size;
        private $pk;
        private $create;
        private $cols;
        private $side_pagination;

        private $evaluate;
        private $lote;


        public function __construct($attributes = array())
        {
            define('ERR_ID', 'La Clase -Grid- debe contener un atributo id en el vector que la inicializa.');
            $this->attributes = $attributes;
            if (isset($attributes["id"])) {
                $this->id = $this->_get_Atribute("id", null);
                $this->ajax = $this->_get_Atribute("ajax", null);
                $this->size = $this->_get_Atribute("size", 10);
                $this->pk = $this->_get_Atribute("pk", null);
                $this->create = $this->_get_Atribute("create", null);
                $this->evaluate = $this->_get_Atribute("evaluate", null);
                $this->lote = $this->_get_Atribute("lote", null);
                $this->cols = $this->_get_Atribute("cols", null);
                $this->side_pagination = $this->_get_Atribute("side_pagination", "server");
            } else {
                throw new \Exception(ERR_ID);
            }
        }

        /**
         * Retorna los valores de los atributos solicitados desde el vector que inicalizo la clase.
         * @param $name
         * @param $default
         * @return mixed
         */
        private function _get_Atribute(string $name, $default)
        {
            if (isset($this->attributes[$name])) {
                return ($this->attributes[$name]);
            }
            return ($default);
        }

        private function generate()
        {
            $c = "";

            $c .= "\n<div id=\"{$this->id}-table-toolbar\">";
            if (!empty($this->create)) {
                $c .= "\n    <a href=\"{$this->create}\"  autocomplete=\"off\" id=\"add-btn\" class=\"btn btn-secondary mr-2\">";
                $c .= "\n        <i class=\"fas fa-plus text-100\"></i>";
                $c .= "\n    </a>";
            }
            if (!empty($this->evaluate)) {
                $c .= "\n    <a href=\"{$this->evaluate}\"  autocomplete=\"off\" id=\"add-btn\" class=\"btn btn-danger mr-2\">";
                $c .= "\n        <i class=\"far fa-eye-evil text-100\"></i> Calificar";
                $c .= "\n    </a>";
            }
            if (!empty($this->lote)) {
                $c .= "\n    <a href=\"{$this->lote}\"  autocomplete=\"off\" id=\"add-btn\" class=\"btn btn-primary mr-2\">";
                $c .= "\n        <i class=\"far fa-ball-pile text-100\"></i>";
                $c .= "\n    </a>";
            }

            $c .= "\n</div>";

            $c .= "\n<table class=\"table text-dark-m2 text-95 p-0 m-0\" id=\"{$this->id}\"></table>";
            $c .= "\n<table";
            $c .= "\n    id=\"table\"";
            $c .= "\n    data-locale=\"es-ES\"";
            $c .= "\n    data-toolbar=\"#{$this->id}-table-toolbar\"";
            $c .= "\n    data-show-button-icons=\"true\"";
            $c .= "\n    data-search=\"true\"";
            $c .= "\n    data-search-align=\"right\"";
            $c .= "\n    data-pagination=\"true\"";
            $c .= "\n    data-side-pagination=\"{$this->side_pagination}\"";
            $c .= "\n    data-url=\"{$this->ajax}\"";
            $c .= "\n    data-total-field=\"total\"";
            $c .= "\n    data-data-field=\"data\"";
            $c .= "\n    data-show-pagination-switch=\"true\"";
            $c .= "\n    data-page-size=\"{$this->size}\"";
            $c .= "\n    data-show-extended-pagination=\"true\"";
            $c .= "\n    data-toggle=\"table\"";
            $c .= "\n    data-show-columns=\"true\"";
            $c .= "\n    data-show-refresh=\"true\"";
            $c .= "\n    data-show-fullscreen=\"true\"";
            $c .= "\n    data-id-field=\"{$this->pk}\"";
            $c .= "\n    data-select-item-name=\"{$this->pk}\"";
            $c .= "\n    stickyHeader=\"true\" ";
            $c .= "\n    stickyHeaderOffsetLeft= parseInt($('body').css('padding-left'), 10) ";
            $c .= "\n    stickyHeaderOffsetRight= parseInt($('body').css('padding-right'), 10) ";
            $c .= "\n    theadClasses=\"classes\" ";
            $c .= "\n    >";
            $c .= "\n    <thead>";
            $c .= "\n        <tr>";
            //$c .= "\n            <th data-radio=\"true\"></th>";
            if (is_array($this->cols)) {
                foreach ($this->cols as $key => $value) {
                    if (is_array($value)) {
                        //data-halign
                        //data-align
                        //data-valign
                        //data-switchable=\"false\"
                        $halign = isset($value["halign"]) ? "data-halign=\"{$value["halign"]}\"" : "";
                        $align = isset($value["align"]) ? "data-align=\"{$value["align"]}\"" : "";
                        $valign = isset($value["valign"]) ? "data-valign=\"{$value["valign"]}\"" : "";
                        $width = isset($value["width"]) ? "data-width=\"{$value["width"]}\"" : "";
                        $visible = isset($value["visible"]) ? "data-visible=\"{$value["visible"]}\"" : "";
                        $c .= "\n            <th data-field=\"{$key}\" {$valign} {$align} {$halign} {$visible} {$width} >{$value["text"]}</th>";
                    } else {
                        $c .= "\n            <th data-field=\"{$key}\">{$value}</th>";
                    }
                }
            } else {
                echo("error");
                print_r($this->cols);
            }
            $c .= "\n        </tr>";
            $c .= "\n    </thead>";
            $c .= "\n</table>";
            return ($c);
        }

        public function __toString()
        {
            return ($this->generate());
        }

    }

}