<?php
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$discounts = $mdiscounts->get_List(1000, 0);
$discounteds = $mdiscounteds->where('object', $oid)->findAll();
?>
<div id="items-container">
    <?php if (is_array($discounteds)) { ?>
        <table id="discounts-table" class="table table-striped table-bordered table-hover table-responsive w-100 mb-0">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Detalle</th>
                <th class="text-center" style="width: 150px;">Tipo</th>
                <th class="text-center" style="width: 150px;">Característica</th>
                <th class="text-center" style="width: 150px;">Valor</th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 0; ?>
            <?php foreach ($discounteds as $discounted) { ?>
                <?php $count++; ?>
                <?php $discount = $mdiscounts->getDiscount($discounted['discount']); ?>
                <?php $character = @$discount['character']; ?>
                <?php $character = ($character == "PERCENTAGE") ? "Porcentaje" : "Valor"; ?>
                <?php $discount_name = @$discount['name']; ?>
                <?php $discount_value = @$discount['value']; ?>
                <?php
                $type = @$discount['type'];
                if ($type == "SCHOLARSHIP") {
                    $type = "Beca";
                } elseif ($type == "REGISTRATION") {
                    $type = "Descuento inscripción";
                } elseif ($type == "FIXED") {
                    $type = "Descuento";
                }
                ?>
                <tr class="discount-row">
                    <td class="text-center align-middle"><?php echo($count); ?></td>
                    <td class="text-start align-middle"><?php echo($discount_name); ?></td>
                    <td class="text-start align-middle"><?php echo($type); ?></td>
                    <td class="text-start align-middle"><?php echo($character); ?></td>
                    <td class="text-end align-middle"><?php echo($discount_value); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>