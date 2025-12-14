<?php

declare(strict_types=1);

namespace Higgs\Html\Attribute;

/**
 * Class ClassAttribute
 * Maneja lógica específica para el atributo 'class', permitiendo arrays condicionales.
 */
class ClassAttribute extends Attribute
{
    /**
     * Procesa los valores permitiendo claves condicionales.
     * Ejemplo: ['btn', 'active' => $isActive, 'd-none' => false]
     * Resultado: ['btn', 'active']
     */
    public function preprocess(array $values, array $context = []): array
    {
        $processed = [];

        foreach ($values as $key => $value) {
            if (is_string($key)) {
                // Si la clave es string (ej: 'active' => true), 
                // usamos la clave como valor solo si el valor es true.
                if ($value === true) {
                    $processed[] = $key;
                }
                // Si es false, se descarta.
            } else {
                // Si la clave es numérica (índice normal), usamos el valor tal cual.
                $processed[] = $value;
            }
        }

        return $processed;
    }
}
