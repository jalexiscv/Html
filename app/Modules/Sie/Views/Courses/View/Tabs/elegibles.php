<?php
/**
 * Las personas elegibles para tomar este curso deben de tener el
 * módulo base del curso, como modulo base de pensum
 * uno de los "progress en sus "pensums"
 */
$mcourses = model('App\Modules\Sie\Models\Sie_Courses');
$eligibles=$mcourses->getEligibleStudentsForCourse($oid);
?>
<input type="hidden" id="courseId" value="<?= esc($oid) ?>">

<table id="eligible-students-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th class="align-middle align-center">
            <input type="checkbox" id="checkAll">
        </th>
        <th class="align-middle align-center">#</th>
        <th class="align-middle align-center">Registro</th>
        <th class="align-middle align-center">Nombre</th>
        <th class="align-middle align-center">Progreso</th>
        <th>Antecedentes</th>
        <th>Convenio</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($eligibles)): ?>
        <?php $count=0;?>
        <?php foreach ($eligibles as $row): ?>
        <?php $count++;?>
        <?php $fullname=trim($row['first_name'] . ' ' . $row['second_name'])." ".trim($row['first_surname'] . ' ' . $row['second_surname']);?>
            <tr>
                <td>
                    <?php if($row['has_previous_execution_module']=="NO"){?>
                    <input
                        type="checkbox"
                        class="student-check"
                        value="<?= esc($row['registration']) ?>"
                        data-registration="<?= esc($row['registration']) ?>"
                        data-progress="<?= esc($row['progress']) ?>"
                    >
                    <?php }?> 
                </td>
                <td><?= esc($count) ?></td>
                <td><?= esc($row['registration']) ?></td>
                <td><?= esc($fullname) ?></td>
                <td><?= esc($row['progress']) ?></td>
                <td><?= esc($row['has_previous_execution_module']) ?></td>
                <td><?= esc($row['agreement']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No hay estudiantes elegibles para este curso.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="mt-3 d-flex gap-2">
    <button type="button" id="btnSelectAll" class="btn btn-sm btn-outline-primary">
        Seleccionar todos
    </button>

    <button type="button" id="btnRegisterSelected" class="btn btn-sm btn-success">
        Registrar seleccionados al curso
    </button>
</div>

<div id="registerResult" class="mt-2"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll         = document.getElementById('checkAll');
        const btnSelectAll     = document.getElementById('btnSelectAll');
        const btnRegister      = document.getElementById('btnRegisterSelected');
        const courseIdInput    = document.getElementById('courseId');
        const resultContainer  = document.getElementById('registerResult');

        const getStudentCheckboxes = () =>
            Array.from(document.querySelectorAll('.student-check'));

        // 1) Checkbox del header: marca / desmarca todos
        if (checkAll) {
            checkAll.addEventListener('change', function () {
                const checked = this.checked;
                getStudentCheckboxes().forEach(cb => {
                    cb.checked = checked;
                });
            });
        }

        // 2) Botón "Seleccionar todos" (solo selecciona, no togglear)
        if (btnSelectAll) {
            btnSelectAll.addEventListener('click', function () {
                getStudentCheckboxes().forEach(cb => {
                    cb.checked = true;
                });
                if (checkAll) {
                    checkAll.checked = true;
                }
            });
        }

        // 3) Botón "Registrar seleccionados"
        if (btnRegister) {
            btnRegister.addEventListener('click', function () {
                const courseId = courseIdInput ? courseIdInput.value : null;
                const selected = getStudentCheckboxes()
                    .filter(cb => cb.checked)
                    .map(cb => ({
                        registration: cb.dataset.registration,
                        progress: cb.dataset.progress
                    }));

                // Validación simple
                if (!courseId) {
                    alert('No se encontró el ID del curso.');
                    return;
                }

                if (selected.length === 0) {
                    alert('No hay estudiantes seleccionados.');
                    return;
                }

                // Construimos el payload
                const payload = {
                    courseId: courseId,
                    students: selected
                };

                // Petición XHR
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/matriculas/registrar-masivo', true); // <-- ajusta esta URL
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        let message = '';
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                // Ajusta según lo que devuelva tu controlador
                                message = response.message || 'Matrícula procesada correctamente.';
                                resultContainer.className = 'mt-2 alert alert-success';
                            } catch (e) {
                                message = 'Matrícula procesada (respuesta no JSON).';
                                resultContainer.className = 'mt-2 alert alert-success';
                            }
                        } else {
                            message = 'Ocurrió un error al procesar la matrícula. Código: ' + xhr.status;
                            resultContainer.className = 'mt-2 alert alert-danger';
                        }
                        resultContainer.textContent = message;
                    }
                };

                xhr.send(JSON.stringify(payload));
            });
        }
    });
</script>