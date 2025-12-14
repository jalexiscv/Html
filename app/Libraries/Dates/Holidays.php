<?php

namespace App\Libraries\Dates;

/**
 * Class Holidays
 * @package App\Libraries\Dates
 * // Uso de la clase
 * $colombianHolidays = [
 * // Lista de días festivos en Colombia a ser actualizada anualmente
 * '2023-01-01', '2023-01-09',
 *];
 * $holidays = new Holidays($colombianHolidays);
 * $date = new DateTime('2023-07-20');
 * if ($holidays->isWorkingDay($date)) {
 * echo "La fecha {$date->format('Y-m-d')} es un día laboral en Colombia.";
 * } else {
 * echo "La fecha {$date->format('Y-m-d')} NO es un día laboral en Colombia.";
 * }
 */
class Holidays
{
    private array $holidays;

    public function __construct()
    {
        $this->holidays = array(
            "2024-01-01" => "Año Nuevo",
            "2024-01-08" => "Epifanía",
            "2024-03-25" => "Día de San José",
            "2024-03-28" => "Jueves Santo",
            "2024-03-29" => "Viernes Santo",
            "2024-05-01" => "Día del trabajo",
            "2024-05-13" => "Ascensión de Jesús",
            "2024-06-03" => "Corpus Christi",
            "2024-06-10" => "Sagrado Corazón de Jesús",
            "2024-07-01" => "San Pedro y San Pablo",
            "2024-07-20" => "Día de la independencia",
            "2024-08-07" => "Batalla de Boyacá",
            "2024-08-19" => "Asunción de la Virgen",
            "2024-10-14" => "Día de la raza",
            "2024-11-04" => "Todos los Santos",
            "2024-11-11" => "Independencia de Cartagena",
            "2024-12-08" => "Inmaculada Concepción",
            "2024-12-25" => "Navidad",
            "2025-01-01" => "Año Nuevo",
            "2025-01-06" => "Epifanía",
            "2025-03-24" => "Día de San José",
            "2025-04-17" => "Jueves Santo",
            "2025-04-18" => "Viernes Santo",
            "2025-05-01" => "Día del trabajo",
            "2025-06-02" => "Ascensión de Jesús",
            "2025-06-23" => "Corpus Christi",
            "2025-06-30" => "Sagrado Corazón de Jesús",
            "2025-07-20" => "Día de la independencia",
            "2025-08-07" => "Batalla de Boyacá",
            "2025-08-18" => "Asunción de la Virgen",
            "2025-10-13" => "Día de la raza",
            "2025-11-03" => "Todos los Santos",
            "2025-11-17" => "Independencia de Cartagena",
            "2025-12-08" => "Inmaculada Concepción",
            "2025-12-25" => "Navidad",
        );
    }

    public function is_WorkingDay(string $date): bool
    {
        $datetime = new \DateTime($date);
        $dayOfWeek = $datetime->format('N');// 'N' devuelve el día de la semana donde 1 es lunes y 7 es domingo
        return $dayOfWeek >= 1 && $dayOfWeek <= 5 && !$this->is_Holiday($date);// Verifica si es un día laboral y no un día festivo
    }

    public function is_Holiday(string $date): bool
    {
        $date = new \DateTime($date);
        $formattedDate = $date->format('Y-m-d'); // Formatea la fecha como cadena para la comparación
        return array_key_exists($formattedDate, $this->holidays); // Verifica si la fecha está en las claves del array
    }

}


?>