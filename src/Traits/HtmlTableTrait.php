<?php

declare(strict_types=1);

namespace Higgs\Html\Traits;

use Higgs\Html\Tag\TagInterface;

/**
 * Trait HtmlTableTrait
 * Provee métodos para generar tablas rápidamente.
 */
trait HtmlTableTrait
{
    /**
     * Genera una tabla completa con encabezados y filas.
     *
     * @param array $headers Array de strings para los encabezados (th).
     * @param array $rows Matriz de datos para las filas (td).
     * @param array $attributes Atributos de la tabla principal (<table>).
     * @return TagInterface
     */
    public static function table(array $headers = [], array $rows = [], array $attributes = []): TagInterface
    {
        $table = self::tag('table', $attributes);

        // Generar THEAD
        if (!empty($headers)) {
            $tr = self::tag('tr');
            foreach ($headers as $header) {
                $tr->addChild(self::tag('th', [], $header));
            }
            $table->addChild(self::tag('thead', [], $tr));
        }

        // Generar TBODY
        if (!empty($rows)) {
            $tbody = self::tag('tbody');
            foreach ($rows as $row) {
                $tr = self::tag('tr');
                foreach ($row as $cell) {
                    $tr->addChild(self::tag('td', [], $cell));
                }
                $tbody->addChild($tr);
            }
            $table->addChild($tbody);
        }

        return $table;
    }

    // --- Constructor de Tablas Atómico ---

    /**
     * Crea un elemento caption (título de tabla).
     */
    public static function caption(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('caption', $attributes, $content);
    }

    /**
     * Crea un elemento colgroup (grupo de columnas).
     */
    public static function colgroup(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('colgroup', $attributes, $content);
    }

    /**
     * Crea un elemento col (columna).
     */
    public static function col(array $attributes = []): TagInterface
    {
        return self::tag('col', $attributes);
    }

    /**
     * Crea un elemento thead (encabezado de tabla).
     */
    public static function thead(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('thead', $attributes, $content);
    }

    /**
     * Crea un elemento tbody (cuerpo de tabla).
     */
    public static function tbody(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('tbody', $attributes, $content);
    }

    /**
     * Crea un elemento tfoot (pie de tabla).
     */
    public static function tfoot(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('tfoot', $attributes, $content);
    }

    /**
     * Crea un elemento tr (fila de tabla).
     */
    public static function tr(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('tr', $attributes, $content);
    }

    /**
     * Crea un elemento th (celda de encabezado).
     */
    public static function th(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('th', $attributes, $content);
    }

    /**
     * Crea un elemento td (celda de datos).
     */
    public static function td(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('td', $attributes, $content);
    }
}
