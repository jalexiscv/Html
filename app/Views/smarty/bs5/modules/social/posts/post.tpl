{if is_mobile()}
    {include file="modules/social/posts/ads-mobile.tpl"}
{else}
    {include file="modules/social/posts/ads-desktop.tpl"}
{/if}
<div class="row">
    <div class="col-md-9 col-sm-12 ">
        {include file="modules/social/posts/content.tpl"}
        {include file="modules/social/comments/comments.tpl"}
        {include file="modules/social/comments/comment.tpl"}
        {include file="modules/social/posts/keywords.tpl"}
        {include file="modules/social/posts/complementary.tpl"}
    </div>
    <div class="col-md-3 d-none d-xl-block d-lg-block pl-md-0">
        {include file="modules/modules/social/posts/locals.tpl"}
    </div>
</div>