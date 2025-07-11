<!DOCTYPE html>
<html>
<head>
    <title>Time Range Picker con Bootstrap 5</title>
    <!-- Agregar los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Agregar los estilos del complemento bootstrap-timepicker -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <style>
        .time-range-picker {
            display: flex;
            align-items: center;
        }

        .time-range-picker input {
            margin: 5px;
        }
    </style>
</head>
<body>
<div class="time-range-picker">
    <input type="text" id="hora_inicio" placeholder="Hora de inicio">
    <span>a</span>
    <input type="text" id="hora_fin" placeholder="Hora de fin">
</div>


<!-- Agregar los scripts de Bootstrap y jQuery (necesarios para el complemento) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- Agregar el script del complemento bootstrap-timepicker -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const horaInicioInput = document.getElementById('hora_inicio');
        const horaFinInput = document.getElementById('hora_fin');

        // Inicializar los selectores de tiempo con flatpickr
        flatpickr(horaInicioInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 15,
            onChange: function (selectedDates, dateStr, instance) {
                // Asegurarse de que la hora de inicio no sea mayor que la hora de fin
                if (dateStr > horaFinInput.value) {
                    horaFinInput._flatpickr.setDate(dateStr, false, 'H:i');
                }
            }
        });

        flatpickr(horaFinInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 15,
            onChange: function (selectedDates, dateStr, instance) {
                // Asegurarse de que la hora de fin no sea menor que la hora de inicio
                if (dateStr < horaInicioInput.value) {
                    horaInicioInput._flatpickr.setDate(dateStr, false, 'H:i');
                }
            }
        });
    });
</script>


</body>
</html>
