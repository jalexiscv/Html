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

/**
 * General PHP Barcode Generator
 *
 * @author Casper Bakker - picqer.com
 * Based on TCPDF Barcode Generator
 */

namespace App\Libraries\Barcode;

use App\Libraries\Barcode\Exceptions\UnknownTypeException;
use App\Libraries\Barcode\Types\TypeCodabar;
use App\Libraries\Barcode\Types\TypeCode11;
use App\Libraries\Barcode\Types\TypeCode128;
use App\Libraries\Barcode\Types\TypeCode128A;
use App\Libraries\Barcode\Types\TypeCode128B;
use App\Libraries\Barcode\Types\TypeCode128C;
use App\Libraries\Barcode\Types\TypeCode32;
use App\Libraries\Barcode\Types\TypeCode39;
use App\Libraries\Barcode\Types\TypeCode39Checksum;
use App\Libraries\Barcode\Types\TypeCode39Extended;
use App\Libraries\Barcode\Types\TypeCode39ExtendedChecksum;
use App\Libraries\Barcode\Types\TypeCode93;
use App\Libraries\Barcode\Types\TypeEan13;
use App\Libraries\Barcode\Types\TypeEan8;
use App\Libraries\Barcode\Types\TypeIntelligentMailBarcode;
use App\Libraries\Barcode\Types\TypeInterleaved25;
use App\Libraries\Barcode\Types\TypeInterleaved25Checksum;
use App\Libraries\Barcode\Types\TypeITF14;
use App\Libraries\Barcode\Types\TypeKix;
use App\Libraries\Barcode\Types\TypeMsi;
use App\Libraries\Barcode\Types\TypeMsiChecksum;
use App\Libraries\Barcode\Types\TypePharmacode;
use App\Libraries\Barcode\Types\TypePharmacodeTwoCode;
use App\Libraries\Barcode\Types\TypePlanet;
use App\Libraries\Barcode\Types\TypePostnet;
use App\Libraries\Barcode\Types\TypeRms4cc;
use App\Libraries\Barcode\Types\TypeStandard2of5;
use App\Libraries\Barcode\Types\TypeStandard2of5Checksum;
use App\Libraries\Barcode\Types\TypeTelepen;
use App\Libraries\Barcode\Types\TypeUpcA;
use App\Libraries\Barcode\Types\TypeUpcE;
use App\Libraries\Barcode\Types\TypeUpcExtension2;
use App\Libraries\Barcode\Types\TypeUpcExtension5;

abstract class BarcodeGenerator
{
    const TYPE_CODE_32 = 'C32';
    const TYPE_CODE_39 = 'C39';
    const TYPE_CODE_39_CHECKSUM = 'C39+';
    const TYPE_CODE_39E = 'C39E'; // CODE 39 EXTENDED
    const TYPE_CODE_39E_CHECKSUM = 'C39E+'; // CODE 39 EXTENDED + CHECKSUM
    const TYPE_CODE_93 = 'C93';
    const TYPE_STANDARD_2_5 = 'S25';
    const TYPE_STANDARD_2_5_CHECKSUM = 'S25+';
    const TYPE_INTERLEAVED_2_5 = 'I25';
    const TYPE_INTERLEAVED_2_5_CHECKSUM = 'I25+';
    const TYPE_ITF_14 = 'ITF14';
    const TYPE_CODE_128 = 'C128';
    const TYPE_CODE_128_A = 'C128A';
    const TYPE_CODE_128_B = 'C128B';
    const TYPE_CODE_128_C = 'C128C';
    const TYPE_EAN_2 = 'EAN2'; // 2-Digits UPC-Based Extention
    const TYPE_EAN_5 = 'EAN5'; // 5-Digits UPC-Based Extention
    const TYPE_EAN_8 = 'EAN8';
    const TYPE_EAN_13 = 'EAN13';
    const TYPE_UPC_A = 'UPCA';
    const TYPE_UPC_E = 'UPCE';
    const TYPE_MSI = 'MSI'; // MSI (Variation of Plessey code)
    const TYPE_MSI_CHECKSUM = 'MSI+'; // MSI + CHECKSUM (modulo 11)
    const TYPE_POSTNET = 'POSTNET';
    const TYPE_PLANET = 'PLANET';
    const TYPE_TELEPEN_ALPHA = 'TELEPENALPHA';
    const TYPE_TELEPEN_NUMERIC = 'TELEPENNUMERIC';
    const TYPE_RMS4CC = 'RMS4CC'; // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
    const TYPE_KIX = 'KIX'; // KIX (Klant index - Customer index)
    const TYPE_IMB = 'IMB'; // IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
    const TYPE_CODABAR = 'CODABAR';
    const TYPE_CODE_11 = 'CODE11';
    const TYPE_PHARMA_CODE = 'PHARMA';
    const TYPE_PHARMA_CODE_TWO_TRACKS = 'PHARMA2T';

