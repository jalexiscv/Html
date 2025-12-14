<?php
require_once(APPPATH . 'ThirdParty/Bacon/autoload.php');

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$registration=$oid;

// Configurar el generador de QR
$renderer = new ImageRenderer(
    new RendererStyle(300),
    new SvgImageBackEnd()
);
$writer = new Writer($renderer);

// Generar el código QR
$qrCode = $writer->writeString($registration);
?>

<div class="card mb-3">

    <div class="card-body text-center">
        <?php echo $qrCode; ?>
        <p class="card-text mt-3">ID de Registro: <?php echo htmlspecialchars($registration); ?></p>
    </div>
</div>