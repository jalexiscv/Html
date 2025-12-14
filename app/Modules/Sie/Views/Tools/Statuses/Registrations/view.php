<?php
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');

$statuses = $mstatuses
    ->where('registration', NULL)
    ->findAll();

echo("<table class='table table-bordered'>");
echo("<tr>");
echo("<th>#</th>");
echo("<th>status</th>");
echo("<th>registration</th>");
echo("<th>identification_number</th>");
echo("<th>program</th>");
echo("<th>period</th>");
echo("<th>moment</th>");
echo("<th>cycle</th>");
echo("<th>reference</th>");
echo("<th>observation</th>");
echo("<th>date</th>");
echo("<th>time</th>");
echo("<th>author</th>");
echo("<th>locked_at</th>");
echo("</tr>");
$count = 0;
foreach ($statuses as $status) {
    $count++;
    $registration = $mregistrations
        ->where('identification_number', $status['identification_number'])
        ->first();
    echo("<tr>");
    echo("<td>{$count}</td>");
    echo("<td>" . @$status['status'] . "</td>");
    echo("<td>" . @$registration["registration"] . "</td>");
    echo("<td>" . $status['identification_number'] . "</td>");
    echo("<td>" . $status['program'] . "</td>");
    echo("<td>" . $status['period'] . "</td>");
    echo("<td>" . $status['moment'] . "</td>");
    echo("<td>" . $status['cycle'] . "</td>");
    echo("<td>" . $status['reference'] . "</td>");
    echo("<td>" . $status['observation'] . "</td>");
    echo("<td>" . $status['date'] . "</td>");
    echo("<td>" . $status['time'] . "</td>");
    echo("<td>" . $status['author'] . "</td>");
    echo("<td>" . $status['locked_at'] . "</td>");
    echo("</tr>");
    if (!empty($registration['registration'])) {
        $mstatuses->update($status['status'], [
            'registration' => $registration['registration'],
            'created_at' => @$registration['created_at'],
        ]);
    }
}
echo("</table>");


?>