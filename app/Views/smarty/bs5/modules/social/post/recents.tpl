{if isset($recents) && is_array($recents)}

    {foreach from=$recents item=post}
        <!-- Card -->
        {if isset($post["post"])}
            <div class="card mb-2">
                {if isset($post["cover"])&&!is_array($post["cover"])}
                    <div class="view overlay">
                        <a href="{$post["link"]}" class="inline">
                            <img class="card-img-top" src="{$post["cover"]}" alt="">
                        </a>
                    </div>
                {/if}
                <!-- Card content -->
                <div class="card-body pt-2 pb-0 pl-2 pr-2">
                    <!-- Text -->
                    <p class="small-post-content">
                        {if isset($post["title"])}
                            {$post["title"]}
                        {/if}
                        [ <a href="{$post["link"]}" class="inline">{lang("App.Read-More")}</a>
                        ]
                    </p>
                </div>
            </div>
        {/if}
    {/foreach}
{/if}