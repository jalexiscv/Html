<?php
$mphones = model("App\Modules\C4isr\Models\C4isr_Phones");
$phones = $mphones->query_UnionByProfile($oid, 100, 0)
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Pais</th>
            <th>Area</th>
            <th>Local</th>
            <th>Extensión</th>
            <th>Tipo</th>
            <th>Operador</th>
            <th>Numero</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($phones as $phone): ?>
            <tr>
                <td><?= htmlspecialchars($phone['phone']) ?></td>
                <td><?= htmlspecialchars(@$phone['country_code']) ?></td>
                <td><?= htmlspecialchars(@$phone['area_code']) ?></td>
                <td><?= htmlspecialchars(@$phone['local_number']) ?></td>
                <td><?= htmlspecialchars(@$phone['extension']) ?></td>
                <td><?= htmlspecialchars(@$phone['type']) ?></td>
                <td><?= htmlspecialchars(@$phone['carrier']) ?></td>
                <td><?= htmlspecialchars(@$phone['normalized_number']) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>