<?php

namespace App\Libraries;

/**
 * @package Insside
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright (c) 2015 www.insside.com
 * @version 1.0
 */
if (!class_exists("Numbers")) {

    class Numbers
    {

        public static function to_TextualCurrency($floatcurr, $curr = 'COP')
        {
            $currencies['COP'] = array(
                "decimals" => 0,
                "decimal-separator" => ",",
                "thousands-separator" => ".",
                "currency" => "COP",
                "symbol" => "$"
            );
            $number = number_format(
                $floatcurr,
                $currencies[$curr]["decimals"],
                $currencies[$curr]["decimal-separator"],
                $currencies[$curr]["thousands-separator"]);
            $text = "\${$number} <span class=\"text-muted\">{$currencies[$curr]["currency"]}</span>";
            return ($text);
        }

        public static function to_Currency($floatcurr, $curr = 'COP')
        {
            $currencies['ARS'] = array(2, ',', '.');          //  Argentine Peso
            $currencies['AMD'] = array(2, '.', ',');          //  Armenian Dram
            $currencies['AWG'] = array(2, '.', ',');          //  Aruban Guilder
            $currencies['AUD'] = array(2, '.', ' ');          //  Australian Dollar
            $currencies['BSD'] = array(2, '.', ',');          //  Bahamian Dollar
            $currencies['BHD'] = array(3, '.', ',');          //  Bahraini Dinar
            $currencies['BDT'] = array(2, '.', ',');          //  Bangladesh, Taka
            $currencies['BZD'] = array(2, '.', ',');          //  Belize Dollar
            $currencies['BMD'] = array(2, '.', ',');          //  Bermudian Dollar
            $currencies['BOB'] = array(2, '.', ',');          //  Bolivia, Boliviano
            $currencies['BAM'] = array(2, '.', ',');          //  Bosnia and Herzegovina, Convertible Marks
            $currencies['BWP'] = array(2, '.', ',');          //  Botswana, Pula
            $currencies['BRL'] = array(2, ',', '.');          //  Brazilian Real
            $currencies['BND'] = array(2, '.', ',');          //  Brunei Dollar
            $currencies['CAD'] = array(2, '.', ',');          //  Canadian Dollar
            $currencies['KYD'] = array(2, '.', ',');          //  Cayman Islands Dollar
            $currencies['CLP'] = array(0, '', '.');          //  Chilean Peso
            $currencies['CNY'] = array(2, '.', ',');          //  China Yuan Renminbi
            $currencies['COP'] = array(2, ',', '.',);          //  Colombian Peso
            $currencies['CRC'] = array(2, ',', '.');          //  Costa Rican Colon
            $currencies['HRK'] = array(2, ',', '.');          //  Croatian Kuna
            $currencies['CUC'] = array(2, '.', ',');          //  Cuban Convertible Peso
            $currencies['CUP'] = array(2, '.', ',');          //  Cuban Peso
            $currencies['CYP'] = array(2, '.', ',');          //  Cyprus Pound
            $currencies['CZK'] = array(2, '.', ',');          //  Czech Koruna
            $currencies['DKK'] = array(2, ',', '.');          //  Danish Krone
            $currencies['DOP'] = array(2, '.', ',');          //  Dominican Peso
            $currencies['XCD'] = array(2, '.', ',');          //  East Caribbean Dollar
            $currencies['EGP'] = array(2, '.', ',');          //  Egyptian Pound
            $currencies['SVC'] = array(2, '.', ',');          //  El Salvador Colon
            $currencies['ATS'] = array(2, ',', '.');          //  Euro
            $currencies['BEF'] = array(2, ',', '.');          //  Euro
            $currencies['DEM'] = array(2, ',', '.');          //  Euro
            $currencies['EEK'] = array(2, ',', '.');          //  Euro
            $currencies['ESP'] = array(2, ',', '.');          //  Euro
            $currencies['EUR'] = array(2, ',', '.');          //  Euro
            $currencies['FIM'] = array(2, ',', '.');          //  Euro
            $currencies['FRF'] = array(2, ',', '.');          //  Euro
            $currencies['GRD'] = array(2, ',', '.');          //  Euro
            $currencies['IEP'] = array(2, ',', '.');          //  Euro
            $currencies['ITL'] = array(2, ',', '.');          //  Euro
            $currencies['LUF'] = array(2, ',', '.');          //  Euro
            $currencies['NLG'] = array(2, ',', '.');          //  Euro
            $currencies['PTE'] = array(2, ',', '.');          //  Euro
            $currencies['GHC'] = array(2, '.', ',');          //  Ghana, Cedi
            $currencies['GIP'] = array(2, '.', ',');          //  Gibraltar Pound
            $currencies['GTQ'] = array(2, '.', ',');          //  Guatemala, Quetzal
            $currencies['HNL'] = array(2, '.', ',');          //  Honduras, Lempira
            $currencies['HKD'] = array(2, '.', ',');          //  Hong Kong Dollar
            $currencies['HUF'] = array(0, '', '.');          //  Hungary, Forint
            $currencies['ISK'] = array(0, '', '.');          //  Iceland Krona
            $currencies['INR'] = array(2, '.', ',');          //  Indian Rupee
            $currencies['IDR'] = array(2, ',', '.');          //  Indonesia, Rupiah
            $currencies['IRR'] = array(2, '.', ',');          //  Iranian Rial
            $currencies['JMD'] = array(2, '.', ',');          //  Jamaican Dollar
            $currencies['JPY'] = array(0, '', ',');          //  Japan, Yen
            $currencies['JOD'] = array(3, '.', ',');          //  Jordanian Dinar
            $currencies['KES'] = array(2, '.', ',');          //  Kenyan Shilling
            $currencies['KWD'] = array(3, '.', ',');          //  Kuwaiti Dinar
            $currencies['LVL'] = array(2, '.', ',');          //  Latvian Lats
            $currencies['LBP'] = array(0, '', ' ');          //  Lebanese Pound
            $currencies['LTL'] = array(2, ',', ' ');          //  Lithuanian Litas
            $currencies['MKD'] = array(2, '.', ',');          //  Macedonia, Denar
            $currencies['MYR'] = array(2, '.', ',');          //  Malaysian Ringgit
            $currencies['MTL'] = array(2, '.', ',');          //  Maltese Lira
            $currencies['MUR'] = array(0, '', ',');          //  Mauritius Rupee
            $currencies['MXN'] = array(2, '.', ',');          //  Mexican Peso
            $currencies['MZM'] = array(2, ',', '.');          //  Mozambique Metical
            $currencies['NPR'] = array(2, '.', ',');          //  Nepalese Rupee
            $currencies['ANG'] = array(2, '.', ',');          //  Netherlands Antillian Guilder
            $currencies['ILS'] = array(2, '.', ',');          //  New Israeli Shekel
            $currencies['TRY'] = array(2, '.', ',');          //  New Turkish Lira
            $currencies['NZD'] = array(2, '.', ',');          //  New Zealand Dollar
            $currencies['NOK'] = array(2, ',', '.');          //  Norwegian Krone
            $currencies['PKR'] = array(2, '.', ',');          //  Pakistan Rupee
            $currencies['PEN'] = array(2, '.', ',');          //  Peru, Nuevo Sol
            $currencies['UYU'] = array(2, ',', '.');          //  Peso Uruguayo
            $currencies['PHP'] = array(2, '.', ',');          //  Philippine Peso
            $currencies['PLN'] = array(2, '.', ' ');          //  Poland, Zloty
            $currencies['GBP'] = array(2, '.', ',');          //  Pound Sterling
            $currencies['OMR'] = array(3, '.', ',');          //  Rial Omani
            $currencies['RON'] = array(2, ',', '.');          //  Romania, New Leu
            $currencies['ROL'] = array(2, ',', '.');          //  Romania, Old Leu
            $currencies['RUB'] = array(2, ',', '.');          //  Russian Ruble
            $currencies['SAR'] = array(2, '.', ',');          //  Saudi Riyal
            $currencies['SGD'] = array(2, '.', ',');          //  Singapore Dollar
            $currencies['SKK'] = array(2, ',', ' ');          //  Slovak Koruna
            $currencies['SIT'] = array(2, ',', '.');          //  Slovenia, Tolar
            $currencies['ZAR'] = array(2, '.', ' ');          //  South Africa, Rand
            $currencies['KRW'] = array(0, '', ',');          //  South Korea, Won
            $currencies['SZL'] = array(2, '.', ', ');         //  Swaziland, Lilangeni
            $currencies['SEK'] = array(2, ',', '.');          //  Swedish Krona
            $currencies['CHF'] = array(2, '.', '\'');         //  Swiss Franc
            $currencies['TZS'] = array(2, '.', ',');          //  Tanzanian Shilling
            $currencies['THB'] = array(2, '.', ',');          //  Thailand, Baht
            $currencies['TOP'] = array(2, '.', ',');          //  Tonga, Paanga
            $currencies['AED'] = array(2, '.', ',');          //  UAE Dirham
            $currencies['UAH'] = array(2, ',', ' ');          //  Ukraine, Hryvnia
            $currencies['USD'] = array(2, '.', ',');          //  US Dollar
            $currencies['VUV'] = array(0, '', ',');          //  Vanuatu, Vatu
            $currencies['VEF'] = array(2, ',', '.');          //  Venezuela Bolivares Fuertes
            $currencies['VEB'] = array(2, ',', '.');          //  Venezuela, Bolivar
            $currencies['VND'] = array(0, '', '.');          //  Viet Nam, Dong
            $currencies['ZWD'] = array(2, '.', ' ');          //  Zimbabwe Dollar
            if ($curr == "INR") {
                return _self::formatinr($floatcurr);
            } else {
                return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
            }
        }

        // custom function to generate: ##,##,###.##
        function formatinr($input)
        {
            $dec = "";
            $pos = strpos($input, ".");
            if ($pos === FALSE) {
                //no decimals
            } else {
                //decimals
                $dec = substr(round(substr($input, $pos), 2), 1);
                $input = substr($input, 0, $pos);
            }
            $num = substr($input, -3);    // get the last 3 digits
            $input = substr($input, 0, -3); // omit the last 3 digits already stored in $num
            // loop the process - further get digits 2 by 2
            while (strlen($input) > 0) {
                $num = substr($input, -2) . "," . $num;
                $input = substr($input, 0, -2);
            }
            return ("{$num}.{$dec}");
        }

        public static function get_NumberFormat($number, $decimals = 0)
        {
            return (number_format($number, $decimals));
        }

        public static function toStat($number)
        {
            return ($number);
        }

        /**
         * Convierte un numero a letras(palabras)
         * Máxima cifra soportada: 18 dígitos con 2 decimales
         * Ejemplo: 999,999,999,999,999,999.99
         * Resultado: NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
         * @param type $xcifra
         * @return type
         */
        public static function toWords($xcifra)
        {
            $xarray = array(0 => "Cero",
                1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
                "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
                "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
                100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
            );
//
            $xcifra = trim($xcifra);
            $xlength = strlen($xcifra);
            $xpos_punto = strpos($xcifra, ".");
            $xaux_int = $xcifra;
            $xdecimales = "00";
            if (!($xpos_punto === false)) {
                if ($xpos_punto == 0) {
                    $xcifra = "0" . $xcifra;
                    $xpos_punto = strpos($xcifra, ".");
                }
                $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
                $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
            }

            $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
            $xcadena = "";
            for ($xz = 0; $xz < 3; $xz++) {
                $xaux = substr($XAUX, $xz * 6, 6);
                $xi = 0;
                $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
                $xexit = true; // bandera para controlar el ciclo del While 
                while ($xexit) {
                    if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                        break; // termina el ciclo
                    }

                    $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                    $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                    for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                        switch ($xy) {
                            case 1: // checa las centenas
                                if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                } else {
                                    $xseek = isset($xarray[substr($xaux, 0, 3)]) ? true : false; // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    if ($xseek) {
                                        $xsub = self::subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                        if (substr($xaux, 0, 3) == 100)
                                            $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                    } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                        $xseek = $xarray[substr($xaux, 0, 1) * 100]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 0, 3) < 100)
                                break;
                            case 2: // checa las decenas (con la misma lógica que las centenas)
                                if (substr($xaux, 1, 2) < 10) {

                                } else {
                                    $xseek = isset($xarray[substr($xaux, 1, 2)]) ? true : false;
                                    if ($xseek) {
                                        $xsub = self::subfijo($xaux);
                                        if (substr($xaux, 1, 2) == 20)
                                            $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3;
                                    } else {
                                        $xseek = $xarray[substr($xaux, 1, 1) * 10];
                                        if (substr($xaux, 1, 1) * 10 == 20)
                                            $xcadena = " " . $xcadena . " " . $xseek;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 1, 2) < 10)
                                break;
                            case 3: // checa las unidades
                                if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                } else {
                                    $xseek = $xarray[substr($xaux, 2, 1)]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                    $xsub = self::subfijo($xaux);
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                } // ENDIF (substr($xaux, 2, 1) < 1)
                                break;
                        } // END SWITCH
                    } // END FOR
                    $xi = $xi + 3;
                } // ENDDO

                if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                    $xcadena .= " DE";

                if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                    $xcadena .= " DE";

// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
                if (trim($xaux) != "") {
                    switch ($xz) {
                        case 0:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN BILLON ";
                            else
                                $xcadena .= " BILLONES ";
                            break;
                        case 1:
                            if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                                $xcadena .= "UN MILLON ";
                            else
                                $xcadena .= " MILLONES ";
                            break;
                        case 2:
                            if ($xcifra < 1) {
                                //$xcadena = "CERO PESOS $xdecimales/100 M.N.";
                                $xcadena = "CERO PESOS M/CTE";
                            }
                            if ($xcifra >= 1 && $xcifra < 2) {
                                //$xcadena = "UN PESO $xdecimales/100 M.N. ";
                                $xcadena = "UN PESO M/CTE";
                            }
                            if ($xcifra >= 2) {
                                //$xcadena .= " PESOS $xdecimales/100 M.N. "; // 
                                $xcadena .= " PESOS M/CTE"; // 
                            }
                            break;
                    } // endswitch ($xz)
                } // ENDIF (trim($xaux) != "")
// ------------------      en este caso, para México se usa esta leyenda     ----------------
                $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles 
                $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles 
                $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
            } // ENDFOR ($xz)
            return trim($xcadena);
        }

// END FUNCTION

        public static function subfijo($xx)
        { // esta función regresa un subfijo para la cifra
            $xx = trim($xx);
            $xstrlen = strlen($xx);
            if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
                $xsub = "";
// 
            if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
                $xsub = "MIL";
//
            return $xsub;
        }

        /**
         * Converts a number into a short version, eg: 1000 -> 1k
         */
        public static function get_Short($n, $precision = 1)
        {
            if (empty($n) || is_null($n)) {
                $n = 0;
            }
            if ($n < 900) {
                // 0 - 900
                $n_format = number_format($n, $precision);
                $suffix = '';
            } else if ($n < 900000) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = 'K';
            } else if ($n < 900000000) {
                // 0.9m-850m
                $n_format = number_format($n / 1000000, $precision);
                $suffix = 'M';
            } else if ($n < 900000000000) {
                // 0.9b-850b
                $n_format = number_format($n / 1000000000, $precision);
                $suffix = 'B';
            } else {
                // 0.9t+
                $n_format = number_format($n / 1000000000000, $precision);
                $suffix = 'T';
            }
            // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
            // Intentionally does not affect partials, eg "1.50" -> "1.50"
            if ($precision > 0) {
                $dotzero = '.' . str_repeat('0', $precision);
                $n_format = str_replace($dotzero, '', $n_format);
            }
            return $n_format . $suffix;
        }

        public static function pad_LeftWithZeros($text, $totalLength)
        {
            // Asegúrate de que $totalLength sea mayor que la longitud del texto
            if (strlen($text) >= $totalLength) {
                return $text;
            }
            // Rellena la cadena con ceros a la derecha hasta alcanzar la longitud total
            $paddedText = str_pad($text, $totalLength, "0", STR_PAD_LEFT);
            return $paddedText;
        }

        /**
         * Divide un número en partes enteras exactas y manejar cualquier discrepancia decimal en la última parte:
         * 1). Determina el valor entero que cada parte debe tener dividiendo el número total por el número de partes, y luego tomando la parte entera de este resultado.
         * 2). Calcula el total que se ha distribuido multiplicando el valor entero de cada parte por el número de partes.
         * 3). Calcula la discrepancia restando el total original por el total distribuido.
         * 4). Asigna el valor entero a cada parte, y añade la discrepancia al último valor para asegurar que la suma de todas las partes sea igual al total original.
         * Ejemplo de uso
         *          $numeroTotal = 100;
         *          $numeroDePartes = 3;
         *          $partes = dividirEnPartesEnteras($numeroTotal, $numeroDePartes);
         *          print_r($partes);
         * @param $numeroTotal
         * @param $numeroDePartes
         * @return array
         */
        public static function get_WholeParts($numeroTotal, $numeroDePartes)
        {
            // Convert inputs to proper types
            $numeroTotal = floatval($numeroTotal);
            $numeroDePartes = intval($numeroDePartes);

            // Calculate value per part (using floor to get whole parts)
            $valorPorParte = floor($numeroTotal / $numeroDePartes);

            // Calculate total distributed
            $totalDistribuido = $valorPorParte * $numeroDePartes;

            // Calculate discrepancy
            $discrepancia = $numeroTotal - $totalDistribuido;

            // Assign values to each part
            $partes = array_fill(0, $numeroDePartes, $valorPorParte);

            // Add the discrepancy to the last value
            $partes[$numeroDePartes - 1] += $discrepancia;

            return $partes;
        }


        public function convertToFloat($entrada, $decimales = 2)
        {
            // Asegurarse de que la entrada sea numérica
            if (!is_numeric($entrada)) {
                return false;
            }

            // Convertir la entrada a float
            $numero = floatval($entrada);

            // Formatear el número con la cantidad especificada de decimales
            return number_format($numero, $decimales, '.', '');
        }
    }

}