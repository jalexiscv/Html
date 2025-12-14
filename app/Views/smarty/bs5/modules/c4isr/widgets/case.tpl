<div class="card text-center mb-3">
    <div class="card-header">
        Caso #{if isset($case) AND $case!==false }{$case}{/if}
    </div>
    <div class="card-body">
        <table class="table table-bordered m-0">
            <tr>
                <td class="  "><b>Referencia</b></td>
            </tr>
            <tr>
                <td class="  ">{if isset($reference) AND $reference!==false }{$reference}{/if}</td>
            </tr>
            <tr>
                <td class="  "><b>Titulo</b></td>
            </tr>
            <tr>
                <td class="  ">{if isset($title) AND $title!==false }{$title}{/if}</td>
            </tr>
            <tr>
                <td class="  "><b>Descripción</b></td>
            </tr>
            <tr>
                <td class="   ">{if isset($description) AND $description!==false }{$description}{/if}</td>
            </tr>
        </table>
    </div>
    <!--
    <div class="card-footer text-muted">
        2 days ago
    </div>
    //-->
</div>