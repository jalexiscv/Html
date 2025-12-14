<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-08-04 06:57:51
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Intelligence\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
/** @var object $module */
generate_intelligence_permissions($module);
$chat_id = "chat-" . lpk();
$alias = safe_get_alias();
$bootstrap = service("bootstrap");
$server = service("server");
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Intelligence') / 102400), 6);
$card = $bootstrap->get_Card("card-view-Intelligence", array(
    "class" => "mb-3",
    "title" => lang("Intelligence.module") . "<span class='text-muted'>v{$version}</span>",
    "header-back" => "/",
    "image" => "/themes/assets/images/header/module-intelligence.png",
    "image-class" => "img-fluid p-3",
    "content" => lang("Intelligence.intro-1")
));
//echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("intelligence-access")) {
    $shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/#" . lpk(), "icon" => ICON_TOOLS, "value" => "Tool #1", "description" => "Herramienta")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/#" . lpk(), "icon" => ICON_TOOLS, "value" => "Tool #2", "description" => "Herramienta")));
    //echo($shortcuts);
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.1.0/github-markdown.min.css">


<div class="flex-grow-1 overflow-y-scroll d-flex flex-column" id="chat-container">
    <div class="d-flex flex-row h-100">
        <div class="d-flex flex-column align-items-center" id="ai-avatar-column">
            <img src="/themes/assets/images/messenger-user.jpg" alt="AI Avatar" class="messenger-avatar">
        </div>
        <div class="d-flex flex-column align-items-center w-100 mx-3 " id="column-main">
            <div class="flex-grow-1 overflow-y-auto mb-3 w-100 h-100" id="<?php echo($chat_id); ?>-chat-messages">
                <!-- Los mensajes se cargarán aquí -->
            </div>
            <div class="mt-auto w-100" id="chat-input">
                <form id="chat-form" class="d-flex">
                    <input type="text" id="<?php echo($chat_id); ?>-message-input" class="form-control"
                           placeholder="Escribe un mensaje...">
                    <button id="<?php echo($chat_id); ?>-send-button" type="submit" class="btn btn-primary ms-2"><i
                                class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center align-content-end" id="user-avatar-column">
            <img src="/themes/assets/images/messenger-user.jpg" alt="AI Avatar" class="messenger-avatar">
        </div>
    </div>
</div>


<style>
    #chat-container {
        height: 100%;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    #column-main {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }


    .messenger-avatar {
        border: 2px solid #D2DDE0;
        border-radius: 2px;
        background-color: #FAFBFD;
        max-height: 150px;
        padding: 10px;
    }


    .user-avatar-column {
        align-self: flex-end;
        height: 100% !important;
    }

    #<?php echo($chat_id);?>-chat-messages {
        min-height: 0;
        display: inline-grid;
        padding: 1rem;
        border: 2px solid #D2DDE0;
        border-radius: 2px;
        font-size: 0.9rem;
        line-height: 0.9rem;
    }

    .theme-dark #<?php echo($chat_id);?>-chat-messages {
        border: 2px solid #1a1e21 !important;
    }




    #chat-input {
        flex-shrink: 0; /* Evita que el área de entrada se encoja */
    }

    #<?php echo($chat_id);?>-chat-messages .message {
        margin-bottom: 10px;
        padding: 5px 10px;
        border-radius: 5px;
        border-color: #6c757d2e;
        border-width: 1px;
        border-style: solid;
    }

    .theme-dark #<?php echo($chat_id);?>-chat-messages .message {
        border-color: #1a1e21;
    }


    #<?php echo($chat_id);?>-chat-messages .user {
        background-color: #e6f2ff;
        align-self: flex-end;
        text-align: right;
        margin-right: 26px;
    }


    .theme-dark #<?php echo($chat_id);?>-chat-messages .user {
        background-color: #1a1e21;
    }

    #<?php echo($chat_id);?>-chat-messages .intelligence {
        background-color: #6c757d17;
        align-self: flex-start;
        margin-left: 26px;
    }


    #<?php echo($chat_id);?>-chat-messages .avatar {
        width: 2.5rem;
        height: 2.5rem;
        object-fit: cover;
        border-radius: 50%;
        border-color: #6c757d2e;
        border-width: 1px;
        border-style: solid;
        background-color: #edf0f5;
    }

    .message p {
        margin-bottom: 0.5rem;
    }

    #<?php echo($chat_id);?>-chat-messages .user .avatar {
        right: -32px;
    }

    #<?php echo($chat_id);?>-chat-messages .intelligence .avatar {
        left: -32px;
    }

