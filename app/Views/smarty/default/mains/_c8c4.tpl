<div id="page" class="page-content container">
    {if isset($page_header)}
        {$page_header}
    {/if}
    <div class="h-1 my-1"></div>
    <div class="row">
        <div class="col-lg-8 pr-lg-0">
            {$main}
        </div>
        <div class="col-lg-4 mt-4 pl-lg-1 mt-lg-0">
            {$right}
        </div>
    </div>
</div>