<?php

namespace App\Libraries;

class Dates
{


    function __construct()
    {
        setlocale(LC_TIME, "spanish");

    }

    /**
     * Retorna una fecha a partir de una cadena que contenga una fecha textual
     **/
    public static function get_DateFromString($string)
    {
        $date = self::get_STRFtime('%Y-%m-%d', strtotime($string));
        return ($date);
    }


    public function getNextPeriod($currentPeriod) {
        // Extraer el año y el semestre
        $year = substr($currentPeriod, 0, 4);
        $semester = substr($currentPeriod, 4, 1);

        // Calcular el siguiente período
        if ($semester === 'A') {
            // Si es semestre A, el siguiente es B del mismo año
            return $year . 'B';
        } else if ($semester === 'B') {
            // Si es semestre B, el siguiente es A del siguiente año
            return (intval($year) + 1) . 'A';
        } else {
            // Formato inválido, devolver el mismo período
            return $currentPeriod;
        }
    }



    /**
     * Locale-formatted self::get_STRFtime using \IntlDateFormatter (PHP 8.1 compatible)
     * This provides a cross-platform alternative to self::get_STRFtime() for when it will be removed from PHP.
     * Note that output can be slightly different between libc sprintf and this function as it is using ICU.
     *
     * Usage:
     * use function \PHP81_BC\self::get_STRFtime;
     * echo self::get_STRFtime('%A %e %B %Y %X', new \DateTime('2021-09-28 00:00:00'), 'fr_FR');
     *
     * Original use:
     * \setlocale('fr_FR.UTF-8', LC_TIME);
     * echo \self::get_STRFtime('%A %e %B %Y %X', strtotime('2021-09-28 00:00:00'));
     *
     * @param string $format Date format
     * @param integer|string|DateTime $timestamp Timestamp
     * @return string
     * @author BohwaZ <https://bohwaz.net/>
     */
    private static function get_STRFtime(string $format, $timestamp = null, ?string $locale = null): string
    {
        if (null === $timestamp) {
            $timestamp = new \DateTime;
        } elseif (is_numeric($timestamp)) {
            $timestamp = date_create('@' . $timestamp);

            if ($timestamp) {
                $timestamp->setTimezone(new \DateTimezone(date_default_timezone_get()));
            }
        } elseif (is_string($timestamp)) {
            $timestamp = date_create($timestamp);
        }

        if (!($timestamp instanceof \DateTimeInterface)) {
            throw new \InvalidArgumentException('$timestamp argument is neither a valid UNIX timestamp, a valid date-time string or a DateTime object.');
        }

        $locale = substr((string)$locale, 0, 5);

        $intl_formats = [
            '%a' => 'EEE',    // An abbreviated textual representation of the day	Sun through Sat
            '%A' => 'EEEE',    // A full textual representation of the day	Sunday through Saturday
            '%b' => 'MMM',    // Abbreviated month name, based on the locale	Jan through Dec
            '%B' => 'MMMM',    // Full month name, based on the locale	January through December
            '%h' => 'MMM',    // Abbreviated month name, based on the locale (an alias of %b)	Jan through Dec
        ];

        $intl_formatter = function (\DateTimeInterface $timestamp, string $format) use ($intl_formats, $locale) {
            $tz = $timestamp->getTimezone();
            $date_type = \IntlDateFormatter::FULL;
            $time_type = \IntlDateFormatter::FULL;
            $pattern = '';

            // %c = Preferred date and time stamp based on locale
            // Example: Tue Feb 5 00:45:10 2009 for February 5, 2009 at 12:45:10 AM
            if ($format == '%c') {
                $date_type = \IntlDateFormatter::LONG;
                $time_type = \IntlDateFormatter::SHORT;
            }
            // %x = Preferred date representation based on locale, without the time
            // Example: 02/05/09 for February 5, 2009
            elseif ($format == '%x') {
                $date_type = \IntlDateFormatter::SHORT;
                $time_type = \IntlDateFormatter::NONE;
            } // Localized time format
            elseif ($format == '%X') {
                $date_type = \IntlDateFormatter::NONE;
                $time_type = \IntlDateFormatter::MEDIUM;
            } else {
                $pattern = $intl_formats[$format];
            }

            return (new \IntlDateFormatter($locale, $date_type, $time_type, $tz, null, $pattern))->format($timestamp);
        };

        // Same order as https://www.php.net/manual/en/function.self::get_STRFtime.php
        $translation_table = [
            // Day
            '%a' => $intl_formatter,
            '%A' => $intl_formatter,
            '%d' => 'd',
            '%e' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('j'));
            },
            '%j' => function ($timestamp) {
                // Day number in year, 001 to 366
                return sprintf('%03d', $timestamp->format('z') + 1);
            },
            '%u' => 'N',
            '%w' => 'w',