</style>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to generate a unique ID
        function generateUniqueId() {
            return 'msg-' + Math.random().toString(36).substr(2, 9);
        }

        // Helper function to escape HTML characters
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function (m) {
                return map[m];
            });
        }

        // Modified appendMessage function
        function appendMessage(sender, message) {
            const messageElement = document.createElement('div');
            const messageId = generateUniqueId();
            messageElement.id = messageId;
            let url = "/themes/assets/images/avatar-ia.png";
            if (sender === 'user') {
                url = "<?php echo(safe_get_user_avatar());?>";
            }
            let avatar = '<img class="avatar" src="' + url + '" alt="higgs">';
            let html = '<span class="message-content" id="typed-' + messageId + '"></span>' + avatar;
            messageElement.classList.add('message', sender.toLowerCase());
            messageElement.innerHTML = html;
            chatMessages.appendChild(messageElement);

            // Apply typewriter effect
            const messageContentElement = document.getElementById('typed-' + messageId);
            if (sender === 'intelligence') {
                type_Writer(message, messageContentElement);
            } else {
                normal_Writer(message, messageContentElement);
                disable_send();
            }
        }

        /**
         * Escribe el mensaje de forma normal
         * @param message
         * @param element
         */
        function normal_Writer(message, element) {
            element.innerHTML = message;
            scrollToBottom();
            playSound();
        }

        /**
         * Escribe el mensaje con efecto de máquina de escribir
         * @param text
         * @param element
         */
        function type_Writer(text, element) {
            const escapedText = escapeHtml(text);
            new Typed(element, {
                strings: [text],
                typeSpeed: 0,
                backSpeed: 0,
                fadeOut: true,
                shuffle: true,
                showCursor: true, // Show cursor
                cursorChar: '|', // Cursor character
                onComplete: function () {
                    scrollToBottom();
                    playSound();
                    enable_send();
                }
            });
        }


        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('<?php echo($chat_id);?>-message-input');
        const chatMessages = document.getElementById('<?php echo($chat_id);?>-chat-messages');

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            const message = messageInput.value.trim();
            if (!message) return; // Do not send if the message is empty
            // Send the message to the API
            fetch('/intelligence/api/callbacks/json/request/<?php echo(lpk());?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({message: message})
            })
                .then(response => response.json())
                .then(data => {
                    // Add the user's message
                    appendMessage('user', message);
                    // Add the server's response
                    if (data.message) {
                        appendMessage('intelligence', data.message);
                    }

                    // Clear the input
                    messageInput.value = '';

                    // Scroll to the bottom of the chat
                    scrollToBottom();
                })
                .catch(error => {
                    console.error('Error:', error);
                    appendMessage('Sistema', 'Error al enviar el mensaje. Por favor, intenta de nuevo.');
                });
        });

        // Function to scroll to the bottom of chat messages
        function scrollToBottom() {
            const chatMessages = document.getElementById('<?php echo($chat_id);?>-chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }


        function playSound() {
            const audio = new Audio('/themes/assets/sounds/whatsapp-apple.mp3');
            audio.play();
        }

        function disable_send() {
            const sendButton = document.getElementById('<?php echo($chat_id);?>-send-button');
            const messageInput = document.getElementById('<?php echo($chat_id);?>-message-input');
            sendButton.disabled = true;
            messageInput.disabled = true;
        }

        function enable_send() {
            const sendButton = document.getElementById('<?php echo($chat_id);?>-send-button');
            const messageInput = document.getElementById('<?php echo($chat_id);?>-message-input');
            sendButton.disabled = false;
            messageInput.disabled = false;
        }


        //Observe changes in chat messages and scroll to bottom
        const observer = new MutationObserver(scrollToBottom);
        observer.observe(chatMessages, {childList: true, subtree: true});


    });
</script>