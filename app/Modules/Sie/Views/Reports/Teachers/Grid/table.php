<?php
$b = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$musers = model("App\Modules\Sie\Models\Sie_Users");
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');

//[vars]----------------------------------------------------------------------------------------------------------------
$period = $_GET['period'];
$groups = $mcourses->select('teacher, period, COUNT(*) as course_count')->where("period", $period)->groupBy('teacher')->findAll();
$code = "";
$code .= "<style>\n    
.course-item {\n        border-bottom: 1px solid #eee;\n        padding: 0;\n    }\n    
.course-item:last-child {\n        border-bottom: none;\n    }\n    
.progress-bar {\n        font-size: 0.75rem;\n        line-height: 20px;\n    }\n
</style>";

$code .= "<div class=\"table-responsive\" style=\"max-height: 600px;\">\n";
$code .= "\t\t<table id=\"grid-table\" class=\"table table-striped table-hover mb-0\">\n";
$code .= "\t\t\t\t<thead class=\"table-dark sticky-top\">\n";
$code .= "\t\t\t\t<tr>\n";
$code .= "\t\t\t\t\t\t<th scope=\"col\">#</th>\n";
$code .= "\t\t\t\t\t<th style=\"width:100px;\" class=\"align-middle text-start\" scope=\"col\">Profesor</th>\n";
$code .= "\t\t\t\t\t<th  class=\"align-middle text-center\" scope=\"col\">C</th>\n";
$code .= "\t\t\t\t\t<th scope=\"col\">Detalles</th>\n";
$code .= "\t\t\t\t\t<th style=\"width:100px;\" class=\"text-center text-nowrap\" scope=\"col\">E</th>\n";
$code .= "\t\t\t\t\t<th style=\"width:100px;\" scope=\"col\">Calificaciones</th>\n";
$code .= "\t\t\t\t</tr>\n";
$code .= "\t\t\t\t</thead>\n";
$code .= "\t\t\t\t<tbody>\n";

$count = 0;
foreach ($groups as $group) {
    $teacher = @$group["teacher"];
    $profile = $mfields->get_Profile($group['teacher']);
    $teacherFullname = safe_strtoupper(@$profile['name']);
    $linkName = "<a href=\"/sie/teachers/report/\" . lpk() . \"?teacher={$group['teacher']}\" target=\"_blank\">{$teacherFullname}</a>";
    $count++;

    // Initialize counters
    $totalStudents = 0;
    $totalPossibleGrades = 0;
    $completedGrades = 0;
    $courseDetails = [];

    // Get all courses for this teacher
    $courses = $mcourses->where('teacher', $group['teacher'])->where("period", $period)->findAll();

    // Process each course
    foreach ($courses as $course) {
        $executions = $mexecutions
            ->select('MAX(execution) as execution, progress')
            ->where('course', $course['course'])
            ->orderBy('created_at', 'DESC')
            ->groupBy(['course', 'progress'])
            ->find();

        $studentCount = count($executions);
        $totalStudents += $studentCount;

        // Count completed grades
        $courseGrades = 0;
        foreach ($executions as $execution) {
            $exec = $mexecutions->get_Execution($execution['execution']);
            $c1 = (!empty($exec['c1']) && doubleval($exec['c1']) > 0) ? 1 : 0;
            $c2 = (!empty($exec['c2']) && doubleval($exec['c2']) > 0) ? 1 : 0;
            $c3 = (!empty($exec['c3']) && doubleval($exec['c3']) > 0) ? 1 : 0;
            $courseGrades += $c1 + $c2 + $c3;
        }

        $completedGrades += $courseGrades;
        $totalPossibleGrades += ($studentCount * 3);

        // Prepare course details
        $courseDetails[] = [
            'course' => $course['course'],
            'name' => $course['name'],
            'students' => $studentCount,
            'grades' => $courseGrades . '/' . ($studentCount * 3)
        ];
    }

    // Calculate completion percentage
    $completion = $totalPossibleGrades > 0 ? round(($completedGrades / $totalPossibleGrades) * 100) : 0;
    $completionClass = $completion == 100 ? 'bg-success' : ($completion > 50 ? 'bg-primary' : 'bg-warning');

    // Build the row
    $code .= "<tr>";
    $code .= "<td class='align-middle'>{$count}</td>";
    $code .= "<td class='align-middle'>{$linkName}</td>";
    $code .= "<td class=\"align-middle text-center\">{$group['course_count']}</td>";

    // Course details
    $code .= "<td class='align-middle text-start'>";
    $code .= "<ol>";
    foreach ($courseDetails as $detail) {
        $code .= "<li>";
        $code .= "<div class='course-item d-flex justify-content-between align-items-center'>";
        $code .= "<span><a href='/sie/courses/view/{$detail['course']}' target='_blank'>{$detail['name']}</a> - {$detail['course']}</span>";
        $code .= "<span class='badge bg-secondary'>{$detail['students']} <i class='fas fa-user-graduate ms-1'></i></span>";
        $code .= "</div>";
        $code .= "</li>";
    }
    $code .= "</ol>";
    $code .= "</td>";

    // Total students
    $code .= "<td class='align-middle text-center text-nowrap'><span class='badge bg-primary'>{$totalStudents}</span></td>";

    // Grades progress
    $code .= "<td class='align-middle'>";
    $code .= "<div class='d-flex align-items-center'>";
    // Vertical progress bar
    $code .= "<div class='progress me-2' style='height: 100px; width: 20px; align-items: flex-end;'>";
    $code .= "<div class='progress-bar {$completionClass}' role='progressbar' style='width: 100%; height: {$completion}%;' ";
    $code .= "aria-valuenow='{$completion}' aria-valuemin='0' aria-valuemax='100' title='{$completedGrades}/{$totalPossibleGrades} grados completados'>";
    $code .= "</div></div>";
    // Text next to the bar
    $code .= "<div><small class='text-muted'>{$completion}%</small><br><small class='text-muted'>{$completedGrades}/{$totalPossibleGrades}</small></div>";
    $code .= "</div></td>";

    $code .= "</tr>\n";
}

$code .= "\t\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "</div>\n";

echo($code);
?>