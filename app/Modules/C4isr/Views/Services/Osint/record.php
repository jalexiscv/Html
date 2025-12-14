<?php
//$cedula = ;
//$nropersona = "65929";
//$nacionalidad = "V";
//$nombreprimero = "REMIGIO";
//$nombresegundo = "";
//$apellidoprimero = "CEBALLOS ICHASO";
//$apellidosegundo = "";
//$fechanacimiento = "1963-04-30T19:30:00-04:30";
//$sexo = "M";
//$estadocivil = "C";
$fechadefuncion = "0001-01-01T00:00:00Z";
//$correo = "RSI3000@GMAIL.COM";
//$peso = "58";
//$talla = "m";
//$estatura = "1.75";
//$colorpiel = "TR";
//$gruposanguineo = "O+";
//$colorojos = "NE";
//$colorcabello = "CA";
//$senasparticulares = "";
//$ciudad = "CARACAS";
//$estado = "VE-A";
//$municipio = "LIBERTADOR";
//$parroquia = "EL VALLE";
//$calleavenida = "FUERTE TIUNA";
//$casa = "";
//$apartamento = "";

//$tipo = "CC";
//$institucion = "0003";
//$cuenta = "3001-6140-00-1031901___";
//$prioridad = "";
//$autorizado = "";
//$titular = "";

