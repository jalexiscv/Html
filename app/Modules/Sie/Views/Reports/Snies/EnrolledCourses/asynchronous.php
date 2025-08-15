<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('grid-table');

        if (table) {
            const headerCells = table.querySelector('thead tr').querySelectorAll('th');
            const totalColumns = headerCells.length;
            const rows = table.querySelector('tbody').querySelectorAll('tr');

            // Filtrar solo las filas que necesitan procesamiento
            const rowsToProcess = Array.from(rows).filter(row =>
                row.getAttribute('data-status') === 'STARTED' &&
                row.querySelectorAll('td').length < totalColumns
            );

            // Crear indicador de progreso
            createProgressIndicator(rowsToProcess.length);

            // Procesar filas secuencialmente
            processRowsSequentially(rowsToProcess, totalColumns, 0);
        }

        // Crear indicador de progreso visual
        function createProgressIndicator(totalRows) {
            const progressContainer = document.createElement('div');
            progressContainer.id = 'progress-container';
            progressContainer.innerHTML = `
        <div style="
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 90%;
            max-width: 800px;
            margin: 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        ">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span><strong>Procesando datos de la tabla...</strong></span>
                <span id="progress-text">0 de ${totalRows} filas procesadas</span>
            </div>
            <div style="width: 100%; height: 20px; background: #e9ecef; border-radius: 10px; overflow: hidden;">
                <div id="progress-bar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #28a745, #20c997); transition: width 0.3s ease;"></div>
            </div>
            <div style="margin-top: 10px; font-size: 12px; color: #6c757d;">
                <span id="progress-status">Iniciando procesamiento...</span>
            </div>
        </div>
    `;

            // Añadir al body en lugar de insertar antes de la tabla
            document.body.appendChild(progressContainer);
        }

        // Actualizar indicador de progreso
        function updateProgress(current, total, status = '') {
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const progressStatus = document.getElementById('progress-status');

            if (progressBar && progressText && progressStatus) {
                const percentage = Math.round((current / total) * 100);
                progressBar.style.width = percentage + '%';
                progressText.textContent = `${current} de ${total} filas procesadas`;

                if (status) {
                    progressStatus.textContent = status;
                }

                // Cambiar color según el progreso
                if (percentage === 100) {
                    progressBar.style.background = 'linear-gradient(90deg, #28a745, #20c997)';
                    progressStatus.textContent = '¡Procesamiento completado exitosamente!';

                    // Ocultar el indicador después de 3 segundos
                    setTimeout(() => {
                        const container = document.getElementById('progress-container');
                        if (container) {
                            container.style.opacity = '0';
                            container.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => container.remove(), 500);
                        }
                    }, 3000);
                }
            }
        }

        // Función para procesar filas una por una
        function processRowsSequentially(rows, totalColumns, currentIndex) {
            if (currentIndex >= rows.length) {
                console.log('Todas las filas han sido procesadas');
                updateProgress(rows.length, rows.length, '¡Procesamiento completado!');
                return;
            }

            const row = rows[currentIndex];
            const currentCells = row.querySelectorAll('td');
            const currentColumnCount = currentCells.length;

            const rowData = {
                numero: currentCells[0]?.textContent.trim() || '',
                año: currentCells[1]?.textContent.trim() || '',
                semestre: currentCells[2]?.textContent.trim() || '',
                tipoDoc: currentCells[3]?.textContent.trim() || '',
                numDoc: currentCells[4]?.textContent.trim() || '',
                proConsecutivo: currentCells[5]?.textContent.trim() || '',
                idMunicipio: currentCells[6]?.textContent.trim() || '',
                dataRegistration: row.getAttribute('data-registration'),
                dataProgram: row.getAttribute('data-program'),
                dataPeriod: row.getAttribute('data-period'),
            };

            // Actualizar progreso y estado
            updateProgress(currentIndex, rows.length, `Procesando documento: ${rowData.numDoc}`);
            console.log(`Procesando fila ${currentIndex + 1} de ${rows.length} - Documento: ${rowData.numDoc}`);

            // Marcar la fila como "procesando" con estilo visual
            row.setAttribute('data-status', 'PROCESSING');
            row.style.backgroundColor = '#fff3cd';
            row.style.borderLeft = '4px solid #ffc107';

            // Obtener datos con reintentos
            getAdditionalRowDataWithRetry(rowData, function (additionalData, success) {
                if (success) {
                    // Completar la fila con los datos obtenidos
                    const missingColumns = totalColumns - currentColumnCount;
                    for (let i = 0; i < missingColumns; i++) {
                        const newCell = document.createElement('td');
                        newCell.className = 'text-start';
                        newCell.title = '';

                        const columnIndex = currentColumnCount + i;
                        const value = getColumnValue(columnIndex, additionalData);

                        // Usar innerHTML para matricula (índice 9) y textContent para el resto
                        //if (columnIndex === 9) {
                        newCell.innerHTML = value;
                        //} else {
                        //newCell.textContent = value;
                        //}

                        row.appendChild(newCell);
                    }

                    // Marcar como completada con estilo visual
                    row.setAttribute('data-status', 'COMPLETED');
                    row.style.backgroundColor = '#d4edda';
                    row.style.borderLeft = '4px solid #28a745';
                    console.log(`Fila ${currentIndex + 1} completada exitosamente`);
                } else {
                    // Marcar como error con estilo visual
                    row.setAttribute('data-status', 'ERROR');
                    row.style.backgroundColor = '#f8d7da';
                    row.style.borderLeft = '4px solid #dc3545';
                    console.error(`Error al procesar fila ${currentIndex + 1} - Documento: ${rowData.numDoc}`);
                }

                // Procesar siguiente fila después de un pequeño delay
                setTimeout(() => {
                    processRowsSequentially(rows, totalColumns, currentIndex + 1);
                }, 100);
            }, 3);
        }

