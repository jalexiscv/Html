<?php
/** @var object $parent Trasferido desde el controlador * */
/** @var object $authentication Trasferido desde el controlador * */
/** @var object $request Trasferido desde el controlador * */
/** @var object $dates Trasferido desde el controlador * */
/** @var string $component Trasferido desde el controlador * */
/** @var string $view Trasferido desde el controlador * */
/** @var string $oid Trasferido desde el controlador * */
/** @var string $views Trasferido desde el controlador * */
/** @var string $prefix Trasferido desde el controlador * */
/** @var array $data Trasferido desde el controlador * */
/** @var object $model Modelo de datos utilizado en la vista y trasferido desde el index * */
/** @var array $course Vector con los datos del curso para mostrarlos en la vista * */
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$count = $mcourses->get_CountStudentsByCourse($oid);
$card_count_students = get_sie_count_students($count);
$card_course_schedule = get_sie_course_schedule($course);
echo($card_count_students);
echo($card_course_schedule);
?>