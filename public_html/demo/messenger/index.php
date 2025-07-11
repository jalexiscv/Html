<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
    <script type="module">
        // Importa las funciones que necesitas de los SDKs que necesitas
        import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js";
        import {getAnalytics} from "https://www.gstatic.com/firebasejs/10.8.1/firebase-analytics.js";
        import {
            addDoc,
            getFirestore,
            doc,
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
        const onlineCollection = collection(db, 'online'); // obtén una referencia a la colección 'online'
        onSnapshot(onlineCollection, snapshot => {
            snapshot.docChanges().forEach(change => {
                // asume las funciones renderUsers y removeUser están definidas en alguna parte
                if (change.type === 'added') {
                    renderUsers(change.doc.data(), change.doc.id);
                }
                if (change.type === 'removed') {
                    removeUser(change.doc.id);
                }
                if (change.type === 'modified') {
                    modifyUser(change.doc.data(), change.doc.id);
                }
            });

            setInterval(async function () {
                const name = generateRandomName();
                try {
                    const docRef = await addDoc(onlineCollection, {
                        user: <?php echo($_SESSION['user']);?>,
                        name: <?php echo($_SESSION['user']);?>,
                        timestamp: Date.now()
                    });
                    console.log('Document written with ID: ', docRef.id);
                } catch (e) {
                    console.error('Error adding document: ', e);
                }
            }, 10000);
        });

        function renderUsers(data, id) {
            // renderiza el usuario en el DOM
            const usersDiv = document.getElementById('messenger-users');
            const userDiv = document.createElement('div');
            userDiv.id = id;
            userDiv.innerHTML = data.name;
            usersDiv.appendChild(userDiv);
        }

        function removeUser(id) {
            // elimina el usuario del DOM
            const userDiv = document.getElementById(id);
            userDiv.parentNode.removeChild(userDiv);
        }

        function modifyUser(data, id) {
            // modifica el usuario en el DOM
            const userDiv = document.getElementById(id);
            userDiv.innerHTML = data.name;
        }

        function generateRandomName() {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const charactersLength = characters.length;
            for (let i = 0; i < 5; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

    </script>
</head>
<body>
<div id="chat-container">
    <div id="messenger-users"></div>
</div>
</body>
</html>