<?php
$strings = service('strings');
$maddresses = model("App\Modules\C4isr\Models\C4isr_Addresses");
$addresses = $maddresses->where('profile', $oid)->findAll();
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Dirección</th>
            <th>Referencia</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($addresses as $address): ?>
            <?php $direction = $strings->get_URLDecode($address['direction']); ?>
            <?php $reference = $strings->get_URLDecode($address['reference']); ?>
            <tr>
                <td><?= htmlspecialchars($address['address']) ?></td>
                <td><?= htmlspecialchars($direction) ?></td>
                <td><?= htmlspecialchars($reference) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>