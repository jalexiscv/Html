<?php

declare(strict_types=1);

namespace Higgs\Html\Traits;

use Closure;
use ReflectionClass;
use ReflectionMethod;
use BadMethodCallException;

/**
 * Trait Macroable
 * Permite agregar métodos dinámicamente a la clase Html.
 */
trait Macroable
{
    /**
     * Los macros registrados.
     *
     * @var array
     */
    protected static $macros = [];

    /**
     * Registra un macro personalizado.
     *
     * @param string $name Nombre del método.
     * @param object|callable $macro Lógica del macro.
     */
    public static function macro(string $name, object|callable $macro): void
    {
        static::$macros[$name] = $macro;
    }

    /**
     * Verifica si un macro está registrado.
     *
     * @param string $name
     * @return bool
     */
    public static function hasMacro(string $name): bool
    {
        return isset(static::$macros[$name]);
    }

    /**
     * Maneja llamadas dinámicas estáticas a la clase.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.',
                static::class,
                $method
            ));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            $macro = $macro->bindTo(null, static::class);
        }

        return $macro(...$parameters);
    }
}
