<script>
    // ========================================
    // CONFIGURACIÓN DE ESTADOS
    // ========================================
    const statusConfig = {
        REGISTERED: {
            zones: {
                enrollments: false,  // Oculto - no pedir campos de aquí
                programs: true,      // Visible
                aditionals: false,   // Oculto - no pedir campos de aquí
                extra: false,        // Oculto - no pedir campos de aquí
                degree: false        // Oculto - no pedir campos de aquí
            },
            fieldsInZone: {
                // Dentro de zonePrograms (visible) ocultar algunos campos
                moment: false,
                grid: false,
                version: false,
                period: true
            },
            required: ['status_program']  // ✅ Solo campos de zonas visibles
        },
        ENROLLED: {
            zones: {
                enrollments: false,  // Oculto
                programs: true,      // Visible
                aditionals: true,    // Visible
                extra: true,         // Visible
                degree: false        // Oculto
            },
            fieldsInZone: {
                grid: true,
                version: true,
                period: true
            },
            required: ['status_program', 'status_grid', 'status_version', 'status_period', 'status_moment', 'status_cycle', 'status_journey']
            // ✅ Todos de zonas visibles: programs, aditionals, extra
        },
        DESISTEMENT: {
            zones: {
                enrollments: false,  // Oculto
                programs: true,      // Visible
                aditionals: false,   // Oculto
                extra: false,        // Oculto
                degree: false        // Oculto
            },
            required: []  // ✅ No requiere nada
        },
        ABP: {
            zones: {
                enrollments: false,  // Oculto
                programs: true,      // Visible
                aditionals: true,    // Visible
                extra: false,        // Oculto
                degree: false        // Oculto
            },
            fieldsInZone: {
                period: true,
                moment: true,
                cycle: true,
                grid: false,
                version: false
            },
            required: ['status_period', 'status_moment', 'status_cycle']
            // ✅ Solo de zoneAditionals (visible)
        },
        GRADUATED: {
            zones: {
                enrollments: true,   // Visible
                programs: false,     // Oculto - NO pedir status_program
                aditionals: true,    // Visible
                extra: true,         // Visible
                degree: true         // Visible
            },
            fieldsInZone: {
                // Estos campos NO deben estar aquí porque zonePrograms está OCULTO
                // Se eliminan grid y version de aquí
            },
            required: ['status_enrollment', 'status_period', 'status_moment', 'status_cycle', 'status_journey', 'degree_certificate', 'degree_folio', 'degree_date']
            // ✅ Solo de zonas visibles: enrollments, aditionals, extra, degree
            // ❌ Eliminados: status_grid, status_version (están en zonePrograms que está oculto)
        }
    };

    // Alias de estados que comparten configuración
    const statusAliases = {
        'ENROLLED-OLD': 'ENROLLED',
        'ENROLLED-EXT': 'ENROLLED',
        'INACTIVE': 'DESISTEMENT',
        'ABP-RENEWAL': 'ABP',
        'ABP-REENTRY': 'ABP',
        'ABP-HOMOLOG': 'ABP',
        'UNADMITTED': 'ABP',
        'PROCESS': 'ABP'
    };

    // ========================================
    // CACHE DE ELEMENTOS DOM
    // ========================================
    const el = {
        // Zonas (contenedores visuales)
        zones: {
            programs: document.getElementById('zonePrograms'),
            enrollments: document.getElementById('zoneEnrollments'),
            aditionals: document.getElementById('zoneAditionals'),
            extra: document.getElementById('zoneExtra'),
            degree: document.getElementById('zoneDegree')
        },
        // Campos del formulario
        fields: {
            statusType: document.getElementById('status_type'),
            statusProgram: document.getElementById('status_program'),
            statusEnrollment: document.getElementById('status_enrollment'),
            statusPeriod: document.getElementById('status_period'),
            statusMoment: document.getElementById('status_moment'),
            statusCycle: document.getElementById('status_cycle'),
            statusGrid: document.getElementById('status_grid'),
            statusVersion: document.getElementById('status_version'),
            statusJourney: document.getElementById('status_journey'),
            statusObservation: document.getElementById('status_observation'),
            degreeCertificate: document.getElementById('degree_certificate'),
            degreeFolio: document.getElementById('degree_folio'),
            degreeDate: document.getElementById('degree_date'),
            degreeDiploma: document.getElementById('degree_diploma'),
            degreeBook: document.getElementById('degree_book'),
            degreeResolution: document.getElementById('degree_resolution')
        },
        // Elementos UI
        form: document.getElementById('statusForm'),
        submitButton: document.getElementById('submitButton')
    };

    // ========================================
    // FUNCIONES AUXILIARES
    // ========================================
    function hide(element) {
        if (element) element.classList.add('d-none');
    }

    function show(element) {
        if (element) element.classList.remove('d-none');
    }

    function toggle(element, visible) {
        visible ? show(element) : hide(element);
    }

    function hideAllZones() {
        Object.values(el.zones).forEach(hide);
    }

    function clearAllRequired() {
        Object.values(el.fields).forEach(field => {
            if (field) {
                field.required = false;
                removeRequiredIndicator(field);
            }
        });
    }

    // ========================================
    // INDICADORES VISUALES DE CAMPOS REQUERIDOS
    // ========================================
    function addRequiredIndicator(field) {
        if (!field) return;

        const label = field.previousElementSibling;
        if (!label || label.tagName !== 'LABEL') return;

        // Verificar si ya existe el indicador
        if (label.querySelector('.required-indicator')) return;

        // Crear y agregar el indicador
        const indicator = document.createElement('span');
        indicator.className = 'required-indicator';
        indicator.innerHTML = ' <span class="indicator-icon" style="color: #dc3545; font-weight: bold;">*</span>';
        indicator.title = 'Campo requerido';
        label.appendChild(indicator);

        // Agregar borde rojo al campo
        field.style.borderLeft = '3px solid #dc3545';

        // Agregar listener para detectar cuando se completa
        setupFieldCompletionListener(field);

        // Verificar estado inicial
        updateFieldIndicator(field);
    }

    function removeRequiredIndicator(field) {
        if (!field) return;

        const label = field.previousElementSibling;
        if (!label || label.tagName !== 'LABEL') return;

        // Remover el indicador
        const indicator = label.querySelector('.required-indicator');
        if (indicator) {
            indicator.remove();
        }

        // Quitar el borde
        field.style.borderLeft = '';
    }

    function setupFieldCompletionListener(field) {
        if (!field) return;

        // Usar el evento apropiado según el tipo de campo
        const eventType = field.tagName === 'SELECT' ? 'change' : 'input';

        field.addEventListener(eventType, function() {
            updateFieldIndicator(field);
            validateForm(); // ✅ Validar el formulario cada vez que cambia un campo
        });
    }

    function updateFieldIndicator(field) {
        if (!field || !field.required) return;

        const label = field.previousElementSibling;
        if (!label || label.tagName !== 'LABEL') return;

        const indicator = label.querySelector('.indicator-icon');
        if (!indicator) return;

        const isCompleted = field.value.trim() !== '';

        if (isCompleted) {
            // Campo completado - cambiar a verde con checkmark
            indicator.style.color = '#28a745';
            indicator.innerHTML = '✓';
            indicator.title = 'Campo completado';
            field.style.borderLeft = '3px solid #28a745';
        } else {
            // Campo vacío - mantener rojo con asterisco
            indicator.style.color = '#dc3545';
            indicator.innerHTML = '*';
            indicator.title = 'Campo requerido';
            field.style.borderLeft = '3px solid #dc3545';
        }
    }

    function updateAllFieldIndicators() {
        Object.values(el.fields).forEach(field => {
            if (field && field.required) {
                updateFieldIndicator(field);
            }
        });
    }

    // ========================================
    // APLICAR CONFIGURACIÓN DE ESTADO
    // ========================================
    function applyStatusConfig(statusType) {
        const configKey = statusAliases[statusType] || statusType;
        const config = statusConfig[configKey];

        // Limpiar todo primero
        hideAllZones();
        clearAllRequired();

        if (!config) {
            // Configuración por defecto si no existe el estado
            show(el.zones.programs);
            show(el.zones.aditionals);
            if (el.fields.statusGrid?.parentElement) show(el.fields.statusGrid.parentElement);
            if (el.fields.statusVersion?.parentElement) show(el.fields.statusVersion.parentElement);
            validateForm();
            return;
        }

        // 1. Mostrar/ocultar ZONAS completas
        Object.entries(config.zones).forEach(([zoneName, visible]) => {
            toggle(el.zones[zoneName], visible);
        });

        // 2. Control específico de CAMPOS INDIVIDUALES dentro de zonas visibles
        // (Para casos donde la zona está visible pero algunos campos dentro deben ocultarse)
        if (config.fieldsInZone) {
            const fieldMap = {
                moment: el.fields.statusMoment,
                grid: el.fields.statusGrid,
                version: el.fields.statusVersion,
                period: el.fields.statusPeriod,
                cycle: el.fields.statusCycle
            };

            Object.entries(config.fieldsInZone).forEach(([fieldKey, visible]) => {
                const field = fieldMap[fieldKey];
                if (field?.parentElement) {
                    toggle(field.parentElement, visible);
                }
            });
        }

        // 3. Marcar campos como requeridos
        if (config.required) {
            config.required.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.required = true;
                    addRequiredIndicator(field);
                }
            });
        }

        // Actualizar indicadores visuales
        updateAllFieldIndicators();
        validateForm();
    }

    // ========================================
    // VALIDACIÓN
    // ========================================
    function validateForm() {
        const requiredFields = el.form.querySelectorAll('[required]');
        const missingFields = [];
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.value.trim() === '') {
                isValid = false;
                const label = field.previousElementSibling?.textContent || field.id;
                missingFields.push(label.trim());
            }
        });

        el.submitButton.disabled = !isValid;

        if (!isValid) {
            console.log('Campos faltantes:', missingFields);
        } else {
            console.log('Todos los campos completos');
        }

        return isValid;
    }

    // ========================================
    // CARGA DINÁMICA DE SELECTS
    // ========================================
    function loadGrids(programId) {
        if (!programId) return;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/sie/api/grids/json/select/' + programId, true);
        xhr.responseType = 'json';
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = xhr.response.data;
                console.log(data);
                let html = '<option value="">Seleccione una (Actualizado)...</option>';
                data.forEach(item => {
                    html += `<option value="${item.value}">${item.label}</option>`;
                });
                el.fields.statusGrid.innerHTML = html;
            }
        };
        xhr.send();
    }

    function loadVersions(gridId) {
        if (!gridId || gridId.trim() === '') {
            console.log('No se consulta la version de la malla ya que no hay una malla seleccionada');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/sie/api/versions/json/all/' + gridId, true);
        xhr.responseType = 'json';
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = xhr.response.data;
                let html = '<option value="">Seleccione una versión...</option>';
                data.forEach(item => {
                    html += `<option value="${item.version}">${item.reference}</option>`;
                });
                el.fields.statusVersion.innerHTML = html;
            }
        };
        xhr.send();
    }

    // ========================================
    // ENVÍO DEL FORMULARIO
    // ========================================
    function submitForm() {
        const formData = {
            status_type: el.fields.statusType.value,
            status_program: el.fields.statusProgram.value,
            status_enrollment: el.fields.statusEnrollment.value,
            status_grid: el.fields.statusGrid.value,
            status_version: el.fields.statusVersion.value,
            status_period: el.fields.statusPeriod.value,
            status_moment: el.fields.statusMoment.value,
            status_cycle: el.fields.statusCycle.value,
            status_journey: el.fields.statusJourney.value,
            status_observation: el.fields.statusObservation.value,
            status_degree_certificate: el.fields.degreeCertificate.value,
            status_degree_folio: el.fields.degreeFolio.value,
            status_degree_date: el.fields.degreeDate.value,
            status_degree_diploma: el.fields.degreeDiploma.value,
            status_degree_book: el.fields.degreeBook.value,
            status_degree_resolution: el.fields.degreeResolution.value
        };

        hideStatusModal();
        showLoadingModal();

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/sie/api/registrations/json/status/<?php echo($oid);?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.send(JSON.stringify(formData));
    }

    // ========================================
    // GESTIÓN DE MODALES
    // ========================================
    function showLoadingModal() {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        const audio = document.getElementById('audio-wait-momment');
        if (audio) {
            audio.play();
            audio.addEventListener('ended', function() {
                hideLoadingModal();
                location.reload();
            }, { once: true });
        }
    }

    function hideLoadingModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
        if (modal) modal.hide();
    }

    function hideStatusModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
        if (modal) modal.hide();
    }

    // ========================================
    // INICIALIZACIÓN Y EVENT LISTENERS
    // ========================================
    hideAllZones();

    // Marcar status_type como requerido siempre
    el.fields.statusType.required = true;
    addRequiredIndicator(el.fields.statusType);

    // Marcar status_observation como requerido siempre
    el.fields.statusObservation.required = true;
    addRequiredIndicator(el.fields.statusObservation);

    // Deshabilitar botón al inicio
    el.submitButton.disabled = true;

    // Event listeners principales
    el.fields.statusType.addEventListener('change', (e) => applyStatusConfig(e.target.value));
    el.fields.statusProgram.addEventListener('change', (e) => loadGrids(e.target.value));
    el.fields.statusGrid.addEventListener('change', (e) => loadVersions(e.target.value));

    // Prevenir submit por defecto
    el.form.addEventListener('submit', (e) => e.preventDefault());
    el.submitButton.addEventListener('click', submitForm);

    // Validación inicial
    validateForm();
</script>