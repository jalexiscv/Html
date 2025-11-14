<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Ya Abierta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        h1 {
            color: #e74c3c;
            margin: 0 0 20px 0;
        }

        p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="icon">⚠️</div>
    <h1>Página Ya Abierta</h1>
    <p>Esta página ya está abierta en otra ventana o pestaña del navegador.</p>
    <p>Por favor, cierra esta pestaña y continúa trabajando en la ventana original.</p>
    <button class="btn" onclick="window.close()">Cerrar Esta Pestaña</button>
    <br><br>
    <a href="<?= base_url() ?>" class="btn">Ir al Inicio</a>
</div>
</body>
</html>