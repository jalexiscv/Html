/**
 * @file modals.js
 * @description Módulo para gestionar la interactividad de las ventanas modales.
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright 2023 - CloudEngine S.A.S., Inc.
 *
 * @class Modals
 * @description
 *   Esta clase encapsula toda la lógica relacionada con las ventanas modales de la
 *   aplicación, como la búsqueda de módulos, la actualización de caché, etc.
 *   No está diseñada para ser ejecutada de forma independiente, sino para ser
 *   importada y utilizada por el punto de entrada principal de la aplicación (`index.js`).
 *
 * @usage
 *   Este módulo se importa en `index.js` y se instancia para que su lógica
 *   se active. El método `exec()` es el punto de entrada que inicializa
 *   todos los listeners de eventos necesarios.
 *
 * @example
 *   // Dentro de index.js
 *
 *   // 1. Importar la clase desde este archivo.
 *   import { Modals } from "./modals.js";
 *
 *   // 2. Crear una instancia de la clase.
 *   const modals = new Modals();
 *
 *   // 3. Ejecutar el método principal para activar la funcionalidad.
 *   modals.exec();
 */
export class Modals {
    constructor() {
        this.searchInput = document.getElementById('higgs-input-module-search');
        this.moduleItems = document.querySelectorAll('.module-item');
        this.noResultsElement = document.getElementById('noResults');
        this.modalElement = document.getElementById('higgs-options-modules');
        this.refreshButton = document.getElementById('btn-modal-modules-refresh');
    }

    /**
     * @function filterModules
     * @description Filtra la lista de módulos basándose en el término de búsqueda.
     */
    filterModules() {
        if (!this.searchInput) return;
        const searchTerm = this.searchInput.value.toLowerCase().trim();
        let foundResults = false;

        this.moduleItems.forEach(item => {
            const moduleTitle = item.querySelector('.card-title').textContent.toLowerCase();
            const shouldBeVisible = moduleTitle.includes(searchTerm) || searchTerm === '';

            item.classList.toggle('hidden', !shouldBeVisible);
            if (shouldBeVisible) {
                const card = item.querySelector('.module-card');
                card.classList.add('search-result');
                setTimeout(() => card.classList.remove('search-result'), 500);
                foundResults = true;
            }
        });

        if (this.noResultsElement) {
            this.noResultsElement.classList.toggle('hidden', foundResults || searchTerm === '');
        }
    }

    /**
     * @function setupEventListeners
     * @description Configura todos los listeners de eventos para los modales.
     */
    setupEventListeners() {
        if (this.searchInput) {
            this.searchInput.addEventListener('input', () => this.filterModules());
        }

        if (this.modalElement) {
            this.modalElement.addEventListener('show.bs.modal', () => {
                if (this.searchInput) {
                    this.searchInput.value = '';
                }
                this.filterModules();
            });
        }

        if (this.refreshButton) {
            this.refreshButton.addEventListener('click', () => {
                fetch('/frontend/api/refresh/json/cache/clear', {method: 'POST'})
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            console.error('Error en la solicitud de refresco:', response.status);
                        }
                    })
                    .catch(error => {
                        console.error('Error en la conexión:', error);
                    });
            });
        }
    }

    /**
     * @function exec
     * @description Punto de entrada para ejecutar la lógica del módulo.
     */
    exec() {
        // Asegurarse de que el DOM está cargado antes de asignar eventos.
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupEventListeners());
        } else {
            this.setupEventListeners();
        }
    }
}