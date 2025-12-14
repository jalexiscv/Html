<?php
generate_wallet_permissions();

$b = service('Bootstrap');
$main = $b->get_card("card_" . uniqid(), array(
    "title" => "Módulo Wallet (Billetera)",
    "image" => "/themes/assets/images/slide/wallet.png",
    "content" => "<p>Nuestro módulo de Wallet(Billetera) le permite aceptar fácilmente cualquier empresa / banco financiero físico o plataforma de pago en línea como métodos de depósito y retiro para su aplicación o plataforma. Incluso establecer una tarifa para ganar por cada transacción en línea vinculada a la API del Wallet.</p>"
        . "<p><b>¿Cómo funciona Wallet?: </b> El concepto central detrás de este modulo es que debe haber alguien que administre todo detrás de escena (el administrador). Para procesar las solicitudes de retiro, el administrador envía dinero a las cuentas bancarias manualmente fuera del script y reduce el saldo de la billetera del usuario haciendo clic en un botón después de que se completa la transacción de transferencia bancaria fuera de línea.</p>"
        . "<p>Hay 3 métodos de depósito integrados y automatizados API (PayPal, Stripe y Paystack). Los métodos de depósito registrados por el administrador (dinero móvil, dirección de Bitcoin Wallet, número de Bank Swift y otros medios para enviar y recibir dinero registrados por el administrador) siguen el concepto fuera de línea.</p>",
));

$right = "";

session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', $right);

?>