<?php

namespace App\Libraries\Html\Bootstrap;

use Higgs\Html\HtmlTag;
use InvalidArgumentException;

class Scores
{
    /**
     * Definición de variantes de colores predefinidas
     */
    private static array $colorVariants = [
        'default' => [
            'background' => '#495057',
            'text' => 'text-white',
            'icon' => 'text-warning'
        ],
        'primary' => [
            'background' => '#0d6efd',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'secondary' => [
            'background' => '#6c757d',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'success' => [
            'background' => '#198754',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'warning' => [
            'background' => '#ffc107',
            'text' => 'text-dark',
            'icon' => 'text-dark'
        ],
        'danger' => [
            'background' => '#dc3545',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'info' => [
            'background' => '#0dcaf0',
            'text' => 'text-dark',
            'icon' => 'text-dark'
        ],
        'light' => [
            'background' => '#f8f9fa',
            'text' => 'text-dark',
            'icon' => 'text-primary'
        ],
        'dark' => [
            'background' => '#212529',
            'text' => 'text-white',
            'icon' => 'text-warning'
        ],
        'gradient-primary' => [
            'background' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'gradient-success' => [
            'background' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'text' => 'text-white',
            'icon' => 'text-light'
        ],
        'gradient-warning' => [
            'background' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'text' => 'text-white',
            'icon' => 'text-light'
        ]
    ];
    private string $id;
    private string $class;
    private string $cardClass;
    private string $cardStyle;
    private string $bodyClass;
    private string $title;
    private string $titleClass;
    private string $value;
    private string $valueClass;
    private string $icon;
    private string $iconClass;
    private string $subtitle;
    private string $subtitleClass;
    private string $colClass;
    private string $variant;

    /**
     * Constructor de la clase Scores
     *
     * @param array $attributes Atributos de la tarjeta de puntuación
     */
    public function __construct(array $attributes = [])
    {
        // Obtener la variante solicitada
        $this->variant = $this->get_Attribute($attributes, 'variant', 'default', false);

        // Primero asignar valores por defecto
        $this->id = $this->get_Attribute($attributes, 'id', 'score-' . uniqid(), false);
        $this->class = $this->get_Attribute($attributes, 'class', '', false);
        $this->cardClass = $this->get_Attribute($attributes, 'card-class', 'card dashboard-card border-0 shadow-sm h-100', false);
        $this->cardStyle = $this->get_Attribute($attributes, 'card-style', '', false);
        $this->bodyClass = $this->get_Attribute($attributes, 'body-class', '', false);
        $this->title = $this->get_Attribute($attributes, 'title', '', true);
        $this->titleClass = $this->get_Attribute($attributes, 'title-class', 'small opacity-75 mb-1', false);
        $this->value = $this->get_Attribute($attributes, 'value', '', true);
        $this->valueClass = $this->get_Attribute($attributes, 'value-class', 'display-4 fw-bold', false);
        $this->icon = $this->get_Attribute($attributes, 'icon', '', false);
        $this->iconClass = $this->get_Attribute($attributes, 'icon-class', '', false);
        $this->subtitle = $this->get_Attribute($attributes, 'subtitle', '', false);
        $this->subtitleClass = $this->get_Attribute($attributes, 'subtitle-class', 'small opacity-75', false);
        $this->colClass = $this->get_Attribute($attributes, 'col-class', 'col-12 mb-3', false);

        // Luego aplicar colores de la variante (después de tener los valores por defecto)
        $this->applyVariantColors($attributes);
    }

    /**
     * Obtiene el valor de un atributo del array de atributos
     */
    private function get_Attribute(array $attributes, string $key, mixed $default, bool $required): mixed
    {
        if (isset($attributes[$key])) {
            if (is_string($attributes[$key])) {
                return trim($attributes[$key]);
            } elseif (is_array($attributes[$key])) {
                return $attributes[$key];
            } else {
                return $attributes[$key];
            }
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
            } else {
                return $default;
            }
        }
    }

    /**
     * Aplica los colores de la variante seleccionada
     */
    private function applyVariantColors(array $attributes): void
    {
        if (!isset(self::$colorVariants[$this->variant])) {
            $this->variant = 'default';
        }

        $colors = self::$colorVariants[$this->variant];

        // Solo aplicar colores de variante si no se especificaron manualmente en los atributos
        if (empty($this->cardStyle) && !isset($attributes['card-style'])) {
            $this->cardStyle = 'background: ' . $colors['background'] . ';';
        }

        if (empty($this->bodyClass) && !isset($attributes['body-class'])) {
            $this->bodyClass = 'card-body p-3 ' . $colors['text'];
        }

        if (empty($this->iconClass) && !isset($attributes['icon-class'])) {
            $this->iconClass = $colors['icon'] . ' ms-1';
        }
    }

    /**
     * Obtiene las variantes de colores disponibles
     */
    public static function getAvailableVariants(): array
    {
        return array_keys(self::$colorVariants);
    }

    /**
     * Obtiene los colores de una variante específica
     */
    public static function getVariantColors(string $variant): array|null
    {
        return self::$colorVariants[$variant] ?? null;
    }

    /**
     * Método mágico para convertir el objeto a string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Renderiza la tarjeta de puntuación
     */
    public function render(): string
    {
        // Crear el contenedor principal (columna)
        $colAttributes = ['class' => $this->colClass];
        if (!empty($this->id)) {
            $colAttributes['id'] = $this->id;
        }
        if (!empty($this->class)) {
            $colAttributes['class'] .= ' ' . $this->class;
        }

        // Construir el contenido del cuerpo de la tarjeta
        $bodyContent = [];

        // Agregar el título
        if (!empty($this->title)) {
            $titleTag = HtmlTag::tag('div', ['class' => $this->titleClass], $this->title);
            $bodyContent[] = $titleTag;
        }

        // Agregar el valor con icono opcional
        if (!empty($this->value)) {
            $valueContent = $this->value;

            // Agregar icono si está presente
            if (!empty($this->icon)) {
                $iconTag = HtmlTag::tag('i', ['class' => $this->icon . ' ' . $this->iconClass], '');
                $valueContent = [$this->value, ' ', $iconTag];
            }

            $valueTag = HtmlTag::tag('div', ['class' => $this->valueClass], $valueContent);
            $bodyContent[] = $valueTag;
        }

        // Agregar el subtítulo
        if (!empty($this->subtitle)) {
            $subtitleTag = HtmlTag::tag('div', ['class' => $this->subtitleClass], $this->subtitle);
            $bodyContent[] = $subtitleTag;
        }

        // Crear el cuerpo de la tarjeta con todo el contenido
        $cardBody = HtmlTag::tag('div', ['class' => $this->bodyClass], $bodyContent);

        // Crear la tarjeta
        $cardAttributes = ['class' => $this->cardClass];
        if (!empty($this->cardStyle)) {
            $cardAttributes['style'] = $this->cardStyle;
        }
        $card = HtmlTag::tag('div', $cardAttributes, $cardBody);

        // Crear el contenedor principal (columna)
        $col = HtmlTag::tag('div', $colAttributes, $card);

        return $col->render();
    }
}

?>