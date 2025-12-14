{if is_array($posts)}
    {foreach from=$posts item=post}
        <div class="card overflow-hidden mb-1">
            <div class="row no-gutters">
                <div class="col-5 p-0 m-0">
                    <a href="{$post["link"]}" class="inline">
                        <img src="{$post["cover"]}" class="card-img-top h-100" alt="...">
                    </a>
                </div>
                <div class="col-7 p-0 m-0">
                    <div class="card-body social-card-body">
                        <b>{$post["title"]}</b>.
                        {$post["ago"]}
                        [ <a href="{$post["link"]}">Leer más</a> ]
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}

{if isset($offset)}
    <!-- Pagination -->
    {$previus=$offset-20}
    {$next=$offset+20}
    <ul class="pagination justify-content-center">
        <li class="page-item"><a href="/social/users/view/{$alias}?offset={$previus}" class="page-link"><i
                        class="fas fa-chevron-left"></i></a></li>
        {section name=pagination loop=6 start=1 step=1}
            {$position=$smarty.section.pagination.index*20}
            <li class="page-item"><a href="/social/users/view/{$alias}?offset={$position}"
                                     class="page-link">{$position/20}</a></li>
        {/section}
        <li class="page-item"><a href="/social/users/view/{$alias}?offset={$next}" class="page-link"><i
                        class="fas fa-chevron-right"></i></a></li>
    </ul>
{/if}
