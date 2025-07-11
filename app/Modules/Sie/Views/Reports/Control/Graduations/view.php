<?php
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mgraduations = model('App\Modules\Sie\Models\Sie_Graduations');

/**
 * "graduation",
 * "city",
 * "date",
 * "application_type",
 * "full_name",
 * "document_type",
 * "document_number",
 * "expedition_place",
 * "address",
 * "phone_1",
 * "email",
 * "phone_2",
 * "degree",
 * "doc_id",
 * "highschool_diploma",
 * "highschool_graduation_act",
 * "icfes_results",
 * "saber_pro",
 * "academic_clearance",
 * "financial_clearance",
 * "graduation_fee_receipt",
 * "graduation_request",
 * "admin_graduation_request",
 * "ac",
 * "ac_score",
 * "ek",
 * "ek_score",
 * "status",
 * "author",
 * "created_at",
 * "updated_at",
 * "deleted_at",
 */

$code = "";
$code .= "<table\n";
$code .= "\t\t id=\"excelTable\"\n";
$code .= "\t\t class=\"table table-bordered table-striped table-hover table-excel\" \n ";
$code .= "\t\t >\n";
$code .= "<thead>";
$code .= "<tr>";
$code .= "<td>#</td>";
$code .= "<td>City</td>";
$code .= "<td>Date</td>";
$code .= "<td>Application Type</td>";
$code .= "<td>Full Name</td>";
$code .= "<td>Document Type</td>";
$code .= "<td>Document Number</td>";
$code .= "<td>Expedition Place</td>";
$code .= "<td>Address</td>";
$code .= "<td>Phone 1</td>";
$code .= "<td>Email</td>";
$code .= "<td>Phone 2</td>";
$code .= "<td>Degree</td>";
$code .= "<td>Doc ID</td>";
$code .= "<td>Highschool Diploma</td>";
$code .= "<td>Highschool Graduation Act</td>";
$code .= "<td>Icfes Results</td>";
$code .= "<td>Saber Pro</td>";
$code .= "<td>Academic Clearance</td>";
$code .= "<td>Financial Clearance</td>";
$code .= "<td>Graduation Fee Receipt</td>";
$code .= "<td>Graduation Request</td>";
$code .= "<td>Admin Graduation Request</td>";
$code .= "<td>Ac</td>";
$code .= "<td>Ac Score</td>";
$code .= "<td>Ek</td>";
$code .= "<td>Ek Score</td>";
$code .= "<td>Status</td>";
$code .= "<td>Author</td>";
$code .= "</tr>";
$code .= "</thead>";

$mgraduations = $mgraduations->findAll();

$count = 0;
foreach ($mgraduations as $graduation) {
    $count++;
    $code .= "<tr>";
    $code .= "    <td>" . @$count . "</td>";
    $code .= "    <td>" . @$graduation['city'] . "</td>";
    $code .= "    <td>" . @$graduation['date'] . "</td>";
    $code .= "    <td>" . @$graduation['application_type'] . "</td>";
    $code .= "    <td>" . @$graduation['full_name'] . "</td>";
    $code .= "    <td>" . @$graduation['document_type'] . "</td>";
    $code .= "    <td>" . @$graduation['document_number'] . "</td>";
    $code .= "    <td>" . @$graduation['expedition_place'] . "</td>";
    $code .= "    <td>" . @$graduation['address'] . "</td>";
    $code .= "    <td>" . @$graduation['phone_1'] . "</td>";
    $code .= "    <td>" . @$graduation['email'] . "</td>";
    $code .= "    <td>" . @$graduation['phone_2'] . "</td>";
    $code .= "    <td>" . @$graduation['degree'] . "</td>";
    $code .= "    <td>" . @$graduation['doc_id'] . "</td>";
    $code .= "    <td>" . @$graduation['highschool_diploma'] . "</td>";
    $code .= "    <td>" . @$graduation['highschool_graduation_act'] . "</td>";
    $code .= "    <td>" . @$graduation['icfes_results'] . "</td>";
    $code .= "    <td>" . @$graduation['saber_pro'] . "</td>";
    $code .= "    <td>" . @$graduation['academic_clearance'] . "</td>";
    $code .= "    <td>" . @$graduation['financial_clearance'] . "</td>";
    $code .= "    <td>" . @$graduation['graduation_fee_receipt'] . "</td>";
    $code .= "    <td>" . @$graduation['graduation_request'] . "</td>";
    $code .= "    <td>" . @$graduation['admin_graduation_request'] . "</td>";
    $code .= "    <td>" . @$graduation['ac'] . "</td>";
    $code .= "    <td>" . @$graduation['ac_score'] . "</td>";
    $code .= "    <td>" . @$graduation['ek'] . "</td>";
    $code .= "    <td>" . @$graduation['ek_score'] . "</td>";
    $code .= "    <td>" . @$graduation['status'] . "</td>";
    $code .= "</tr>";
}

$code .= "</table>";

echo($code);
?>
<style>
    /* Estilos adicionales para simular Excel */
    .table-excel {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-excel thead {
        background-color: #f1f3f5;
        font-weight: bold;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table-excel th {
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        text-wrap: nowrap;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    .table-excel td {
        vertical-align: middle;
        text-wrap: nowrap;
    }

    .table-excel tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    /* Efecto de selección similar a Excel */
    .table-excel .selected {
        background-color: #b3d7ff !important;
    }


    .table-excel th,
    .table-excel td {
        min-width: 100px; /* Ancho mÃ­nimo para cada columna */
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

</style>
