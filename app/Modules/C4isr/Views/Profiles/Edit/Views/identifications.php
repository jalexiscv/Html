<?php
$midentifications = model("App\Modules\C4isr\Models\C4isr_Identifications");
$identifications = $midentifications->where('profile', $oid)->findAll();
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Pais</th>
            <th>Tipo</th>
            <th>Numero</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($identifications as $identification): ?>
            <tr>
                <td><?= htmlspecialchars($identification['identification']) ?></td>
                <td><?= htmlspecialchars(@$identification['country']) ?></td>
                <td><?= htmlspecialchars(@$identification['type']) ?></td>
                <td><?= htmlspecialchars(@$identification['number']) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>