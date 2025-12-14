<?php
$msocials = model("App\Modules\C4isr\Models\C4isr_Socials");
$socials = $msocials->where('profile', $oid)->findAll();
?>
<div class="col-12">
    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Red Social</th>
            <th>SID</th>
            <th>Alias</th>
            <th>Opciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($socials as $social): ?>
            <tr>
                <td><?= htmlspecialchars($social['social']) ?></td>
                <td><?= htmlspecialchars(@$social['network']) ?></td>
                <?php if ($social['network'] == "FACEBOOK") { ?>}
                    <td><a href="https://www.facebook.com/<?= htmlspecialchars(@$social['sid']) ?>"
                           target="_blank"><?= htmlspecialchars(@$social['sid']) ?></a></td>
                <?php } else { ?>
                    <td><?= htmlspecialchars(@$social['sid']) ?></td>
                <?php } ?>
                <td><?= htmlspecialchars(@$social['alias']) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>