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

// ---------------------------------------------------------------------
// QUADRATIC
// ---------------------------------------------------------------------
function QuadraticInOut(k) {

    if ((k *= 2) < 1) {

        return 0.5 * k * k;

    }

    return -0.5 * (--k * (k - 2) - 1);

}

function QuadraticIn(k) {

    return k * k;

}

function QuadraticOut(k) {

    return k * (2 - k);

}

// ---------------------------------------------------------------------
// CUBIC
// ---------------------------------------------------------------------

function CubicInOut(k) {

    if ((k *= 2) < 1) {

        return 0.5 * k * k * k;

    }

    return 0.5 * ((k -= 2) * k * k + 2);

}

function CubicIn(k) {

    return k * k * k;

}

function CubicOut(k) {

    return --k * k * k + 1;

}

// ---------------------------------------------------------------------
// SINUSOIDAL
// ---------------------------------------------------------------------

function SinusoidalInOut(k) {

    return 0.5 * (1 - Math.cos(Math.PI * k));

}

function SinusoidalIn(k) {

    return 1 - Math.cos(k * Math.PI / 2);

}

function SinusoidalOut(k) {

    return Math.sin(k * Math.PI / 2);

}

// ---------------------------------------------------------------------
// EXPONENTIAL
// ---------------------------------------------------------------------

function ExponentialInOut(k) {

    if (k === 0) return 0;
    if (k === 1) return 1;

    if ((k *= 2) < 1) {

        return 0.5 * Math.pow(1024, k - 1);

    }

    return 0.5 * (-Math.pow(2, -10 * (k - 1)) + 2);

}

function ExponentialIn(k) {

    return k === 0 ? 0 : Math.pow(1024, k - 1);

}

function ExponentialOut(k) {

    return k === 1 ? 1 : 1 - Math.pow(2, -10 * k);

}

// ---------------------------------------------------------------------
// CIRCULAR
// ---------------------------------------------------------------------

function CircularInOut(k) {

    if ((k *= 2) < 1) {

        return -0.5 * (Math.sqrt(1 - k * k) - 1);

    }

    return 0.5 * (Math.sqrt(1 - (k -= 2) * k) + 1);

}

function CircularIn(k) {

    return 1 - Math.sqrt(1 - k * k);

}

function CircularOut(k) {

    return Math.sqrt(1 - (--k * k));

}

// ---------------------------------------------------------------------
// BACK
// ---------------------------------------------------------------------

function BackInOut(k) {

    var s = 1.70158 * 1.525;

    if ((k *= 2) < 1) {

        return 0.5 * (k * k * ((s + 1) * k - s));

    }

    return 0.5 * ((k -= 2) * k * ((s + 1) * k + s) + 2);

}

function BackIn(k) {

    var s = 1.70158;

    return k * k * ((s + 1) * k - s);

}

function BackOut(k) {

    var s = 1.70158;

    return --k * k * ((s + 1) * k + s) + 1;

}

// ---------------------------------------------------------------------
// ELASTIC
// ---------------------------------------------------------------------

function ElasticInOut(k) {

    if (k === 0) return 0;
    if (k === 1) return 1;

    k *= 2;

    if (k < 1) {

        return -0.5 * Math.pow(2, 10 * (k - 1)) * Math.sin((k - 1.1) * 5 * Math.PI);

    }

    return 0.5 * Math.pow(2, -10 * (k - 1)) * Math.sin((k - 1.1) * 5 * Math.PI) + 1;

}

function ElasticIn(k) {

    if (k === 0) return 0;
    if (k === 1) return 1;

    return -Math.pow(2, 10 * (k - 1)) * Math.sin((k - 1.1) * 5 * Math.PI);

}

function ElasticOut(k) {

    if (k === 0) return 0;
    if (k === 1) return 1;

    return Math.pow(2, -10 * k) * Math.sin((k - 0.1) * 5 * Math.PI) + 1;

}