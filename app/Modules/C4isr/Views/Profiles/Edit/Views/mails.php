<?php
$strings = service('strings');
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mvulnerabilities = model('App\Modules\C4isr\Models\C4isr_Vulnerabilities');
$mintrusions = model('App\Modules\C4isr\Models\C4isr_Intrusions');
$maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');

$mails = $mmails->query_UnionByProfile($oid, 100, 0);
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Correo electrónico</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($mails as $mail): ?>
            <tr>
                <td><?= htmlspecialchars($mail['mail']) ?></td>
                <td><?= htmlspecialchars($strings->get_URLDecode($mail['email'])) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>