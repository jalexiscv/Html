<div class="container m-0 p-0">
    <div class="row justify-content-center mt-0">
        <div class="col-12">
            <div class="card ">
                <div class="card-header">
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
                                        {$tab["text"]}
                                    </button>
                                {/if}
                            </li>
                        {/foreach}
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
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