<?php
$msettings = model("App\Modules\Security\Models\Security_Settings");
$bootstrap = service("bootstrap");

$listGroup = $bootstrap->get_ListGroup(array());
$opcion1 = $bootstrap->get_ListGroupItem(array(
    "id" => "lgi-auto-register",
    "type" => "switch",
    "checked" => $msettings->get_Value("autoregister"),
    "href" => "#",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "Característica de autorregistro de usuario",
    "content" => "Permite a cualquiera gestionar su propio procedimiento de registro en la plataforma.",
    "timestamp" => "now",
));
$opcion2 = $bootstrap->get_ListGroupItem(array(
    "id" => "lgi-2fa",
    "type" => "switch",
    "checked" => $msettings->get_Value("2fa"),
    "href" => "#",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "Verificación en 2 pasos (2FA)",
    "content" => "Protege las cuentas de los usuarios contra accesos no autorizados al solicitar un código adicional cuando inician sesión.",
    "timestamp" => "now",
));
$listGroup->add_Item($opcion1);
$listGroup->add_Item($opcion2);
$card = $bootstrap->get_Card("card-tools", array(
    "title" => "" . lang("App.Settings"),
    "header-back" => "/security/home/" . lpk(),
    "content" => $listGroup,
));
echo($card);
?>
<script>
    var switch_autoregister = document.querySelector('#lgi-auto-register');
    switch_autoregister.addEventListener('change', function () {
        if (this.checked) {
            console.log('El switch está activado');
        } else {
            console.log('El switch está desactivado');
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/security/api/settings/json/update/<?php echo(lpk());?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                console.log('La solicitud se completó correctamente');
            }
        }
        var data = 'option=autoregister&value=' + this.checked;
        xhr.send(data);
    });

    var switch_2fa = document.querySelector('#lgi-2fa');
    switch_2fa.addEventListener('change', function () {
        if (this.checked) {
            console.log('El switch está activado');
        } else {
            console.log('El switch está desactivado');
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/security/api/settings/json/update/<?php echo(lpk());?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                console.log('La solicitud se completó correctamente');
            }
        }
        var data = 'option=2fa&value=' + this.checked;
        xhr.send(data);
    });
</script>