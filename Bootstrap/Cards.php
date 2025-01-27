<?php

namespace App\Libraries\Html\Bootstrap;

use App\Libraries\Html\Html;
use App\Libraries\Html\HtmlTag;

/**
 * Clase para crear tarjetas de Bootstrap 5
 */
class Cards
{
    private $id;
    private $class;
    private $header;
    private $headerTitle;
    private $headerSubtitle;
    private $body;
    private $footer;
    private $image;
    private $imagePosition;
    private $contentTitle;
    private $contentSubtitle;
    private $text;
    private $buttons;
    private $headerButtons;
    private $horizontal;
    private $attributes;

    /**
     * Constructor de la clase Cards
     *
     * @param array $attributes Atributos de la tarjeta
     */
    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', 'card-' . uniqid());
        $this->class = $this->get_Attribute($attributes, 'class', 'card');
        $this->header = '';
        // Values
        $header_title = $this->get_Attribute($attributes, 'header-title', '');
        $header_title_class = $this->get_Attribute($attributes, 'header-title-class', 'card-title');
        // Setters
        $this->headerTitle = array("content" => $header_title, "attributes" => array("class" => $header_title_class));
        $this->headerSubtitle = $this->get_Attribute($attributes, 'header-subtitle', '');
        $this->body = $this->get_Attribute($attributes, 'body', '');
        $this->footer = $this->get_Attribute($attributes, 'footer', '');
        $this->image = $this->get_Attribute($attributes, 'image', '');
        $this->imagePosition = $this->get_Attribute($attributes, 'imagePosition', 'top');
        $this->contentTitle = '';
        $this->contentSubtitle = '';
        $this->text = $this->get_Attribute($attributes, 'text', '');
        $this->horizontal = $this->get_Attribute($attributes, 'horizontal', false);
        $this->buttons = [];
        $this->headerButtons = [];
        $this->attributes = $attributes;
    }

    /**
     * Establece el título del header de la tarjeta
     *
     * @param string $title Título del header
     * @param array $attributes Atributos adicionales para el título
     * @return self
     */
    public function set_HeaderTitle($title, $attributes = []): self
    {
        if (empty($title)) {
            return $this;
        }
        $this->headerTitle = ['content' => $title, 'attributes' => $attributes];
        return $this;
    }

    /**
     * Establece el subtítulo del header de la tarjeta
     *
     * @param string $subtitle Subtítulo del header
     * @param array $attributes Atributos adicionales para el subtítulo
     * @return self
     */
    public function set_HeaderSubtitle($subtitle, $attributes = []): self
    {
        if (empty($subtitle)) {
            return $this;
        }
        $this->headerSubtitle = [
            'content' => $subtitle,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Establece el título del contenido de la tarjeta
     *
     * @param string $title Título del contenido
     * @param array $attributes Atributos adicionales para el título
     * @return self
     */
    public function set_ContentTitle($title, $attributes = []): self
    {
        if (empty($title)) {
            return $this;
        }
        $this->contentTitle = [
            'content' => $title,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Establece el subtítulo del contenido de la tarjeta
     *
     * @param string $subtitle Subtítulo del contenido
     * @param array $attributes Atributos adicionales para el subtítulo
     * @return self
     */
    public function set_ContentSubtitle($subtitle, $attributes = []): self
    {
        if (empty($subtitle)) {
            return $this;
        }
        $this->contentSubtitle = [
            'content' => $subtitle,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Establece el texto principal de la tarjeta
     *
     * @param string $text Texto de la tarjeta
     * @return self
     */
    public function set_Text($text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Establece la imagen de la tarjeta
     *
     * @param string $src URL de la imagen
     * @param string $alt Texto alternativo
     * @param string $position Posición de la imagen (top, bottom, overlay)
     * @param array $attributes Atributos adicionales para la imagen
     * @return self
     */
    public function set_Image($src, $alt = '', $position = 'top', $attributes = []): self
    {
        $this->image = [
            'src' => $src,
            'alt' => $alt,
            'attributes' => array_merge(['class' => 'card-img-' . $position], $attributes)
        ];
        $this->imagePosition = $position;
        return $this;
    }

    /**
     * Establece el encabezado de la tarjeta
     *
     * @param string $header Contenido del encabezado
     * @param array $attributes Atributos adicionales
     * @return self
     */
    public function set_Header($header, $attributes = []): self
    {
        $this->header = '';
        if (!empty($header)) {
            $this->header = [
                'content' => $header,
                'attributes' => array_merge(['class' => 'card-header'], $attributes)
            ];
        }
        return $this;
    }

    /**
     * Establece el pie de la tarjeta
     *
     * @param string $footer Contenido del pie
     * @param array $attributes Atributos adicionales
     * @return self
     */
    public function set_Footer($footer, $attributes = []): self
    {
        $this->footer = [
            'content' => $footer,
            'attributes' => array_merge(['class' => 'card-footer'], $attributes)
        ];
        return $this;
    }

    /**
     * Configura la tarjeta como horizontal
     *
     * @param bool $horizontal True para hacer la tarjeta horizontal
     * @return self
     */
    public function set_Horizontal($horizontal = true): self
    {
        $this->horizontal = $horizontal;
        if ($horizontal) {
            $this->class .= ' card-horizontal';
        }
        return $this;
    }

    /**
     * Agrega un botón al encabezado de la tarjeta
     *
     * @param string $label Etiqueta del botón
     * @param array $attributes Atributos del botón
     * @return self
     */
    public function add_HeaderButton($label, $attributes = []): self
    {
        $default_attributes = [
            'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
            'type' => 'button',
            'target' => '_self'
        ];
        $this->headerButtons[] = [
            'label' => $label,
            'attributes' => array_merge($default_attributes, $attributes)
        ];
        return ($this);
    }

    /**
     * Agrega un botón a la tarjeta
     *
     * @param string $label Etiqueta del botón
     * @param array $attributes Atributos del botón
     * @return self
     */
    public function add_Button($label, $attributes = []): self
    {
        $this->buttons[] = [
            'label' => $label,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Obtiene un atributo del array de atributos
     *
     * @param array $attributes Array de atributos
     * @param string $name Nombre del atributo
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    private function get_Attribute($attributes, $name, $default = null)
    {
        return $attributes[$name] ?? $default;
    }

    /**
     * Renderiza los botones del encabezado
     *
     * @return string HTML de los botones
     */
    private function render_HeaderButtons(): string
    {
        if (empty($this->headerButtons)) {
            return '';
        }

        $buttons = '';
        $buttons_default_class = 'btn btn-sm bg-toolbar-primary border-toolbar-primary';
        foreach ($this->headerButtons as $button) {
            if (!empty($button['attributes']['href'])) {
                $buttons .= Html::get_A([
                    'content' => @$button['label'],
                    'class' => @$button['attributes']['class'],
                    'type' => @$button['attributes']['type'],
                    'target' => @$button['attributes']['target'],
                    'href' => @$button['attributes']['href'],
                    'test' => "prueba-link",
                ]);
            } else {
                $buttons .= Html::get_Button([
                    'content' => @$button['label'],
                    'class' => !empty($button['attributes']['class']) ?? $buttons_default_class,
                    'type' => @$button['attributes']['type'],
                    'test' => "prueba-button",
                ]);
            }
        }
        return $buttons;
    }

    /**
     * Renderiza los botones de la tarjeta
     *
     * @return string HTML de los botones
     */
    private function render_Buttons(): string
    {
        if (empty($this->buttons)) {
            return '';
        }

        $buttons = '';
        foreach ($this->buttons as $button) {
            $buttons .= Html::get_Button([
                'content' => $button['label'],
                'class' => $button['attributes']['class'],
                'type' => $button['attributes']['type']
            ]);
        }
        return $buttons;
    }

    /**
     * Renderiza la imagen de la tarjeta
     *
     * @return string HTML de la imagen
     */
    private function render_Image(): string
    {
        if (empty($this->image)) {
            return '';
        }

        return Html::get_Img([
            'src' => $this->image['src'],
            'alt' => $this->image['alt'],
            'class' => $this->image['attributes']['class']
        ]);
    }

    /**
     * Renderiza el cuerpo de la tarjeta
     *
     * @return string HTML del cuerpo
     */
    private function render_Body(): string
    {
        $body = '';

        // Título del contenido
        if (!empty($this->contentTitle)) {
            $titleAttrs = array_merge(
                ['class' => 'card-title'],
                $this->contentTitle['attributes'] ?? []
            );
            $body .= Html::get_H1([
                'content' => $this->contentTitle['content'],
                'class' => $titleAttrs['class']
            ]);
        }

        // Subtítulo del contenido
        if (!empty($this->contentSubtitle)) {
            $subtitleAttrs = array_merge(
                ['class' => 'card-subtitle mb-2 text-muted'],
                $this->contentSubtitle['attributes'] ?? []
            );
            $body .= Html::get_H1([
                'content' => $this->contentSubtitle['content'],
                'class' => $subtitleAttrs['class']
            ]);
        }

        // Texto
        if (!empty($this->text)) {
            $body .= Html::get_P([
                'content' => $this->text,
                'class' => 'card-text'
            ]);
        }

        // Botones
        if (!empty($this->buttons)) {
            $body .= $this->render_Buttons();
        }

        return Html::get_Div([
            'content' => $body,
            'class' => 'card-body'
        ]);
    }

    /**
     * Renderiza el título del header
     * @param $content
     * @return string
     */
    private function render_HeaderTitle(): string
    {
        if (!empty($this->headerTitle['content'])) {
            $h5 = HtmlTag::tag('h5');
            $h5->attr('class', "card-title mb-0");
            $h5->content($this->headerTitle['content']);
            return ($h5);
        }
        return ("");
    }

    private function render_HeaderToolbar(): string
    {
        $rhb = $this->render_HeaderButtons();
        $group = HtmlTag::tag('div');
        $group->attr('class', "btn-group mx-0");
        $group->attr("rol", "group");
        $group->content($rhb);
        $toolbar = HtmlTag::tag('div');
        $toolbar->attr('class', "btn-toolbar");
        $toolbar->attr("rol", "toolbar");
        $toolbar->content($group);
        return ($toolbar);
    }


    /**
     * Convierte la tarjeta a HTML
     *
     * @return string
     */
    public function __toString()
    {
        $content = '';

        // Header
        if (!empty($this->headerTitle)) {
            $headerContent = '';
            if (!empty($this->header['content'])) {
                $headerContent = $this->header['content'];
            }

            // Agregar título del header si existe
            $headerContent = $this->render_HeaderTitle();

            /**
             * // Agregar subtítulo del header si existe
             * if (!empty($this->headerSubtitle)) {
             * $subtitleAttrs = array_merge(
             * ['class' => 'card-header-subtitle'],
             * $this->headerSubtitle['attributes'] ?? []
             * );
             * $headerContent .= Html::get_H1([
             * 'content' => $this->headerSubtitle['content'],
             * 'class' => $subtitleAttrs['class']
             * ]);
             * }
             * **/

            $headerTitle = $this->render_HeaderTitle();
            $headerToolbar = $this->render_HeaderToolbar();
            // Header de la card con título y toolbar
            $contentHeader = HtmlTag::tag('div');
            $contentHeader->attr('class', "d-flex justify-content-between align-items-center");
            $contentHeader->content(array($headerTitle, $headerToolbar));
            // Agregar botones del header
            $headerClass = $this->header['attributes']['class'] ?? 'card-header px-2';
            $content .= Html::get_Div(['content' => $contentHeader, 'class' => $headerClass]);
        }

        // Imagen superior
        if (!empty($this->image) && $this->imagePosition === 'top') {
            $content .= $this->render_Image();
        }

        // Cuerpo
        $content .= $this->render_Body();

        // Imagen inferior
        if (!empty($this->image) && $this->imagePosition === 'bottom') {
            $content .= $this->render_Image();
        }

        // Footer
        if (!empty($this->footer)) {
            $content .= Html::get_Div([
                'content' => $this->footer['content'],
                'class' => $this->footer['attributes']['class']
            ]);
        }

        // Si es horizontal, envolver en un div con clase row
        if ($this->horizontal) {
            $content = Html::get_Div([
                'content' => $content,
                'class' => 'row g-0'
            ]);
        }

        // Tarjeta principal
        return Html::get_Div([
            'content' => $content,
            'id' => $this->id,
            'class' => $this->class
        ]);
    }
}
