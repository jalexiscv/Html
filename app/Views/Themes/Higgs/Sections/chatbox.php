<div class="chat d-none" id="chat-box">
    <div class="contact bar">
        <div id="chatbox-avatar" class="pic receiver border-1"></div>
        <div id="chatbox-name" class="name">Nombre Completo</div>
        <div id="chatbox-seen" class="seen">Fecha/Hora</div>
        <button type="button" class="btn-close chatbox-close" onclick="window.messenger.Hide();"></button>
    </div>
    <div id="chatbox-messages" class="messages h-100">
        <div class="time">
            Actualizando...
        </div>
    </div>
    <div class="input">
        <i class="fas fa-camera"></i><i class="far fa-laugh-beam"></i>
        <input id="message-input" name="message-input" placeholder="Escriba su mensaje aquí!" type="text" on><i
                class="fas fa-microphone"></i>
    </div>
</div>
<script type="module">
    // Importa las funciones que necesitas de los SDKs que necesitas
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
    // Configuración de tu aplicación web de Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyBbJqeIWrmmaRGuzZkOC-RTRfXDXubXt2Q",
        authDomain: "higgs-messenger.firebaseapp.com",
        projectId: "higgs-messenger",
        storageBucket: "higgs-messenger.appspot.com",
        messagingSenderId: "928686305046",
        appId: "1:928686305046:web:099509aca6fa6a427a6a37",
        measurementId: "G-K3PW8NGFFL"
    };
    // Inicializa Firebase
    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app); // obtén una instancia de Firestore
    // Escucha cambios en la colección 'online'
    const onlineCollection = collection(db, 'messages'); // obtén una referencia a la colección 'online'

    document.addEventListener('DOMContentLoaded', function () {
        let input = document.getElementById('message-input');
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                let receiver = document.getElementById('chatbox-name').innerText;
                window.messenger.Send();
            }
        });
    });
</script>