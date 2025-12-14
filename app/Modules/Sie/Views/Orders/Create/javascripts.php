<?php
/** @var TYPE_NAME $oid */
/** @var TYPE_NAME $registration */
?>
<script>
    const program_student = "<?php echo(@$registration['program']); ?>";
    const tableBody = document.querySelector('#items-table tbody');
    const predefinedItems = [
                <?php /** @var array $mproducts */
                $products = $mproducts->get_List(100, 0); ?>
                <?php foreach($products as $product){ ?>
                <?php
                $product_type = @$product['type'];
                // Se deben consultar todos los desceuntos a los cuales tiene derecho el estudiante
                $mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
                $mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");

                $discounteds = $mdiscounteds->where('object', $oid)->findAll();
                //print_r($discounteds);
                // Se crea un vector que contiene los descuentos aplicables con sus valores
                $discounts = [];
                foreach ($discounteds as $discounted) {
                    $discount = $mdiscounts->getDiscount($discounted['discount']);
                    $discounts[] = $discount;
                }

                //print_r($discounts);

                $discount = 0;
                foreach ($discounts as $rdiscount) {
                    if ($rdiscount['type'] == "ENROLLMENT" && $product_type == "ENROLLMENT") {
                        $discount += $rdiscount['value'];
                    } else if ($rdiscount['type'] == "REGISTRATION" && $product_type == "REGISTRATION") {
                        $discount += $rdiscount['value'];
                    } else if ($rdiscount['type'] == "INSURANCE" && $product_type == "INSURANCE") {
                        $discount += $rdiscount['value'];
                    } else if ($rdiscount['type'] == "CARD" && $product_type == "CARD") {
                        $discount += $rdiscount['value'];
                    } else if ($rdiscount['type'] == "CONTRIBUTION" && $product_type == "CONTRIBUTION") {
                        $discount += $rdiscount['value'];
                    } else if ($rdiscount['type'] == "FEES" && $product_type == "FEES") {
                        $discount += $rdiscount['value'];
                    }
                }

                ?>
            {
                code: "<?php echo(@$product['product']); ?>",
                program: "<?php echo(@$product['program']); ?>",
                description: "<?php echo(@$product['name']); ?>",
                type: "<?php echo(@$product['type']); ?>",
                price: <?php echo(@$product['value']); ?>,
                discount: <?php echo($discount); ?>},
                <?php } ?>
        ]
    ;

    addItem();

    function renderItem(product) {
        let id = "select-item-" + product + "-" + Math.floor(Math.random() * 1000);
        let selectHTML = `<select id="${id}" class="form-select item-type me-2" onchange="updatePrice(this)" required><option value="">Seleccione un ítem</option>`;
        predefinedItems.forEach(item => {
            selectHTML += `<option value="${item.code}" item-type="${item.type}" item-discount="${item.discount}" >${item.code} - ${item.description}</option>`;
        });
        selectHTML += `</select>`;
        const newRow = document.createElement('tr');
        newRow.id = "item-row-" + id;
        newRow.classList.add('item-row');
        newRow.innerHTML = `
        <td>${selectHTML}</td>
        <td><input type="number" class="form-control me-2 item-quantity" placeholder="Cantidad" min="1" oninput="calculateTotal()" required></td>
        <td><input type="number" class="form-control me-2 item-price text-end pr-1" placeholder="Precio Unitario" min="0" step="0.01" oninput="inputPrice(this)"></td>
        <td><input type="number" class="form-control me-2 item-discount text-end pr-1" placeholder="Descuento" min="0" max="100" step="0.01" oninput="inputDiscount(this)" ></td>
        <td><input type="number" class="form-control me-2 item-subtotal text-end pr-1" placeholder="Subtotal" min="0" step="0.01" style="background-color: #c7eaf4;" item-type="" readonly></td>
        <td><button type="button" class="btn btn-danger w-100" onclick="removeItem(this)"><i class="fa-regular fa-trash"></i></button></td>
        `;
        const totalRow = tableBody.querySelector('tr:last-child');
        tableBody.insertBefore(newRow, totalRow);
        // Set the selected item in the dropdown
        document.getElementById(id).value = product;
        document.getElementById(id).dispatchEvent(new Event('change'));

    }


    function addItemsEnrollment() {
        // Eliminar los items existentes sin importar su tipo y recalcular el valor total
        const itemRows = document.querySelectorAll('#items-table tbody tr.item-row');
        itemRows.forEach(row => {
            row.remove();
        });


        // Renderizar nuevos items

        // Se busque entre "predefinedItems" aquel producto cuyo atributo "program" sea igual a la constante "program"
        // del principio del formulario.
        let program = searchProgram(program_student);
        renderItem(program.code);// Matricula
        renderItem("6657A2F7AA325");//Aporte bienestar
        renderItem("6657A59065FE8");// Carnet
        renderItem("6657A5BE00AD6");// Derechos de registro y control
        renderItem("6657A60B770A5");// Seguro estudiantil
    }


    function searchProgram(programCode) {
        if (!programCode) {
            console.error("Debe proporcionar un código de programa para buscar");
            return null;
        }
        const itemEncontrado = predefinedItems.find(item => item.program === programCode);
        return itemEncontrado || null;
    }


    function addItem() {
        console.log(predefinedItems);

        let selectHTML = `<select class="form-select item-type me-2" onchange="updatePrice(this)" required><option value="">Seleccione un ítem</option>`;
        predefinedItems.forEach(item => {
            selectHTML += `<option value="${item.code}" item-type="${item.type}" item-discount="${item.discount}">${item.code} - ${item.description}</option>`;
        });
        selectHTML += `</select>`;
        const newRow = document.createElement('tr');
        newRow.classList.add('item-row');
        newRow.innerHTML = `
        <td>${selectHTML}</td>
        <td><input type="number" class="form-control me-2 item-quantity" placeholder="Cantidad" min="1" oninput="calculateTotal()" required></td>
        <td><input type="number" class="form-control me-2 item-price text-end pr-1" placeholder="Precio Unitario" min="0" step="0.01" oninput="inputPrice(this)"></td>
        <td><input type="number" class="form-control me-2 item-discount text-end pr-1" placeholder="Descuento" min="0" max="100" step="0.01" oninput="inputDiscount(this)" ></td>
        <td><input type="number" class="form-control me-2 item-subtotal text-end pr-1" placeholder="Subtotal" min="0" step="0.01" style="background-color: #c7eaf4;" item-type="" readonly></td>
        <td><button type="button" class="btn btn-danger w-100" onclick="removeItem(this)"><i class="fa-regular fa-trash"></i></button></td>
        `;
        const totalRow = tableBody.querySelector('tr:last-child');
        tableBody.insertBefore(newRow, totalRow);
    }

    function removeItem(button) {
        const row = button.closest('tr');
        row.remove();
        calculateTotal();
    }

    function inputPrice(element) {
        const row = element.closest('tr');
        const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
        const price = parseFloat(element.value) || 0;
        const discountInput = row.querySelector('.item-discount');
        const discountPercentage = parseFloat(discountInput.value) || 0;
        // Calculate subtotal with discount applied
        const discountAmount = (quantity * price * discountPercentage) / 100;
        const subtotal = (quantity * price) - discountAmount;
        // Update the subtotal field
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        // Recalculate totals
        calculateNeto();
        calculateBruto();
    }


    function inputDiscount(element) {
        const row = element.closest('tr');
        const quantity = parseFloat(row.querySelector('input[type="number"]').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        let discountPercentage = parseFloat(element.value) || 0;
        if (discountPercentage > 100) {
            discountPercentage = 100;
            element.value = 100; // Update the input field value
        }
        const discountAmount = (quantity * price * discountPercentage) / 100;
        const subtotal = (quantity * price) - discountAmount;
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        calculateNeto();
        calculateBruto();
    }


    function inputDiscountOLD(element) {
        const row = element.closest('tr');
        const quantity = parseFloat(row.querySelector('input[type="number"]').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const discountPercentage = parseFloat(element.value) || 0;
        const discountAmount = (quantity * price * discountPercentage) / 100;
        const subtotal = (quantity * price) - discountAmount;
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        calculateNeto();
        calculateBruto();
        // Screen
        //const screenValueElement = document.getElementById("screen-value");
        //if (screenValueElement) screenValueElement.innerHTML = subtotal.toFixed(2);
    }

    /**
     * Se ejecuta cuando se selecciona un tipo de item
     * @param selectElement
     */
    function updatePrice(selectElement) {
        // Get the parent row (tr) element
        const row = selectElement.closest('tr');
        // Find the price input within this specific row
        const priceInput = row.querySelector('.item-price');
        // Find the quantity input within this specific row
        const quantityInput = row.querySelector('input[type="number"]');
        const discountInput = row.querySelector('.item-discount');
        const selectedCode = selectElement.value;
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const subtotalInput = row.querySelector('.item-subtotal');

        let itemType = "";
        let itemDiscount = "";
        if (selectElement.value !== "") {
            itemType = selectedOption.getAttribute('item-type');
            itemDiscount = selectedOption.getAttribute('item-discount');
        }
        subtotalInput.setAttribute('item-type', itemType);
        subtotalInput.setAttribute('item-discount', itemDiscount);

        const price = getPriceByCode(selectedCode);
        priceInput.value = price.toFixed(2);
        priceInput.setAttribute('item-type', itemType);
        priceInput.setAttribute('item-discount', itemDiscount);

        // Establecer cantidad en 1 cuando se selecciona un ítem
        if (selectedCode && !quantityInput.value) {
            quantityInput.value = 1;
        }

        discountInput.value = itemDiscount;

        // If there's a discount value, calculate with discount
        if (discountInput && discountInput.value) {
            inputDiscount(discountInput);
        } else {
            calculateTotal();
        }
    }


    // Función para obtener el precio por código
    function getPriceByCode(code) {
        const predefinedItems = [
            <?php /** @var array $mproducts */
            $products = $mproducts->get_List(100, 0); ?>
            <?php foreach($products as $product){ ?>
            {
                code: "<?php echo($product['product']); ?>",
                description: "<?php echo($product['name']); ?>",
                price: <?php echo($product['value']); ?>},
            <?php } ?>
        ];

        const item = predefinedItems.find(item => item.code === code);
        return item ? item.price : 0;
    }


    function calculateTotal() {
        const allItemRows = document.querySelectorAll('#items-table tbody tr.item-row');
        Array.from(allItemRows).forEach(row => {
            if (row.querySelector('#total-neto')) {
                return;
            }
            const quantity = parseFloat(row.querySelector('input[type="number"]').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const discountInput = row.querySelector('.item-discount');
            const discountPercentage = discountInput ? (parseFloat(discountInput.value) || 0) : 0;
            const discountAmount = (quantity * price * discountPercentage) / 100;
            const subtotal = (quantity * price) - discountAmount;
            let total = subtotal.toFixed(2);
            row.querySelector('.item-subtotal').value = total;
        });
        calculateNeto();
        calculateBruto();
    }


    function calculateBruto() {
        const itemRows = document.querySelectorAll('#items-table tbody tr.item-row');
        let totalBruto = 0;

        itemRows.forEach(row => {
            const quantityInput = row.querySelector('input[type="number"]');
            const priceInput = row.querySelector('.item-price');

            if (quantityInput && priceInput) {
                const quantity = parseFloat(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;

                if (quantity > 0 && price > 0) {
                    const itemBruto = quantity * price;
                    totalBruto += itemBruto;
                }
            }
        });

        // Update the total bruto value in the form if it exists
        const totalBrutoInput = document.getElementById('total-bruto');
        if (totalBrutoInput) {
            totalBrutoInput.value = totalBruto.toFixed(2);
        }

        // Update the screen display
        const screenBrutoElement = document.getElementById("screen-bruto");
        if (screenBrutoElement) {
            screenBrutoElement.innerHTML = "$ " + totalBruto.toFixed(2);
        }

        return totalBruto;
    }


    /**
     * Calculate the net total from subtotals and display it
     */
    function calculateNeto() {
        const itemRows = document.querySelectorAll('#items-table tbody tr.item-row');
        let neto = 0;
        itemRows.forEach(row => {
            const subtotalElement = row.querySelector('.item-subtotal');
            if (subtotalElement) {  // Only process if the element exists
                const subtotal = parseFloat(subtotalElement.value) || 0;
                neto += subtotal;
            }
        });
        let discounts = calculateDiscounts();
        discounts = discounts.toFixed(2);
        neto = neto.toFixed(2);
        document.getElementById('total-neto').value = neto;
        const screenValueElement = document.getElementById("screen-value");
        if (screenValueElement) screenValueElement.innerHTML = "$ " + neto;
        return neto;
    }


    function calculateDiscounts() {
        const discountRows = document.querySelectorAll('#discounts-table tbody tr.discount-row');
        const totalBrutoElement = document.getElementById('total-neto');
        let totalDiscount = 0;
        let totalBruto = totalBrutoElement ? totalBrutoElement.value : 0;

        // Process item discounts from item rows
        const itemRows = document.querySelectorAll('#items-table tbody tr.item-row');
        itemRows.forEach(row => {
            const discountInput = row.querySelector('.item-discount');
            if (discountInput && parseFloat(discountInput.value) > 0) {
                const quantity = parseFloat(row.querySelector('input[type="number"]').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const discountPercentage = parseFloat(discountInput.value) || 0;
                const discountAmount = (quantity * price * discountPercentage) / 100;
                totalDiscount += discountAmount;
            }
        });
        // Process discounts from discount rows
        discountRows.forEach(row => {
            let discountValue = 0;
            let ediscount = row.querySelector('.item-discount-value');
            if (ediscount && parseFloat(ediscount.value) > 0) {
                let discount = parseFloat(ediscount.value) || 0;
                let character = ediscount.getAttribute('discount-character');
                let type = ediscount.getAttribute('discount-type');
                if (character == "PERCENTAGE") {
                    // Calculate total for applicable items
                    let enrollmentTotal = 0;
                    const itemSubtotals = document.querySelectorAll('#items-table tbody tr.item-row .item-subtotal');
                    itemSubtotals.forEach(subtotal => {
                        const itemType = subtotal.getAttribute('item-type');
                        if (itemType === "ENROLLMENT" || (itemType === "REGISTRATION" && type === "REGISTRATION")) {
                            enrollmentTotal += parseFloat(subtotal.value) || 0;
                        }
                    });
                    discountValue = (enrollmentTotal * discount) / 100;
                    const discountSubtotal = row.querySelector('.item-discount-subtotal');
                    if (discountSubtotal) {
                        discountSubtotal.value = discountValue.toFixed(2);
                    }
                } else {
                    discountValue = discount;
                    const discountSubtotal = row.querySelector('.item-discount-subtotal');
                    if (discountSubtotal) {
                        discountSubtotal.value = discountValue.toFixed(2);
                    }
                }
                totalDiscount += discountValue;
            }
        });
        // Update the screen discount display
        const screenDiscountElement = document.getElementById("screen-discount");
        if (screenDiscountElement) {
            screenDiscountElement.innerHTML = "$ " + totalDiscount.toFixed(2);
        }

        return totalDiscount;
    }


    function calculateDiscountsOLD() {
        const discountRows = document.querySelectorAll('#discounts-table tbody tr.discount-row');
        const totalBrutoElement = document.getElementById('total-neto');
        let totalDiscount = 0;
        let totalBruto = totalBrutoElement ? totalBrutoElement.value : 0;
        discountRows.forEach(row => {
            let discountValue = 0;
            let ediscount = row.querySelector('.item-discount-value');
            if (ediscount) {
                let discount = parseFloat(ediscount.value) || 0;
                let character = ediscount.getAttribute('discount-character');
                let type = ediscount.getAttribute('discount-type');
                if (character == "PERCENTAGE") {
                    // Calculate total for applicable items
                    let enrollmentTotal = 0;
                    const itemSubtotals = document.querySelectorAll('#items-table tbody tr.item-row .item-subtotal');
                    itemSubtotals.forEach(subtotal => {
                        const itemType = subtotal.getAttribute('item-type');
                        if (itemType === "ENROLLMENT" || (itemType === "REGISTRATION" && type === "REGISTRATION")) {
                            enrollmentTotal += parseFloat(subtotal.value) || 0;
                        }
                    });
                    discountValue = (enrollmentTotal * discount) / 100;
                    const discountSubtotal = row.querySelector('.item-discount-subtotal');
                    if (discountSubtotal) {
                        discountSubtotal.value = discountValue.toFixed(2);
                    }
                } else {
                    discountValue = discount;
                    const discountSubtotal = row.querySelector('.item-discount-subtotal');
                    if (discountSubtotal) {
                        discountSubtotal.value = discountValue.toFixed(2);
                    }
                }
                totalDiscount += discountValue;
                console.log("Descuento total: " + totalDiscount);
            }
        });

        //const screendiscount=document.getElementById("screen-discount");
        //if (screendiscount) screendiscount.innerHTML = totalDiscount;
        return totalDiscount;
    }


    function getInputElement(name) {
        <?php /** @var string $fid */?>
        const fid = "<?php echo($fid);?>";
        return document.getElementById(fid + "_" + name);
    }


    function saveInvoice() {
        const order = getInputElement('order').value;
        const user = getInputElement('user').value;
        const ticket = getInputElement('ticket').value;
        const parent = getInputElement('parent').value;
        const period = getInputElement('period').value;

        const cycle = getInputElement('cycle').value;
        const moment = getInputElement('moment').value;

        const date = getInputElement('date').value;
        const time = getInputElement('time').value;
        const expiration = getInputElement('expiration').value;
        const program = getInputElement('program').value;
        const description = getInputElement('description').value;
        const neto = document.getElementById("total-neto").value;
        // Lista predefinida de ítems con código, descripción y precios
        const predefinedItems = [
            <?php $products = $mproducts->get_List(100, 0); ?>
            <?php foreach($products as $product){ ?>
            {
                code: "<?php echo($product['product']); ?>",
                description: "<?php echo($product['name']); ?>",
                price: <?php echo($product['value']); ?>
            },
            <?php } ?>
        ];


        // Validación con modal en lugar de alert
        if (!cycle) {
            showWarningModal('Debe seleccionar un ciclo');
            return; // Detiene la ejecución
        }

        if (!moment) {
            showWarningModal('Debe seleccionar un momento');
            return; // Detiene la ejecución
        }


        if (!period) {
            showWarningModal('Debe proporsionar un periodo');
            return; // Detiene la ejecución
        }

        if (!description) {
            showWarningModal('Debe proporsionar una descripción');
            return; // Detiene la ejecución
        }


        // Recolectar los items
        // Array para almacenar los items
        const invoiceItems = [];
        const itemRows = document.querySelectorAll('.item-row');
        itemRows.forEach(row => {
            // Obtener los elementos de la fila
            const itemSelect = row.querySelector('.item-type');
            const quantityInput = row.querySelector('.item-quantity');
            const priceInput = row.querySelector('.item-price');
            const discountInput = row.querySelector('.item-discount');
            const subtotalInput = row.querySelector('.item-subtotal');
            if (itemSelect && itemSelect.value) {
                const itemId = itemSelect.value;
                const itemName = itemSelect.options[itemSelect.selectedIndex].text;
                const itemType = itemSelect.options[itemSelect.selectedIndex].getAttribute('item-type');
                const quantity = parseFloat(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const subtotal = parseFloat(subtotalInput.value) || 0;
                if (quantity > 0 && price > 0) {
                    invoiceItems.push({
                        product: itemId,
                        name: itemName,
                        type: itemType,
                        quantity: quantity,
                        price: price,
                        discount: discount,
                        subtotal: subtotal
                    });
                }
            }
        });
        // Datos a enviar
        const data = {
            order: order,
            user: user,
            ticket: ticket,
            parent: parent,
            period: period,
            cycle: cycle,
            moment: moment,
            date: date,
            time: time,
            expiration: expiration,
            program: program,
            description: description,
            neto: neto,
            items: invoiceItems,
        };
        console.log(data);
        showLoading();
        // Enviar los datos vía XHR usando fetch
        fetch('/sie/api/orders/json/create/<?php echo($oid);?>?t=' + Date.now(), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                backToClient();
                console.log('Success:', data);
                //alert('Factura guardada exitosamente');
                //alert(data.callback);//reload-bills
                //reloadBills();

            })
            .catch((error) => {
                hideLoading();
                backToClient();
                console.error('Error:', error);
                alert('Error al guardar la factura');
            });


    }

    function backToClient() {
        location = "/sie/students/view/<?php echo($oid);?>#finance";
    }


    function screen(value, discount) {
        alert("Screen");
        const svalue = document.getElementById("screen-value");
        const sdiscount = document.getElementById("screen-discount");
        svalue.innerHTML = value;
        sdiscount.innerHTML = discount;
    }


    function showLoading() {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        const audio = document.getElementById('audio-wait-momment');
        audio.play();
        audio.addEventListener('ended', function () {
            hideLoading();
            //location.reload();
        });
    }

    function hideLoading() {
        const loadingModal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
        if (loadingModal) {
            loadingModal.hide();
        }
    }


    function removeDiscount(button) {
        button.closest('tr').remove();
        calculateDiscounts();
    }

    function showWarningModal(message) {
        const warningMessage = document.getElementById('warningMessage');
        warningMessage.textContent = message;
        const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
        warningModal.show();
    }

</script>
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="warningModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="warningMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>