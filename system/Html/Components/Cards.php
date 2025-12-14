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
    private $footer_class;
    private $image;
    private $imagePosition;
    private $contentTitle;
    private $contentSubtitle;
    private $text;
    private $buttons;
    private $headerButtons;

    private $headerClass;

    private $footerButtons;
    private $horizontal;
    private $attributes;

    private $bodyclass;

    private $voice;


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
        $this->bodyclass = $this->get_Attribute($attributes, 'body-class', '');
        $this->footer = $this->get_Attribute($attributes, 'footer', '');
        $this->footer_class = $this->get_Attribute($attributes, 'footer-class', '');
        $this->image = $this->get_Attribute($attributes, 'image', '');
        $this->imagePosition = $this->get_Attribute($attributes, 'imagePosition', 'top');
        $this->contentTitle = '';
        $this->contentSubtitle = '';
        $this->text = $this->get_Attribute($attributes, 'text', '');
        $this->horizontal = $this->get_Attribute($attributes, 'horizontal', false);
        $this->buttons = [];
        $this->headerButtons = [];
        $this->headerClass = "card-header";
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

    public function add_Content($content): void
    {
        $this->text .= $content;
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
        $this->header = [
            'content' => $header,
            'attributes' => array_merge(['class' => 'card-header'], $attributes)
        ];
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
     * Agrega de imprimir en el encabezado de la tarjeta
     * @param string $href URL de destino
     * @param array $attributes Atributos del botón
     * @return self
     */
    public function add_HeaderButtonPrint($attributes = []): void
    {
        if (!empty($attributes["header-print"])) {
            if (is_array($attributes["header-print"])) {
                $this->add_HeaderButton('<i class="fas fa-print"></i>', $attributes["header-print"]);
            } else {
                $args_print = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-print"]
                ];
                $this->add_HeaderButton('<i class="fas fa-print"></i>', $args_print);
            }
        }
    }


    public function add_Voice($attributes = []): void
    {
        if (!empty($attributes["voice"])) {
            $this->voice = $attributes["voice"];
        }
    }


    public function add_HeaderButtons($attributes = []): void
    {
        if (!empty($attributes["header-buttons"])) {
            if (is_array($attributes["header-buttons"])) {
                foreach ($attributes["header-buttons"] as $key => $values) {
                    if (is_array($values)) {
                        $this->add_HeaderButton($values["text"], $values);
                    } else {

                    }
                }
            } else {

            }
        }
    }

    /**
     * Agrega un boton para acceder a la creación de eleemntos
     * @param $attributes
     * @return void
     */
    public function add_HeaderButtonAdd($attributes = []): void
    {
        if (!empty($attributes["header-add"])) {
            if (is_array($attributes["header-add"])) {
                $this->add_HeaderButton('<i class="fas fa-plus"></i>', $attributes["header-add"]);
            } else {
                $args_add = [
                    'id' => 'header-add',
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-add"]
                ];
                $this->add_HeaderButton('<i class="fas fa-plus"></i>', $args_add);
            }
        }
    }


    public function add_HeaderButtonSynchronize($attributes = []): void
    {
        if (!empty($attributes["header-synchronize"])) {
            if (is_array($attributes["header-synchronize"])) {
                $this->add_HeaderButton('<i class="fas fa-sync"></i>', $attributes["header-synchronize"]);
            } else {
                $args_add = [
                    'id' => 'header-synchronize',
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-synchronize"]
                ];
                $this->add_HeaderButton('<i class="fas fa-sync"></i>', $args_add);
            }
        }
    }


    public function add_HeaderButtonEdit($attributes = []): void
    {
        if (!empty($attributes["header-edit"])) {
            if (is_array($attributes["header-edit"])) {
                $this->add_HeaderButton('<i class="fas fa-edit"></i>', $attributes["header-edit"]);
            } else {
                $args_edit = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-edit"]
                ];
                $this->add_HeaderButton('<i class="fas fa-edit"></i>', $args_edit);
            }
        }
    }

    public function add_HeaderButtonDelete($attributes = []): void
    {
        if (!empty($attributes["header-delete"])) {
            if (is_array($attributes["header-delete"])) {
                $this->add_HeaderButton('<i class="fas fa-trash"></i>', $attributes["header-delete"]);
            } else {
                $args_delete = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-delete"]
                ];
                $this->add_HeaderButton('<i class="fas fa-trash"></i>', $args_delete);
            }
        }
    }

    public function add_HeaderButtonList($attributes = []): void
    {
        if (!empty($attributes["header-list"])) {
            if (is_array($attributes["header-list"])) {
                $this->add_HeaderButton('<i class="fas fa-list"></i>', $attributes["header-list"]);
            } else {
                $args_list = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-list"]
                ];
                $this->add_HeaderButton('<i class="fas fa-list"></i>', $args_list);
            }
        }
    }

    public function add_HeaderButtonSearch($attributes = []): void
    {
        if (!empty($attributes["header-search"])) {
            if (is_array($attributes["header-search"])) {
                $this->add_HeaderButton('<i class="fas fa-search"></i>', $attributes["header-search"]);
            } else {
                $args_search = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-search"]
                ];
                $this->add_HeaderButton('<i class="fas fa-search"></i>', $args_search);
            }
        }
    }

    public function add_HeaderButtonEvaluate($attributes = []): void
    {
        if (!empty($attributes["header-evaluate"])) {
            if (is_array($attributes["header-evaluate"])) {
                $this->add_HeaderButton('<i class="fas fa-check"></i>', $attributes["header-evaluate"]);
            } else {
                $args_evaluate = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-evaluate"]
                ];
                $this->add_HeaderButton('<i class="fas fa-check"></i>', $args_evaluate);
            }
        }
    }

    public function add_HeaderButtonRefresh($attributes = []): void
    {
        if (!empty($attributes["header-refresh"])) {
            if (is_array($attributes["header-refresh"])) {
                $this->add_HeaderButton('<i class="fas fa-sync"></i>', $attributes["header-refresh"]);
            } else {
                $args_refresh = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-refresh"]
                ];
                $this->add_HeaderButton('<i class="fas fa-sync"></i>', $args_refresh);
            }
        }
    }


    public function add_HeaderButtonHelp($attributes = []): void
    {
        if (!empty($attributes["header-help"])) {
            if (is_array($attributes["header-help"])) {
                $this->add_HeaderButton('<i class="fas fa-question"></i>', $attributes["header-help"]);
            } else {
                $args_help = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-help"]
                ];
                $this->add_HeaderButton('<i class="fas fa-question"></i>', $args_help);
            }
        }
    }


    public function add_HeaderButtonBack($attributes = []): void
    {
        if (!empty($attributes["header-back"])) {
            if (is_array($attributes["header-back"])) {
                $this->add_HeaderButton('<i class="fas fa-arrow-left"></i>', $attributes["header-back"]);
            } else {
                $args_back = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-back"]
                ];
                $this->add_HeaderButton('<i class="fas fa-arrow-left"></i>', $args_back);
            }
        }
    }

    public function add_ContentAlert($attributes = []): void
    {
        if (!empty($attributes["alert"])) {
            $type = $attributes["alert"]["type"];
            $title = $attributes["alert"]["title"];
            $message = $attributes["alert"]["message"];
            $alert = new Alert(['type' => $type, 'title' => $title, 'message' => $message]);
            $this->add_Content($alert);
        }
    }


    public function add_ContentImage($attributes = []): void
    {
        if (!empty($attributes["image"])) {
            if (is_array($attributes["image"])) {
                $src = array("image" => @$attributes["image"]["src"]);
                $alt = array("image" => @$attributes["image"]["alt"]);
                $position = array("image" => @$attributes["image"]["position"]);
                $class = array("image" => @$attributes["image"]["class"]);
                $image = $this->set_Image($src["image"], $alt["image"], $position["image"], $class["image"]);
            } else {
                $image = "<img class=\"card-img-top lazyload\" src=\"{$attributes["image"]}\" alt=\"\">";
            }
            $this->add_Content($image);
        }
    }


    public function add_ContentBody($attributes = []): void
    {
        if (!empty($attributes["content"])) {
            $this->add_Content($attributes["content"]);
        }

        if (!empty($attributes["content-class"])) {
            //$this->add_Content($attributes["body"]);
        }

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
                    'id' => @$button['attributes']['id'],
                    'content' => @$button['label'],
                    'class' => @$button['attributes']['class'],
                    'type' => @$button['attributes']['type'],
                    'target' => @$button['attributes']['target'],
                    'href' => @$button['attributes']['href'],
                    'onclick' => @$button['attributes']['onclick'],
                    'test' => "prueba-link",
                ]);
            } else {
                $buttons .= Html::get_Button([
                    'id' => @$button['attributes']['id'],
                    'content' => @$button['label'],
                    'class' => !empty($button['attributes']['class']) ?? $buttons_default_class,
                    'type' => @$button['attributes']['type'],
                    'onclick' => @$button['attributes']['onclick'],
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
        if (!empty(safe_trim($this->text))) {
            $body .= $this->text;
        }

        // Botones
        if (!empty($this->buttons)) {
            $body .= $this->render_Buttons();
        }

        // classes for card-body
        $bodyClass = $this->bodyclass;

        return Html::get_Div([
            'content' => $body,
            'class' => "card-body {$bodyClass}"
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
        $group->attr("role", "group");
        $group->content($rhb);
        $toolbar = HtmlTag::tag('div');
        $toolbar->attr('class', "btn-toolbar ms-auto");
        $toolbar->attr("role", "toolbar");
        $toolbar->content($group);
        return ($toolbar);
    }

    public function add_FooterButton($label, $attributes = []): self
    {
        $default_attributes = [
            'class' => 'btn',
            'type' => 'button',
            'target' => '_self'
        ];
        $this->footerButtons[] = [
            'label' => $label,
            'attributes' => array_merge($default_attributes, $attributes)
        ];
        return ($this);
    }


    public function add_FooterButtonContinue($attributes = []): void
    {
        if (!empty($attributes["footer-continue"])) {
            if (is_array($attributes["footer-continue"])) {
                $this->add_FooterButton('<i class="fas fa-arrow-left"></i>', $attributes["footer-continue"]);
            } else {
                $args_back = [
                    'class' => 'btn btn-sm bg-toolbar-primary border-toolbar-primary',
                    'href' => $attributes["header-back"]
                ];
                $this->add_FooterButton(lang("App.Continue"), $args_back);
            }
        }
    }

    public function render_Footer(): string
    {
        if (empty($this->footerButtons)) {
            return '';
        }
        $buttons = '';
        foreach ($this->footerButtons as $button) {
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
                    'class' => @$button['attributes']['class'],
                    'type' => @$button['attributes']['type'],
                    'test' => "prueba-button",
                ]);
            }
        }
        return $buttons;

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
            $headerClass = $this->headerClass;
            // Header de la card con título y toolbar
            $contentHeader = HtmlTag::tag('div');
            $contentHeader->attr('class', "d-flex justify-content-between align-items-center");
            $contentHeader->content(array($headerTitle, $headerToolbar));
            // Agregar botones del header
            $headerClass = $this->header['attributes']['class'] ?? 'card-header';
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

        $this->footer = $this->render_Footer();
        // Footer
        if (!empty($this->footer)) {
            $footer_class = $this->footer_class;
            $content .= Html::get_Div([
                'content' => $this->footer,
                'class' => "card-footer x {$footer_class}"
            ]);
        }

        if (!empty($this->voice)) {
            $code = "<audio class=\¨card-audio\¨ src=\"/themes/assets/audios/{$this->voice}?lpk=" . lpk() . "\" type=\"audio/mp3\" autoplay></audio>";

            $content .= Html::get_Div([
                'content' => $code,
                'class' => "d-none"
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