// Función para obtener datos con sistema de reintentos
        function getAdditionalRowDataWithRetry(rowData, callback, maxRetries = 3, currentRetry = 1) {
            const xhr = new XMLHttpRequest();
            // Usar el atributo data-registration como parámetro
            const url = `/sie/api/reports/json/enrolledcourses/<?php echo(lpk());?>?registration=${encodeURIComponent(rowData.dataRegistration)}&program=${rowData.dataProgram}&period=${rowData.dataPeriod}`;

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            const additionalData = {
                                num_materias_inscritas: response.num_materias_inscritas || '0',
                                num_materias_aprobadas: response.num_materias_aprobadas || '0',
                                matricula: response.matricula || '0',
                                progresos: response.progresos || '0',
                            };
                            callback(additionalData, true);
                        } catch (e) {
                            console.error(`Error parsing JSON response (intento ${currentRetry}):`, e);
                            handleRetry();
                        }
                    } else {
                        console.error(`HTTP Error ${xhr.status} (intento ${currentRetry}):`, xhr.statusText);
                        handleRetry();
                    }
                }
            };

            xhr.onerror = function () {
                console.error(`Network error (intento ${currentRetry})`);
                handleRetry();
            };

            xhr.ontimeout = function () {
                console.error(`Request timeout (intento ${currentRetry})`);
                handleRetry();
            };

            xhr.timeout = 10000;

            function handleRetry() {
                if (currentRetry < maxRetries) {
                    console.log(`Reintentando... (${currentRetry + 1}/${maxRetries}) para documento: ${rowData.numDoc}`);
                    setTimeout(() => {
                        getAdditionalRowDataWithRetry(rowData, callback, maxRetries, currentRetry + 1);
                    }, 1000 * currentRetry);
                } else {
                    console.error(`Máximo de reintentos alcanzado para documento: ${rowData.numDoc}`);
                    callback(getDefaultData(), false);
                }
            }

            xhr.send();
        }


        function getDefaultData() {
            return {
                num_materias_inscritas: '0',
                num_materias_aprobadas: '0',
                matricula: '0',
                progresos: '0',
            };
        }

        function getColumnValue(columnIndex, data) {
            const columnMap = {
                7: data.num_materias_inscritas,
                8: data.num_materias_aprobadas,
                9: data.matricula,
                10: data.progresos
            };
            return columnMap[columnIndex] || '0';
        }
    });
</script>