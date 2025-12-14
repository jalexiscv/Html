<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-28 23:21:45
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Orders\List\table.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
//[models]--------------------------------------------------------------------------------------------------------------
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mpayments = model('App\Modules\Sie\Models\Sie_Payments');
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    "order" => "Factura(Orden)",
    //"user" => lang("App.user"),
    "ticket" => lang("App.Ticket"),
    //"parent" => lang("App.parent"),
    //"period" => lang("App.period"),
    //"total" => lang("App.total"),
    //"paid" => lang("App.paid"),
    //"status" => lang("App.status"),
    //"author" => lang("App.author"),
    //"type" => lang("App.type"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"expiration" => lang("App.expiration"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array("user" => $oid);
$morders->clear_AllCache();
$rows = $morders->get_CachedSearch($conditions, $limit, $offset, "order DESC");
$total = $morders->get_CountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//echo(safe_dump($rows['data']));
$registration = $mregistrations->getRegistration($oid);
//[build]--------------------------------------------------------------------------------------------------------------
$tid = "grid-" . uniqid();
$bgrid = $bootstrap->get_Grid(array("id" => $tid));
$bgrid->set_Id($tid);
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center	align-middle"),
    //array("content" => lang("App.Order"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.user"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Ticket"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.parent"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Period"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Description"), "class" => "text-left	align-middle"),
    array("content" => lang("App.Total"), "class" => "text-right align-middle"),
    array("content" => lang("App.Paid"), "class" => "text-right	align-middle"),
    array("content" => "Balance", "class" => "text-right	align-middle"),
    //array("content" => lang("App.status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.type"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.expiration"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$bgrid->set_Buttons(
    array(
        $bootstrap->get_Link("btn-bill", array("size" => "sm", "icon" => ICON_PLUS, "text" => "Facturar", "title" => lang("App.New"), "data-bs-toggle" => "modal", "data-bs-target" => "#invoiceModal")),
        //$bootstrap->get_Link("btn-secondary", array("size" => "sm", "icon" => ICON_BACK, "title" => lang("App.Back"), "href" => $back)),
    )
);
$component = '/sie/orders';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row['order'])) {
        $count++;
        //echo(safe_dump($row));
        $payment = $mpayments->where("ticket", $row['ticket'])->first();
        $paid = !empty($payment['value']) ? $payment['value'] : 0;
        $total = !empty($row['total']) ? $row['total'] : 0;
        $balance = $total - $paid;
        $lockeds = ($balance == 0) ? "disabled opacity-25" : "";
        $ctext = ($balance == 0) ? "text-success" : "text-danger";
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/print/{$row["order"]}";
        $hrefEdit = "$component/edit/{$row["order"]}";
        $hrefDelete = "$component/delete/{$row["order"]}";
        $hrefCredit = "/sie/orders/credit/{$row['order']}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-primary ml-1", "target" => "_blank"));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-secondary ml-1",));
        $btnCredit = $bootstrap::get_Link('btn-credit', array("size" => "sm", 'icon' => ICON_CREDIT, 'title' => lang("App.Credit"), 'href' => $hrefCredit, 'class' => "btn-warning {$lockeds}"));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-danger ml-1 {$lockeds}",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnCredit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------


        $payment_payment = @$payment['payment'];
        if ($balance == 0) {
            $apaid = array("content" => "<a href=\"/sie/payments/view/{$payment_payment}\" target=\"_blank\">$ " . number_format($paid, 2, ',', '.') . "</a>", "class" => "text-end align-middle {$ctext}");
        } else {
            $apaid = array("content" => "$ " . number_format($paid, 2, ',', '.'), "class" => "text-end align-middle {$ctext}");
        }
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['order'], "class" => "text-center align-middle"),
                //array("user" => $row['user'], "class" => "text-left align-middle"),
                array("content" => $row['ticket'], "class" => "text-center align-middle"),
                //array("parent" => $row['parent'], "class" => "text-left align-middle"),
                array("content" => $row['period'], "class" => "text-center align-middle"),
                array("content" => @$row['description'], "class" => "text-start align-middle"),
                array("content" => "$ " . number_format($row['total'], 2, ',', '.'), "class" => "text-end align-middle"),
                $apaid,
                array("content" => "$ " . number_format($balance, 2, ',', '.'), "class" => "text-end align-middle {$ctext}"),
                //array("status" => $row['status'], "class" => "text-left align-middle"),
                //array("author" => $row['author'], "class" => "text-left align-middle"),
                //array("type" => $row['type'], "class" => "text-left align-middle"),
                //array("date" => $row['date'], "class" => "text-left align-middle"),
                //array("time" => $row['time'], "class" => "text-left align-middle"),
                //array("expiration" => $row['expiration'], "class" => "text-left align-middle"),
                //array("created_at" => $row['created_at'], "class" => "text-left align-middle"),
                //array("updated_at" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("deleted_at" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
