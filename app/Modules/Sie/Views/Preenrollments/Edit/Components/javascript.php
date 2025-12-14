<?php
$current_year = date('Y');
$current_month = date('n');
$period = $current_year . ($current_month <= 6 ? 'A' : 'B');
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var radioButtons = document.querySelectorAll('.form-check-input');
        var previousChecked = null;
        var period = '<?php echo $period ?>';
        //var credits=18;

        document.getElementById('btn-print').addEventListener('click', function () {
            var printContents = document.getElementById('card-view-service').cloneNode(true);
            // Reemplazar inputs radio con elementos visibles
            printContents.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                var span = document.createElement('span');
                span.className = radio.checked ? 'radio-checked' : 'radio-unchecked';
                span.textContent = radio.checked ? 'X ' : ' ';
                span.style.marginRight = '5px';

                var label = radio.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    label.parentNode.insertBefore(span, label);
                } else {
                    radio.parentNode.insertBefore(span, radio.nextSibling);
                }
                radio.style.display = 'none';
            });

            var printWindow = window.open('', '_blank');
            if (printWindow) {
                var htmlContent = "<!DOCTYPE html>\r\n"
                    + "<html lang=\"es\">\r\n<head>\r\n    " +
                    "<meta charset=\"UTF-8\">\r\n    " +
                    "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    " +
                    "<title>Imprimir<\/title>\r\n    " +
                    "<link rel=\"stylesheet\" href=\"https:\/\/intranet.utede.edu.co\/themes\/assets\/libraries\/bootstrap\/5.3.3\/css\/bootstrap.min.css\">\r\n    " +
                    "<style>\r\n        " +
                    "   @media print {\r\n            " +
                    "       .radio-checked, .radio-unchecked {\r\n" +
                    "                -webkit-print-color-adjust: exact;\r\n                " +
                    "               color-adjust: exact;\r\n" +
                    "       }\r\n        }\r\n" +
                    "    <\/style>\r\n" +
                    "    <script>\r\n        " +
                    "       function printAndClose() {\r\n" +
                    "            window.print();\r\n" +
                    "            window.close();\r\n" +
                    "       }\r\n" +
                    "    <\/script>" +
                    "<script>\r\n        " +
                    "   function printAndClose() {\r\n            " +
                    "   window.print();\r\n            " +
                    "   window.close();\r\n        }\r\n    " +
                    "<\/script>\r\n" +
                    "<\/head>\r\n" +
                    "<body onload=\"printAndClose()\">\r\n    " +
                    "   <div id=\"printable-content\">\r\n        " + printContents.innerHTML + "\r\n    <\/div>\r\n" +
                    "<\/body>\r\n" +
                    "<\/html>";
                printWindow.document.write(htmlContent);
                printWindow.document.close();
            } else {
                alert('Por favor, permite las ventanas emergentes para este sitio para poder imprimir.');
            }
        });

        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('mousedown', function (event) {
                var name = radioButton.name;
                var value = radioButton.value;
                if (radioButton === previousChecked) {
                    setTimeout(function () {
                        radioButton.checked = false;
                    }, 0);
                    previousChecked = null;
                    event.preventDefault();
                    sendXHR(name, value);
                } else {
                    previousChecked = radioButton;
                }
            });


            radioButton.addEventListener('change', function () {
                var name = radioButton.name;
                var value = radioButton.value;

            });
        });

        function sendXHR(progress, course) {
            var timestamp = Math.floor(Date.now() / 1000);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/sie/api/executions/json/change/' + timestamp, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Response:', xhr.responseText);
                }
            };
            xhr.send('progress=' + encodeURIComponent(progress) + '&course=' + encodeURIComponent(course) + '&period=' + encodeURIComponent(period));
        }

        var btnContinuar = document.getElementById('btn-submit');
        btnContinuar.addEventListener('click', function () {
            var totalCredits = 0;
            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    var credits = parseInt(radioButton.getAttribute('data-credits'), 10);
                    if (!isNaN(credits)) {
                        totalCredits += credits;
                    }
                }
            });
            //alert(totalCredits);
            if (totalCredits <= credits) {
                var timestamp = Math.floor(Date.now() / 1000);
                var form = document.getElementById('form_preenrrolments');
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/sie/api/executions/json/update/' + timestamp, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert(response.message);
                            window.location.href = '<?php echo($back);?>?t=' + timestamp;
                        } else {
                            alert(response.message);
                        }
                    }
                };
                xhr.send(formData);
            } else {
                alert("El total de créditos(" + totalCredits + ") supera el límite permitido(" + credits + "), por favor verifique.");
            }
        });

        let ultimaSeleccion = null;
        updateCredits();

        radioButtons.forEach(radio => {
            radio.addEventListener('click', function (event) {
                if (this === ultimaSeleccion) {
                    this.checked = false;
                    ultimaSeleccion = null;
                } else {
                    ultimaSeleccion = this;
                }
                updateCredits();
            });

        });

        function updateCredits() {
            var totalCredits = 0;
            radioButtons.forEach(function (radioButton) {
                if (radioButton.checked) {
                    let credits = radioButton.getAttribute('data-credits');
                    if (credits === null || credits === undefined || credits === "") {
                        credits = 0;
                    }

                    totalCredits += parseInt(credits, 10);
                }
            });
            document.getElementById('count-credits').textContent = totalCredits;
        }
    });

</script>