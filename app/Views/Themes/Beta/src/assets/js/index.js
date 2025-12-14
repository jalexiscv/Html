/**
 * @file index.js
 * @description Punto de Entrada Principal (Entry Point) para la Aplicación del Lado del Cliente.
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright 2023 - CloudEngine S.A.S., Inc.
 *
 * @role Este archivo actúa como el orquestador central para toda la funcionalidad JavaScript
 * del tema. Es responsable de inicializar la aplicación, cargar todos los módulos
 * necesarios y poner en marcha sus respectivos procesos. Transforma la página HTML,
 * que inicialmente es estática, en una aplicación web interactiva y dinámica (SPA-like).
 *
 * @responsibilities
 *  - Importar todos los módulos JavaScript (UI, gráficos, comunicación en tiempo real, etc.).
 *  - Inicializar servicios de terceros, como Firebase, para la base de datos en tiempo real.
 *  - Instanciar y ejecutar los controladores principales para las diferentes partes de la UI
 *    (barras laterales, gráficos, etc.).
 *  - Exponer instancias clave al objeto global `window` para facilitar el debugging y la
 *    comunicación entre módulos.
 */

// --------------------------------------------------------------------------------
// Importación de Módulos
// --------------------------------------------------------------------------------
// Se cargan todos los componentes necesarios para la aplicación.

// Firebase: Para la comunicación y base de datos en tiempo real.
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-firestore.js";

// Módulos de la aplicación
import { HeatGraph } from "./heatgraphs.js?v=${version}";      // Renderiza gráficos de mapa de calor.
import { SidebarStart } from "./sidebarstart.js?v=${version}";  // Controla la barra lateral izquierda.
import { SidebarEnd } from "./sidebarend.js?v=${version}";      // Controla la barra lateral derecha.
import { Messenger } from "./messenger.js?v=${version}";        // Gestiona la mensajería en tiempo real.
import { Apexcharts } from "./apexcharts.js?v=${version}";       // Renderiza gráficos avanzados.
import { Crypt } from "./crypt.js?v=${version}";                // Utilidades de encriptación.
import { Ui } from "./ui.js?v=${version}";                     // Lógica general de la interfaz de usuario.
import { Excel } from "./excel.js?v=${version}";               // Funcionalidades para exportar a Excel.
import { Modals } from "./modals.js?v=${version}";              // Gestiona la interactividad de los modales.


/**
 * IIFE (Immediately Invoked Function Expression)
 * Esta función anónima se ejecuta inmediatamente después de ser definida.
 * Se utiliza para crear un scope privado para la aplicación, evitando contaminar
 * el scope global con variables y funciones.
 */
(function () {

    /**
     * @function load
     * @description Función principal que arranca (bootstraps) toda la aplicación del lado del cliente.
     * Se encarga de la inicialización de servicios y la ejecución de los módulos.
     */
    function load() {
        // --------------------------------------------------------------------------------
        // Inicialización de Firebase
        // --------------------------------------------------------------------------------
        // Se configura la conexión con el proyecto de Firebase para habilitar
        // funcionalidades en tiempo real como bases de datos y notificaciones.
        const firebaseConfig = {
            apiKey: "AIzaSyBbJqeIWrmmaRGuzZkOC-RTRfXDXubXt2Q",
            authDomain: "higgs-messenger.firebaseapp.com",
            projectId: "higgs-messenger",
            storageBucket: "higgs-messenger.appspot.com",
            messagingSenderId: "928686305046",
            appId: "1:928686305046:web:099509aca6fa6a427a6a37",
            measurementId: "G-K3PW8NGFFL"
        };
        
        // Se inicializa la app de Firebase y se obtiene una instancia de Firestore.
        // Se exponen en `window` para poder acceder a ellas desde la consola o otros scripts.
        window.app = initializeApp(firebaseConfig);
        window.db = getFirestore(window.app);
        
        // --------------------------------------------------------------------------------
        // Instanciación y Ejecución de Módulos
        // --------------------------------------------------------------------------------
        
        // Renderiza los gráficos de mapa de calor.
        const heatgraph = new HeatGraph();
        const elementsheatGraphs = document.querySelectorAll('[id^="heatGraph-"]');
        if (elementsheatGraphs.length > 0) {
            elementsheatGraphs.forEach(element => heatgraph.render(element.id));
        }

        // Inicializa y ejecuta la lógica para la barra lateral izquierda (start).
        const sidebarstart = new SidebarStart();
        sidebarstart.exec();

        // Inicializa y ejecuta la lógica para la barra lateral derecha (end).
        const sidebarend = new SidebarEnd();
        sidebarend.exec();

        // Inicializa el sistema de mensajería en tiempo real. Se expone en `window`.
        window.messenger = new Messenger();
        window.messenger.Exec(new Date().getTime());

        // Inicializa el módulo de criptografía. Se expone en `window`.
        window.crypt = new Crypt();
        window.crypt.Exec(new Date().getTime());
        
        // Inicializa el módulo de Excel. Se expone en `window`.
        window.excel = new Excel();
        window.excel.Exec(new Date().getTime());

        // Inicializa el controlador principal de la UI. Se expone en `window`.
        window.ui = new Ui();

        // Inicializa y renderiza los gráficos de ApexCharts.
        const apexcharts = new Apexcharts();
        apexcharts.exec(new Date().getTime());

        // Inicializa la lógica de los modales.
        const modals = new Modals();
        modals.exec();
    }

    // Se llama a la función `load` para iniciar la aplicación tan pronto como el script es ejecutado.
    load(); 
})();