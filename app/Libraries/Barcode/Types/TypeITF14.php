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

namespace App\Libraries\Barcode\Types;

use App\Libraries\Barcode\Barcode;
use App\Libraries\Barcode\BarcodeBar;
use App\Libraries\Barcode\Exceptions\InvalidCharacterException;
use App\Libraries\Barcode\Exceptions\InvalidLengthException;

class TypeITF14 implements TypeInterface
{
    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     */
    public function getBarcodeData(string $code): Barcode
    {
        $chr = [];
        $chr['0'] = '11221';
        $chr['1'] = '21112';
        $chr['2'] = '12112';
        $chr['3'] = '22111';
        $chr['4'] = '11212';
        $chr['5'] = '21211';
        $chr['6'] = '12211';
        $chr['7'] = '11122';
        $chr['8'] = '21121';
        $chr['9'] = '12121';
        $chr['A'] = '11';
        $chr['Z'] = '21';

        if (strlen($code) < 13 || strlen($code) > 14) {
            throw new InvalidLengthException();
        }

        if (strlen($code) === 13) {
            $code .= $this->getChecksum($code);
        }

        $barcode = new Barcode($code);

        // Add start and stop codes
        $code = 'AA' . strtolower($code) . 'ZA';

        // Loop through 2 chars at once
        for ($charIndex = 0; $charIndex < strlen($code); $charIndex += 2) {
            if (!isset($chr[$code[$charIndex]]) || !isset($chr[$code[$charIndex + 1]])) {
                throw new InvalidCharacterException();
            }

            $drawBar = true;
            $pbars = $chr[$code[$charIndex]];
            $pspaces = $chr[$code[$charIndex + 1]];
            $pmixed = '';

            while (strlen($pbars) > 0) {
                $pmixed .= $pbars[0] . $pspaces[0];
                $pbars = substr($pbars, 1);
                $pspaces = substr($pspaces, 1);
            }

            foreach (str_split($pmixed) as $width) {
                $barcode->addBar(new BarcodeBar($width, 1, $drawBar));
                $drawBar = !$drawBar;
            }
        }

        return $barcode;
    }

    private function getChecksum(string $code): string
    {
        $total = 0;

        for ($charIndex = 0; $charIndex <= (strlen($code) - 1); $charIndex++) {
            $integerOfChar = intval($code . substr($charIndex, 1));
            $total += $integerOfChar * (($charIndex === 0 || $charIndex % 2 === 0) ? 3 : 1);
        }

        $checksum = 10 - ($total % 10);
        if ($checksum === 10) {
            $checksum = 0;
        }

        return (string)$checksum;
    }
}
