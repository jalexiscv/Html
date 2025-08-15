<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            font-size: 10px !important;
            line-height: 10px !important;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }


        .table > :not(caption) > * > * {
            padding: 0px 0px;
        }


    </style>
</head>
<body>
<?php
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$musers = model('App\Modules\Sie\Models\Sie_Users');
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");


$courses = $mcourses->where('status', "ACTIVE")->findAll();


$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-bordered table-striped table-hover \" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "\t\t <thead>";
$code .= "\t\t\t\t  <tr>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">#</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Código</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Referencia</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Estado</th>\n";
$code .= "\t\t\t\t  </tr>\n";
$code .= "\t\t </thead>";
$code .= "\t\t <tbody>";

$count = 0;
foreach ($courses as $course) {
    $count++;
    $trid = @$course["course"];
    $name = @$course['name'];
    $teacher = @$course['teacher'];
    $profile = $mfields->get_Profile($teacher);
    $teacher_name = @$profile['firstname'];
    $moodle_teacher = @$profile['citizenshipcard'];
    $moodle_course = @$course['moodle_course'];
    $course_name = strtoupper($name);
    $teacher_name = strtoupper("{$teacher_name} {$teacher}");

    // Fila
    $code .= "\t\t\t\t  <tr id=\"trid-{$trid}\" data-registration=\"{$trid}\" data-status=\"STARTED\" >\n";
    $code .= "\t\t\t\t\t <td class='text-center align-middle'>{$count}</td>\n";
    $code .= "\t\t\t\t\t <td class='text-center align-middle'>{$course["course"]}</td>\n";
    $code .= "\t\t\t\t\t <td class='text-start p-1 '>";
    $code .= "<table>";
    $code .= "<tr><td class='text-end'><b>Curso</b>:</td><td>{$course_name}</td></tr>";
    $code .= "<tr><td class='text-end'><b>Profesor</b>:</td><td>{$teacher_name}</td> </tr>";
    $code .= "<tr><td class='text-end'><b>Moodle-Course</b>:</td><td><i class=\"fa-solid fa-lock-open\"></i> <span class='text-success'>{$moodle_course}</span></td></tr>";
    $code .= "<tr><td class='text-end'><b>Moodle-User</b>:</td><td><i class=\"fa-solid fa-key\"></i> <span class='text-success'>{$moodle_teacher}</span></td></tr>";
    $code .= "</table>";
    include("moodle-assign-delete.php");
    include("moodle-assign-teacher.php");
    $code .= "</td>\n";
    $code .= "\t\t\t\t\t <td class='text-start ' title=\"\" >{$course["status"]}</td>\n";
    $code .= "\t\t\t\t  </tr>\n";

}
$code .= "\t\t</tbody>\n";
$code .= "\t</table>\n";

echo $code;

?>
<body>
</html>