$componentenombre = "";
$componentedescripcion = "EJERCITO BOLIVARIANO";
$componenteabreviatura = "EJ";
$gradonombre = "1000";
$gradodescripcion = "GENERAL EN JEFE";
$gradoabreviatura = "GJ";
$componente = "EJ";
$grado = "TTE";
$categoria = "EFE";
$situacion = "ACT";
$clase = "OFI";
$fresuelto = "0001-01-01T00:00:00Z";
?>
<div class="container">
    <h2 class="mx-0 my-3 form-header">Perfil de Persona</h2>
    <div class="row">
        <div class="col-md-4">
            <img src="https://app.ipsfa.gob.ve/sssifanb/afiliacion/temp/<?php echo($cedula); ?>/foto.jpg"
                 class="img-fluid"
                 alt="Responsive image">
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo($cedula); ?>">
            </div>
            <div class="form-group">
                <label for="nropersona">Número de persona</label>
                <input type="text" class="form-control" id="nropersona" name="nropersona"
                       value="<?php echo($nropersona); ?>">
            </div>
            <div class="form-group">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad"
                       value="<?php echo($nacionalidad); ?>">
            </div>
            <div class="form-group">
                <label for="nombreprimero">Primer nombre</label>
                <input type="text" class="form-control" id="nombreprimero" name="nombreprimero"
                       value="<?php echo($nombreprimero); ?>">
            </div>
            <div class="form-group">
                <label for="nombresegundo">Segundo nombre</label>
                <input type="text" class="form-control" id="nombresegundo" name="nombresegundo"
                       value="<?php echo($nombresegundo); ?>">
            </div>
            <div class="form-group">
                <label for="apellidoprimero">Primer apellido</label>
                <input type="text" class="form-control" id="apellidoprimero" name="apellidoprimero"
                       value="<?php echo($apellidoprimero); ?>">
            </div>
            <div class="form-group">
                <label for="apellidosegundo">Segundo apellido</label>
                <input type="text" class="form-control" id="apellidosegundo" name="apellidosegundo"
                       value="<?php echo($apellidosegundo); ?>">
            </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="fechanacimiento">Fecha de nacimiento</label>
                <input type="text" class="form-control" id="fechanacimiento" name="fechanacimiento"
                       value="<?php echo($fechanacimiento); ?>">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo</label>
                <input type="text" class="form-control" id="sexo" name="sexo" value="<?php echo($sexo); ?>">
            </div>
            <div class="form-group">
                <label for="estadocivil">Estado civil</label>
                <input type="text" class="form-control" id="estadocivil" name="estadocivil"
                       value="<?php echo($estadocivil); ?>">
            </div>
            <div class="form-group">
                <label for="fechadefuncion">Fecha de defunción</label>
                <input type="text" class="form-control" id="fechadefuncion" name="fechadefuncion"
                       value="<?php echo($fechadefuncion); ?>">
            </div>
            <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo($correo); ?>">
            </div>
            <div class="form-group">
                <label for="correo">Teléfono</label>
                <input type="email" class="form-control" id="telefono" name="telefono"
                       value="<?php echo($telefono); ?>">
            </div>
            <div class="form-group">
                <label for="correo">IP</label>
                <input type="email" class="form-control" id="ip" name="ip"
                       value="<?php echo($ip); ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <h2 class="mx-0 my-3 form-header">Datos físicos y fisionómicos</h2>
        <div class="col-md-6">

            <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" class="form-control" id="peso" value="<?php echo($peso); ?>">
            </div>
            <div class="mb-3">
                <label for="talla" class="form-label">Talla (m)</label>
                <input type="text" class="form-control" id="talla" value="<?php echo($talla); ?>">
            </div>
            <div class="mb-3">
                <label for="estatura" class="form-label">Estatura (m)</label>
                <input type="number" step="0.01" class="form-control" id="estatura" value="<?php echo($estatura); ?>">
            </div>
            <div class="mb-3">
                <label for="color-piel" class="form-label">Color de piel</label>
                <input type="text" class="form-control" id="color-piel" value="<?php echo($colorpiel); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="grupo-sanguineo" class="form-label">Grupo sanguíneo</label>
                <input type="text" class="form-control" id="gruposanguineo" value="<?php echo($gruposanguineo); ?>">
            </div>

            <div class="mb-3">
                <label for="color-ojos" class="form-label">Color de ojos</label>
                <input type="text" class="form-control" id="color-ojos" value="<?php echo($colorojos); ?>">
            </div>
            <div class="mb-3">
                <label for="color-cabello" class="form-label">Color de cabello</label>
                <input type="text" class="form-control" id="color-cabello" value="<?php echo($colorcabello); ?>">
            </div>

            <div class="mb-3">
                <label for="senas-particulares" class="form-label">Señas particulares</label>
                <textarea class="form-control" id="senas-particulares"><?php echo($senasparticulares); ?></textarea>
            </div>

        </div>
    </div>

    <div class="row">
        <h2 class="mx-0 my-3 form-header">Dirección (Residencia)</h2>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" value="<?php echo($ciudad); ?>">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" value="<?php echo($estado); ?>">
            </div>
            <div class="mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" value="<?php echo($municipio); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="parroquia" class="form-label">Parroquia</label>
                <input type="text" class="form-control" id="parroquia" value="<?php echo($parroquia); ?>">
            </div>
            <div class="mb-3">
                <label for="calle-avenida" class="form-label">Calle/Avenida</label>
                <input type="text" class="form-control" id="calle-avenida" value="<?php echo($calleavenida); ?>">
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="casa" class="form-label">Casa</label>
                        <input type="text" class="form-control" id="casa" value="<?php echo($casa); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apartamento" class="form-label">Apartamento</label>
                        <input type="text" class="form-control" id="apartamento" value="<?php echo($apartamento); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <h2 class="mx-0 my-3 form-header">Información bancaria </h2>
        <div class="col-md-6">
            <div class="form-group">
                <label for="tipo">Tipo de cuenta</label>
                <input type="text" class="form-control" id="tipo" value="<?php echo($tipo); ?>">
            </div>
            <div class="form-group">
                <label for="institucion">Institución financiera</label>
                <input type="text" class="form-control" id="institucion" value="<?php echo($institucion); ?>">
            </div>
            <div class="form-group">
                <label for="cuenta">Número de cuenta</label>
                <input type="text" class="form-control" id="cuenta" value="<?php echo($cuenta); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <input type="text" class="form-control" id="prioridad" value="<?php echo($prioridad); ?>">
            </div>
            <div class="form-group">
                <label for="autorizado">Autorizado por</label>
                <input type="text" class="form-control" id="autorizado" value="<?php echo($autorizado); ?>">
            </div>
            <div class="form-group">
                <label for="titular">Titular de la cuenta</label>
                <input type="text" class="form-control" id="prioridad" value="<?php echo($titular); ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <h2 class="mx-0 my-3 form-header">Cargo Actual (Componente) </h2>
        <div class="col-md-6">
            <div class="form-group">
                <label for="componente-nombre">Nombre del componente</label>
                <input type="text" class="form-control" id="componente-nombre"
                       value="<?php echo($componente_nombre); ?>">
            </div>
            <div class="form-group">
                <label for="componente-descripcion">Descripción del componente</label>
                <input type="text" class="form-control" id="componente-descripcion"
                       value="<?php echo($componente_descripcion); ?>">
            </div>
            <div class="form-group">
                <label for="componente-abreviatura">Abreviatura del componente</label>
                <input type="text" class="form-control" id="componente-abreviatura"
                       value="<?php echo($componente_abreviatura); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="grado-nombre">Nombre del grado</label>
                <input type="text" class="form-control" id="grado-nombre" value="<?php echo($grado_nombre); ?>">
            </div>
            <div class="form-group">
                <label for="grado-descripcion">Descripción del grado</label>
                <input type="text" class="form-control" id="grado-descripcion"
                       value="<?php echo($grado_descripcion); ?>">
            </div>
            <div class="form-group">
                <label for="grado-abreviatura">Abreviatura del grado</label>
                <input type="text" class="form-control" id="grado-abreviatura"
                       value="<?php echo($grado_abreviatura); ?>">
            </div>
        </div>
    </div>


