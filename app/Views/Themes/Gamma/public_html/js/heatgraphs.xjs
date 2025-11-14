/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
export function HeatGraph() {
    function render(oid) {
        var canvas = document.getElementById(oid);
        var title = canvas.getAttribute('data-title');
        var subtitle = canvas.getAttribute('data-subtitle');
        var percentage = canvas.getAttribute('data-percentage');
        var type = canvas.getAttribute('data-type');
        var ctx = canvas.getContext('2d');
        var color1 = "rgba(153,0,0,0.7)";
        var color2 = "rgba(255,102,0,0.7)";
        var color3 = "rgba(255,255,0,0.7)";
        var color4 = "rgba(0,153,0,0.7)";
        var dpr = window.devicePixelRatio || 1;
        var rect = canvas.getBoundingClientRect();
        canvas.width = rect.width * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);
        var maxValue = 100;
        var barWidth = 64;
        var barHeight = canvas.height * 0.6;
        var scaleOffset = 14;
        var margin = 13;
        //var centerX = canvas.width / 2;
        var centerX = rect.width / 2;
        var centerY = canvas.height / 2;
        var secondBarPercentage = percentage;
        // Dibujar el título en dos líneas si es demasiado largo
        ctx.fillStyle = 'black';
        ctx.font = 'italic 15px Arial';
        ctx.textAlign = 'center';
        // Calcular el ancho máximo ocupable para el texto del título
        var maxTextWidth = canvas.width - 2 * margin;
        if (ctx.measureText(title).width > maxTextWidth) {
            // Si el título es demasiado largo, busca el punto de corte aproximado
            var breakPoint = findBreakPoint(title, maxTextWidth, ctx);
            var titlePart1 = title.substring(0, breakPoint);
            var titlePart2 = title.substring(breakPoint).trim();
            // Ajustar la posición y para las dos líneas del título
            ctx.textAlign = 'center';
            ctx.fillText(titlePart1, centerX, margin);
            ctx.fillText(titlePart2, centerX, margin + 13);
        } else {
            ctx.textAlign = 'center';
            ctx.fillText(title, centerX, margin + 9);
        }
        // Encuentra un punto para dividir el título en dos partes
        //var midpoint = Math.floor(title.length / 2);
        //var splitPoint = title.lastIndexOf(' ', midpoint) + 1 || midpoint; // Trata de dividir en un espacio
        //var titlePart1 = title.substr(0, splitPoint);
        //var titlePart2 = title.substr(splitPoint);
        // Ajuste en la posición 'y' para que el título esté centrado respecto al espacio originalmente asignado
        //ctx.fillText(titlePart1, centerX, margin);
        //ctx.fillText(titlePart2, centerX, margin + 12);
        var gradient = ctx.createLinearGradient(0, centerY + barHeight / 2, 0, centerY - barHeight / 2);
        gradient.addColorStop(0.25, color1);
        gradient.addColorStop(0.5, color2);
        gradient.addColorStop(0.75, color3);
        gradient.addColorStop(1, color4);
        ctx.fillStyle = gradient;
        ctx.fillRect(centerX - barWidth / 2, centerY - barHeight / 2, barWidth, barHeight);
        var secondBarHeight = barHeight * (secondBarPercentage / 100);
        ctx.fillStyle = gradient;
        ctx.fillRect(centerX - barWidth / 2, centerY + barHeight / 2 - secondBarHeight, barWidth, secondBarHeight);
        ctx.strokeStyle = 'black';
        ctx.strokeRect(centerX - barWidth / 2, centerY + barHeight / 2 - secondBarHeight, barWidth, secondBarHeight);
        ctx.fillStyle = 'black';
        ctx.font = '10px Arial';
        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';
        for (var i = 0; i <= maxValue; i += 20) {
            var yPos = centerY + barHeight / 2 - (i / maxValue) * barHeight;
            ctx.fillText(i.toString(), centerX - barWidth / 2 - scaleOffset, yPos);
            ctx.beginPath();
            ctx.moveTo(centerX - barWidth / 2 - scaleOffset, yPos);
            ctx.lineTo(centerX - barWidth / 2 - scaleOffset + 5, yPos);
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
        // Dibujar el subtítulo
        ctx.fillStyle = 'black';
        ctx.font = 'bold 17px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(subtitle, centerX, (centerY + barHeight / 2) + margin);
        // Tipo
        ctx.fillStyle = '#000000';
        ctx.font = 'italic 15px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(type, centerX, canvas.height - (margin - 6));
    }


    function findBreakPoint(text, maxWidth, ctx) {
        // Empieza por la mitad del texto para buscar un punto de quiebre adecuado
        for (let i = Math.floor(text.length / 2); i < text.length; i++) {
            let currentText = text.substring(0, i);
            if (ctx.measureText(currentText).width > maxWidth) {
                // Encuentra el último espacio antes del punto donde el texto excede el máximo permitido
                return text.lastIndexOf(' ', i - 1);
            }
        }
        return text.length; // En caso de no encontrar un punto de quiebre, retorna la longitud total
    }


    return {
        render: render,
        //funcion2: funcionInterna2
    };

}