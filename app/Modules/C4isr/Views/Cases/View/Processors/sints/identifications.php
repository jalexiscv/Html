<?php

$bootstrap = service('bootstrap');
$midentifications = model('App\Modules\C4isr\Models\C4isr_Identifications');
$mprofiles = model('App\Modules\C4isr\Models\C4isr_Profiles');
$identifications = $midentifications
    ->select('identification, profile, country, type, number')
    ->where('country', $country)
    ->like('number', $search)
    ->findAll();

$grid = $bootstrap->get_Grid();
$grid->set_Id("table-" . pk());
$grid->set_Headers([
    'Identificación',
    'Perfil',
    'País',
    'Nombres',
    'Apellidos',
    'Tipo',
    'Número',
]);

// Agregar filas a la tabla
foreach ($identifications as $row) {
    $profile = $mprofiles->find($row['profile']);
    $p = array(
        $row["identification"],
        "<a href=\"/c4isr/profiles/edit/{$row["profile"]}\" target='_blank'>{$row["profile"]}</a>",
        $row["country"],
        $profile["firstname"],
        $profile["lastname"],
        $row["type"],
        $row["number"]
    );
    $grid->add_Row($p);
}

// Imprimir la tabla en formato HTML
echo $grid;
?>
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
            {id: "E", type: "Social", reference: "<?php echo(time());?>", color: getRandomColor()},
        ],
        links: [
            {source: "search", target: "A"},
            {source: "search", target: "B"},
            {source: "search", target: "C"},
            {source: "search", target: "D"},
            {source: "search", target: "E"}
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
