document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.querySelector('.chat-messages');
    const userInput = document.querySelector('#user-input');
    const fileInput = document.querySelector('#file-input');
    const filePreview = document.querySelector('#file-preview');
    let selectedFiles = [];

    // Configurar marked.js
    marked.setOptions({
        highlight: function(code, lang) {
            if (lang && hljs.getLanguage(lang)) {
                return hljs.highlight(code, { language: lang }).value;
            }
            return hljs.highlightAuto(code).value;
        },
        breaks: true,
        gfm: true,
        headerIds: false,
        mangle: false
    });

    // Función para mostrar el indicador de escritura
    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'message ai-message typing-indicator';
        indicator.textContent = 'Aurora está escribiendo';
        chatContainer.appendChild(indicator);
        indicator.scrollIntoView({ behavior: 'smooth', block: 'end' });
        return indicator;
    }

    // Función para extraer el texto de la respuesta
    function extractResponseText(response) {
        if (Array.isArray(response)) {
            return response.map(item => {
                if (typeof item === 'string') return item;
                if (item && item.type === 'text' && item.text) return item.text;
                return '';
            }).join('\n');
        }
        return response;
    }

    // Función para agregar un mensaje al chat
    function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
        
        // Crear el avatar
        const avatar = document.createElement('div');
        avatar.className = 'avatar';
        const icon = document.createElement('i');
        icon.className = isUser ? 'fas fa-user' : 'fas fa-robot';
        avatar.appendChild(icon);
        messageDiv.appendChild(avatar);

        // Contenedor del mensaje
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        
        if (isUser) {
            if (typeof content === 'string') {
                messageContent.textContent = content;
            } else {
                messageContent.appendChild(content);
            }
        } else {
            // Formatear y renderizar la respuesta Markdown
            const markdownDiv = document.createElement('div');
            markdownDiv.className = 'markdown-content';
            
            // Procesar la respuesta según su tipo
            let markdownContent = '';
            if (typeof content === 'string') {
                markdownContent = content;
            } else if (Array.isArray(content)) {
                markdownContent = extractResponseText(content);
            } else if (content && typeof content === 'object') {
                if (content.response) {
                    markdownContent = extractResponseText(content.response);
                } else if (content.text) {
                    markdownContent = content.text;
                } else {
                    markdownContent = JSON.stringify(content, null, 2);
                }
            } else {
                markdownContent = String(content);
            }
            
            // Renderizar Markdown
            markdownDiv.innerHTML = marked.parse(markdownContent);
            
            // Resaltar bloques de código
            markdownDiv.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
            
            messageContent.appendChild(markdownDiv);
        }
        
        messageDiv.appendChild(messageContent);
        chatContainer.appendChild(messageDiv);
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'end' });
    }

    // Función para manejar la vista previa de archivos
    function updateFilePreview() {
        filePreview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const previewContainer = document.createElement('div');
            previewContainer.className = 'file-preview-item';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'file-preview-image';
                previewContainer.appendChild(img);
            } else {
                const fileIcon = document.createElement('div');
                fileIcon.className = 'file-preview-icon';
                fileIcon.textContent = file.name;
                previewContainer.appendChild(fileIcon);
            }

            const removeButton = document.createElement('button');
            removeButton.className = 'btn btn-danger file-remove-button';
            removeButton.innerHTML = '×';
            removeButton.onclick = (e) => {
                e.preventDefault();
                selectedFiles = selectedFiles.filter((_, i) => i !== index);
                updateFilePreview();
            };

            previewContainer.appendChild(removeButton);
            filePreview.appendChild(previewContainer);
        });
    }

    // Función para enviar el mensaje
    async function sendMessage(message) {
        const formData = new FormData();
        formData.append('message', message);
        
        // Agregar archivos si existen
        selectedFiles.forEach((file, index) => {
            formData.append(`file${index}`, file);
        });

        // Mostrar indicador de escritura
        const typingIndicator = showTypingIndicator();

        try {
            const response = await fetch('api/chat.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            typingIndicator.remove();

            if (data.success && data.response) {
                addMessage(data.response, false);
            } else {
                throw new Error(data.error || 'Error en la respuesta');
            }
        } catch (error) {
            console.error('Error:', error);
            typingIndicator.remove();
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.textContent = `Error: ${error.message}`;
            addMessage(errorDiv);
        }

        // Limpiar archivos seleccionados después del envío
        selectedFiles = [];
        updateFilePreview();
    }

    // Event Listeners
    const form = document.getElementById('chat-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = userInput.value.trim();
        
        if (message || selectedFiles.length > 0) {
            const messageContent = document.createElement('div');
            
            if (message) {
                messageContent.textContent = message;
            }
            
            if (selectedFiles.length > 0) {
                const filesInfo = document.createElement('div');
                filesInfo.className = 'files-info';
                filesInfo.textContent = `Archivos adjuntos: ${selectedFiles.length}`;
                messageContent.appendChild(filesInfo);
            }
            
            addMessage(messageContent, true);
            userInput.value = '';
            await sendMessage(message);
        }
    });

    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        selectedFiles = selectedFiles.concat(files);
        updateFilePreview();
        fileInput.value = '';
    });
});
