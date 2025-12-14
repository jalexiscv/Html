<div class="card {if isset($class)}{$class}{/if}">
    {include file="assets/card/header.tpl"}
    {if isset($image)}
        <img src="{$image}" class="card-img-top p-5" alt="...">
    {/if}
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <p class="text-center">
                    <i class="far fa-cloud-upload fa-4x"></i>
                </p>
            </div>
            <div class="col-9">
                {if isset($message)}
                    <p class="card-text">{$message}</p>
                {/if}
                {$body}
            </div>
        </div>
    </div>
    {if isset($footer)}
        <div class="card-footer text-muted">
            {$footer}
        </div>
    {/if}
</div>