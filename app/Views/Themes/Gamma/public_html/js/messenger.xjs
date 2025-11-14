/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js";
import {getAnalytics} from "https://www.gstatic.com/firebasejs/10.8.1/firebase-analytics.js";
import {
    doc,
    addDoc,
    getDocs,
    deleteDoc,
    getFirestore,
    setDoc,
    collection,
    onSnapshot,
    query,
    where
} from "https://www.gstatic.com/firebasejs/10.8.1/firebase-firestore.js";

export function Messenger() {
    function Exec(timestamp) {
        const sidebar = document.getElementById('sidebar-end');
        // alert('Messenger');

    }

    function Show(element) {
        //console.log(element);
        let user = element.getAttribute('data-user');
        let name = element.getAttribute('data-name');
        let avatar = element.getAttribute('data-avatar');
        let messenger = document.getElementById('messenger');
        let chatbox = document.getElementById('chat-box');
        let chatbox_name = document.getElementById('chatbox-name');
        let chatbox_seen = document.getElementById('chatbox-seen');
        let chatbox_avatar = document.getElementById('chatbox-avatar');
        let chatbox_messages = document.getElementById('chatbox-messages');
        chatbox.setAttribute('data-receiver', user);
        chatbox_name.innerHTML = name;
        chatbox_seen.innerHTML = TimeDifference({timestamp: Date.now()});
        chatbox_avatar.style.backgroundImage = "url(" + avatar + ")";
        chatbox.classList.remove('d-none');
        chatbox.style.right = messenger.offsetWidth + 'px';
        chatbox.style.bottom = "0px";
        chatbox_messages.innerHTML = '';
        //Draw('sender', 'Hey');
        //Draw('receiver', 'Hello');
        Messages();
    }

    function Messages() {
        console.log("Actualizando mensajes...");
        let sender = window.crypt.Decrypt(window.user);
        let receiver = document.getElementById('chat-box').getAttribute('data-receiver');
        if (window.db) {
            const q = query(
                collection(window.db, "messages"),
                where("sender", "in", [sender, receiver]),
                where("receiver", "in", [sender, receiver])
            );
            onSnapshot(q, (querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    let data = doc.data();
                    console.log(`"sender=" ${data.sender} "receiver=" ${data.receiver} "message=" ${data.message} "timestamp=" ${data.timestamp}`);
                    if (data.sender == sender) {
                        Draw('sender', data.message);
                    } else {
                        Draw('receiver', data.message);
                    }
                });
            });
        }
    }

    function TimeDifference(data) {
        let difference = Date.now() - data.timestamp;
        if (difference >= 86400000) {
            let daysAgo = Math.floor(difference / 86400000);
            return "Visto hace " + daysAgo + " días";
        } else if (difference >= 3600000) {
            let hoursAgo = Math.floor(difference / 3600000);
            return "Visto hace " + hoursAgo + " horas";
        } else if (difference >= 60000) {
            let minutesAgo = Math.floor(difference / 60000);
            return "Visto hace " + minutesAgo + " minutos";
        } else {
            let secondsAgo = Math.floor(difference / 1000);
            return "Visto hace " + secondsAgo + " segundos";
        }
    }

    function Draw(from, message) {
        let messages = document.getElementById('chatbox-messages');
        let code = '';
        //code += '<div class="time">' + chatbox_getTimeDifference(data) + '</div>';
        code += '<div class="message ' + from + '">';
        code += message;
        code += '</div>';
        messages.insertAdjacentHTML('beforeend', code);
        //scroll bottom
        messages.scrollTop = messages.scrollHeight;
    }

    function Hide() {
        let chatbox = document.getElementById('chat-box');
        chatbox.classList.add('d-none');
    }


    function Uniqid() {
        return Date.now().toString(36);
    }


    /**
     * Send message
     * Permite enviar un mensaje, el cual se dibuja en el chat y es trasferido al firebase para que sea leido por
     * el receptor.
     * @constructor
     */
    async function Send() {
        let input = document.getElementById('message-input');
        let text = input.value;
        Draw('sender', text);
        input.value = '';
        if (window.db) {
            const docRef = doc(window.db, 'messages', Uniqid());
            try {
                let chatbox = document.getElementById('chat-box');
                let user = window.crypt.Decrypt(window.user);
                let instance = window.crypt.Decrypt(window.instance);
                let receiver = chatbox.getAttribute('data-receiver');
                await setDoc(docRef, {
                    instance: instance,
                    sender: user,
                    receiver: receiver,
                    message: text,
                    timestamp: Date.now()
                }, {merge: true});
                console.log('Document written with ID: ', docRef.id);
            } catch (e) {
                console.error('Error adding document: ', e);
            }
        }
    }


    function Alert() {
        console.log('Messenger Alert');
    }

    return {
        Exec: Exec,
        Show: Show,
        Hide: Hide,
        Send: Send,
    };
}