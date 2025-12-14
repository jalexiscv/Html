<?php
/** @var int $page viene de grid.php */
/** @var model $mexecutions */
/** @var model $mprogress */
/** @var model $mstatuses */
/** @var model $mregistrations */
/** @var model $mprograms */
/** @var model $magreements */
/** @var model $minstitutions */
/** @var model $mcities */
/** @var model $mdiscounteds */
/** @var model $mfields */
/** @var string $program */
/** @var string $period */
/** @var string $status */
/** @var int $limit */
/** @var int $offset */
$dates = service('dates');

$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$menrollments = model('App\Modules\Sie\Models\Sie_Enrollments');
$mprogress = model('App\Modules\Sie\Models\Sie_Progress');
$mexecutions = model('App\Modules\Sie\Models\Sie_Executions');
$mdiscounteds = model('App\Modules\Sie\Models\Sie_Discounteds');
$mdiscounts = model('App\Modules\Sie\Models\Sie_Discounts');

//ENROLLED = Matriculado
//ENROLLED-OLD = Matriculado - Antiguo
//ENROLLED-EXT =Matriculado - Extensión

$references = ["ENROLLED", "ENROLLED-OLD"];

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
            ->where("period", $period)
            ->whereIn('reference', $references)
            ->where("program", $program)
            ->limit($limit, $offset)
            ->find();
} else {
    $statuses = $mstatuses
            ->where("period", $period)
            ->whereIn('reference', $references)
            ->limit($limit, $offset)
            ->find();
}

$totalRecords = count($statuses);


$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<thead>";
$code .= "<tr>\n";
$code .= "<th class='text-center ' title=\"\" >#</th>\n";
$code .= "<th class='text-center ' title=\"\" >ESTADO</th>\n";
$code .= "<th class='text-center ' title=\"\" >AÑO</th>\n";
$code .= "<th class='text-center ' title=\"\" >SEMESTRE</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_TIPO_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >NUM_DOCUMENTO</th>\n";
$code .= "<th class='text-center ' title=\"\" >PRO_CONSECUTIVO</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_MUNICIPIO</th>\n";
$code .= "<th class='text-center ' title=\"\" >ID_VALIDACION_REQUISITO</th>\n";
$code .= "<th class='text-center ' title=\"\" >CRED_ACAD_PROGRAMA_RC</th>\n";
$code .= "<th class='text-center ' title=\"\" >CREDIT_ACADEM_ACUMU_SEM_ANTE</th>\n";
$code .= "<th class='text-center ' title=\"\" >CREDIT_ACAD_A_MATRIC_REGU_SEM</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_BRUTO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_GOB_NAC_DESCUENTO_VOTAC</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_GOBERNAC_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ALCALDIA_PROGR_PERMANENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >DESCUENT_RECURRENTES_DE_LA_IES</th>\n";
$code .= "<th class='text-center ' title=\"\" >OTROS_APOYOS_A_LA_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_NETO_DERECHOS_MATRICULA</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ADICIONAL_GOBERNACIONES</th>\n";
$code .= "<th class='text-center ' title=\"\" >APOYO_ADICIONAL_ALCALDIAS</th>\n";
$code .= "<th class='text-center ' title=\"\" >DESCUENTOS_ADICIONALES_IES</th>\n";
$code .= "<th class='text-center ' title=\"\" >OTROS_APOYOS_ADICIONALES</th>\n";
$code .= "<th class='text-center ' title=\"\" >VAL_NETO_DER_MAT_A_CARGO_EST</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_BRUTO_DERECHOS_COMPLEMEN</th>\n";
$code .= "<th class='text-center ' title=\"\" >VALOR_NETO_DERECHOS_COMPLEMENT</th>\n";
$code .= "<th class='text-center ' title=\"\" >CAUSA_NO_ACCESO</th>\n";

$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";

