<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con JSON</title>
    <!-- Enlace a Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Chat
                </div>
                <div class="card-body" id="chat">
                    <!-- Aquí se mostrarán los mensajes del chat -->
                </div>
                <div class="card-footer">
                    <form id="chatForm">
                        <input type="text" class="form-control" id="messageInput" placeholder="Escribe un mensaje...">
                        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatDiv = document.getElementById('chat');

    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const message = messageInput.value;
        if (message.trim() === '') {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'javier.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const messageElement = document.createElement('p');
                    messageElement.textContent = 'Tú: ' + message;
                    chatDiv.appendChild(messageElement);

                    const responseElement = document.createElement('p');
                    responseElement.innerHTML = 'Javier 1.0.1: ' + response.message;
                    chatDiv.appendChild(responseElement);

                    messageInput.value = '';
                } else {
                    console.error('Error al enviar el mensaje');
                }
            }
        };

        const requestData = JSON.stringify({message: message});
        xhr.send(requestData);
    });
</script>
</body>
</html>