            // Week
            '%U' => function ($timestamp) {
                // Number of weeks between date and first Sunday of year
                $day = new \DateTime(sprintf('%d-01 Sunday', $timestamp->format('Y')));
                return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
            },
            '%V' => 'W',
            '%W' => function ($timestamp) {
                // Number of weeks between date and first Monday of year
                $day = new \DateTime(sprintf('%d-01 Monday', $timestamp->format('Y')));
                return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
            },

            // Month
            '%b' => $intl_formatter,
            '%B' => $intl_formatter,
            '%h' => $intl_formatter,
            '%m' => 'm',

            // Year
            '%C' => function ($timestamp) {
                // Century (-1): 19 for 20th century
                return floor($timestamp->format('Y') / 100);
            },
            '%g' => function ($timestamp) {
                return substr($timestamp->format('o'), -2);
            },
            '%G' => 'o',
            '%y' => 'y',
            '%Y' => 'Y',

            // Time
            '%H' => 'H',
            '%k' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('G'));
            },
            '%I' => 'h',
            '%l' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('g'));
            },
            '%M' => 'i',
            '%p' => 'A', // AM PM (this is reversed on purpose!)
            '%P' => 'a', // am pm
            '%r' => 'h:i:s A', // %I:%M:%S %p
            '%R' => 'H:i', // %H:%M
            '%S' => 's',
            '%T' => 'H:i:s', // %H:%M:%S
            '%X' => $intl_formatter, // Preferred time representation based on locale, without the date

            // Timezone
            '%z' => 'O',
            '%Z' => 'T',

            // Time and Date Stamps
            '%c' => $intl_formatter,
            '%D' => 'm/d/Y',
            '%F' => 'Y-m-d',
            '%s' => 'U',
            '%x' => $intl_formatter,
        ];

        $out = preg_replace_callback('/(?<!%)(%[a-zA-Z])/', function ($match) use ($translation_table, $timestamp) {
            if ($match[1] == '%n') {
                return "\n";
            } elseif ($match[1] == '%t') {
                return "\t";
            }

            if (!isset($translation_table[$match[1]])) {
                throw new \InvalidArgumentException(sprintf('Format "%s" is unknown in time format', $match[1]));
            }

            $replace = $translation_table[$match[1]];

            if (is_string($replace)) {
                return $timestamp->format($replace);
            } else {
                return $replace($timestamp, $match[1]);
            }
        }, $format);

        $out = str_replace('%%', '%', $out);
        return $out;
    }

    /**
     * Retorna la fecha textual de una fecha convencional.
     * @param type $fecha
     * @return type
     */
    public static function get_TextualDateFromDate($fecha)
    {
        setlocale(LC_TIME, "spanish");
        $strftime = self::get_STRFtime("%A %d  de %B %Y", strtotime($fecha));
        $date = mb_convert_encoding($strftime, "UTF-8", mb_detect_encoding($strftime));
        return ($date);
    }

    public static function getTextualMonthFromNumber($mes)
    {

        $nombre = self::get_STRFtime("%B", mktime(0, 0, 0, $mes, 1, 2000));
        return ($nombre);
    }

    /**
     * Retorna la fecha actual en forma textual.
     * @return type
     */
    public static function get_CurrentTextualDate($option)
    {
        if ($option == "minimum") {
            return (utf8_encode(self::get_STRFtime("%d  de %B %Y", time())));
        } else {
            return (utf8_encode(self::get_STRFtime("%A %d  de %B %Y", time())));
        }
    }

    /**
     * Retorna el dia de la semana actual en forma textual.
     * @return type
     */
    public static function getCurrentTextualDay()
    {
        return (utf8_encode(self::get_STRFtime("%A", time())));
    }

    /**
     * Retorna el tiempo textual trascurrido desde un timestamp recibido,
     * si el valor que se necesita recibir para realziar el calculo del
     * tiempo de vida trascurrido no es un timestam se debe convertir a este
     * formato para lograr el efecto esperado.
     * Ejemplo: $dates::get_LiveTimestamp($post["date"], $post["time"], $pref = lang("App.Ago"));
     * @param type $timestamp
     * @return type
     */
    public static function get_LiveTimestamp($date, $time, $pref = "hace")
    {
        $timestamp = strtotime("{$date} {$time}");
        $diff = time() - (int)$timestamp;
        if ($diff < 20) {
            $return = 'Ahora mismo';
        } else if ($diff >= 20 and $diff < 60) {
            $return = sprintf($pref . ' %s segundos.', $diff);
        } else if ($diff >= 60 and $diff < 120) {
            $return = sprintf($pref . ' %s minuto.', floor($diff / 60));
        } else if ($diff >= 120 and $diff < 3600) {
            $return = sprintf($pref . ' %s minutos.', floor($diff / 60));
        } else if ($diff >= 3600 and $diff < 7200) {
            $return = sprintf($pref . ' %s hora.', floor($diff / 3600));
        } else if ($diff >= 7200 and $diff < 86400) {
            $return = sprintf($pref . ' %s horas.', floor($diff / 3600));
        } else if ($diff >= 86400 and $diff < 172800) {
            $return = sprintf($pref . ' %s dia.', floor($diff / 86400));
        } else if ($diff >= 172800 and $diff < 604800) {
            $return = sprintf($pref . ' %s dias.', floor($diff / 86400));
        } else if ($diff >= 604800 and $diff < 1209600) {
            $return = sprintf($pref . ' %s semana.', floor($diff / 604800));
        } else if ($diff >= 1209600 and $diff < 2629744) {
            $return = sprintf($pref . ' %s semanas.', floor($diff / 604800));
        } else if ($diff >= 2629744 and $diff < 5259488) {
            $return = sprintf($pref . ' %s mes.', floor($diff / 2629744));
        } else if ($diff >= 5259488 and $diff < 31556926) {
            $return = sprintf($pref . ' %s meses.', floor($diff / 2629744));
        } else if ($diff >= 31556926 and $diff < 63113852) {
            $return = sprintf($pref . ' %s año.', floor($diff / 31556926));
        } else if ($diff >= 63113852) {
            $return = sprintf($pref . ' %s años.', floor($diff / 31556926));
        } else {
            $return = date('H:i:s d/m/Y', $timestamp);
        }
        return $return;
    }

    public static function get_LiveTimestampFromString($str, $pref = "hace")
    {
        $timestamp = strtotime($str);
        $diff = time() - (int)$timestamp;
        if ($diff < 20) {
            $return = 'Ahora mismo';
        } else if ($diff >= 20 and $diff < 60) {
            $return = sprintf($pref . ' %s segundos.', $diff);
        } else if ($diff >= 60 and $diff < 120) {
            $return = sprintf($pref . ' %s minuto.', floor($diff / 60));
        } else if ($diff >= 120 and $diff < 3600) {
            $return = sprintf($pref . ' %s minutos.', floor($diff / 60));
        } else if ($diff >= 3600 and $diff < 7200) {
            $return = sprintf($pref . ' %s hora.', floor($diff / 3600));
        } else if ($diff >= 7200 and $diff < 86400) {
            $return = sprintf($pref . ' %s horas.', floor($diff / 3600));
        } else if ($diff >= 86400 and $diff < 172800) {
            $return = sprintf($pref . ' %s dia.', floor($diff / 86400));
        } else if ($diff >= 172800 and $diff < 604800) {
            $return = sprintf($pref . ' %s dias.', floor($diff / 86400));
        } else if ($diff >= 604800 and $diff < 1209600) {
            $return = sprintf($pref . ' %s semana.', floor($diff / 604800));
        } else if ($diff >= 1209600 and $diff < 2629744) {
            $return = sprintf($pref . ' %s semanas.', floor($diff / 604800));
        } else if ($diff >= 2629744 and $diff < 5259488) {
            $return = sprintf($pref . ' %s mes.', floor($diff / 2629744));
        } else if ($diff >= 5259488 and $diff < 31556926) {
            $return = sprintf($pref . ' %s meses.', floor($diff / 2629744));
        } else if ($diff >= 31556926 and $diff < 63113852) {
            $return = sprintf($pref . ' %s año.', floor($diff / 31556926));
        } else if ($diff >= 63113852) {
            $return = sprintf($pref . ' %s años.', floor($diff / 31556926));
        } else {
            $return = date('H:i:s d/m/Y', $timestamp);
        }
        return $return;
    }

    /**
     * Retorna el tiempo textual trascurrido desde una fecha especificada en segundos
     * para la version textual se debe usar Dates::get_LiveTimestamp($r["date"], $r["time"], $pref = "");
     * @param type $datefrom
     * @param type $dateto
     * @return string
     */


    public static function Borrar_get_Ago($datefrom, $dateto = -1)
    {
        // Defaults and assume if 0 is passed in that
        // its an error rather than the epoch
        $datefrom = strtotime($datefrom);
        $dateto = strtotime($dateto);
        if ($datefrom <= 0) {
            return "···";
        }
        if ($dateto == -1) {
            $dateto = time();
        }
        // Calculate the difference in seconds betweeen
        // the two timestamps
        $difference = $dateto - $datefrom;
        // If difference is less than 60 seconds,
        // seconds is a good interval of choice
        if ($difference < 60) {
            $interval = "s";
        }
        // If difference is between 60 seconds and
        // 60 minutes, minutes is a good interval
        elseif ($difference >= 60 && $difference < 60 * 60) {
            $interval = "n";
        }
        // If difference is between 1 hour and 24 hours
        // hours is a good interval
        elseif ($difference >= 60 * 60 && $difference < 60 * 60 * 24) {
            $interval = "h";
        }
        // If difference is between 1 day and 7 days
        // days is a good interval
        elseif ($difference >= 60 * 60 * 24 && $difference < 60 * 60 * 24 * 7) {
            $interval = "d";
        }
        // If difference is between 1 week and 30 days
        // weeks is a good interval
        elseif ($difference >= 60 * 60 * 24 * 7 && $difference < 60 * 60 * 24 * 30) {
            $interval = "ww";
        }
        // If difference is between 30 days and 365 days
        // months is a good interval, again, the same thing
        // applies, if the 29th February happens to exist
        // between your 2 dates, the function will return
        // the 'incorrect' value for a day
        elseif ($difference >= 60 * 60 * 24 * 30 && $difference < 60 * 60 * 24 * 365) {
            $interval = "m";
        }
        // If difference is greater than or equal to 365
        // days, return year. This will be incorrect if
        // for example, you call the function on the 28th April
        // 2008 passing in 29th April 2007. It will return
        // 1 year ago when in actual fact (yawn!) not quite
        // a year has gone by
        elseif ($difference >= 60 * 60 * 24 * 365) {
            $interval = "y";
        }
        // Based on the interval, determine the
        // number of units between the two dates
        // From this point on, you would be hard
        // pushed telling the difference between
        // this function and DateDiff. If the $datediff
        // returned is 1, be sure to return the singular
        // of the unit, e.g. 'day' rather 'days'

        switch ($interval) {
            case "m":
                $months_difference = floor($difference / 60 / 60 / 24 / 29);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {

                    $months_difference++;
                }
                $datediff = $months_difference;

                // We need this in here because it is possible
                // to have an 'm' interval and a months
                // difference of 12 because we are using 29 days
                // in a month

                if ($datediff == 12) {
                    $datediff--;
                }
                $res = ($datediff == 1) ? "$datediff Mes" : "$datediff Meses";
                break;

            case "y":
                $datediff = floor($difference / 60 / 60 / 24 / 365);
                $res = ($datediff == 1) ? "$datediff Años" : "$datediff years ago";
                break;
            case "d":
                $datediff = floor($difference / 60 / 60 / 24);
                $res = ($datediff == 1) ? "$datediff Dia" : "$datediff Dias";
                break;
            case "ww":
                $datediff = floor($difference / 60 / 60 / 24 / 7);
                $res = ($datediff == 1) ? "$datediff Semana" : "$datediff Semanas";
                break;
            case "h":
                $datediff = floor($difference / 60 / 60);
                $res = ($datediff == 1) ? "$datediff Hora" : "$datediff Horas";
                break;
            case "n":
                $datediff = floor($difference / 60);
                $res = ($datediff == 1) ? "$datediff Minuto" : "$datediff Minutos";
                break;
            case "s":
                $datediff = $difference;
                $res = ($datediff == 1) ? "$datediff Segundo" : "$datediff Segundos";
                break;
        }
        return $res;
    }

    /**
     * Este metodo retorna un vector que contiene los dias habiles trascurridos entre dos fechas, incluido
     * un conteo de la cantidad de dias retornados, los dias habiles se calculan excluyendo feriados y festivos
     * adaptados al calendario colombiano
     * @param type $inicial
     * @param type $final
     * @return type
     */
    public static function habiles($inicial, $final)
    {
        $festivos = new Festivos();
        $habiles = $festivos->dias_habiles($inicial, $final);
        return ($habiles['conteo']);
    }

    /**
     * $tt=Dates::getElapsedTime2($fila["fecha-transaccion"], Dates::get_Date());
     * $fila["idtt"] ="{$tt["y"]}:{$tt["m"]}:{$tt["d"]}:{$tt["i"]}";
     * @param type $inicial
     * @param type $final
     * @return type
     */
    public static function get_ElapsedDays($inicio, $fin)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = ((($dif / 60) / 60) / 24);
        return (ceil($diasFalt));
    }

    /**
     * La función get_ElapsedTime calcula la diferencia entre dos fechas dadas y devuelve un arreglo con el tiempo
     * transcurrido en años, meses, días, horas, minutos y segundos.
     * @param string $inicial Fecha y hora inicial en formato "Y-m-d H:i:s".
     * @param string $final Fecha y hora final en formato "Y-m-d H:i:s".
     * @return array Array con el tiempo transcurrido en años, meses, días, horas, minutos y segundos.
     */
    public static function get_ElapsedTime(string $inicial, string $final): array
    {
        $elapsedTime = array();
        if (class_exists('DateTime')) {
            $date1 = new \DateTime($inicial);
            $date2 = new \DateTime($final);
            $diff = $date1->diff($date2);
            $elapsedTime['years'] = str_pad($diff->y, 2, "0", STR_PAD_LEFT);
            $elapsedTime['months'] = str_pad($diff->m, 2, "0", STR_PAD_LEFT);
            $elapsedTime['days'] = str_pad($diff->d, 2, "0", STR_PAD_LEFT);
            $elapsedTime['hours'] = str_pad($diff->h, 2, "0", STR_PAD_LEFT);
            $elapsedTime['minutes'] = str_pad($diff->i, 2, "0", STR_PAD_LEFT);
            $elapsedTime['seconds'] = str_pad($diff->s, 2, "0", STR_PAD_LEFT);
        } else {
            $seconds = strtotime($final) - strtotime($inicial);
            $elapsedTime['years'] = floor($seconds / (365 * 24 * 60 * 60));
            $seconds -= $elapsedTime['years'] * 365 * 24 * 60 * 60;
            $elapsedTime['months'] = floor($seconds / (30 * 24 * 60 * 60));
            $seconds -= $elapsedTime['months'] * 30 * 24 * 60 * 60;
            $elapsedTime['days'] = floor($seconds / (24 * 60 * 60));
            $seconds -= $elapsedTime['days'] * 24 * 60 * 60;
            $elapsedTime['hours'] = floor($seconds / (60 * 60));
            $seconds -= $elapsedTime['hours'] * 60 * 60;
            $elapsedTime['minutes'] = floor($seconds / 60);
            $seconds -= $elapsedTime['minutes'] * 60;
            $elapsedTime['seconds'] = $seconds;
        }
        return ($elapsedTime);
    }

    /**
     * Vamos a ver un script de ejemplo en PHP que nos permite, dada una cantidad
     * de segundos determinada, averiguar (y mostrar en pantalla) a cuantas horas,
     * minutos, y segundos corresponde. Para ello definimos una función en PHP que,
     * dada una cantidad determinada de segundos ($seg_ini), escribe en pantalla las
     * horas ($horas), minutos ($minutos) y segundos ($segundos) equivalentes:
     * @param type $seg_ini
     * @return type
     */

    public static function conversor_segundos($seg_ini)
    {
        $hours = floor($seg_ini / 3600);
        $minutes = floor(($seg_ini - ($hours * 3600)) / 60);
        $seconds = $seg_ini - ($hours * 3600) - ($minutes * 60);
        return (array("hours" => $hours, "minutes" => $minutes, "seconds" => $seconds));
    }

    /**
     * Adiciona dias habiles a una fecha en forma aproximada ya que solo
     * cosidera sabados y domingos a la semana, y el numero de semanas entre
     * la fecha dada y la cantidad de dias a adicionar, sin considerar los
     * festivos y feriados en medio (por esto es un aproximado).
     * @param type $fecha
     * @param type $dias
     * @return type
     */
    public static function addDaysAprox($fecha, $dias)
    {
        $datestart = strtotime($fecha);
        $diasemana = date('N', $datestart);
        $totaldias = $diasemana + $dias;
        $findesemana = intval($totaldias / 5) * 2;
        $diasabado = $totaldias % 5;
        if ($diasabado == 6) {
            $findesemana++;
        }
        $total = (($dias + $findesemana) * 86400) + $datestart;
        return ($twstart = date('Y-m-d', $total));
    }

    /**
     * Agrega un numero de dias exactos y obtiene la fecha final a partir de una fecha inicial
     * @param string $fecha Fecha inicial en formato 'Y-m-d'
     * @param int $dias Número de días a agregar
     * @return string Fecha resultante en formato 'Y-m-d'
     */
    public static function addDaysExact($fecha, $dias)
    {
        $timestamp = strtotime($fecha);// Convertir la fecha a timestamp
        $nuevoTimestamp = $timestamp + ($dias * 86400); // Agregar los días (86400 segundos = 1 día)
        return date('Y-m-d', $nuevoTimestamp);// Convertir el nuevo timestamp de vuelta a formato de fecha
    }

    public static function subtractDaysExact($fecha, $dias)
    {
        $nuevafecha = strtotime("-{$dias} day", strtotime($fecha));
        $nuevafecha = date('Y-m-j', $nuevafecha);
        return ($nuevafecha);
    }

    /**
     * Retorna la fecha actual en formato AAAA-MM-DD
     * @return type
     */
    public static function get_Date()
    {

        return (date('Y-m-d', time()));
    }

    public static function get_DateTime()
    {

        return (date('Y-m-d H:i:sP', time()));
    }

    public static function get_Year()
    {

        return (date('Y', time()));
    }

    public static function get_Month()
    {

        return (date('m', time()));
    }

    /**
     * Retorna el nombre del mes a partir de su numero
     * @param type $month
     * @return type
     */
    public static function get_MonthName($month)
    {
        $month = (int)($month);
        $months = array(
            "1" => "Enero",
            "2" => "Febrero",
            "3" => "Marzo",
            "4" => "Abril",
            "5" => "Mayo",
            "6" => "Junio",
            "7" => "Julio",
            "8" => "Agosto",
            "9" => "Septiembre",
            "10" => "Octubre",
            "11" => "Noviembre",
            "12" => "Diciembre");
        return ($months[$month]);
    }

    public static function get_Day()
    {

        return (date('d', time()));
    }

    /**
     * Retorna la hora actual en formato HH:MM:SS
     * @return string
     */
    public static function get_Time(): string
    {

        return (date('H:i:s', time()));
    }

    /**
     * Recibida una cadena de texto que contiene una fecha y una hora, determinadas retorna la
     * misma en una expresión convertida a como google la requiere para los sitemaps y los
     * dta del SEO de las paginas.
     * @param type $string
     * @return type
     */
    public static function getGoogleDateFormat($date, $time)
    {
        $d = date_create("{$date} {$time}");
        return (date_format($d, "Y-m-d H:i:sP"));
    }

    public static function get_DateRFC822($fecha, $hora)
    {
        $timestamp = strtotime("$fecha $hora"); // Convertir la fecha y hora a un timestamp
        $fecha_formateada = gmdate("D, d M Y H:i:s", $timestamp) . " GMT"; // Formatear el timestamp en el formato especificado
        return $fecha_formateada;
    }

    /**
     * Proporsionada una cadena que contiene una fecha extrae el año de la misma y lo retorna
     * como resultado.
     * @param type $string
     * @return type
     */
    public static function extractYearofDate($string)
    {
        $date = date_create($string);
        return (date_format($date, "Y"));
    }

    private static function get_timespan_string($older, $newer)
    {
        $Y1 = $older->format('Y');
        $Y2 = $newer->format('Y');
        $Y = $Y2 - $Y1;

        $m1 = $older->format('m');
        $m2 = $newer->format('m');
        $m = $m2 - $m1;

        $d1 = $older->format('d');
        $d2 = $newer->format('d');
        $d = $d2 - $d1;

        $H1 = $older->format('H');
        $H2 = $newer->format('H');
        $H = $H2 - $H1;

        $i1 = $older->format('i');
        $i2 = $newer->format('i');
        $i = $i2 - $i1;

        $s1 = $older->format('s');
        $s2 = $newer->format('s');
        $s = $s2 - $s1;

        if ($s < 0) {
            $i = $i - 1;
            $s = $s + 60;
        }
        if ($i < 0) {
            $H = $H - 1;
            $i = $i + 60;
        }
        if ($H < 0) {
            $d = $d - 1;
            $H = $H + 24;
        }
        if ($d < 0) {
            $m = $m - 1;
            $d = $d + self::get_days_for_previous_month($m2, $Y2);
        }
        if ($m < 0) {
            $Y = $Y - 1;
            $m = $m + 12;
        }
        $timespan_string = self::tiempo_ddmmyy($Y, $m, $d, $H, $i, $s);
        return $timespan_string;
    }

    public static function get_days_for_previous_month($current_month, $current_year)
    {
        $previous_month = $current_month - 1;
        if ($current_month == 1) {
            $current_year = $current_year - 1; //going from January to previous December
            $previous_month = 12;
        }
        if ($previous_month == 11 || $previous_month == 9 || $previous_month == 6 || $previous_month == 4) {
            return 30;
        } else if ($previous_month == 2) {
            if (($current_year % 4) == 0) { //remainder 0 for leap years
                return 29;
            } else {
                return 28;
            }
        } else {
            return 31;
        }
    }

    private static function tiempo_ddmmyy($Y, $m, $d, $H, $i, $s)
    {
        $d = str_pad($d, 2, '0', STR_PAD_LEFT);
        $m = str_pad($m, 2, '0', STR_PAD_LEFT);
        $Y = str_pad($Y, 2, '0', STR_PAD_LEFT);
        //return=$d . ":" . $m . ":" . $Y;
        $return = array("days" => $d, "months" => $m, "years" => $Y, "hours" => $H, "minutes" => $i, "seconds" => $s);
        return ($return);
    }

    /**
     * Retorna la fecha actual en formato AAAA-MM-DD
     * @return type
     */
    function is_WorkingDay($date)
    {
        $dateTime = new DateTime($date);
        $dayOfWeek = $dateTime->format('N'); // 'N' representa el día de la semana donde 1 es lunes y 7 es domingo.

        // Verificar si el día es de lunes a viernes
        if ($dayOfWeek >= 6) {
            // Es fin de semana (sábado o domingo)
            return false;
        }

        // Convertir la fecha a formato "Y-m-d" para comparar con la lista de días festivos
        $formattedDate = $dateTime->format('Y-m-d');

        // Verificar si la fecha es un día festivo
        if (in_array($formattedDate, $holidays)) {
            // Es un día festivo
            return false;
        }

        // La fecha es un día laboral y no es festivo
        return true;
    }

    function ahora()
    {
        return (date('H:i:s', time()));
    }

    /**
     * Retorna el tiempo en horas que falta para llegar a la fecha exacta indicada
     */
    public function get_leftTime($datestr, $format = "hours")
    {
        $date = strtotime($datestr); //Converted to a PHP date (a second count)
        $diff = $date - time(); //time returns current time in seconds
        $days = floor($diff / (60 * 60 * 24)); //seconds/minute*minutes/hour*hours/day)
        if ($format == "hours") {
            $hours = round(($diff) / (60 * 60));
            return ($hours);
        } else {
            return ($days);
        }
        //$hours = round(($diff - $days * 60 * 60 * 24) / (60 * 60));
        //echo "$days days $hours hours remain<br />";
    }

    /**
     * El prefijo es una cadena texto utilizada para marcar textualmente algunos objetos esta conformada
     * por el año, mes, dia, horas, minutos y segundos al momento actual, como elementos textuales sin
     * separaciones se utiliza generalmente para marcar archivos subidos al servidor.
     * @return type
     */
    function prefijo()
    {
        return (date('YmdHis', time()));
    }

    function completa()
    {
        return (self::get_STRFtime("%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time()));
    }

    function plazo($dias)
    {
        return ($this->sumar_diashabiles($this->hoy(), $dias));
    }

    /** Metodos Estaticos * */

    function sumar_diashabiles($fecha, $dias)
    {
        $datestart = strtotime($fecha);
        $datesuma = 15 * 86400;
        $diasemana = date('N', $datestart);
        $totaldias = $diasemana + $dias;
        $findesemana = intval($totaldias / 5) * 2;
        $diasabado = $totaldias % 5;
        if ($diasabado == 6) {
            $findesemana++;
        }
        $total = (($dias + $findesemana) * 86400) + $datestart;
        return ($twstart = date('Y-m-d', $total));
    }


    function hoy()
    {
        return (date('Y-m-d', time()));
    }

    function edad($fecha)
    {
        list($Y, $m, $d) = explode("-", $fecha);
        return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
    }

    /**
     * Retorna la edad de una persona a partir de una fecha de nacimiento recibida como cadena de texto
     * @return type
     */
    public function get_Age(mixed $date)
    {
        if (!empty($date)) {
            list($year, $month, $day) = explode("-", $date);
            $currentYear = date("Y");
            $currentMonth = date("m");
            $currentDay = date("d");
            $age = $currentYear - $year;
            if ($currentMonth < $month || ($currentMonth == $month && $currentDay < $day)) {
                $age--;
            }
            return ($age);
        }
        return ("0");
    }

    public function addMonthToDate($timeStamp, $totalMonths = 1)
    {
        // You can add as many months as you want. mktime will accumulate to the next year.
        $thePHPDate = getdate($timeStamp); // Covert to Array
        $thePHPDate['mon'] = $thePHPDate['mon'] + $totalMonths; // Add to Month
        $timeStamp = mktime($thePHPDate['hours'], $thePHPDate['minutes'], $thePHPDate['seconds'], $thePHPDate['mon'], $thePHPDate['mday'], $thePHPDate['year']); // Convert back to timestamp
        return $timeStamp;
    }

    public function sdias($timeStamp, $totalDays = 1)
    {//Sumar Dias
        $thePHPDate = getdate($timeStamp);
        $thePHPDate['mday'] = $thePHPDate['mday'] + $totalDays;
        $timeStamp = mktime($thePHPDate['hours'], $thePHPDate['minutes'], $thePHPDate['seconds'], $thePHPDate['mon'], $thePHPDate['mday'], $thePHPDate['year']);
        return $timeStamp;
    }

    public function addYearToDate($timeStamp, $totalYears = 1)
    {
        $thePHPDate = getdate($timeStamp);
        $thePHPDate['year'] = $thePHPDate['year'] + $totalYears;
        $timeStamp = mktime($thePHPDate['hours'], $thePHPDate['minutes'], $thePHPDate['seconds'], $thePHPDate['mon'], $thePHPDate['mday'], $thePHPDate['year']);
        return $timeStamp;
    }

    function validar($fecha)
    {
        $fecha = $this->fecha($fecha);
        if (checkdate($fecha['mes'], $fecha['dia'], $fecha['anno'])) {
            return (true);
        } else {
            return (false);
        }
    }

    function fecha($date)
    {
        $fecha['fecha'] = strtotime($date);
        $fecha['anno'] = date("Y", $fecha['fecha']); // Year (2003)
        $fecha['mes'] = date("m", $fecha['fecha']); // Month (12)
        $fecha['dia'] = date("d", $fecha['fecha']); // day (14)
        return ($fecha);
    }

    function create_timespan_string($Y, $m, $d, $H, $i, $s)
    {
        $timespan_string = '';
        $found_first_diff = false;
        if ($Y >= 1) {
            $found_first_diff = true;
            $timespan_string .= $this->pluralize($Y, 'year') . ' ';
        }
        if ($m >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= $this->pluralize($m, 'month') . ' ';
        }
        if ($d >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= $this->pluralize($d, 'day') . ' ';
        }
        if ($H >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= $this->pluralize($H, 'hour') . ' ';
        }
        if ($i >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= $this->pluralize($i, 'minute') . ' ';
        }
        if ($found_first_diff) {
            $timespan_string .= 'and ';
        }
        $timespan_string .= $this->pluralize($s, 'second');
        return $timespan_string;
    }

    function pluralize($count, $text)
    {
        return $count . (($count == 1) ? (" {$text}") : (" {$text}s"));
    }

    function dmy($fecha)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fecha)) {
            $date = new DateTime($fecha);
            return ($date->format('d-m-Y'));
        } else {
            return ($fecha);
        }
    }

}

?>