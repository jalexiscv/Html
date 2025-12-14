<?php
$strings = service('strings');
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');

$aliases = $maliases->query_UnionByProfile($oid, 100, 0);
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Alias</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($aliases as $alias): ?>
            <tr>
                <td><?= htmlspecialchars($alias['alias']) ?></td>
                <td><?= htmlspecialchars($strings->get_URLDecode($alias['user'])) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>