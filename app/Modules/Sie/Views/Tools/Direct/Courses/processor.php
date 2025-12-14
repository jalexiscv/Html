<?php

//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mobservations = model("App\Modules\Sie\Models\Sie_Observations");
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mexecutions = model('App\\Modules\\Sie\\Models\\Sie_Executions');
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$d = array(
    "registration" => $f->get_Value("registration"),
    "course" => $f->get_Value("course"),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    "first_name" => $f->get_Value("first_name"),
    "second_name" => $f->get_Value("second_name"),
    "first_surname" => $f->get_Value("first_surname"),
    "second_surname" => $f->get_Value("second_surname"),
    "email_address" => $f->get_Value("email_address"),
    "gender" => $f->get_Value("gender"),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "residence_country" => $f->get_Value("residence_country"),
    "residence_region" => $f->get_Value("residence_region"),
    "residence_city" => $f->get_Value("residence_city"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $mregistrations->find($d["registration"]);
//$l["back"] = "/sie/tools/direct/courses/" . lpk();
$l["back"] = "/";
$asuccess = "sie/orders-edit-success-message.mp3";
$anoexist = "sie/orders-edit-noexist-message.mp3";

$course = $mcourses->getCourse($d["course"]);//[build]---------------------------------------------------------------------------------------------------------------


if (is_array($row)) {
    //$edit = $model->update($d['order'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.direct-registration-success-courses-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Registrations.direct-registration-success-courses-message"), $course['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $mregistrations->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.direct-registration-success-courses-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Registrations.direct-registration-success-courses-message"), $course['name']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}


$observation = array(
    "observation" => pk(),
    "object" => $d["registration"],
    "type" => "37",
    "content" => "El usuario se registró directamente en el curso {$course['name']} - {$course['course']}. En esta modalidad de inscripción solo se solicitan datos básicos, ya que el estudiante se matricula únicamente en el curso y no en un programa académico completo.",
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
);
$create = $mobservations->insert($observation);

$execution = array(
    "execution" => pk(),
    "registration" => $d["registration"],
    "progress" => "",
    "course" => $course['course'],
    "date_start" => safe_get_date(),
    "date_end" => $f->get_Value("date_end"),
    "total" => $f->get_Value("total"),
    "author" => safe_get_user(),
);
$create = $mexecutions->insert($execution);

cache()->clean();


echo($c);
?>