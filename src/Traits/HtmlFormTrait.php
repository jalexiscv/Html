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

        foreach ($options as $key => $label) {
            // Soporte para Optgroups
            if (is_array($label)) {
                $groupOptions = [];
                foreach ($label as $optValue => $optLabel) {
                    $optAttr = ['value' => $optValue];
                    if ((string)$optValue === (string)$selected) {
                        $optAttr['selected'] = 'selected';
                    }
                    $groupOptions[] = self::tag('option', $optAttr, $optLabel);
                }
                $optionTags[] = self::tag('optgroup', ['label' => $key], $groupOptions);
                continue;
            }

            // Opciones normales
            $optAttr = ['value' => $key];

            // Comparación estricta puede fallar con números en strings, usamos comparacion suave segura
            if ((string)$key === (string)$selected) {
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

    // --- Extended Inputs ---

    public static function file(string $name, array $attributes = []): TagInterface
    {
        return self::input('file', $name, null, $attributes);
    }

    public static function date(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('date', $name, $value, $attributes);
    }

    public static function time(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('time', $name, $value, $attributes);
    }

    public static function number(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('number', $name, $value, $attributes);
    }

    public static function range(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('range', $name, $value, $attributes);
    }

    public static function color(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('color', $name, $value, $attributes);
    }

    public static function tel(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('tel', $name, $value, $attributes);
    }

    public static function url(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('url', $name, $value, $attributes);
    }

    public static function search(string $name, mixed $value = null, array $attributes = []): TagInterface
    {
        return self::input('search', $name, $value, $attributes);
    }
}