</div>


<script src="https://d3js.org/d3.v6.min.js"></script>
<svg width="740" height="480"></svg>
<script>

    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgb(${r},${g},${b})`;
    }

    function createRhombusPath(width, height) {
        const halfWidth = width / 2;
        const halfHeight = height / 2;
        return `M 0,${-halfHeight} L ${halfWidth},0 L 0,${halfHeight} L ${-halfWidth},0 Z`;
    }

    function createHexagonPath(radius) {
        const angles = [0, 60, 120, 180, 240, 300];
        const points = angles.map(angle => {
            const radians = (Math.PI / 180) * angle;
            const x = radius * Math.cos(radians);
            const y = radius * Math.sin(radians);
            return `${x},${y}`;
        });
        return `M ${points.join("L")} Z`;
    }

    const rhombusWidth = 30;
    const rhombusHeight = 40;


    const data = {
        nodes: [
            {id: "search", type: "Búsqueda", reference: "<?php echo($search);?>", color: getRandomColor()},
            {id: "A", type: "Teléfono", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "B", type: "Identificación", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "C", type: "Email", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "D", type: "Alias", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "E", type: "Dirección", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "F", type: "Bancaria", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "G", type: "Fisionomía", reference: "<?php echo(time());?>", color: getRandomColor()},
            {id: "H", type: "Familiares", reference: "<?php echo(time());?>", color: getRandomColor()},
        ],
        links: [
            {source: "search", target: "A"},
            {source: "search", target: "B"},
            {source: "search", target: "C"},
            {source: "search", target: "D"},
            {source: "search", target: "E"},
            {source: "search", target: "F"},
            {source: "search", target: "G"},
            {source: "search", target: "H"},
        ]
    };

    const width = 740;
    const height = 480;

    const svg = d3.select('svg');
    const simulation = d3.forceSimulation(data.nodes)
        .force("link", d3.forceLink(data.links).id(d => d.id).distance(150))
        .force("charge", d3.forceManyBody().strength(-250))
        .force("center", d3.forceCenter(width / 3, height / 2));

    const link = svg.selectAll("line")
        .data(data.links)
        .join("line")
        .attr("stroke-width", "2")
        .attr("stroke", "black");

    const node = svg.selectAll("g")
        .data(data.nodes)
        .join("g")
        .call(drag(simulation));


    node.append("path")
        .attr("d", createHexagonPath(44))
        .attr("fill", d => d.color)
        .attr("stroke", "black")
        .attr("stroke-width", "2");


    //node.append("circle")
    //    .attr("r", 40)
    //    .attr("stroke", "white") // Agrega un borde de color negro
    //    .attr("stroke-width", "2") // Establece el grosor del borde en 2 píxeles
    //    .attr("fill", () => getRandomColor()); // Usa la función getRandomColor()

    node.append("text")
        .attr("text-anchor", "middle")
        .attr("dy", "6px") // Ajusta la posición vertical para la primera línea
        .attr("fill", "black")
        .attr("font-size", "12px")
        .text(d => d.type);

    node.append("text")
        .attr("text-anchor", "middle")
        .attr("dy", "50") // Ajusta la posición vertical para la segunda línea
        .attr("fill", d => d.color)
        .attr("font-size", "12px")
        .text(d => d.reference);


    simulation.on("tick", () => {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("transform", d => `translate(${d.x}, ${d.y})`);
    });

    function drag(simulation) {
        function dragstarted(event, d) {

            if (!event.active) simulation.alphaTarget(0.3).restart();
            d.fx = d.x;
            d.fy = d.y;
        }

        function dragged(event, d) {
            d.fx = event.x;
            d.fy = event.y;
        }

        function dragended(event, d) {
            if (!event.active) simulation.alphaTarget(0);
            d.fx = null;
            d.fy = null;
        }

        return d3.drag().on("start", dragstarted).on("drag", dragged).on("end", dragended);
    }

</script>