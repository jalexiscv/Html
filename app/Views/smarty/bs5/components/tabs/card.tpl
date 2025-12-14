<div class="container m-0 p-0">
    <div class="row justify-content-center mt-0">
        <div class="col-12">
            <div class="card ">
                {include file="assets/card/header.tpl"}
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            {foreach from=$tabs item=tab}
                                <li class="nav-item" role="presentation">
                                    {if $tab["active"]==true}
                                        <button class="nav-link active"
                                                id="{$tab["id"]}"
                                                data-bs-toggle="tab"
                                                data-bs-target="#content-{$tab["id"]}"
                                                type="button"
                                                role="tab"
                                                aria-controls="{$tab["id"]}"
                                                aria-selected="true"
                                        >
                                            {if (isset($tab["icon"]))}
                                                <i class="{$tab["icon"]} fa-xl"></i>
                                            {/if}
                                            {$tab["text"]}
                                        </button>
                                    {else}
                                        <button class="nav-link"
                                                id="{$tab["id"]}"
                                                data-bs-toggle="tab"
                                                data-bs-target="#content-{$tab["id"]}"
                                                type="button"
                                                role="tab"
                                        >
                                            {if (isset($tab["icon"]))}
                                                <i class="{$tab["icon"]} fa-xl"></i>
                                            {/if}
                                            {$tab["text"]}
                                        </button>
                                    {/if}
                                </li>
                            {/foreach}
                        </ul>
                        {foreach from=$tabs item=tab}
                            {if $tab["active"]==true}
                                <div class="tab-pane fade show active"
                                     id="content-{$tab["id"]}"
                                     role="tabpanel"
                                     aria-labelledby="home-tab">
                                    {$tab["content"]}
                                </div>
                            {else}
                                <div class="tab-pane fade"
                                     id="content-{$tab["id"]}"
                                     role="tabpanel"
                                     aria-labelledby="home-tab">
                                    {$tab["content"]}
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>