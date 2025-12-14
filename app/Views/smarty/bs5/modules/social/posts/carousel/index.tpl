<!-- mobile //-->
{if isset($main_carousel)}
    {if is_array($main_carousel)}
        <div class="card  {if isset($class) AND $class!==false }{$class}{/if} w-100 mb-3">
            {if (isset($header) AND $header==TRUE) }
                <div class="card-header {if isset($class_header)}{$class_header}{/if}">
                    {if isset($header)}
                        <h2 class="">{$header}</h2>
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
            {/if}
            {if (isset($image) AND $image==TRUE) }
                <img src="{$image}" class="card-img-top p-5" alt="...">
            {/if}
            <div class="card-body ">
                {if is_desktop() }
                    {include file="modules/social/posts/carousel/desktop.tpl"}
                {else}
                    {include file="modules/social/posts/carousel/mobile.tpl"}
                {/if}
            </div>
            {if isset($footer) AND $footer!==false }
                <div class="card-footer ">
                    {$footer}
                </div>
            {/if}
        </div>
    {/if}
{/if}