<?php

namespace App\Libraries;
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

class Crypt
{
    // Definimos el alfabeto de la cifra
    private string $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    // Generar una clave aleatoria

    /**
     * Este método encripta un texto
     * @param $text
     * @param $key
     * @return mixed
     */
    public function encrypt($text, $key = null): mixed
    {
        if ($key === null) {
            $key = $this->generateKey();
        }
        $result = $key; // Iniciamos el resultado con la clave
        $keyLength = strlen($key);
        for ($i = 0; $i < strlen($text); $i++) {
            $charIndex = strpos($this->alphabet, $text[$i]);
            if ($charIndex !== false) {
                // Usa la posición del carácter y de la clave para encriptar
                $newIndex = ($charIndex + strpos($this->alphabet, $key[$i % $keyLength])) % strlen($this->alphabet);
                $result .= $this->alphabet[$newIndex];
            } else {
                $result .= $text[$i]; // Caracteres especiales no se encriptan
            }
        }
        return $result;
    }

    // Encriptar el texto

    /**
     * Este método genera una clave aleatoria
     * @param int $length
     * @return string
     */
    public function generateKey(int $length = 16): string
    {
        $result = '';
        $charactersLength = strlen($this->alphabet);
        for ($i = 0; $i < $length; $i++) {
            $result .= $this->alphabet[rand(0, $charactersLength - 1)];
        }
        return $result;
    }

    /**
     * Este método desencripta un texto
     * @param $encryptedText
     * @param int $keyLength
     * @return string
     */
    public function decrypt($encryptedText, int $keyLength = 5): string
    {
        $key = substr($encryptedText, 0, $keyLength); // Extraemos la clave
        $text = substr($encryptedText, $keyLength); // Extraemos el mensaje encriptado
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $charIndex = strpos($this->alphabet, $text[$i]);
            if ($charIndex !== false) {
                // Usa la posición del carácter y de la clave para desencriptar
                $newIndex = ($charIndex - strpos($this->alphabet, $key[$i % $keyLength]) + strlen($this->alphabet)) % strlen($this->alphabet);
                $result .= $this->alphabet[$newIndex];
            } else {
                $result .= $text[$i]; // Caracteres especiales no se desencriptan
            }
        }
        return $result;
    }
}

?>