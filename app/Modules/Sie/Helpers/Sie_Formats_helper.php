<?php
/**
 * Componente de Gestor de Instrucciones
 * Genera un componente completo para gestionar variables con coordenadas, tamaño, tipo de letra y color en formato JSON
 *
 * @param string $fieldName Nombre del campo que se enviará en el formulario (default: 'instructions')
 * @param array $variables Array de variables disponibles (opcional)
 * @param array $initialData Datos iniciales en formato array (opcional)
 * @param array $fontTypes Array de tipos de fuente disponibles (opcional)
 * @return string HTML del componente completo
 */
function instructionManagerComponent($fieldName = 'instructions', $initialData = null, $variables = null, $fontTypes = null)
{
    // Variables por defecto si no se proporcionan
    if ($variables === null) {
        $variables = ['FULLNAME', 'IDTYPE', 'IDNUMBER', 'DATE', 'SERIAL'];
    }

    // Tipos de fuente por defecto
    if ($fontTypes === null) {
        $fontTypes = ['Arial', 'Verdana', 'Mono'];
    }

    // Generar un ID único para este componente
    $componentId = 'inst_manager_' . md5($fieldName . microtime());

    // Convertir datos iniciales a JSON si existen
    $initialJSON = $initialData ? json_encode($initialData) : '[]';

    ob_start();
    ?>

    <!-- Inicio del Componente: Instruction Manager -->
    <style>
        .instruction-manager-<?php echo $componentId; ?> {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .instruction-manager-<?php echo $componentId; ?> .add-instruction-form {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .instruction-manager-<?php echo $componentId; ?> .instructions-table {
            background-color: #ffffff;
        }

        .instruction-manager-<?php echo $componentId; ?> .color-preview {
            width: 30px;
            height: 30px;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            display: inline-block;
            vertical-align: middle;
        }

        .instruction-manager-<?php echo $componentId; ?> .json-output {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            max-height: 200px;
            overflow-y: auto;
            word-break: break-all;
        }

        .instruction-manager-<?php echo $componentId; ?> .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .instruction-manager-<?php echo $componentId; ?> .btn-sm-icon {
            padding: 0.25rem 0.5rem;
        }

        .instruction-manager-<?php echo $componentId; ?> .font-preview {
            padding: 0.25rem 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            display: inline-block;
        }

        .instruction-manager-<?php echo $componentId; ?> .form-control-color {
            max-width: 50px;
            padding: 0.25rem;
        }
    </style>

    <div class="instruction-manager-<?php echo $componentId; ?>">
        <!-- Formulario para agregar nueva instrucción -->
        <div class="add-instruction-form">
            <div class="row g-2 mb-2">
                <div class="col-md-2">
                    <label for="variableSelect_<?php echo $componentId; ?>"
                           class="form-label small mb-1">Variable:</label>
                    <select class="form-select form-select-sm" id="variableSelect_<?php echo $componentId; ?>">
                        <option value="">Seleccione una variable</option>
                        <?php foreach ($variables as $variable): ?>
                            <option value="<?php echo htmlspecialchars($variable); ?>"><?php echo htmlspecialchars($variable); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="coordenadaX_<?php echo $componentId; ?>" class="form-label small mb-1">X:</label>
                    <input type="number" class="form-control form-control-sm"
                           id="coordenadaX_<?php echo $componentId; ?>" placeholder="0" min="0" step="1">
                </div>
                <div class="col-md-1">
                    <label for="coordenadaY_<?php echo $componentId; ?>" class="form-label small mb-1">Y:</label>
                    <input type="number" class="form-control form-control-sm"
                           id="coordenadaY_<?php echo $componentId; ?>" placeholder="0" min="0" step="1">
                </div>
                <div class="col-md-1">
                    <label for="fontSize_<?php echo $componentId; ?>" class="form-label small mb-1">Tamaño:</label>
                    <input type="number" class="form-control form-control-sm" id="fontSize_<?php echo $componentId; ?>"
                           placeholder="12" min="1" max="200" step="1">
                </div>
                <div class="col-md-3">
                    <label for="fontType_<?php echo $componentId; ?>" class="form-label small mb-1">Tipo de
                        Letra:</label>
                    <select class="form-select form-select-sm" id="fontType_<?php echo $componentId; ?>">
                        <option value="">Seleccione</option>
                        <?php foreach ($fontTypes as $fontType): ?>
                            <option value="<?php echo htmlspecialchars($fontType); ?>"><?php echo htmlspecialchars($fontType); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="fontColor_<?php echo $componentId; ?>" class="form-label small mb-1">Color
                        (Hexadecimal):</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">#</span>
                        <input type="text" class="form-control form-control-sm"
                               id="fontColor_<?php echo $componentId; ?>" placeholder="000000" maxlength="6"
                               pattern="[0-9A-Fa-f]{6}">
                        <input type="color" class="form-control form-control-color"
                               id="colorPicker_<?php echo $componentId; ?>" value="#000000" title="Selector de color">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="btnAgregarVariable_<?php echo $componentId; ?>"
                           class="form-label small mb-1">Acción</label>
                    <button type="button" class="btn btn-primary btn-sm"
                            id="btnAgregarVariable_<?php echo $componentId; ?>">
                        <i class="fas fa-plus-circle"></i> Agregar Variable
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de variables agregadas -->
        <div class="table-responsive">
            <table class="table table-sm table-hover instructions-table"
                   id="tablaInstrucciones_<?php echo $componentId; ?>">
                <thead class="table-light">
                <tr>
                    <th style="width: 20%;">Variable</th>
                    <th style="width: 8%;">X</th>
                    <th style="width: 8%;">Y</th>
                    <th style="width: 10%;">Tamaño</th>
                    <th style="width: 15%;">Tipo</th>
                    <th style="width: 15%;">Color</th>
                    <th style="width: 10%;">Vista</th>
                    <th style="width: 14%;" class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody id="tablaInstruccionesBody_<?php echo $componentId; ?>">
                <tr class="empty-state">
                    <td colspan="8">
                        <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">No hay variables agregadas</p>
                        <small class="text-muted">Agregue variables usando el formulario superior</small>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Campo oculto con el JSON -->
        <input type="hidden" id="instructionsJSON_<?php echo $componentId; ?>"
               name="<?php echo htmlspecialchars($fieldName); ?>">

        <!-- Vista previa del JSON -->
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label small mb-0">Vista previa JSON:</label>
                <button type="button" class="btn btn-sm btn-outline-secondary"
                        id="btnToggleJSON_<?php echo $componentId; ?>">
                    <i class="fas fa-eye"></i> Ocultar/Mostrar
                </button>
            </div>
            <div class="json-output" id="jsonPreview_<?php echo $componentId; ?>">[]</div>
        </div>
    </div>

    <script>
        (function () {
            // Clase para gestionar las instrucciones
            class InstructionManager_<?php echo $componentId; ?> {
                constructor() {
                    this.instructions = <?php echo $initialJSON; ?>;
                    this.componentId = '<?php echo $componentId; ?>';
                    this.initElements();
                    this.bindEvents();
                    this.actualizarTabla();
                    this.actualizarJSON();
                }

                initElements() {
                    this.variableSelect = document.getElementById('variableSelect_' + this.componentId);
                    this.coordenadaX = document.getElementById('coordenadaX_' + this.componentId);
                    this.coordenadaY = document.getElementById('coordenadaY_' + this.componentId);
                    this.fontSize = document.getElementById('fontSize_' + this.componentId);
                    this.fontType = document.getElementById('fontType_' + this.componentId);
                    this.fontColor = document.getElementById('fontColor_' + this.componentId);
                    this.colorPicker = document.getElementById('colorPicker_' + this.componentId);
                    this.btnAgregar = document.getElementById('btnAgregarVariable_' + this.componentId);
                    this.tablaBody = document.getElementById('tablaInstruccionesBody_' + this.componentId);
                    this.jsonPreview = document.getElementById('jsonPreview_' + this.componentId);
                    this.jsonInput = document.getElementById('instructionsJSON_' + this.componentId);
                    this.btnToggleJSON = document.getElementById('btnToggleJSON_' + this.componentId);
                }

                bindEvents() {
                    this.btnAgregar.addEventListener('click', () => this.agregarVariable());

                    // Toggle JSON preview
                    this.btnToggleJSON.addEventListener('click', () => {
                        this.jsonPreview.style.display = this.jsonPreview.style.display === 'none' ? 'block' : 'none';
                    });

                    // Sincronizar color picker con input hexadecimal
                    this.colorPicker.addEventListener('input', (e) => {
                        this.fontColor.value = e.target.value.substring(1).toUpperCase();
                    });

                    this.fontColor.addEventListener('input', (e) => {
                        let color = e.target.value.replace(/[^0-9A-Fa-f]/g, '').substring(0, 6);
                        e.target.value = color.toUpperCase();
                        if (color.length === 6) {
                            this.colorPicker.value = '#' + color;
                        }
                    });

                    // Permitir agregar con Enter
                    [this.coordenadaX, this.coordenadaY, this.fontSize, this.fontColor].forEach(input => {
                        input.addEventListener('keypress', (e) => {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                this.agregarVariable();
                            }
                        });
                    });
                }

                agregarVariable() {
                    const variable = this.variableSelect.value;
                    const x = this.coordenadaX.value;
                    const y = this.coordenadaY.value;
                    const fontSize = this.fontSize.value;
                    const fontType = this.fontType.value;
                    const fontColor = this.fontColor.value;

                    // Validaciones
                    if (!variable) {
                        alert('Por favor seleccione una variable');
                        this.variableSelect.focus();
                        return;
                    }

                    if (x === '' || y === '') {
                        alert('Por favor ingrese las coordenadas X e Y');
                        if (x === '') this.coordenadaX.focus();
                        else this.coordenadaY.focus();
                        return;
                    }

                    if (fontSize === '') {
                        alert('Por favor ingrese el tamaño de letra');
                        this.fontSize.focus();
                        return;
                    }

                    if (!fontType) {
                        alert('Por favor seleccione un tipo de letra');
                        this.fontType.focus();
                        return;
                    }

                    if (fontColor === '' || fontColor.length !== 6) {
                        alert('Por favor ingrese un color hexadecimal válido (6 caracteres)');
                        this.fontColor.focus();
                        return;
                    }

                    // Verificar si la variable ya existe
                    const existe = this.instructions.find(inst => inst.variable === variable);
                    if (existe) {
                        if (!confirm(`La variable ${variable} ya existe. ¿Desea reemplazarla?`)) {
                            return;
                        }
                        this.eliminarVariable(variable);
                    }

                    // Agregar la nueva instrucción
                    const instruction = {
                        variable: variable,
                        x: parseInt(x),
                        y: parseInt(y),
                        fontSize: parseInt(fontSize),
                        fontType: fontType,
                        color: fontColor.toUpperCase()
                    };

                    this.instructions.push(instruction);
                    this.actualizarTabla();
                    this.actualizarJSON();
                    this.limpiarFormulario();
                }

                eliminarVariable(variable) {
                    this.instructions = this.instructions.filter(inst => inst.variable !== variable);
                    this.actualizarTabla();
                    this.actualizarJSON();
                }

                editarVariable(variable) {
                    const instruction = this.instructions.find(inst => inst.variable === variable);
                    if (instruction) {
                        this.variableSelect.value = instruction.variable;
                        this.coordenadaX.value = instruction.x;
                        this.coordenadaY.value = instruction.y;
                        this.fontSize.value = instruction.fontSize;
                        this.fontType.value = instruction.fontType;
                        this.fontColor.value = instruction.color;
                        this.colorPicker.value = '#' + instruction.color;
                        this.variableSelect.focus();
                    }
                }

                actualizarTabla() {
                    if (this.instructions.length === 0) {
                        this.tablaBody.innerHTML = `
                        <tr class="empty-state">
                            <td colspan="8">
                                <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No hay variables agregadas</p>
                                <small class="text-muted">Agregue variables usando el formulario superior</small>
                            </td>
                        </tr>
                    `;
                        return;
                    }

                    const self = this;
                    this.tablaBody.innerHTML = this.instructions.map(inst => `
                    <tr>
                        <td><strong>${inst.variable}</strong></td>
                        <td>${inst.x}</td>
                        <td>${inst.y}</td>
                        <td>${inst.fontSize}px</td>
                        <td><span style="font-family: ${inst.fontType};">${inst.fontType}</span></td>
                        <td>
                            <div class="color-preview" style="background-color: #${inst.color};" title="#${inst.color}"></div>
                            <small class="ms-1">#${inst.color}</small>
                        </td>
                        <td>
                            <div class="font-preview" style="font-family: ${inst.fontType}; font-size: ${inst.fontSize}px; color: #${inst.color};">
                                Abc
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-sm-icon"
                                    onclick="window.instructionManager_${self.componentId}.editarVariable('${inst.variable}')"
                                    title="Editar">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-sm-icon"
                                    onclick="window.instructionManager_${self.componentId}.eliminarVariable('${inst.variable}')"
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
                }

                actualizarJSON() {
                    const jsonString = JSON.stringify(this.instructions, null, 2);
                    this.jsonPreview.textContent = jsonString;
                    this.jsonInput.value = JSON.stringify(this.instructions);
                }

                limpiarFormulario() {
                    this.variableSelect.value = '';
                    this.coordenadaX.value = '';
                    this.coordenadaY.value = '';
                    this.fontSize.value = '';
                    this.fontType.value = '';
                    this.fontColor.value = '';
                    this.colorPicker.value = '#000000';
                    this.variableSelect.focus();
                }

                obtenerJSON() {
                    return JSON.stringify(this.instructions);
                }
            }

            // Inicializar el gestor de instrucciones y hacerlo globalmente accesible
            window.instructionManager_<?php echo $componentId; ?> = new InstructionManager_<?php echo $componentId; ?>();
        })();
    </script>
    <!-- Fin del Componente: Instruction Manager -->

    <?php
    return ob_get_clean();
}

?>