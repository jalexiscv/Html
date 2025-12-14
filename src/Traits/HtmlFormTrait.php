<?php

declare(strict_types=1);

namespace Higgs\Html\Traits;

use Higgs\Html\Tag\TagInterface;

/**
 * Trait HtmlFormTrait
 * Provee métodos avanzados para formularios.
 */
trait HtmlFormTrait
{
    /**
     * Crea un input genérico.
     */
    public static function input(string $type, string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        
        if ($value !== null) {
            $attributes['value'] = $value;
        }

        return self::tag('input', $attributes);
    }

    /**
     * Crea un campo de texto.
     */
    public static function text(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('text', $name, $value, $attributes);
    }

    /**
     * Crea un campo de email.
     */
    public static function email(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('email', $name, $value, $attributes);
    }

    /**
     * Crea un campo de contraseña.
     */
    public static function password(string $name, array $attributes = []): TagInterface
    {
        return self::input('password', $name, null, $attributes);
    }

    /**
     * Crea un campo oculto.
     */
    public static function hidden(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('hidden', $name, $value, $attributes);
    }

    /**
     * Crea un textarea.
     */
    public static function textarea(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        $attributes['name'] = $name;
        // Textarea usa contenido innerHTML, no atributo value
        return self::tag('textarea', $attributes, $value);
    }

    /**
     * Crea un checkbox.
     */
    public static function checkbox(string $name, mixed $value = 1, bool $checked = false, array $attributes = []): TagInterface
    {
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        return self::input('checkbox', $name, $value, $attributes);
    }

    /**
     * Crea un radio button.
     */
    public static function radio(string $name, mixed $value = 1, bool $checked = false, array $attributes = []): TagInterface
    {
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        return self::input('radio', $name, $value, $attributes);
    }

    /**
     * Crea un select dropdown.
     * 
     * @param string $name Nombre del campo.
     * @param array $options Array de opciones (key => label).
     * @param mixed $selected Valor seleccionado (key).
     * @param array $attributes Atributos extra.
     */
    public static function select(string $name, array $options = [], mixed $selected = null, array $attributes = []): TagInterface
    {
        $attributes['name'] = $name;
        $optionTags = [];

        foreach ($options as $value => $label) {
            $optAttr = ['value' => $value];
            
            // Comparación estricta puede fallar con números en strings, usamos comparacion suave segura
            if ((string)$value === (string)$selected) {
                $optAttr['selected'] = 'selected';
            }

            $optionTags[] = self::tag('option', $optAttr, $label);
        }

        return self::tag('select', $attributes, $optionTags);
    }

    /**
     * Crea un label.
     */
    public static function label(string $for, string $text, array $attributes = []): TagInterface
    {
        $attributes['for'] = $for;
        return self::tag('label', $attributes, $text);
    }
}
