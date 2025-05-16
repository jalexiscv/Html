<?php
// Activar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(APPPATH . 'ThirdParty/FPDF/fpdf.php');
require_once(APPPATH . 'ThirdParty/FPDI/autoload.php');
//require_once(APPPATH . 'ThirdParty/Barcode/autoload.php');
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use setasign\Fpdi\Fpdi;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$server = service('server');

// Crear un nuevo documento PDF
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

// Titulo
//$pdf->SetFont('Helvetica', 'B', 16);
//$pdf->Cell(0, 10, 'Documento PDF Dinámico', 0, 1, 'C');
//$pdf->Ln(10);

// Añadir información de ejemplo
$pdf->SetFont('Helvetica', '', 12);
//$pdf->MultiCell(0, 10, 'Este es un documento PDF generado dinámicamente. Presione el botón para añadir el código QR.', 0, 'L');

// Si se solicita con QR, añadirlo
if (isset($_GET['withQR']) && $_GET['withQR'] == 1) {
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $qrSize = 50; // tamaño del QR en mm

    // Obtener posición de los parámetros o usar centro por defecto
    $posX = isset($_GET['posX']) ? floatval($_GET['posX']) : ($pageWidth - $qrSize) / 2;
    $posY = isset($_GET['posY']) ? floatval($_GET['posY']) : ($pageHeight - $qrSize) / 2;

    $server = $server->getURL();
    $url = $server . "/sgd/api/images/png/sticker/{$oid}?oid={$oid}"; // URL a codificar en el QR
    $imageData = file_get_contents($url);
    $tempFile = tempnam(sys_get_temp_dir(), 'img') . '.png'; // Agregar extensión .png
    file_put_contents($tempFile, $imageData);
    $pdf->Image($tempFile, $posX, $posY, $qrSize, $qrSize);
    unlink($tempFile);
}

// Enviar el PDF al navegador
//$pdf->Output('I', 'documento_generado.pdf');
$buffer = $pdf->Output('', 'S');
$pdf_base64 = base64_encode($buffer);

$iframe = '<iframe width="100%" height="100%" src="data:application/pdf;base64,' . $pdf_base64 . '"></iframe>';
?>

<style>


    .pdf-column {
        flex: 70%;
        height: 100%;
        padding: 0;
        border-right: 1px solid #dee2e6;
    }

    .controls-column {
        flex: 30%;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
    }

    .pdf-container {
        height: 600px;
        width: 100%;
        border: none;
    }

    .iframe-wrapper {
        height: 100%;
    }

    .qr-image {
        max-width: 390px;
        max-height: 390px;
        border: 1px solid #dee2e6;
        margin-bottom: 40px;
    }

    .btn-container {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 15px;
        width: 80%;
    }

    .app-title {
        margin-bottom: 30px;
        text-align: center;
    }

    .instructions {
        margin-top: 30px;
        font-size: 0.9rem;
    }
</style>
</head>
<body>
<div class="row">
    <div class="col-md-6 col-12">
        <div class="iframe-wrapper">
            <?php echo $iframe; ?>
        </div>
    </div>

    <div class="col-md-6 col-12 controls-column">
        <h2 class="app-title">Generador de Sticker</h2>

        <img src="/sgd/api/images/png/sticker/<?php echo($oid); ?>?oid=<?php echo($oid); ?>&time=<?php echo(time()); ?>"
             alt="Código QR" class="qr-image">

        <div class="position-controls mb-4">
            <h5>Posición del QR:</h5>
            <div class="row mb-3">
                <div class="col">
                    <label for="posX" class="form-label">Posición X (mm):</label>
                    <input type="range" class="form-range" id="posX" min="0" max="210" value="105">
                    <div class="d-flex justify-content-between">
                        <small>Izquierda</small>
                        <small id="posXValue">105</small>
                        <small>Derecha</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="posY" class="form-label">Posición Y (mm):</label>
                    <input type="range" class="form-range" id="posY" min="0" max="297" value="148">
                    <div class="d-flex justify-content-between">
                        <small>Arriba</small>
                        <small id="posYValue">148</small>
                        <small>Abajo</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-container">
            <button id="addQRBtn" class="btn btn-lg btn-success w-100">Añadir Sticker al PDF</button>
            <button id="refreshPDFBtn" class="btn btn-lg btn-primary w-100">Recargar PDF</button>
            <button id="viewOriginalBtn" class="btn btn-lg btn-outline-secondary w-100">Ver PDF Original</button>
        </div>

        <div class="instructions alert alert-info mt-4">
            <p><strong>Instrucciones:</strong></p>
            <ul>
                <li>El PDF se genera dinámicamente al cargar la página.</li>
                <li>Para insertar el código QR en el PDF, haga clic en "Añadir QR al PDF".</li>
                <li>Para volver al PDF original, haga clic en "Ver PDF Original".</li>
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts personalizados -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Referencias a elementos DOM
        const addQRBtn = document.getElementById('addQRBtn');
        const refreshPDFBtn = document.getElementById('refreshPDFBtn');
        const viewOriginalBtn = document.getElementById('viewOriginalBtn');
        const posX = document.getElementById('posX');
        const posY = document.getElementById('posY');
        const posXValue = document.getElementById('posXValue');
        const posYValue = document.getElementById('posYValue');

        // Recuperar valores guardados o usar predeterminados
        const savedPosX = localStorage.getItem('qrPosX') || 105;
        const savedPosY = localStorage.getItem('qrPosY') || 148;

        // Establecer valores iniciales desde localStorage
        posX.value = savedPosX;
        posY.value = savedPosY;
        posXValue.textContent = savedPosX;
        posYValue.textContent = savedPosY;

        // Actualizar valores mostrados y guardarlos cuando se mueven los controles deslizantes
        posX.addEventListener('input', function () {
            const value = this.value;
            posXValue.textContent = value;
            localStorage.setItem('qrPosX', value);
        });

        posY.addEventListener('input', function () {
            const value = this.value;
            posYValue.textContent = value;
            localStorage.setItem('qrPosY', value);
        });

        // Añadir QR al PDF con la posición seleccionada
        addQRBtn.addEventListener('click', function () {
            const x = posX.value;
            const y = posY.value;
            // Guardar posiciones antes de navegar
            localStorage.setItem('qrPosX', x);
            localStorage.setItem('qrPosY', y);
            window.location.href = `<?php echo("/sgd/registrations/print2/" . $oid);?>?withQR=1&posX=${x}&posY=${y}`;
        });

        // Recargar PDF
        refreshPDFBtn.addEventListener('click', function () {
            window.location.reload();
        });

        // Ver PDF original
        viewOriginalBtn.addEventListener('click', function () {
            window.location.href = '<?php echo("/sgd/registrations/print2/" . $oid);?>';
        });

        // Si hay parámetros en la URL, actualizar los controles
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('posX') && urlParams.has('posY')) {
            const urlPosX = urlParams.get('posX');
            const urlPosY = urlParams.get('posY');
            posX.value = urlPosX;
            posY.value = urlPosY;
            posXValue.textContent = urlPosX;
            posYValue.textContent = urlPosY;
            localStorage.setItem('qrPosX', urlPosX);
            localStorage.setItem('qrPosY', urlPosY);
        }
    });
</script>
