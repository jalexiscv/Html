<div class="row">
    <!--[social-posts-topday]-->
    {literal}
    <div id="masonry" class="col-md-12 col-sm-12 pl-md-0 grid-masonry" data-masonry='{"percentPosition": true }'>
        {/literal}
        {include file="modules/social/posts/masonry/post.tpl"}
    </div>

    <!--[/social-posts-small]-->
</div>
<div class="row">
    <div class="col-12">
        {if isset($offset)}
            <!-- Pagination -->
            {$previus=$offset-20}
            {$next=$offset+20}
            <ul class="pagination justify-content-center">
                <li class="page-item"><a href="/social/page/{$previus}" class="page-link"><i
                                class="fas fa-chevron-left"></i></a></li>
                {section name=pagination loop=6 start=1 step=1}
                    {$position=$smarty.section.pagination.index*20}
                    <li class="page-item"><a href="/social/page/{$position}" class="page-link">{$position/20}</a></li>
                {/section}
                <li class="page-item"><a href="/social/page/{$next}" class="page-link"><i
                                class="fas fa-chevron-right"></i></a></li>
            </ul>
        {/if}
    </div>
</div>