<?php

declare(strict_types=1);

namespace Higgs\Html;

use Stringable;
use function gettype;
use function is_array;

/**
 * Clase AbstractBaseHtmlTagObject.
 *
 * Esta clase es la base para otros objetos de etiquetas HTML.
 * Contiene métodos simples y utilitarios requeridos por múltiples componentes.
 */
abstract class AbstractBaseHtmlTagObject
{
    /**
     * Transforma un array multidimensional en un array plano.
     *
     * @param array<mixed> $data El array de entrada.
     * @return array<mixed> Un array simple aplanado.
     */
    protected function ensureFlatArray(array $data): array
    {
        $flat = [];
        array_walk_recursive($data, function ($a) use (&$flat) {
            $flat[] = $a;
        });
        return $flat;
    }

    /**
     * Convierte un valor a cadena cuando es posible.
     *
     * @param mixed $data El valor de entrada.
     * @return string|null El valor convertido a cadena o null si no es posible.
     */
    protected function ensureString(mixed $data): ?string
    {
        return match (true) {
            is_string($data) => $data,
            is_numeric($data) => (string)$data,
            $data instanceof Stringable || (is_object($data) && method_exists($data, '__toString')) => (string)$data,
            default => null,
        };
    }

    /**
     * Asegura que los valores sean convertidos en un array de cadenas.
     *
     * @param array<mixed> $values Los valores de entrada.
     * @return array<string> Los valores de salida convertidos.
     */
    protected function ensureStrings(array $values): array
    {
        $strings = [];
        foreach ($values as $value) {
            $str = $this->ensureString($value);
            if ($str !== null) {
                $strings[] = $str;
            }
        }
        return $strings;
    }
}
