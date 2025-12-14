<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Libraries\Html\Bootstrap;

use App\Libraries\Html\HtmlTag;
use InvalidArgumentException;

/**
 * Clase que genera una barra de progreso de Bootstrap.
 * @see https://getbootstrap.com/docs/5.0/components/progress/
 */
class ProgressBar
{
    private int $value;
    private int $min;
    private int $max;
    private ?string $label;
    private string $class;
    private bool $striped;
    private bool $animated;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->value = (int)$this->get_Attribute($attributes, 'value', 0, false);
        $this->min = (int)$this->get_Attribute($attributes, 'min', 0, false);
        $this->max = (int)$this->get_Attribute($attributes, 'max', 100, false);
        $this->label = $this->get_Attribute($attributes, 'label', null, false);
        $this->class = $this->get_Attribute($attributes, 'class', '', false); // e.g., bg-success, bg-info
        $this->striped = (bool)$this->get_Attribute($attributes, 'striped', false, false);
        $this->animated = (bool)$this->get_Attribute($attributes, 'animated', false, false);
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param array $attributes
     * @param string $key El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @param bool $required Si se establece en true, se lanzará una excepción si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     */
    private function get_Attribute(array $attributes, string $key, mixed $default, bool $required): mixed
    {
        if (array_key_exists($key, $attributes)) {
            return $attributes[$key];
        } elseif ($required) {
            throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
        }
        return $default;
    }

    /**
     * Renderiza la barra de progreso como una cadena HTML.
     * @return string
     */
    public function render(): string
    {
        $percentage = ($this->value - $this->min) / ($this->max - $this->min) * 100;
        $progressBarClasses = ['progress-bar'];
        if ($this->class) {
            $progressBarClasses[] = $this->class;
        }
        if ($this->striped) {
            $progressBarClasses[] = 'progress-bar-striped';
        }
        if ($this->animated) {
            $progressBarClasses[] = 'progress-bar-animated';
        }

        $progressBarClassString = implode(' ', $progressBarClasses);

        $labelContent = $this->label ?? "{$this->value}%";

        $divProgressBar = HtmlTag::tag('div', [
            'class' => $progressBarClassString,
            'role' => 'progressbar',
            'style' => "width: {$percentage}%;",
            'aria-valuenow' => (string)$this->value,
            'aria-valuemin' => (string)$this->min,
            'aria-valuemax' => (string)$this->max,
        ], $labelContent);

        $divProgress = HtmlTag::tag('div', ['class' => 'progress'], $divProgressBar);

        return (string)$divProgress;
    }

    /**
     * Permite que el objeto se represente como una cadena.
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}

?>