echo($bgrid);
?>
<!-- Modal de Factura -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Gestionar Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="invoiceForm">
                    <!-- Información de la factura -->
                    <div class="row">
                        <div class="col-3 mb-3">
                            <label for="order" class="form-label">Código de Factura</label>
                            <input type="text" class="form-control" id="order" value="<?php echo(pk()); ?>"
                                   required readonly>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="date" class="form-label">Fecha Expiración</label>
                            <input type="date" class="form-control" id="date"
                                   value="2024-12-20" required>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="registration" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="registration" value="<?php echo($oid); ?>"
                                   required
                                   readonly>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="registration" class="form-label">Periodo</label>
                            <input type="text" class="form-control" id="period" value="2025A" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="order" class="form-label">Concepto (Descripción)</label>
                            <input type="text" class="form-control" id="description" value="Matricula Financiera 2025A"
                                   required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="order" class="form-label">Programa Académico</label>
                            <?php echo($bootstrap->get_Select("program", array(
                                "selected" => $registration['program'],
                                "data" => $mprograms->get_SelectData(),
                            ))); ?>
                        </div>
                    </div>
                    <!-- Items de la factura -->
                    <div id="itemsContainer">
                        <h6>Items de la Factura</h6>
                        <div class="item-row mb-3 d-flex align-items-center">
                            <select class="form-select me-2" onchange="updatePrice(this)" required>
                                <option value="">Seleccione un ítem</option>
                            </select>
                            <input type="number" class="form-control me-2" placeholder="Cantidad" min="1"
                                   oninput="calculateTotal()" required>
                            <input type="number" class="form-control me-2 item-price" placeholder="Precio Unitario"
                                   min="0" step="0.01">
                            <button type="button" class="btn btn-danger" onclick="removeItem(this)">Eliminar</button>
                        </div>
                    </div>
                    <button id="btn-add-item" type="button" class="btn btn-secondary my-2">Agregar Ítem</button>

                    <!-- Total -->
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveInvoice()">Guardar Factura</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Selecciona el modal por su ID
        const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));

        // Función para abrir el modal
        function showModal() {
            invoiceModal.show();
        }

        // Lista predefinida de ítems con código, descripción y precios
        const predefinedItems = [
            <?php $products = $mproducts->get_List(100, 0); ?>
            <?php foreach($products as $product){ ?>
            {
                code: "<?php echo($product['product']); ?>",
                description: "<?php echo($product['name']); ?>",
                price: <?php echo($product['value']); ?>},
            <?php } ?>
        ];

        // Función para obtener el precio por código
        function getPriceByCode(code) {
            const item = predefinedItems.find(item => item.code === code);
            return item ? item.price : 0;
        }

        // Función para calcular el total
        function calculateTotal() {
            const itemRows = document.querySelectorAll('.item-row');
            let total = 0;

            itemRows.forEach(row => {
                const quantity = parseFloat(row.querySelector('input[type="number"]').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                total += quantity * price;
            });

            document.getElementById('total').value = total.toLocaleString('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 2
            });
        }

        // Función para actualizar el precio unitario basado en el ítem seleccionado
        function updatePrice(selectElement) {
            const parentRow = selectElement.parentElement;
            const priceInput = parentRow.querySelector('.item-price');
            const quantityInput = parentRow.querySelector('input[type="number"]');
            const selectedCode = selectElement.value;
            const price = getPriceByCode(selectedCode);

            priceInput.value = price.toFixed(2);

            // Establecer cantidad en 1 cuando se selecciona un ítem
            if (selectedCode && !quantityInput.value) {
                quantityInput.value = 1;
            }

            calculateTotal();
        }

        // Inicializar el primer select con los ítems predefinidos
        function initializeFirstSelect() {
            const firstSelect = document.querySelector('#itemsContainer .item-row select');
            predefinedItems.forEach(item => {
                const option = document.createElement('option');
                option.value = item.code;
                option.textContent = `${item.code} - ${item.description}`;
                firstSelect.appendChild(option);
            });
        }

        // Función para agregar una nueva fila de ítem con menú desplegable
        function addItem() {
            const itemsContainer = document.getElementById('itemsContainer');
            const itemRow = document.createElement('div');
            itemRow.classList.add('item-row', 'mb-3', 'd-flex', 'align-items-center');

            // Crear el menú desplegable
            let selectHTML = `<select class="form-select me-2" onchange="updatePrice(this)" required>
                    <option value="">Seleccione un ítem</option>`;
            predefinedItems.forEach(item => {
                selectHTML += `<option value="${item.code}">${item.code} - ${item.description}</option>`;
            });
            selectHTML += `</select>`;

            // Rellenar la fila del ítem
            itemRow.innerHTML = `
            ${selectHTML}
            <input type="number" class="form-control me-2" placeholder="Cantidad" min="1" oninput="calculateTotal()" required>
            <input type="number" class="form-control me-2 item-price" placeholder="Precio Unitario" min="0" step="0.01" readonly>
            <button type="button" class="btn btn-danger" onclick="removeItem(this)">Eliminar</button>
        `;
            itemsContainer.appendChild(itemRow);
        }

        // Función para eliminar una fila de ítem
        function removeItem(button) {
            button.parentElement.remove();
            calculateTotal();
        }


        function saveInvoice() {
            const order = document.getElementById('order').value;
            const date = document.getElementById('date').value;
            const registration = document.getElementById('registration').value;
            const total = document.getElementById('total').value;
            const period = document.getElementById('period').value;
            const description = document.getElementById('description').value;
            const program = document.getElementById('program').value;

            // Recolectar los items
            const items = [];
            document.querySelectorAll('.item-row').forEach(row => {
                const selectedCode = row.querySelector('select').value;
                const quantity = row.querySelector('input[type="number"]').value;
                const price = row.querySelector('.item-price').value;

                if (selectedCode && quantity) {
                    items.push({
                        code: selectedCode,
                        description: predefinedItems.find(item => item.code === selectedCode).description,
                        quantity: parseInt(quantity),
                        price: parseFloat(price),
                        subtotal: quantity * parseFloat(price)
                    });
                }
            });

            // Datos a enviar
            const data = {
                order,
                date,
                registration,
                description,
                program,
                total,
                period,
                items
            };

            // Enviar los datos vía XHR usando fetch
            fetch('/sie/api/orders/json/create/<?php echo($oid);?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    //alert('Factura guardada exitosamente');
                    //alert(data.callback);//reload-bills
                    reloadBills();

                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al guardar la factura');
                });
        }

        function reloadBills() {
            const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
            const tabcontainer = document.getElementById("finance");
            const gridurl = "/sie/api/orders/json/grid/<?php echo($oid);?>";
            invoiceModal.hide();

            // Eliminar manualmente el backdrop del DOM
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }

            fetch(gridurl)
                .then(response => response.text())
                .then(data => {
                    tabcontainer.innerHTML = data;
                    // Re-ejecutar los scripts necesarios
                    initializeFirstSelect();
                    document.getElementById('btn-bill').addEventListener('click', showModal);
                    document.getElementById('btn-add-item').addEventListener('click', addItem);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al recargar las facturas');
                });
        }



        // Función para guardar la factura
        function saveInvoiceOLD() {
            const order = document.getElementById('order').value;
            const date = document.getElementById('date').value;
            const registration = document.getElementById('registration').value;
            const total = document.getElementById('total').value;

            // Recolectar los items
            const items = [];
            document.querySelectorAll('.item-row').forEach(row => {
                const selectedCode = row.querySelector('select').value;
                const quantity = row.querySelector('input[type="number"]').value;
                const price = row.querySelector('.item-price').value;

                if (selectedCode && quantity) {
                    items.push({
                        code: selectedCode,
                        description: predefinedItems.find(item => item.code === selectedCode).description,
                        quantity: parseInt(quantity),
                        price: parseFloat(price),
                        subtotal: quantity * parseFloat(price)
                    });
                }
            });

            // Aquí puedes agregar la lógica para enviar la factura
            console.log({
                order,
                date,
                registration,
                total,
                items
            });

            alert(`Factura guardada\nNúmero: ${order}\nFecha: ${date}\nCliente: ${registration}\nTotal: ${total}`);
        }

        // Inicializar el primer select al cargar la página
        initializeFirstSelect();

        // Hacer las funciones globalmente accesibles
        window.updatePrice = updatePrice;
        window.removeItem = removeItem;
        window.saveInvoice = saveInvoice;
        window.calculateTotal = calculateTotal;

        // Eventos
        document.getElementById('btn-bill').addEventListener('click', showModal);
        document.getElementById('btn-add-item').addEventListener('click', addItem);
    });
</script>
