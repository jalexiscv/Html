<?php
$mphysicals = model("App\Modules\C4isr\Models\C4isr_Physicals");
$physicals = $mphysicals->where('profile', $oid)->findAll();
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($physicals as $physical): ?>
            <tr>
                <td><?= htmlspecialchars($physical['physical']) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>