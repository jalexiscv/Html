<?php

namespace App\Libraries\Html;

use InvalidArgumentException;

/**
 * Clase para generar ventanas modales de Bootstrap 5
 */
class Modals
{
    private $id;
    private $title;
    private $body;
    private $footer;
    private $size;
    private $class;
    private $attributes;
    private $buttons;
    private $centered;
    private $scrollable;
    private $static;

    /**
     * Constructor de la clase Modals
     *
     * @param array $attributes Atributos de la ventana modal
     */
    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', 'modal-' . uniqid());
        $this->class = $this->get_Attribute($attributes, 'class', 'modal fade');
        $this->title = $this->get_Attribute($attributes, 'title', '');
        $this->body = $this->get_Attribute($attributes, 'body', '');
        $this->footer = $this->get_Attribute($attributes, 'footer', '');
        $this->size = $this->get_Attribute($attributes, 'size', ''); // lg, sm, xl
        $this->centered = $this->get_Attribute($attributes, 'centered', false);
        $this->scrollable = $this->get_Attribute($attributes, 'scrollable', false);
        $this->static = $this->get_Attribute($attributes, 'static', false);
        $this->buttons = [];
        $this->attributes = $attributes;
    }

    /**
     * Establece el título de la ventana modal
     *
     * @param string $title Título de la ventana modal
     */
    public function set_Title($title): void
    {
        $this->title = $title;
    }

    /**
     * Establece el cuerpo de la ventana modal
     *
     * @param string $body Cuerpo de la ventana modal
     */
    public function set_Body($body): void
    {
        $this->body = $body;
    }

    /**
     * Establece el pie de la ventana modal
     *
     * @param string $footer Pie de la ventana modal
     */
    public function set_Footer($footer): void
    {
        $this->footer = $footer;
    }

    /**
     * Establece el tamaño de la ventana modal
     *
     * @param string $size Tamaño de la ventana modal (lg, sm, xl)
     */
    public function set_Size($size): void
    {
        $this->size = $size;
    }

    /**
     * Establece si la ventana modal está centrada
     *
     * @param bool $centered Verdadero si la ventana modal está centrada
     */
    public function set_Centered($centered): void
    {
        $this->centered = $centered;
    }

    /**
     * Establece si la ventana modal es desplazable
     *
     * @param bool $scrollable Verdadero si la ventana modal es desplazable
     */
    public function set_Scrollable($scrollable): void
    {
        $this->scrollable = $scrollable;
    }

    /**
     * Establece si la ventana modal es estática
     *
     * @param bool $static Verdadero si la ventana modal es estática
     */
    public function set_Static($static): void
    {
        $this->static = $static;
    }

    /**
     * Agrega un botón a la ventana modal
     *
     * @param string $label Etiqueta del botón
     * @param array $attributes Atributos del botón
     */
    public function add_Button($label, $attributes = []): void
    {
        $default_attributes = [
            'type' => 'button',
            'class' => 'btn btn-secondary',
            'data-bs-dismiss' => 'modal'
        ];
        $this->buttons[] = array_merge($default_attributes, $attributes, ['label' => $label]);
    }

    /**
     * Obtiene un atributo de la ventana modal
     *
     * @param array $attributes Atributos de la ventana modal
     * @param string $name Nombre del atributo
     * @param mixed $default Valor por defecto del atributo
     * @return mixed Valor del atributo
     */
    private function get_Attribute($attributes, $name, $default = null)
    {
        return $attributes[$name] ?? $default;
    }

    /**
     * Renderiza los botones de la ventana modal
     *
     * @return string HTML de los botones
     */
    private function render_Buttons(): string
    {
        $html = '';
        foreach ($this->buttons as $button) {
            $label = $button['label'];
            unset($button['label']);
            
            $attributes = '';
            foreach ($button as $key => $value) {
                $attributes .= " {$key}=\"{$value}\"";
            }
            
            $html .= "<button{$attributes}>{$label}</button>";
        }
        return $html;
    }

    /**
     * Convierte la ventana modal a una cadena de texto
     *
     * @return string HTML de la ventana modal
     */
    public function __toString()
    {
        $dialog_class = 'modal-dialog';
        if ($this->size) {
            $dialog_class .= " modal-{$this->size}";
        }
        if ($this->centered) {
            $dialog_class .= ' modal-dialog-centered';
        }
        if ($this->scrollable) {
            $dialog_class .= ' modal-dialog-scrollable';
        }

        $modal_attributes = "id=\"{$this->id}\" class=\"{$this->class}\"";
        if ($this->static) {
            $modal_attributes .= ' data-bs-backdrop="static" data-bs-keyboard="false"';
        }

        $html = "<div {$modal_attributes} tabindex=\"-1\" aria-labelledby=\"{$this->id}Label\" aria-hidden=\"true\">";
        $html .= "<div class=\"{$dialog_class}\">";
        $html .= "<div class=\"modal-content\">";
        
        // Header
        if ($this->title) {
            $html .= "<div class=\"modal-header\">";
            $html .= "<h5 class=\"modal-title\" id=\"{$this->id}Label\">{$this->title}</h5>";
            $html .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>";
            $html .= "</div>";
        }
        
        // Body
        if ($this->body) {
            $html .= "<div class=\"modal-body\">";
            $html .= $this->body;
            $html .= "</div>";
        }
        
        // Footer
        if ($this->footer || !empty($this->buttons)) {
            $html .= "<div class=\"modal-footer\">";
            if (!empty($this->buttons)) {
                $html .= $this->render_Buttons();
            } else {
                $html .= $this->footer;
            }
            $html .= "</div>";
        }
        
        $html .= "</div></div></div>";
        
        return $html;
    }
}
