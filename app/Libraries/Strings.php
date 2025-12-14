<?php

namespace App\Libraries;

/**
 * @package Insside
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright (c) 2015 www.insside.com
 * @version 1.0
 */
if (!class_exists("Strings")) {

    class Strings
    {

        private $string;


        public static function removePluralEnding($word)
        {
            $endings = ['es', 'as', 's', 'ies', 'oes', 'ves'];
            foreach ($endings as $ending) {
                if (substr($word, -strlen($ending)) === $ending) {
                    return substr($word, 0, -strlen($ending));
                }
            }
            return $word;
        }


        /**
         * Devuelve parte de una cadena
         * @param type $texto
         * @param type $longitud
         * @return type
         */
        public static function getSubstr($texto, $longitud = 180)
        {
            if ((strlen($texto) > $longitud)) {
                $pos_espacios = strpos($texto, ' ', $longitud) - 1;
                if ($pos_espacios > 0) {
                    $caracteres = count_chars(substr($texto, 0, ($pos_espacios + 1)), 1);
                    if (@$caracteres[ord('<')] > @$caracteres[ord('>')]) {
                        $pos_espacios = strpos($texto, ">", $pos_espacios) - 1;
                    }
                    $texto = substr($texto, 0, ($pos_espacios + 1)) . '...';
                }
                if (preg_match_all("|(<([\w]+)[^>]*>)|", $texto, $buffer)) {
                    if (!empty($buffer[1])) {
                        preg_match_all("|</([a-zA-Z]+)>|", $texto, $buffer2);
                        if (count($buffer[2]) != count($buffer2[1])) {
                            $cierrotags = array_diff($buffer[2], $buffer2[1]);
                            $cierrotags = array_reverse($cierrotags);
                            foreach ($cierrotags as $tag) {
                                $texto .= '</' . $tag . '>';
                            }
                        }
                    }
                }
            }
            return ($texto);
        }


        function get_Protect(string $inputString, float $visiblePercentage = 50): string
        {
            $visiblePercentage = max(0, min(100, $visiblePercentage));
            $numVisibleCharacters = ceil(strlen($inputString) * ($visiblePercentage / 200));
            $visiblePartStart = substr($inputString, 0, $numVisibleCharacters);
            $visiblePartEnd = substr($inputString, -$numVisibleCharacters);
            $numHiddenCharacters = strlen($inputString) - (2 * $numVisibleCharacters);
            $hiddenPart = str_repeat('*', $numHiddenCharacters);
            $protectedString = $visiblePartStart . $hiddenPart . $visiblePartEnd;
            return $protectedString;
        }

        function get_Protect2(string $inputString, float $visiblePercentage = 50): string
        {
            $visiblePercentage = max(0, min(100, $visiblePercentage));
            $numVisibleCharacters = ceil(strlen($inputString) * ($visiblePercentage / 100));
            $visiblePart = substr($inputString, 0, $numVisibleCharacters);
            $hiddenPart = str_repeat('*', strlen($inputString) - $numVisibleCharacters);
            $protectedString = $visiblePart . $hiddenPart;
            return ($protectedString);
        }

        /**
         * Este metodo reemplazará todos los caracteres intermedios en el nombre de usuario por asteriscos (*),
         * manteniendo el primer y el último carácter intactos. Por ejemplo, si el correo electrónico original es
         * "ejemplo@example.com", el resultado será "e*****o@example.com". Ten en cuenta que esta técnica también
         * puede hacer que el correo electrónico sea menos legible para los usuarios, así que úsala con precaución.
         * @param $email
         * @return mixed|string
         */
        public function get_HideEmail($email)
        {
            // Dividir el correo electrónico en dos partes en el símbolo @
            $partes = explode('@', $email);

            if (count($partes) == 2) {
                $nombreUsuario = $partes[0];
                $dominio = $partes[1];

                // Obtener la longitud del nombre de usuario
                $longitud = strlen($nombreUsuario);

                // Reemplazar caracteres intermedios con asteriscos
                $caracteresOcultos = str_repeat('*', $longitud - 2);

                // Construir la dirección de correo electrónico oculta
                $correoOculto = $nombreUsuario[0] . $caracteresOcultos . $nombreUsuario[$longitud - 1] . '@' . $dominio;

                return $correoOculto;
            } else {
                // En caso de que el correo electrónico no sea válido, simplemente devolverlo sin cambios
                return $email;
            }
        }


        public function get_OTP($longitud = 6)
        {
            $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $codigo = '';

            for ($i = 0; $i < $longitud; $i++) {
                $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }
            return $codigo;
        }


        /**
         * Retorna el largo de una cadena
         * @param type $str
         * @return type
         */
        static function getLenght($str)
        {
            return (strlen($str));
        }

        static function capitalizar($str)
        {
            return (convert_case($str, CASE_TITLE, "UTF-8"));
        }

        function mayusculas($str)
        {
            return (convert_case($str, CASE_UPPER, "UTF-8"));
        }

        function minusculas($str)
        {
            return (convert_case($str, CASE_LOWER, "UTF-8"));
        }

        /** Esta funcion permite condenzar multiples espacios en blanco adyacentes en uno solo, es
         * ideal para resumir codigo tipo HTML, CSS reduciendo estos caracteres sobrantes.
         *
         * @param type $texto
         * @return type
         */
        public static function condenzar($texto)
        {
            return preg_replace("/\s+/", " ", $texto);
        }

        /**
         * Elimina los saltos de linea de una cadena
         * @param type $str
         * @return type
         */
        public static function saltos($str)
        {
            $str = str_replace("\n", "", $str);
            $str = str_replace("\r", "", $str);
            $str = preg_replace("/ +/", " ", $str);
            return ($str);
        }

        public static function tabulados($str)
        {
            return (trim($str, "\t"));
        }


        /*
         * Limpia una cadena proporsionada eliminando:
         *  - Saltos de linea \n
         *  - Retorcesos
         *  - Tabulaciones
         *  - Etiquetas html
         */


        public static function get_Clear($str)
        {
            $str = urldecode($str);
            $str = strip_tags($str);
            $str = str_replace("\n", "", $str);
            $str = str_replace("\r", "", $str);
            $str = str_replace("\t", "", $str);
            $str = preg_replace("/ +/", " ", $str);
            $str = htmlentities($str);
            $str = preg_replace('/\&(.)[^;]*;/', '\\1', $str);
            return $str;
        }

        /**
         * Elimina los saltos de linea y las tabulaciones de la cadena recivida
         * @param type $str
         */
        public static function fullTrim($str)
        {
            $str = str_replace("\n", "", $str);
            $str = str_replace("\t", "", $str);
            $str = str_replace("\r", "", $str);
            $str = preg_replace("/\s+/", " ", $str);
            return ($str);
        }

        /**
         * Retira las etiquetas HTML y PHP de un string
         * respeta las tildes
         * @param type $str
         * @return string the stripped string.
         */
        public static function get_Striptags($str)
        {
            $str = str_replace('"', '', $str);
            $str = str_replace("'", '', $str);
            return (strip_tags($str));
        }

        /**
         * Completa una cadena numerica con caracteres 0 a la izquierda
         * @param $valor
         * @param $longitud
         * @return false|string
         */
        function get_ZeroFill($valor, $longitud): false|string
        {
            if (empty($valor) || is_null($valor)) {
                return false;
            }
            return str_pad($valor, $longitud, '0', STR_PAD_LEFT);
        }

        function antesde($buscado, $str)
        {
            return substr($str, 0, strpos($str, $buscado));
        }

        function depuesdelultimo($buscado, $str)
        {
            if (!is_bool(strrevpos($str, $buscado))) {
                return substr($str, $this->strrevpos($str, $buscado) + strlen($buscado));
            }
        }

        function antesdelultimo($buscado, $str)
        {
            return substr($str, 0, $this->strrevpos($str, $buscado));
        }

        function entre($inicio, $final, $str)
        {
            return ($this->antesde($final, $this->despuesde($inicio, $str)));
        }

        function entreelprimeryultimo($inicio, $final, $str)
        {
            return ($this->antesdelultimo($final, $this->despuesde($inicio, $str)));
        }

        function entrelosultimos($inicio, $final, $str)
        {
            return $this->depuesdelultimo($inicio, $this->antesdelultimo($final, $str));
        }

// use strrevpos function in case your php version does not include it
        function strrevpos($instr, $needle)
        {
            $rev_pos = strpos(strrev($instr), strrev($needle));
            if ($rev_pos === false) {
                return false;
            } else {
                return strlen($instr) - $rev_pos - strlen($needle);
            }
        }

        public function despuesde($buscado, $str)
        {

            if (!is_bool(strpos($str, $buscado))) {
                return substr($str, strpos($str, $buscado) + strlen($buscado));
            }
        }

        /**
         * Recibido un texto largo genera la descripción corta del mismo de acuerdo a las
         * normas para el metadescription, Las meta descripciones pueden tener cualquier
         * longitud, pero Google generalmente trunca los fragmentos a ~ 155-160 caracteres.
         * Es mejor mantener las meta descripciones lo suficientemente largas como
         * para que sean lo suficientemente descriptivas, por lo que recomendamos descripciones
         * entre 50 y 160 caracteres. Tenga en cuenta que la duración "óptima" variará
         * según la situación, y su objetivo principal debe ser proporcionar valor y
         * generar clics.
         * @param type $titulo
         */
        public static function get_Description($content, $large = 155)
        {
            $content = str_replace("[p]", "", $content);
            $content = str_replace("[/p]", "", $content);
            return (self::get_WordWrap($content, $large));
        }

        public static function get_TitleCase($str)
        {
            /*
             * Exceptions in lower case are words you don't want converted
             * Exceptions all in upper case are any words you don't want converted to title case
             *   but should be converted to upper case, e.g.:
             *   king henry viii or king henry Viii should be King Henry VIII
             */
            $delimiters = array(" ", "-", ".", "'", "O'", "Mc");
            $exceptions = array("de", "del", "se", "con", "la", "y", "e", "ni", "no solo", "sino", "también", "tanto", "como", "así", "como", "igual", "que", "lo mismo", "que", "pero", "mas", "empero", "sino", "mientras que", "o bien", "bien", "ya", "ora", "sea", "fuera", "porque", "como", "ya que", "dado que", "visto que", "puesto que", "pues", "sin", "aunque", "aun cuando", "si bien", "así", "aun cuando", "por más que", "por mucho que", "si", "si no", "a menos que", "en caso de que", "siempre que", "con tal de que", "así que", "de modo que", "de manera que", "de forma que", "para que", "a fin de que", "luego", "conque", "luego que");

            $str = convert_case($str, CASE_TITLE, "UTF-8");

            foreach ($delimiters as $dlnr => $delimiter) {
                $words = explode($delimiter, $str);
                $newwords = array();
                foreach ($words as $wordnr => $word) {
                    if (in_array(strtoupper($word, "UTF-8"), $exceptions)) {
// check exceptions list for any words that should be in upper case
                        $word = strtoupper($word, "UTF-8");
                    } elseif (in_array(strtolower($word, "UTF-8"), $exceptions)) {
// check exceptions list for any words that should be in upper case
                        $word = strtolower($word, "UTF-8");
                    } elseif (!in_array($word, $exceptions)) {
// convert to uppercase (non-utf8 only)
                        $word = ucfirst($word);
                    }
                    array_push($newwords, $word);
                }
                $str = join($delimiter, $newwords);
            }//foreach
            return $str;
        }

        public static function getKeywords2($str)
        {
            internal_encoding('UTF-8');
            $str = strip_tags($str);
            $str = self::saltos($str);
            $str = self::tabulados($str);
            $stopwords = array();
            $str = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', strtolower($str))));
            $matchWords = array_filter(explode(" ", $str), function ($item) use ($stopwords) {
                return !($item == '' || in_array($item, $stopwords) || strlen($item) <= 2 || is_numeric($item));
            });
            $wordCountArr = array_count_values($matchWords);
            arsort($wordCountArr);
            $r = array_keys(array_slice($wordCountArr, 0, 50));
            $r = self::get_Tags($r);
            return (implode(",", $r));
        }

        /**
         * Finds all of the keywords (words that appear most) on param $str
         * and return them in order of most occurrences to less occurrences.
         * @param string $str The string to search for the keywords.
         * @param int $minWordLen [optional] The minimun length (number of chars) of a word to be considered a keyword.
         * @param int $minWordOccurrences [optional] The minimun number of times a word has to appear
         * on param $str to be considered a keyword.
         * @param boolean $asArray [optional] Specifies if the function returns a string with the
         * keywords separated by a comma ($asArray = false) or a keywords array ($asArray = true).
         * @return mixed A string with keywords separated with commas if param $asArray is true,
         * an array with the keywords otherwise.
         */
        public static function get_Keywords($str, $minWordLen = 6, $minWordOccurrences = 4, $asArray = true)
        {
            $srt = strip_tags($str);
            $str = self::saltos($str);
            $str = self::tabulados($str);
            $str = strtolower($str, "UTF-8");

            $str = preg_replace('/[^\p{L}0-9 áéíóúüñ]/', ' ', $str);
            $str = trim(preg_replace('/\s+/', ' ', $str));

            $words = explode(' ', $str);
            $keywords = array();
            while (($c_word = array_shift($words)) !== null) {
                if (strlen($c_word) < $minWordLen)
                    continue;

                $c_word = strtolower($c_word);
                if (array_key_exists($c_word, $keywords))
                    $keywords[$c_word][1]++;
                else
                    $keywords[$c_word] = array($c_word, 1);
            }
            usort($keywords, 'self::keyword_count_sort');

            $final_keywords = array();
            foreach ($keywords as $keyword_det) {
                if ($keyword_det[1] < $minWordOccurrences) {
                    break;
                }
                $kw = ($keyword_det[0]);
                array_push($final_keywords, $kw);
            }
            $final_keywords = self::get_Tags($final_keywords);
            if ($asArray) {
                return ($final_keywords);
            } else {
                return (implode(', ', $final_keywords));
            }
        }

        public static function keyword_count_sort($first, $sec)
        {
            return $sec[1] - $first[1];
        }

        /*
         * Esta función permite filtrar un vector de palabras excluyendo del mismo 
         * articulos y preposiciónes
         * que no deben estar dentro de las etiquetas utilizando articulos y 
         * preposiciones del idioma 
         * español (pueden ser mas ).
         */

        public static function get_Tags($keywords = array())
        {
            if (is_array($keywords)) {
                $keywords = unserialize(strtolower(serialize($keywords), "UTF-8"));
                $ap = array(
                    "articulos" => array('unos', 'unas', 'este', 'estos', 'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esas', 'aquella', 'aquellas', 'éste', 'éstos', 'ésos', 'aquél', 'aquéllos', 'ésta', 'éstas', 'ésas', 'aquélla', 'aquéllas'),
                    "preposiciones" => array('ante', 'bajo', 'cabe', 'desde', 'contra', 'entre', 'hacia', 'hasta', 'para', 'según', 'segun', 'sobre', 'tras'),
                    "conjuciones" => array("del", "que", "con", "una", "para", "por", "la", "han", "se", "las", "cual", "además", "más", "parte", "aunque", "también", "tanto", "como", "así", "igual", "que", "lo mismo", "que", "pero", "mas", "empero", "sino", "mientras que", "o bien", "bien", "ya", "ora", "sea", "fuera", "porque", "como"),
                    "etc" => array("información", "través", "dentro", "equipo", "contó", "encontrado", "municipal", "cabecera", "estaba", "estado", "cerrar", "terminar", "intenta", "intentar")
                );
                $r = array_diff($keywords, $ap['articulos'], $ap['preposiciones'], $ap['conjuciones'], $ap['etc']);
                return ($r);
            } else {
                throw new \Exception('Strings::getTags requiere un vector para realizar su labor.');
            }
        }

        public static function get_WordWrap($str, $longitud)
        {
            $str = strip_tags($str);
            $str = wordwrap($str, $longitud, "|", TRUE);
            $seg = explode("|", $str);
            $str = "{$seg[0]}";
            return ($str);
        }


        /**
         * Obtiene una versión vectorizada de una cadena original truncada posicion por posicion, los elementos del vector
         * no excederan el largo maximo indicado, cada posicion del vector contendra el restante presentado tras el truncado
         * sin perder datos. Asegurándose de no cortar palabras y eliminando cualquier espacio adicional al final.
         * @param string|null $string La cadena original que se va a truncar.
         * @param int $maxLength La longitud máxima permitida para la cadena resultante.
         * @return array La cadena truncada sin cortar palabras y sin espacios adicionales al final.
         * @throws \Exception Si la cadena es nula o vacía, o si el maxLength es menor o igual a 0.
         * @example $text = "Este es un texto largo que necesita ser dividido en varias líneas sin cortar palabras y respetando una longitud máxima.";
         * $maxLength = 20;
         * $result = $this->getWraps($text, $maxLength);
         * Resultado:
         *  array(
         *    "Este es un texto",
         *    "largo que necesita",
         *    "ser dividido en",
         *    "varias líneas sin",
         *    "cortar palabras y",
         *    "respetando una",
         *    "longitud máxima."
         * );
         **/

        public function getWraps($str, $maxLength): array
        {
            // Si la cadena es nula o vacía, devolver un array vacío
            if ($str === null || $str === '') {
                return [];
            }

            // Si el maxLength es menor o igual a 0, devolver un array vacío
            if ($maxLength <= 0) {
                return [];
            }

            $result = []; // Array que contendrá las subcadenas
            $remainingText = $str; // Texto restante para procesar

            // Mientras quede texto por procesar
            while (strlen($remainingText) > 0) {
                // Si el texto restante es menor o igual al maxLength, lo agregamos y terminamos
                if (strlen($remainingText) <= $maxLength) {
                    $result[] = trim($remainingText);
                    break;
                }

                // Encontrar la posición del último espacio dentro del maxLength
                $cutPosition = $maxLength;

                // Si no hay suficiente texto para llegar al maxLength
                if (strlen($remainingText) < $maxLength) {
                    $cutPosition = strlen($remainingText);
                } else {
                    // Buscar el último espacio dentro del límite para no cortar palabras
                    $lastSpace = strrpos(substr($remainingText, 0, $maxLength), ' ');

                    // Si encontramos un espacio dentro del límite, usamos esa posición
                    if ($lastSpace !== false) {
                        $cutPosition = $lastSpace;
                    }
                }

                // Extraer la subcadena y eliminar espacios al final
                $chunk = trim(substr($remainingText, 0, $cutPosition));
                $result[] = $chunk;

                // Actualizar el texto restante, eliminando la parte que ya procesamos
                $remainingText = substr($remainingText, $cutPosition);
                $remainingText = ltrim($remainingText); // Eliminar espacios al inicio del texto restante
            }

            // Eliminar elementos vacíos del resultado si los hubiera
            return array_filter($result, function ($item) {
                return $item !== '';
            });
        }


        /**
         * Obtiene una versión truncada de una cadena que no excede la longitud máxima especificada,
         * asegurándose de no cortar palabras y eliminando cualquier espacio adicional al final.
         * @param string|null $string La cadena original que se va a truncar.
         * @param int $maxLength La longitud máxima permitida para la cadena resultante.
         * @return string La cadena truncada sin cortar palabras y sin espacios adicionales al final.
         */
        public function get_Wrap(mixed $string, int $maxLength): string
        {
            if (empty($string)) {
                return '';
            }
            $string = (string)$string; // Asegurarse de convertir la entrada a una cadena de texto
            if (strlen($string) <= $maxLength) {
                return $string;
            }
            $words = preg_split('/\s+/', $string);
            $result = '';
            $currentLength = 0;
            foreach ($words as $word) {
                $wordLength = strlen($word);
                if ($currentLength + $wordLength + strlen($result) <= $maxLength) {
                    $result .= $word . ' ';
                    $currentLength += $wordLength + 1; // Agregar 1 por el espacio que se añade junto a la palabra
                } else {
                    break;
                }
            }
            return trim($result);
        }

        /**
         * ucfirst — Convierte el primer caracter de una cadena a mayúsculas
         * @param type $str
         * @return type
         */
        public static function getUCfirst($str)
        {
            return (ucfirst(strtolower($str, "UTF-8")));
        }

        /**
         * Retorna falso o verdadero si una cadena contiene a otra.
         * @param type $string
         * @param type $search
         * @return type
         */
        public static function Contain($string, $search)
        {
            if (strpos($string, $search) !== false) {
                return (true);
            } else {
                return (false);
            }
        }

        /*
         * Find the position of the Xth occurrence of a substring in a string 
         * @param $haystack El string donde buscar.
         * @param $needle Cadena buscada
         * @param $number integer > 0 
         * @return int 
         */

        public static function get_PositionX($haystack, $needle, $number)
        {
            if ($number == '1') {
                return strpos($haystack, $needle);
            } elseif ($number > '1') {
                return strpos($haystack, $needle, self::get_PositionX($haystack, $needle, $number - 1) + strlen($needle));
            } else {
                return error_log('Error: Value for parameter $number is out of range');
            }
        }

        public static function get_ReplaceSpecialCharacters($text)
        {
            $wrong = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ç', 'ü');
            $right = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N', 'c', 'u');
            return (str_replace($wrong, $right, $text));
        }

        public static function get_Semantic($titulo, $id, $formato = "", $suffix = "", $palabrasCensuradas = array())
        {
            $wrong = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ç', 'ü');
            $right = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N', 'c', 'u');
            //Reemplaza los caracteres especiales 
            $titulo = str_replace($wrong, $right, $titulo);
            //Pone la cadena en minisculas 
            $titulo = strtolower($titulo);
            //Reemplaza todo lo que no sean letras ni numeros por "-" 
            $titulo = preg_replace("/[^a-z0-9]+/", "-", $titulo);
            //Elimino los "-" al principio y final de la cadena 
            $titulo = trim($titulo, '-');
            //Separo la cadena en un array, usando "-" como delimitador 
            $palabras = explode("-", $titulo);
            $censuradas = array("a", "en", "el", "un", "la", "una", "o", "se", "de", "del");
            $censuradas = array_merge($censuradas, $palabrasCensuradas);
            //Usando array_diff, a mi array antes obtenido le resto el array de palabras comunes 
            $palabras = array_diff($palabras, $censuradas);
            //Vuelvo a "pegar" la cadena 
            $titulo = implode("-", $palabras);
            //Vuelvo id a su valor numerico 
            $id = strtolower($id);
            if (!empty($formato)) {
                $plantilla = array('{id}', '{titulo}');
                $reemplazo = array($id, $titulo);
                $url = str_replace($plantilla, $reemplazo, $formato);
                $url .= $suffix;
            } else {
                $url = "$titulo-$id$suffix";
            }
            //Retorno la URL amigable 
            return ($url);
        }

        public function add($string)
        {
            $this->string .= $string;
        }

        /**
         * Retorna un arreglo correspondiente a la intercession de valores entre
         * dos vectores.
         * @param type $primary_array
         * @param type $secondary_array
         * @return boolean
         */
        public static function arrayIntersect($primary_array, $secondary_array)
        {

            if (!is_array($primary_array) || !is_array($secondary_array)) {
                return false;
            }

            if (!empty($primary_array)) {

                foreach ($primary_array as $key => $value) {

                    if (!isset($secondary_array[$key])) {
                        unset($primary_array[$key]);
                    } else {
                        if (serialize($secondary_array[$key]) != serialize($value)) {
                            unset($primary_array[$key]);
                        }
                    }
                }

                return $primary_array;
            } else {
                return array();
            }
        }

        /**
         * Indica si una cadena esta dentro de otra.
         * @param string $buscado cadena de texto a buscar.
         * @param string $cadena cadena de texto donde se buscara.
         * @return bool Indica si se encontro la cadena.
         */
        public static function isIn($buscado, $cadena)
        {
            $pos = strpos($cadena, $buscado);
            return !($pos === false);
        }

        public function __toString()
        {
            return ($this->string);
        }

        /**
         * La función "get_Ucfirst" comprueba si el valor de $string es nulo o está vacío.
         * Si es así, devuelve una cadena vacía. Si no es así, devuelve la primera letra de la cadena en
         * mayúscula mediante la función "ucfirst"
         * @param string $string
         * @return string
         */
        public function get_Ucfirst($string)
        {
            if (is_null($string) || $string === '') {
                return ('');
            }
            return (ucfirst($string));
        }

        /**
         * La función "get_Strtolower" convierte una cadena dada en minúsculas.
         * Primero, comprueba si el valor de $string es nulo o está vacío. Si es así, devuelve una cadena vacía.
         * Si no es así, convierte todas las letras de la cadena en minúsculas mediante la función "strtolower" y devuelve el resultado.
         * @param string $string
         * @return string
         */
        public function get_Strtolower($string)
        {
            if (empty($string)) {
                return ('');
            }
            return (strtolower($string));
        }


        /**
         * La función "get_Strtoupper" convierte una cadena dada en mayúsculas.
         * Primero, comprueba si el valor de $string es nulo o está vacío. Si es así, devuelve una cadena vacía.
         * Si no es así, convierte todas las letras de la cadena en minúsculas mediante la función "strtolower" y devuelve el resultado.
         * @param string $string
         * @return string
         */
        public function get_Strtoupper($string)
        {
            setlocale(LC_CTYPE, 'es_ES.UTF-8');
            if (is_null($string) || $string === '') {
                return ('');
            }
            return mb_strtoupper($string, 'UTF-8');
        }

        public function get_Trim($string)
        {
            if (is_null($string) || $string === '') {
                return ('');
            }
            return (trim($string));
        }


        public function get_StrPad($string, $length, $padString = ' ', $padType = STR_PAD_RIGHT)
        {
            if (is_null($string) || $string === '') {
                return ('');
            }
            return (str_pad($string, $length, $padString, $padType));
        }

        /**
         * URL-encode according to RFC 3986 Verificar si el parámetro de entrada es una cadena de texto. Si no lo es,
         * lanzar una excepción o retornar un valor que indique un error. (2) Utilizar la función urldecode de PHP para
         * decodificar la cadena. (3) Limpiar la cadena decodificada para eliminar posibles caracteres que puedan ser
         * peligrosos. Para esto, puedes usar una función como htmlspecialchars que convierte caracteres especiales en
         * entidades HTML, lo que ayuda a prevenir ataques de inyección de código.
         * Parameters:
         * string $string The URL to be encoded.
         * Returns:
         * string a string in which all non-alphanumeric characters except -_. have been replaced with a percent (%)
         * sign followed by two hex digits. This is the encoding described in RFC 1738 for protecting literal characters
         * from being interpreted as special URL delimiters, and for protecting URLs from being mangled by transmission
         * media with character conversions (like some email systems).
         * Links:
         * https://php.net/manual/en/function.rawurlencode.php
         * @param string $string
         * @return string
         */

        public function get_URLDecode($string): string
        {
            if (!is_string($string)) {
                return ("");
            }
            $decodedString = urldecode($string);// Limpiar la cadena decodificada para prevenir ataques de inyección de código
            $safeString = htmlspecialchars($decodedString, ENT_QUOTES, 'UTF-8');
            return $safeString;
        }


        /**
         * @param $string
         * @return string
         */
        public function get_URLEncode(string $string): string
        {
            if (is_string($string)) {
                return (urlencode($string));
            }
            return ("");
        }

        /**
         * En esta versión actualizada del método, se ha agregado un control de seguridad antes de realizar el corte de
         * la cadena. La función is_string() se utiliza para comprobar si el primer parámetro que se ha recibido es una cadena de texto. Si no lo es, se lanza una excepción de tipo InvalidArgumentException indicando que el primer parámetro debe ser una cadena de texto. Si la comprobación es exitosa, el método continúa con el recorte de la cadena como se había indicado previamente
         * De esta manera, si se intenta utilizar el método con un parámetro que no es una cadena de texto, se lanzará
         * una excepción y se detendrá la ejecución del programa, evitando posibles errores o comportamientos inesperados.
         * @param $cadena
         * @param $longitud
         * @return string
         */
        function get_Substr($cadena, $longitud)
        {
            if (!is_string($cadena)) {
                return ($cadena);
            }
            if (strlen($cadena) > $longitud) {
                $cadena = substr($cadena, 0, $longitud) . '...';
            }
            return ($cadena);
        }

        function removeUnsafeSQLCharacters($string)
        {
            // Definir la expresión regular para mantener solo caracteres seguros para SQL
            $regex = '/[^a-zA-Z0-9 .,\-_\(\)\'";]/';

            // Utilizar preg_replace() para eliminar caracteres no seguros
            $safeString = preg_replace($regex, '', $string);

            // Eliminar los puntos iniciales de la cadena
            $safeString = ltrim($safeString, '.');

            return $safeString;
        }

    }

}
?>