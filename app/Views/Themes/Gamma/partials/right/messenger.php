<div class="messenger col-12 h-100 position-relative">
    <div class="row m-0 p-0">
        <div id="messenger" class="col-12 h-100 position-relative">
            <ul id="messenger-users" class="nav nav-pills flex-column mb-auto m-0">
            </ul>
        </div>
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

    const onlineCollection = collection(db, 'online'); // obtén una referencia a la colección 'online'
    const q = query(onlineCollection, where("instance", "==", `${client}`));
    onSnapshot(q, snapshot => {
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
    });

    setInterval(async function () {
        const uid = 'user-${user}';
        const docRef = doc(db, 'online', uid);
        try {
            await setDoc(docRef, {
                instance: '${client}',
                user: '${user}',
                name: '${userfullname}',
                alias: '${alias}',
                avatar: '${avatar}',
                timestamp: Date.now()
            }, {merge: true});
            console.log('Document written with ID: ', docRef.id);


        } catch (e) {
            console.error('Error adding document: ', e);
        }
    }, (Math.floor(Math.random() * 51) + 10) * 1000);


    removeOldUsers();

    async function removeOldUsers() {
        const oneHourAgo = Date.now() - 3600000; // 3600000 milliseconds = 1 hour
        const querySnapshot = await getDocs(onlineCollection);
        querySnapshot.forEach(async (doc) => {
            console.log(doc.data().timestamp);
            if (doc.data().timestamp < oneHourAgo) {
                await deleteDoc(doc.ref);
            }
        });
    }

    //setInterval(removeOldUsers, 300000); // 300000 milliseconds = 5 minutes


    function renderUsers(data, id) {
        const ul = document.getElementById('messenger-users');
        const li = document.createElement('li');
        const onclick = "window.messenger.Show(this);";
        li.id = id;
        li.className = "nav-item user-item w-100 overflow-hidden border-bottom";
        let code = ("");
        code += ("        <div class=\"d-flex align-items-center position-relative mb-0\"  onclick=\"" + onclick + "\" data-user=\"" + data.user + "\" data-avatar=\"" + data.avatar + "\" data-name=\"" + data.name + "\">");
        code += ("            <div class=\"avatar avatar-2xl status-online\">");
        code += ("                <img class=\"rounded-circle border\" src=\"" + data.avatar + "\" alt=\"\">");
        code += ("            </div>");
        code += ("            <div class=\"mx-1\">");
        code += ("                <h6 class=\"mb-0 fw-semi-bold truncate\">");
        code += ("                    <a class=\"text-900 stretched-link\" href=\"#\">");
        code += ("                        " + data.name + "");
        code += ("                    </a>");
        code += ("                </h6>");
        code += ("                <p class=\"text-500 fs--2 mb-0\">");
        code += ("                      " + getTimeDifference(data));
        code += ("                </p>");
        code += ("            </div>");
        code += ("        </div>");
        li.innerHTML = code;
        ul.appendChild(li);
    }


    function getTimeDifference(data) {
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


    function removeUser(id) {
        let li = document.getElementById(id);
        if (li) {
            li.parentNode.removeChild(li);
        }

    }

    function modifyUser(data, id) {
        const ul = document.getElementById('messenger-users');
        const onclick = "window.messenger.Show(this);";

        let li = document.getElementById(id);
        if (!li) {
            li = document.createElement('li');
            li.id = id;
        }
        li.className = "nav-item user-item w-100 overflow-hidden border-bottom";
        let code = ("");
        code += ("        <div class=\"d-flex align-items-center position-relative mb-0\"  onclick=\"" + onclick + "\" data-user=\"" + data.user + "\" data-avatar=\"" + data.avatar + "\" data-name=\"" + data.name + "\">");
        code += ("            <div class=\"avatar avatar-2xl status-online\">");
        code += ("                <img class=\"rounded-circle border\" src=\"" + data.avatar + "\" alt=\"\">");
        code += ("            </div>");
        code += ("            <div class=\"mx-1\">");
        code += ("                <h6 class=\"mb-0 fw-semi-bold truncate\">");
        code += ("                    <a class=\"text-900 stretched-link\" href=\"#\">");
        code += ("                        " + data.name + "");
        code += ("                    </a>");
        code += ("                </h6>");
        code += ("                <p class=\"text-500 fs--2 mb-0\">");
        code += ("                      " + getTimeDifference(data));
        code += ("                </p>");
        code += ("            </div>");
        code += ("        </div>");
        li.innerHTML = code;
        ul.appendChild(li);
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