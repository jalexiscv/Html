{nocache}
    <div class="card dimension p-3 mb-2">
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-row align-items-center">
                <h3 class="heading">{$name}</h3>
                <div class="toolbar">
                    {if isset($header_menu) AND $header_menu!==false }
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="card-toolbar-btn " data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-caret mr-n3 dropdown-animated"
                                 style="">
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
        </div>
        <div class="mt-0">
            {$graph}
        </div>
        <div class="links">
            {$link}
        </div>
    </div>
{/nocache}