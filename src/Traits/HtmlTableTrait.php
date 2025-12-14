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
}
