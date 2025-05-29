<?php
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$registration = $mregistrations->get_Registration($oid);

$moodle_student_id = "SIN REGISTRO EN MOODLE";

if (!empty($registration["moodle_student_id"])) {
    $moodle_student_id = $registration['moodle_student_id'];
}

?>
<div class="card mb-2">
    <div class="card-body text-center">
        <?php echo($moodle_student_id); ?>
    </div>
</div>
