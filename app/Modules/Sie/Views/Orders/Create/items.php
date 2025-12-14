<div id="items-container">
    <table id="items-table" class="table table-striped table-bordered table-hover table-responsive w-100 mb-0">
        <thead>
        <tr>
            <th>Detalle</th>
            <th style="width: 100px;" class="text-center">Cantidad</th>
            <th style="width: 130px;" class="text-center">Valor Unitario</th>
            <th style="width: 130px;" class="text-center">Descuento</th>
            <th style="width: 130px;" class="text-center">Subtotal</th>
            <th style="width: 64px;" class="text-center"><i class="fa-sharp fa-regular fa-gear"></i></th>
        </tr>
        </thead>
        <tbody>
        <!--
            <tr class="item-row">
                <td><select class="form-select me-2" onchange="updatePrice(this)" required><option value="">Seleccione un ítem</option></select></td>
                <td><input type="number" class="form-control me-2" placeholder="Cantidad" min="1" oninput="calculateTotal()" required></td>
                <td><input type="number" class="form-control me-2 item-price text-end pr-1" placeholder="Precio Unitario" min="0" step="0.01"></td>
                <td><input type="number" class="form-control me-2 item-subtotal text-end pr-1" placeholder="Subtotal" min="0" step="0.01" readonly></td>
                <td><button type="button" class="btn btn-danger w-100" onclick="removeItem(this)">Eliminar</button></td>
            </tr>
            //-->
        <tr class="item-row-total">
            <td></td>
            <td></td>
            <td></td>
            <td class="text-end align-middle"> Total Bruto:</td>
            <td>
                <input id="total-neto" type="number" class="form-control me-2 total-neto text-end pr-1"
                       style="background-color: #c7eaf4;" placeholder="0" min="0" step="0.01" readonly>
            </td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>