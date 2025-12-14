{if isset($plugin_tables)}
    {if $plugin_tables===true}
        {*<script type="text/javascript" src="{base_url("themes/default/node_modules/tableexport.jquery.plugin/tableExport.min.js")}"></script>*}
        {*<script type="text/javascript" src="{base_url("themes/default/node_modules/tableexport.jquery.plugin/libs/FileSaver/FileSaver.min.js")}"></script>*}
        <script type="text/javascript"
                src="{base_url("themes/default/node_modules/bootstrap-table/dist/bootstrap-table.min.js")}"></script>
        {*<script type="text/javascript" src="{base_url("themes/default/node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js")}"></script>*}
        {*<script type="text/javascript" src="{base_url("themes/default/node_modules/bootstrap-table/dist/extensions/print/bootstrap-table-print.js")}"></script>*}
        <script type="text/javascript"
                src="{base_url("themes/default/node_modules/bootstrap-table/dist/locale/bootstrap-table-es-ES.js")}"></script>
        <link rel="stylesheet" type="text/css" href="{base_url
        ("themes/default/node_modules/bootstrap-table/dist/bootstrap-table.css")}"/>
    {/if}
{/if}