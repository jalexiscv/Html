<?php

/** @var $oid string Es el código de la matricula o estudiante */
$dates = service("dates");
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
$mitems = model("App\Modules\Sie\Models\Sie_Orders_Items");
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mapplieds = model("App\Modules\Sie\Models\Sie_Applieds");
//[matricula]-----------------------------------------------------------------------------------------------------------
$registration = $mregistrations->getRegistration($oid);
//print_r($registration);

if ($registration['status'] == 'ADMITTED' || $registration['status'] == 'HOMOLOGATION' || $registration['status'] == 'RE-ENTRY') {
    $program = $mprograms->getProgram($registration['program']);

    $enrollment_ticket = $registration['ticket'] + 10000;
    $enrollment_order = $morders->get_OrderByTicket($enrollment_ticket);
    //echo("TICKET DE MATRICULA: " . $enrollment_ticket . "<br>");
    if (!$enrollment_order) {
        $total = "";
        $paid = "";
        $pkorder = pk();
        $order = array(
            "order" => $pkorder,
            "user" => $registration['registration'],
            "ticket" => $enrollment_ticket,
            "parent" => "",
            "period" => $registration['period'],
            "total" => $total,
            "paid" => $paid,
            "status" => "NORMAL",
            "author" => safe_get_user(),
            "type" => "NORMAL",
            "date" => safe_get_date(),
            "time" => safe_get_time(),
            "expiration" => $dates->addDaysExact(safe_get_date(), 30)
        );
        $morders->insert($order);
        //[costos]-------------------------------------------------------------------------------------------------------
        /**
         * Técnico - Tecnólogo - Profesional
         * 6657A680B1616    007    Inscripción de Estudiantes    $91.000,00
         * 6657A60B770A5    011    Seguro Estudiantil    $23.400,00
         * 6657A5BE00AD6    009    Derechos registro, control y papelería estudiante    $39.000,00
         * 6657A59065FE8    010    Carné Estudiantil    $35.100,00
         * 6657A2F7AA325    012    Aporte Bienestar Estudiantil    $26.000,00
         * 6630B5BC340BE    005    Inscripción para estudiantes en articulación    $0,00
         * 6630B31E9349B    003    Matricula Nivel Profesional Universitario    $1.950.000,00
         * 6630B1EB4307E    002    Matricula Nivel Tecnológico    $1.560.000,00
         * 6630AE0FC6936    001    Matricula Nivel Técnico
         */
        $details = array();
        $matricula = 0;
        if (strpos(safe_strtolower(@$program['name']), 'técnico') !== false) {
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "1300000,00", "amount" => "1", "description" => "Matricula Nivel Técnico (001-6630AE0FC6936)", "percentage" => "0", "author" => safe_get_user());
            $matricula = "1300000,00";
        } elseif (strpos(safe_strtolower(@$program['name']), 'tecnólogo') !== false) {
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "1560000,00", "amount" => "1", "description" => "Matricula Nivel Tecnológico (002-6630B1EB4307E)", "percentage" => "0", "author" => safe_get_user());
            $matricula = "1560000,00";
        } elseif (strpos(safe_strtolower(@$program['name']), 'tecnología') !== false) {
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "1560000,00", "amount" => "1", "description" => "Matricula Nivel Tecnológico (002-6630B1EB4307E)", "percentage" => "0", "author" => safe_get_user());
            $matricula = "1560000,00";
        } elseif (strpos(safe_strtolower(@$program['name']), 'profesional') !== false) {
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "1950000,00", "amount" => "1", "description" => "Matricula Nivel Profesional Universitario (003-6630B31E9349B)", "percentage" => "0", "author" => safe_get_user());
            $matricula = "1950000,00";
        } else {
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "1950000,00", "amount" => "1", "description" => "Error - ", "percentage" => "0", "author" => safe_get_user());
            $matricula = "1950000,00";
        }
        $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "23400,00", "amount" => "1", "description" => "Seguro Estudiantil (011-6657A60B770A5)", "percentage" => "0", "author" => safe_get_user());
        $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "39000,00", "amount" => "1", "description" => "Derechos registro, control y papelería estudiante (009-6657A5BE00AD6)", "percentage" => "0", "author" => safe_get_user());
        $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "35100,00", "amount" => "1", "description" => "Carné Estudiantil (010-6657A59065FE8)", "percentage" => "0", "author" => safe_get_user());
        $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => "26000,00", "amount" => "1", "description" => "Aporte Bienestar Estudiantil (012-6657A2F7AA325)", "percentage" => "0", "author" => safe_get_user());


        //[descuentos]----------------------------------------------------------------------------------------------------------
        $discounteds = $mdiscounteds->where("object", $registration['registration'])->findAll();
        foreach ($discounteds as $discounted) {
            $discount = $mdiscounts->getDiscount($discounted['discount']);
            $concept = $discount['name'];
            $description = is_array($program) ? mb_convert_encoding($concept, 'ISO-8859-1', 'UTF-8') : "";
            if ($discount['character'] == "PERCENTAGE") {
                if (is_numeric($discount['value'])) {
                    $price = doubleval($matricula) * $discount['value'] / 100;
                    echo "El precio con descuento es: " . $price;
                } else {
                    echo "El valor del descuento no es numérico: {$discount['value']}";
                }
            } else {
                $price = $discount['value'];
            }
            $details[] = array("item" => pk(), "order" => $pkorder, "type" => "UNIT_PRICE", "value" => -($price), "amount" => "1", "description" => $description, "percentage" => "0", "author" => safe_get_user());
        }
        // Insert
        foreach ($details as $detail) {
            $create = $mitems->insert($detail);
        }
        //Actualizo el valor de la orden
        $total = 0;
        foreach ($details as $detail) {
            $total += doubleval($detail['value']);
        }
        $morders->update($pkorder, array("total" => $total));
        $morders->update($pkorder, array("paid" => "0,00"));

        //[/ITEMS]------------------------------------------------------------------------------------------------------
    }
}

?>