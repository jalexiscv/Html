<html>
<head>
    <title>Pruebas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
$cifrado = hash('sha256', "HASH");
$iv = openssl_random_pseudo_bytes(16);
?>
<body>
<center>
    <div style="width:640px;">

        <h1>Cifrado y descifrado de mensajes</h1>
        <form action="" method="post">
            <label for="mensaje">Ingresa el mensaje:</label><br>
            <textarea id="mensaje" name="mensaje" style="width:100%;height:180px;">Este es un mensaje muy privado entre nosotros por lo tanto deberá ser totalmente cifrado y seguro entre ambas partes..Este es un mensaje muy privado entre nosotros por lo tanto deberá ser totalmente cifrado y seguro entre ambas partes..</textarea><br>
            <label for="clave">Hash:</label><br>
            <input type="text" id="clave" name="clave" style="width:100%;" value="<?php echo($cifrado); ?>"><br>
            <input type="submit" name="cifrar" value="Cifrar">
        </form>
        <?php
        if (isset($_POST['mensaje']) && isset($_POST['clave'])) {
            $mensaje = $_POST['mensaje'];
            $clave = $_POST['clave'];

            echo "<table border='1'>";
            echo "<tr><td align='center'><b>Mensaje cifrado</b></td></tr>";
            echo "<tr><td>";
            $mensaje_cifrado = openssl_encrypt($mensaje, 'aes-256-cbc', $clave, OPENSSL_RAW_DATA, $iv);
            echo $mensaje_cifrado;
            echo "</td></tr>";


            echo "<tr><td align='center'><b>Mensaje almacenable</b></td></tr>";
            echo "<tr><td align='center'>";

            $almacenable = urlencode($mensaje_cifrado);
            $almacenable = str_replace("%", "░ ", $almacenable);

            echo $almacenable;
            echo "</td></tr>";


            echo "<tr><td align='center'><b>Mensaje descifrado</b></td></b>";
            echo "<tr><td>";
            $mensaje_descifrado = openssl_decrypt($mensaje_cifrado, 'aes-256-cbc', $clave, OPENSSL_RAW_DATA, $iv);
            echo $mensaje_descifrado;
            echo "</td></tr>";

            echo "</table>";
        }
        ?>
    </div>
</center>
</body>
</html>
