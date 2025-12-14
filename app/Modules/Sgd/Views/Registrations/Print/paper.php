<style>
    body {
        background-color: #f8f9fa;
    }

    .page-container {
        width: 300px; /* Más compacto */
        height: 389px; /* Mantiene proporción carta (1:1.294) */
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        border: 1px solid #ddd;
        margin: 0 auto;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr); /* 6 columnas */
        grid-template-rows: repeat(6, 1fr); /* 6 filas */
        gap: 0;
        height: 100%;
        width: 100%;
        border: 1px solid #dee2e6;
    }

    .grid-item {
        border: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        height: 100%;
        user-select: none;
    }

    .grid-item:hover {
        background-color: #e9ecef;
        color: #495057;
    }

    .selected {
        background-color: #cfe2ff !important;
        color: #0d6efd !important;
        border-color: #9ec5fe !important;
    }

    .controls-section {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .controls-section .card {
        border: 1px solid rgba(0, 0, 0, .125);
        box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
    }

    .preview-title {
        color: #495057;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    @media print {
        body {
            background-color: white;
        }

        .card {
            border: none;
            box-shadow: none;
        }

        .controls-section {
            display: none;
        }
    }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Selección de Posición para Sticker</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Columna de la hoja -->
            <div class="col-md-7 d-flex justify-content-center">
                <div class="page-container">
                    <div class="grid-container">
                        <?php for ($i = 1; $i <= 36; $i++): ?>
                            <div class="grid-item" data-position="<?php echo $i; ?>"><?php echo $i; ?></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <!-- Columna de controles -->
            <div class="col-md-5">
                <div class="controls-section">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3 text-muted">Posición Seleccionada</h6>
                            <div class="mb-3">
                                <input type="number" class="form-control" id="positionInput" readonly>
                            </div>
                            <button class="btn btn-primary w-100" onclick="transferirPosicion()">
                                Imprimir Sticker
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3 text-muted">Instrucciones</h6>
                            <ol class="small mb-0">
                                <li>Seleccione una posición en la cuadrícula</li>
                                <li>El número de posición aparecerá en el campo arriba</li>
                                <li>Presione "Imprimir Sticker" para continuar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let selectedPosition = null;
    const gridItems = document.querySelectorAll('.grid-item');
    const positionInput = document.getElementById('positionInput');

    gridItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remover selección previa
            gridItems.forEach(i => i.classList.remove('selected'));
            // Seleccionar nuevo elemento
            item.classList.add('selected');
            selectedPosition = item.dataset.position;
            positionInput.value = selectedPosition;
        });
    });

    function transferirPosicion() {
        if (selectedPosition) {
            // Obtener la URL actual
            let currentUrl = window.location.href;
            // Remover cualquier parámetro position existente
            currentUrl = currentUrl.replace(/[?&]position=\d+/, '');
            // Añadir el nuevo parámetro position
            const separator = currentUrl.includes('?') ? '&' : '?';
            window.location.href = currentUrl + separator + 'position=' + selectedPosition;
        } else {
            alert('Por favor, seleccione una posición primero');
        }
    }
</script>
