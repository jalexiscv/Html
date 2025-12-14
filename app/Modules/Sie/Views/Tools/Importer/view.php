<?php

$mregstrationsold = model('App\Modules\Sie\Models\Sie_Registrations_Old');
$mregstrations = model('App\Modules\Sie\Models\Sie_Registrations');


$all = $mregstrationsold->findAll();

$count = 0;
foreach ($all as $key => $value) {
    $rn = $mregstrations->where('identification_number', $value['identification_number'])->first();
    if (is_array($rn) && count($rn) > 0) {
        //echo "{$count} - {$value['registration']} - {$value['first_name']} - <b>{$value['identification_number']}</b> -  <span style='color:red;'>EXISTE!</span><br>";
    } else {
        $count++;
        echo "{$count} - {$value['registration']} - {$value['first_name']} <b>{$value['identification_number']}</b> <br>";
        /**
         * "registration",
         * "first_name",
         * "second_name",
         * "first_surname",
         * "second_surname",
         * "identification_type",
         * "identification_number",
         * "birth_date",
         * "birth_city",
         * "mobile",
         * "email_address",
         * "address",
         * "residence_country",
         * "residence_city",
         * "neighborhood",
         * "gender",
         * "stratum",
         * "marital_status",
         * "blood_type",
         * "import",
         */
        $data = array(
            'registration' => @$value['registration'],
            'first_name' => @$value['first_name'],
            'second_name' => @$value['second_name'],
            'first_surname' => @$value['first_surname'],
            'second_surname' => $value['second_surname'],
            'identification_type' => @$value['identification_type'],
            'identification_number' => @$value['identification_number'],
            'birth_date' => @$value['birth_date'],
            'birth_city' => @$value['birth_city'],
            'mobile' => @$value['mobile'],
            'email_address' => @$value['email_address'],
            'address' => @$value['address'],
            'residence_country' => @$value['residence_country'],
            'residence_city' => @$value['residence_city'],
            'neighborhood' => @$value['neighborhood'],
            'gender' => @$value['gender'],
            'stratum' => @$value['stratum'],
            'marital_status' => @$value['marital_status'],
            'blood_type' => @$value['blood_type'],
            'import' => @$value['import'],
        );
        $mregstrations->insert($data);
        $mregstrationsold->delete($value['registration']);


    }
}


?>