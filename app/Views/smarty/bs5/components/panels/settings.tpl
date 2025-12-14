<div class="card ">
    <div class="card-header">
        <h2 class="">{$header}</h2>
        <div class="card-toolbar">
            {if isset($header_back) AND $header_back!==false }
                <a href="{$header_back}" class="card-toolbar-btn bg-secondary border-secondary"><i
                            class="fas fa-chevron-left"></i></a>
            {/if}
        </div>
    </div>
    <div class="card-body">
        <div class="row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts">
            {if isset($options)}
                {foreach from=$options item=$option}
                    <div class="col mb-3">
                        <div class="card mb-4 rounded-3 shadow-sm h-100">
                            <div class="card-header">
                                <h4 class="my-0 fw-normal">{$option["title"]}</h4>
                            </div>
                            <div class="card-body pb-0">
                                <i class="{$option["icon"]} fa-4x"></i>
                            </div>
                            <div class="card-footer p-2">
                                {if isset($option["text"])}
                                    <a href="{$option["href"]}" class="w-100 btn btn-lg
                                        {if isset($option["btn-class"])}
                                            {$option["btn-class"]}
                                        {else}
                                            btn-secondary
                                        {/if}">
                                        {$option["text"]}
                                    </a>
                                {else}
                                    <a href="{$option["href"]}" class="w-100 btn btn-lg
                                        {if isset($option["btn-class"])}
                                            {$option["btn-class"]}
                                        {else}
                                            btn-secondary
                                        {/if}">
                                        Acceder
                                    </a>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</div>