$count = ($page - 1) * $limit;
foreach ($statuses as $status) {
    $count++;
    $registration = $mregistrations->getRegistration($status['registration']);
    $program = $mprograms->getProgram($status['program']);
    // Vars
    $period = @$status['period'];
    $year = safe_substr($period, 0, 4);
    $period_literal = safe_substr($period, 4, 1);
    $semester = (($period_literal == "A") ? "1" : "2");
    $identification_type = @$registration['identification_type'];
    $identification_number = @$registration['identification_number'];
    $program = $mprograms->getProgram($status['program']);
    $program_name = safe_strtoupper(@$program['name']);
    $program_snies = safe_strtoupper(@$program['snies']);
    $ethnic_group = !empty($registration['ethnic_group']) ? $registration['ethnic_group'] : "0";
    $disability = @$registration['disability'] == "Y" ? "1" : "0";
    $disability_type = @$registration['disability_type'] == "" ? "0" : (int)($registration['disability_type']);
    $ek = @$registration['ek'];
    // vars
    $RSTATUS = @$status["reference"];
    $ANNO = $year;
    $SEMESTRE = $semester;
    $ID_TIPO_DOCUMENTO = $identification_type;
    $NUM_DOCUMENTO = $identification_number;
    $PRO_CONSECUTIVO = $program_snies;
    $ID_MUNICIPIO = "76111";
    $ID_VALIDACION_REQUISITO = @$registration['snies_id_validation_requisite'];

    $link = "<a href=\"/sie/students/view/{$registration["registration"]}\" target=\"_blank\">{$NUM_DOCUMENTO}</a>";
    // build
    $code .= "<tr id=\"trid-" . @$registration["registration"] . "\" data-registration=\"" . @$status["status"] . "\" data-status=\"STARTED\">\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >$count</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$RSTATUS}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$ANNO}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$SEMESTRE}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$ID_TIPO_DOCUMENTO}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$link}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$PRO_CONSECUTIVO}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$ID_MUNICIPIO}</td>\n";
    $code .= "<td class='text-center text-nowrap' title=\"\" >{$ID_VALIDACION_REQUISITO}</td>\n";
    $code .= "</tr>\n";
}

$code .= "</tbody>";
$code .= "</table>";
echo($code);
?>
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
                idValidacion: currentCells[7]?.textContent.trim() || '',
                dataRegistration: row.getAttribute('data-registration')
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
                        newCell.className = 'text-center';
                        newCell.title = '';

                        const columnIndex = currentColumnCount + i;
                        newCell.textContent = getColumnValue(columnIndex, additionalData);

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
            const url = `/sie/api/reports/json/freeofcharge/<?php echo(lpk());?>?status=${encodeURIComponent(rowData.dataRegistration)}`;

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            const additionalData = {
                                credAcadPrograma: response.credAcadPrograma || '0',
                                creditAcademAcumu: response.creditAcademAcumu || '0',
                                creditAcadMatric: response.creditAcadMatric || '0',
                                valorBrutoMatricula: response.valorBrutoMatricula || '0',
                                apoyoGobNac: response.apoyoGobNac || '0',
                                apoyoGobernac: response.apoyoGobernac || '0',
                                apoyoAlcaldia: response.apoyoAlcaldia || '0',
                                descuentRecurrentes: response.descuentRecurrentes || '0',
                                otrosApoyos: response.otrosApoyos || '0',
                                valorNetoMatricula: response.valorNetoMatricula || '0',
                                apoyoAdicionalGob: response.apoyoAdicionalGob || '0',
                                apoyoAdicionalAlc: response.apoyoAdicionalAlc || '0',
                                descuentosAdicionales: response.descuentosAdicionales || '0',
                                otrosApoyosAdicionales: response.otrosApoyosAdicionales || '0',
                                valNetoCargoEst: response.valNetoCargoEst || '0',
                                valorBrutoComplemen: response.valorBrutoComplemen || '0',
                                valorNetoComplement: response.valorNetoComplement || '0',
                                causaNoAcceso: response.causaNoAcceso || '0'
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
                credAcadPrograma: '0',
                creditAcademAcumu: '0',
                creditAcadMatric: '0',
                valorBrutoMatricula: '0',
                apoyoGobNac: '0',
                apoyoGobernac: '0',
                apoyoAlcaldia: '0',
                descuentRecurrentes: '0',
                otrosApoyos: '0',
                valorNetoMatricula: '0',
                apoyoAdicionalGob: '0',
                apoyoAdicionalAlc: '0',
                descuentosAdicionales: '0',
                otrosApoyosAdicionales: '0',
                valNetoCargoEst: '0',
                valorBrutoComplemen: '0',
                valorNetoComplement: '0',
                causaNoAcceso: '0'
            };
        }

        function getColumnValue(columnIndex, data) {
            const columnMap = {
                8: data.credAcadPrograma,
                9: data.creditAcademAcumu,
                10: data.creditAcadMatric,
                11: data.valorBrutoMatricula,
                12: data.apoyoGobNac,
                13: data.apoyoGobernac,
                14: data.apoyoAlcaldia,
                15: data.descuentRecurrentes,
                16: data.otrosApoyos,
                17: data.valorNetoMatricula,
                18: data.apoyoAdicionalGob,
                19: data.apoyoAdicionalAlc,
                20: data.descuentosAdicionales,
                21: data.otrosApoyosAdicionales,
                22: data.valNetoCargoEst,
                23: data.valorBrutoComplemen,
                24: data.valorNetoComplement,
                25: data.causaNoAcceso
            };
            return columnMap[columnIndex] || '0';
        }
    });
</script>
