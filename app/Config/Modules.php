<?php

namespace Config;


use Higgs\Modules\Modules as CoreModules;

class Modules extends CoreModules
{
    /*
     |--------------------------------------------------------------------------
     | Detección automática habilitada?
     |--------------------------------------------------------------------------
     | Si es verdadero, el descubrimiento automático se producirá en todos los elementos enumerados en
     | $activeExplorers a continuación. Si es falso, no se producirá ningún descubrimiento automático,
     | dando un ligero impulso al rendimiento.
     */
    public $enabled = true;


    /**
     * @var bool $discoverInComposer
     * ¿Está habilitado el descubrimiento automático dentro de los paquetes de Composer?: Si es verdadero, el
     * descubrimiento automático se realizará en todos los espacios de nombres cargados por Composer, así como en los
     * espacios de nombres configurados localmente.
     */
    public $discoverInComposer = false;

    /**
     * Auto-discover Rules: Lista de alias de todas las clases de detección que estarán activas y se usarán durante la solicitud de
     * aplicación actual. Si no aparece en la lista, solo se usarán los elementos de la aplicación base.
     * @example public $aliases = ['events','registrars','routes','services'];
     */
    public $aliases = [];

}
