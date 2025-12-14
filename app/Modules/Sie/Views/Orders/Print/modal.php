<?php
$expired = false;
$now = new DateTime(); // Fecha actual
// Asegúrate de que $order exista antes de usarlo
if (isset($order) && isset($order["expiration"])) {
    $expiration = new DateTime($order["expiration"]);
    // Si la fecha de expiración es menor o igual a la fecha actual
    if ($expiration <= $now) {
        $expired = true;
    }
}
?>
<?php if ($expired) { ?>
    <!-- Modal para factura expirada -->
    <div class="modal fade" id="expiredInvoiceModal" tabindex="-1" aria-labelledby="expiredInvoiceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="expiredInvoiceModalLabel"><i
                                class="bi bi-exclamation-triangle-fill me-2"></i>Aviso importante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="fs-5">Esta factura ya ha expirado...</p>
                </div>
                <div class="modal-footer align-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Abrir la modal automáticamente al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            const expiredInvoiceModal = new bootstrap.Modal(document.getElementById('expiredInvoiceModal'));
            expiredInvoiceModal.show();
        });
    </script>
<?php } ?>