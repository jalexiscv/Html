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
                                   value="<?php echo(date('Y-m-d')); ?>" required>
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