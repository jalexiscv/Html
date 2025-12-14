{if (isset($header) AND $header==TRUE) }
    <div class="card-header {if isset($class_header)}{$class_header}{/if}">
        {if (isset($header_icon))}
            <div class="icon">
                <i class="{$header_icon} fa-xl"></i>
            </div>
        {/if}
        {if isset($header)}
            <h2 class=" {if isset($title_class)}{$title_class}{/if}">{$header}</h2>
        {/if}
        <div class="card-toolbar">
            {if isset($header_back) AND $header_back!==false }
                <a href="{$header_back}" class="card-toolbar-btn bg-secondary border-secondary"><i
                            class="fas fa-chevron-left"></i></a>
            {/if}
            {if isset($header_add) AND $header_add!==false }
                <a href="{$header_add}" class="card-toolbar-btn bg-primary border-primary"><i
                            class="fas fa-plus"></i></a>
            {/if}
            {if isset($header_edit) AND $header_edit!==false }
                <a href="{$header_edit}" class="card-toolbar-btn bg-warning border-warning " target="_self"><i
                            class="fas fa-pencil"></i></a>
            {/if}
            {if isset($header_delete) AND $header_delete!==false }
                <a href="{$header_delete}" class="card-toolbar-btn bg-danger border-danger " target="_self"><i
                            class="fas fa-trash"></i></a>
            {/if}
            {if isset($header_task) AND $header_task!==false }
                <a href="{$header_task}" class="card-toolbar-btn bg-info border-info" target="_self"><i
                            class="fas fa-check"></i></a>
            {/if}
            {if isset($header_info) AND $header_info!==false }
                <a href="{$header_info}" class="card-toolbar-btn bg-info border-info" target="_blank"><i
                            class="fas fa-info"></i></a>
            {/if}
            {if isset($header_importer) AND $header_importer!==false }
                <a href="{$header_importer}" class="card-toolbar-btn bg-info border-info" target="_self"><i
                            class="fa-regular fa-cloud-arrow-up"></i></a>
            {/if}
            {if isset($header_help) AND $header_help!==false }
                <a href="{$header_help}" class="card-toolbar-btn bg-success border-success " target="_self"><i
                            class="fas fa-question"></i></a>
            {/if}
            {if isset($header_menu) AND $header_menu!==false }
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="card-toolbar-btn " data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-caret mr-n3 dropdown-animated" style="">
                        {foreach from=$header_menu item=$item}
                            {if isset($item["separator"]) }
                                <hr class="my-1">
                            {else}
                                <a class="dropdown-item" href="{$item["href"]}">{$item["text"]}</a>
                            {/if}
                        {/foreach}
                    </div>
                </div>
                {if isset($header_update)}
                    <a href="#" data-action="reload" class="card-toolbar-btn text-green"><i
                                class="fas fa-sync-alt"></i></a>
                {/if}
            {/if}
        </div>
    </div>
{/if}