    protected function getBarcodeData(string $code, string $type): Barcode
    {
        $barcodeDataBuilder = $this->createDataBuilderForType($type);

        return $barcodeDataBuilder->getBarcodeData($code);
    }

    protected function createDataBuilderForType(string $type)
    {
        switch (strtoupper($type)) {
            case self::TYPE_CODE_32:
                return new TypeCode32();

            case self::TYPE_CODE_39:
                return new TypeCode39();

            case self::TYPE_CODE_39_CHECKSUM:
                return new TypeCode39Checksum();

            case self::TYPE_CODE_39E:
                return new TypeCode39Extended();

            case self::TYPE_CODE_39E_CHECKSUM:
                return new TypeCode39ExtendedChecksum();

            case self::TYPE_CODE_93:
                return new TypeCode93();

            case self::TYPE_STANDARD_2_5:
                return new TypeStandard2of5();

            case self::TYPE_STANDARD_2_5_CHECKSUM:
                return new TypeStandard2of5Checksum();

            case self::TYPE_INTERLEAVED_2_5:
                return new TypeInterleaved25();

            case self::TYPE_INTERLEAVED_2_5_CHECKSUM:
                return new TypeInterleaved25Checksum();

            case self::TYPE_ITF_14:
                return new TypeITF14();

            case self::TYPE_CODE_128:
                return new TypeCode128();

            case self::TYPE_CODE_128_A:
                return new TypeCode128A();

            case self::TYPE_CODE_128_B:
                return new TypeCode128B();

            case self::TYPE_CODE_128_C:
                return new TypeCode128C();

            case self::TYPE_EAN_2:
                return new TypeUpcExtension2();

            case self::TYPE_EAN_5:
                return new TypeUpcExtension5();

            case self::TYPE_EAN_8:
                return new TypeEan8();

            case self::TYPE_EAN_13:
                return new TypeEan13();

            case self::TYPE_UPC_A:
                return new TypeUpcA();

            case self::TYPE_UPC_E:
                return new TypeUpcE();

            case self::TYPE_MSI:
                return new TypeMsi();

            case self::TYPE_MSI_CHECKSUM:
                return new TypeMsiChecksum();

            case self::TYPE_POSTNET:
                return new TypePostnet();

            case self::TYPE_PLANET:
                return new TypePlanet();

            case self::TYPE_RMS4CC:
                return new TypeRms4cc();

            case self::TYPE_KIX:
                return new TypeKix();

            case self::TYPE_IMB:
                return new TypeIntelligentMailBarcode();

            case self::TYPE_CODABAR:
                return new TypeCodabar();

            case self::TYPE_CODE_11:
                return new TypeCode11();

            case self::TYPE_PHARMA_CODE:
                return new TypePharmacode();

            case self::TYPE_PHARMA_CODE_TWO_TRACKS:
                return new TypePharmacodeTwoCode();

            case self::TYPE_TELEPEN_ALPHA:
                return new TypeTelepen();

            case self::TYPE_TELEPEN_NUMERIC:
                return new TypeTelepen('numeric');

        }

        throw new UnknownTypeException();
    }
}
