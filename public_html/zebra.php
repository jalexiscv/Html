<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carné Vertical</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #f4f4f4;
            padding: 20px;
        }

        canvas {
            border: 1px solid #333;
            margin: 20px 0;
        }

        input {
            margin: 5px;
            padding: 5px;
            width: 250px;
        }

        button {
            padding: 10px 20px;
            background: #0077cc;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
    </style>
</head>
<body>
<h2>Generador de Carnés Vertical</h2>

<div class="formulario">
    <input type="text" id="cedula" placeholder="Cédula"><br>
    <input type="text" id="nombre" placeholder="Nombre completo"><br>
    <input type="text" id="rh" placeholder="RH (Ej: O+)"><br>
    <input type="text" id="rol" placeholder="Rol (Ej: Estudiante)"><br>
    <input type="text" id="programa" placeholder="Programa académico"><br>
    <input type="text" id="web" placeholder="Sitio web"><br>
    <input type="file" id="foto"><br>
    <button onclick="generarCarnet()">Generar Carné</button>
    <button onclick="window.print()">Imprimir</button>
</div>

<!-- Carné vertical CR80: 637 x 1011 px -->
<canvas id="carnet" width="637" height="1011"></canvas>

<script>
    function generarCarnet() {
        const canvas = document.getElementById('carnet');
        const ctx = canvas.getContext('2d');

        // Fondo blanco
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Franja superior
        ctx.fillStyle = "#663399"; // púrpura
        ctx.fillRect(0, 0, canvas.width, 150);

        // Logo (texto provisional)
        ctx.fillStyle = "#fff";
        ctx.font = "bold 60px Arial";
        ctx.fillText("Utedé", 180, 100);

        // Foto (rectángulo temporal)
        ctx.fillStyle = "#ddd";
        ctx.fillRect(160, 170, 320, 380);

        // Si hay foto cargada
        const file = document.getElementById('foto').files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 160, 170, 320, 380);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Datos
        ctx.fillStyle = "#000";
        ctx.font = "28px Arial";
        ctx.fillText("CC: " + document.getElementById('cedula').value, 50, 600);

        ctx.font = "bold 34px Arial";
        ctx.fillText(document.getElementById('nombre').value, 50, 650);

        ctx.font = "28px Arial";
        ctx.fillText("RH: " + document.getElementById('rh').value, 50, 700);

        ctx.font = "bold 32px Arial";
        ctx.fillText(document.getElementById('rol').value, 50, 750);

        ctx.font = "26px Arial";
        ctx.fillText(document.getElementById('programa').value, 50, 800);

        // Franja inferior
        ctx.fillStyle = "#663399";
        ctx.fillRect(0, 930, canvas.width, 80);

        ctx.fillStyle = "#fff";
        ctx.font = "bold 28px Arial";
        ctx.fillText(document.getElementById('web').value, 120, 980);
    }
</script>
</body>
</html>